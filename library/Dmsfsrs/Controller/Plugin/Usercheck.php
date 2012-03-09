<?php
/**
* Config Controller handles checking if the user is logged in.
*
* @category   Zend
* @package    Zend_Controller
* @subpackage Action
* @copyright  Copyright (c) 2010 DMSFSRS
* @version    Release: @package_version@
*/
class Dmsfsrs_Controller_Plugin_Usercheck extends Zend_Controller_Plugin_Abstract
{
    /**
     * preDispatch action
     *
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Ignore for auth and error controller
        if($this->getRequest()->getControllerName() === 'auth') {
            return; // ignoring preDispatch
        }
        if($this->getRequest()->getControllerName() === 'error') {
            return; // ignoring preDispatch
        }
        
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');

        // Authentication with acl and auth
        if (! Zend_Auth::getInstance()->hasIdentity()){

            // Get URL to store in session for redirect
            $url = new Zend_Session_Namespace('url');
            $url->destinationUrl = $request->getRequestUri();

            // Show login form
            $request->setControllerName('auth');
            $request->setActionName('login');
        } else { // user has idenity check acl
            $user = Zend_Auth::getInstance()->getIdentity();
            
            // Check role against ACL
            $acl = Zend_Registry::get('acl');
            
            $controller = $this->getRequest()->getControllerName();
            $action = $this->getRequest()->getActionName();

            // If the controller has no acl defined
            if (!$acl->has($controller)) {
                $controller = null;
                $action = null;
            }

            //var_dump($acl->getResources());
            //var_dump($user->role);
            //var_dump($controller);
            //var_dump($action);
            //var_dump($acl->isAllowed($user->role, $controller, $action));
            if (!$acl->isAllowed($user->role, $controller, $action)){
                // Log attempt
                $logger = Zend_Registry::get('logger');
                $logger->log($controller . ' | ' . $action . ' | ' .'User: ' . $user->username . ' tried to access an administrative area.', Zend_Log::ALERT);

                // Redirect
                $redirector->gotoSimple('index', 'index');
            }
        }
         
         
    }

}