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
        $dql = $this->_entityManager->createQueryBuilder();
        $dql->select('c.firstName', 'c.address')
                ->from('Entity\Person', 'c')
                //->leftJoin('c.Entity\Physician', 'p')
                //->where('c.specialty = Brain surgeon')
                ->orderBy('c.firstName', 'ASC');

        $query = $dql->getQuery();

        $records = new Zend_Paginator(new DoctrineExtensions\Paginate\PaginationAdapter($query));

        $this->view->person = $records;
    }

    public function createAction() {
        
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

}