<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {

    private $_acl = null;
    private $_auth = null;

    public function __construct(Zend_Acl $acl, Zend_Auth $auth) {
        $this->_acl = $acl;
        $this->_auth = $auth;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        $this->_itemNumber = 30;
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->_customerRepo = $this->_entityManager->getRepository('Entity\Person');
        $resource = $request->getControllerName();
        $action = $request->getActionName();

        $email = $this->_auth->getIdentity();

        $q = $this->_entityManager->createQueryBuilder()
                ->select('u')
                ->from('Entity\Person', 'u')
                ->where('u.email = ' . "'$email'");
        //   ->setParameter('email', $auth->getIdentity());

        $result = $q->getQuery();
        $userInfo = $result->getArrayResult();

        $userRole = $userInfo[0]['role'];

        $role = 'guest';

        If ($userRole!= null) {
            
            $role = $userRole;
        }


        if (!$this->_acl->isAllowed($role, $resource, $action)) {
            $request->setControllerName('index')
                    ->setActionName('index');
        }

        //echo 'PreDispatch';
    }

}

?>
