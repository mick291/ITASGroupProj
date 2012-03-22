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
    }

}

