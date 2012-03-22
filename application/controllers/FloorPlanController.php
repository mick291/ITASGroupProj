<?php

class FloorPlanController extends Zend_Controller_Action {

    protected $_flashMessenger = null;

    public function init() {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('add', 'json')
                ->initContext();
    }

    public function listAction() {
        $p = $this->getRequest()->getParams('room');
        echo $p['room'];
    }

    public function indexAction() {

        $this->_helper->layout()->disableLayout();
        
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

}

