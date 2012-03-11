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
    }

    public function indexAction() {

      //  $query = $this->_entityManager->createQuery('SELECT c, o FROM Entity\Physician c JOIN c.physician o WHERE c.specialty = \'Brain Surgeon\'');
       // $result = $query->execute();

        $qb = $this->_entityManager->createQueryBuilder()
        ->select('p')
        ->from('Entity\Person', 'p')
        //->leftJoin('c.physician', 'o')
        ->where('p.physician = true');
        $q = $qb->getQuery();
         $result = $q->getArrayResult();
       
        return $this->view->person = $result;
    }

    public function createAction() {
        
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

}