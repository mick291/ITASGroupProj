<?php

class FloorPlanController extends Zend_Controller_Action {

    protected $_flashMessenger = null;

    public function init() {
        // Get the context switcher helper
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        // We want to have a json and an xml context available for action1
        $contextSwitch->addActionContext('index', array('xml', 'json'))
                ->initContext();
          $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
    }

    public function listAction() {
        $p = $this->getRequest()->getParams('room');
        echo $p['room'];
    }
    
    public function ajaxAction() {
        $this->_helper->layout()->disableLayout();

        $room = $_GET['room'];
//        $room = 4;
        $qb = $this->_entityManager->createQueryBuilder()
                        ->select('r', 'p', 'o', 's', 't', 'b', 'q')
                        ->from('Entity\Bed', 'b')
                        ->join('b.residentPatient', 'r')
                        ->join('r.patient', 'p')
                        ->join('p.assignedPhysician', 'o')
                        ->join('o.physician', 's')
                        ->join('b.roomNumber', 'q')
                        ->join('p.patient', 't')
                        ->where('b.roomNumber = '. "'$room'");
                $q = $qb->getQuery();

 $result = $q->getArrayResult();
//return $this->view->floorPlan = json_encode($result);
//     $result = array();
//       $result['room'] = $_GET['room'];
//       $result['dog'] = "Spot";
        echo json_encode($result);
        
        
    
        

    }

    public function indexAction() {

    }

   

}

