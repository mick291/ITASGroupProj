<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author mickel_smith
 */
class Application_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(
    Zend_Controller_Request_Abstract $request) {
        
    }

    public function dispatchLoopStartup(
    Zend_Controller_Request_Abstract $request) {
        $acl = $this->_getAcl();
        $role = $this->_getRole();
        $resource = $request->getControllerName();
        $privilege = $request->getActionName();

        $allowed = $acl->isAllowed($role, $resource, $privilege);
        if (!$allowed) {
            $controller = 'auth';
            $action = 'index';
            $redirector = new Zend_Controller_Action_Helper_Redirector();
            $redirector->gotoSimpleAndExit($action, $controller);
        }
    }

    protected function _getAcl() {
        if (null === $this->_acl) {
            $acl = new Zend_Acl();

// Roles
            $acl->addRole('guest');
            $acl->addRole('user', 'guest');
            $acl->addRole('admin', 'user');

// Resources
            $acl->add(new Zend_Acl_Resource('index'));
            $acl->add(new Zend_Acl_Resource('person'));
            $acl->add(new Zend_Acl_Resource('auth'));
            $acl->add(new Zend_Acl_Resource('error'));
// Rules
            $acl->deny();
            $acl->allow('user', 'index', array('index', 'add', 'edit', 'view'));
            $acl->allow('admin', 'index', array('delete'));
            $acl->allow('admin', 'person', null);
            $acl->allow('guest', 'auth', null);
            $acl->allow('guest', 'error', null);
            $this->_acl = $acl;
        }

        return $this->_acl;
    }

    protected function _getRole() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $role = empty($identity->role) ? 'user' : $identity->role;
        } else {
            $role = 'guest';
        }
        $_SESSION['stinkyRole'] = $role;
        return $role;
    }

}

?>
