<?php
class IndexController extends Zend_Controller_Action
{

     private $_entityManager;
    
    public function init()
    {

        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
    }
    
    public function indexAction()
    {
        
          $dql = $this->_entityManager->createQueryBuilder();
        $dql    ->select('c.address, c.firstName')
                ->from('Entity\Person', 'c')
                ->orderBy('c.firstName', 'ASC');

        $query = $dql->getQuery();
        return $query;
    }


}