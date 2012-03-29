<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Acl extends Zend_Acl {

    public function __construct() {

        $this->add(new Zend_Acl_Resource('patient'));
        $this->add(new Zend_Acl_Resource('index'), 'patient');
        $this->add(new Zend_Acl_Resource('register'), 'patient');

        $this->add(new Zend_Acl_Resource('auth'));
        $this->add(new Zend_Acl_Resource('logout'), 'auth');
        $this->add(new Zend_Acl_Resource('login'), 'auth');

        $this->add(new Zend_Acl_Resource('person'));
        $this->add(new Zend_Acl_Resource('pdf'));

        $this->add(new Zend_Acl_Resource('floorPlan'));
        $this->add(new Zend_Acl_Resource('list'), 'floorPlan');
        $this->add(new Zend_Acl_Resource('ajax'), 'floorPlan');

        $this->add(new Zend_Acl_Resource('employee'));
        // $this->add(new Zend_Acl_Resource('index'), 'employee');
        $this->add(new Zend_Acl_Resource('empregister'), 'employee');
        $this->add(new Zend_Acl_Resource('docregister'), 'employee');

        $this->addRole(new Zend_Acl_Role('guest'));
        $this->addRole(new Zend_Acl_Role('employee'), 'guest');
        $this->addRole(new Zend_Acl_Role('doctor'), 'employee');
        $this->addRole(new Zend_Acl_Role('admin'), 'doctor');


        $this->allow('guest', 'index', 'index');
        $this->allow('guest', 'auth', 'logout');
        $this->allow('guest', 'auth', 'login');
        $this->allow('employee', 'person', 'index');
        $this->allow('doctor', 'patient', 'index');
        $this->allow('doctor', 'patient', 'register');
        $this->allow('guest', 'floorPlan', 'index');
        $this->allow('doctor', 'pdf', 'index');
        $this->allow('doctor', 'floorPlan', 'list');
        $this->allow('doctor', 'employee', 'empregister');
        $this->allow('doctor', 'employee', 'docregister');
        $this->allow('doctor', 'employee', 'index');
        $this->allow('doctor', 'employee', 'refresh');
        $this->allow('doctor', 'patient', 'refresh');
        $this->allow('doctor', 'floorPlan', 'ajax');
    }

}

?>
