<?php

/**
 * @category    Controller
 * @package     
 * @copyright   
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/5/11 2:50 PM
 */
class PersonController extends Zend_Controller_Action {

    private $_entityManager;
    private $_flashMessenger;
    private $_page;
    private $_itemNumber;

    public function init() {
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

    public function ajaxsearchAction() {

        $p = $this->getRequest()->getParams('keyword');

        if ($this->_request->isXmlHttpRequest()) {


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