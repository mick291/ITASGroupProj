<?php

class PdfController extends Zend_Controller_Action {

    private $_entityManager;

    public function init() {

        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
    }

    public function indexAction() {

       
    }

}