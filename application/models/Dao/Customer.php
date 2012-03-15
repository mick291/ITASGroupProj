<?php
/**
 * @category    
 * @package     
 * @copyright   
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/5/11 2:50 PM
 */

use Doctrine\ORM\EntityManager;


class Application_Model_Dao_Customer
{

    private $_customerRepo;

    private $_entityManager;


    public function __construct()
    {
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->_customerRepo = $this->_entityManager->getRepository('\Entity\Customer');
    }

    public function save($data)
    {
        $entity = new \Entity\Customer;

        $entity->setName($data['address']);

        $this->_entityManager->persist($entity);
        $this->_entityManager->flush();

        return true;
    }

    public function getAll($page, $itemNumber)
    {
        $dql = $this->_entityManager->createQueryBuilder();
        $dql    ->select('c.address, c.firstName')
                ->from('Entity\Person', 'c')
                ->orderBy('c.firstName', 'ASC');

        $query = $dql->getQuery();

        $records = new Zend_Paginator(new DoctrineExtensions\Paginate\PaginationAdapter($query));

        $records->setCurrentPageNumber($page);
        $records->setItemCountPerPage($itemNumber);

        return $records;
    }
    
}