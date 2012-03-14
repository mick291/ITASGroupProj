<?php

class PatientController extends Zend_Controller_Action
{

    private $_entityManager;
    private $_flashMessenger;
    private $_page;
    private $_itemNumber;

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

            $qb = $this->_entityManager->createQueryBuilder()
                    ->select('p', 'o','s','t')
                    ->from('Entity\Patient', 'p')
                    ->leftJoin('p.assignedPhysician', 'o')
                    ->leftJoin('o.physician', 's')
                    ->leftJoin('p.patient', 't')
                    ->where($column . ' LIKE :specialty')
                    ->setParameter('specialty', '%' . $p['keyword'] . '%');
            $q = $qb->getQuery();

            $result = $q->getArrayResult();

            return $this->view->patient = $result;
        }
        //print_r($result);
    }

}

