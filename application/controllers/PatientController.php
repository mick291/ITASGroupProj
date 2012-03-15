<?php

class PatientController extends Zend_Controller_Action {

    private $_entityManager = null;
    private $_flashMessenger = null;
    private $_page = null;
    private $_itemNumber = null;

    public function init() {

        $this->_itemNumber = 30;
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->_customerRepo = $this->_entityManager->getRepository('Entity\Person');
        $this->_flashMessenger = $this->_helper->FlashMessenger;
        $form = new Application_Form_Patient();
        $this->view->form = $form;
    }

    public function indexAction() {

        $p = $this->getRequest()->getParams('keyword');

        if (isset($p['keyword'])) {

            $column = $p['column'];
            $column2 = 't.firstName';

            $qb = $this->_entityManager->createQueryBuilder()
                    ->select('p', 'o', 's', 't')
                    ->from('Entity\Patient', 'p')
                    ->leftJoin('p.assignedPhysician', 'o')
                    ->leftJoin('o.physician', 's')
                    ->leftJoin('p.patient', 't')
                    ->where($column . ' LIKE :specialty')
                    ->orWhere($column2 . ' LIKE :specialty')
                    ->setParameter('specialty', '%' . $p['keyword'] . '%')
                    ->orderBy($column);
            $q = $qb->getQuery();

            $result = $q->getArrayResult();

            return $this->view->patient = $result;
        }
        //print_r($result);
    }

    public function registerAction() {

        $form = new Application_Form_Register();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {

                $formData = $this->_request->getPost();
                
                $newUser = new Application_Model_DbTable_Users();
                $newUser->addUser($form->getValue('firstname'), $form->getValue('lastname'), 
                        $form->getValue('email'), $form->getValue('dob'), 
                        $form->getValue('username'));
                $urlOptions = array('controller' => 'patient', 'action' => 'index');
                $this->_helper->redirector->gotoRoute($urlOptions);
            }


            //Redisplay form with values and error messages
            else {

                $form->populate($formData);
                $this->view->form = $form;
            }
        }
    }

}

