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
        $this->add(new Zend_Acl_Resource('floorPlan'));

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
        $this->allow('doctor', 'floorPlan', 'index');
    }

}

?>
