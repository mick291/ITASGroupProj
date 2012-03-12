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
                ->select('p', 'o')
                ->from('Entity\Physician', 'p')
                ->leftJoin('p.physician', 'o')
                ->where('p.specialty = \'Brain Surgeon\'');
        $q = $qb->getQuery();
        $result = $q->getArrayResult();

        //print_r($result);
        return $this->view->person = $result;
    }

    public function createAction() {
        
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

    function array_flatten($array, &$newArray = Array(), $prefix='', $delimiter='|') {
        foreach ($array as $key => $child) {
            if (is_array($child)) {
                $newPrefix = $prefix . $key . $delimiter;
                $newArray = & array_flatten($child, $newArray, $newPrefix, $delimiter);
            } else {
                $newArray[$prefix . $key] = $child;
            }
        }
        return $newArray;
    }

}