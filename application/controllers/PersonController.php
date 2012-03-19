<?php


class PersonController extends Zend_Controller_Action {

    private $_entityManager;
    private $_flashMessenger;
    private $_page;
    private $_itemNumber;

    public function init() {
        
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('check', 'html');
        $ajaxContext->initContext();
        $this->_itemNumber = 30;
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->_customerRepo = $this->_entityManager->getRepository('Entity\Person');
        $this->_flashMessenger = $this->_helper->FlashMessenger;
        $form = new Application_Form_Search();
        $this->view->form = $form;
    }

    public function indexAction() {

        $p = $this->getRequest()->getParams('keyword');

        if (isset($p['keyword'])) {

            $column = $p['column'];

            $qb = $this->_entityManager->createQueryBuilder()
                    ->select('p', 'o')
                    ->from('Entity\Physician', 'p')
                    ->leftJoin('p.physician', 'o')
                    ->where($column . ' LIKE :specialty')
                    ->setParameter('specialty', '%' . $p['keyword'] . '%');
            $q = $qb->getQuery();

            $result = $q->getArrayResult();

            return $this->view->person = $result;
        }
        //print_r($result);
    }



    public function createAction() {
        
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

}