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

        //Assuming $em is EntityManager
        //$query = $this->createQuery('SELECT c, o FROM Car c JOIN c.owner o');
       // $query = $this->_entityManager->createQuery('SELECT c, o FROM Entity\Physician c JOIN c.physician o WHERE c.specialty = \'Brain Surgeon\'');
       // $result = $query->execute();

        //$dql = $this->_entityManager->createQueryBuilder();
        //$dql->select('c, p')
        //        ->from('Entity\Physician', 'c')
        //        ->leftJoin('c.physician', 'p')
        //       ->where('c.specialty = \'Brain surgeon\'');
        // ->orderBy('c.firstName', 'ASC');
       
        $query = $dql->getQuery();
       // print_r($$query);
       $records = new Zend_Paginator(new DoctrineExtensions\Paginate\PaginationAdapter($query));
      //  print_r($result);
        $this->view->person = $records;
    }

    public function createAction() {
        
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

}