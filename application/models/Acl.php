<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Acl extends Zend_Acl {
    
    public function __construct() {
        $this->add(new Zend_Acl_Resource('patient'));
        $this->add(new Zend_Acl_Resource('index'), 'patient');
        
        $this->add(new Zend_Acl_Resource('patient'));
        $this->add(new Zend_Acl_Resource('register'), 'patient');
        
        $this->addRole(new Zend_Acl_Role('user'));
        $this->addRole(new Zend_Acl_Role('admin'), 'user');
        
        $this->allow('user', 'patient', 'index');
        $this->allow('admin', 'patient', 'register');
    }
}

?>
