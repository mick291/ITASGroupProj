<?php

/**
 * Auth Controller that handles requests involving
 */
class AuthController extends Zend_Controller_Action {

    /**
     * Init action
     *
     */
    public function init() {
        
    }

    /**
     * Index Action
     *
     */
    public function indexAction() {
        
    }

    /**
     * Login Action
     *
     */
    public function loginAction() {
        $loginForm = new Application_Form_Auth();

        //If the request is not POST
        if (!$this->getRequest()->isPost()) {
            $this->view->form = $loginForm;
        } else {//If user submits form
            $formData = $this->_request->getPost();

            $username = $formData['username'];
            $password = $formData['password'];

            require_once 'Zend/Config/Ini.php';

            $config = new Zend_Config_Ini('../application/configs/config.ini', 'production');
            $log_path = $config->ldap->log_path;
            $options = $config->ldap->toArray();
            unset($options['log_path']);

            require_once 'Zend/Auth/Adapter/Ldap.php';

            $authAdapter = new Zend_Auth_Adapter_Ldap($options, $username, $password);

            $authAdapter->setIdentity($username);
            $authAdapter->setCredential($password);
            
            //instanciate the Zend_auth object
            $auth = Zend_Auth::getInstance();


            // Set up the authentication adapter, this may throw an error
            //$authAdapter = new Zend_Auth_Adapter_Ldap($options, $username, $password);
            // Attempt authentication, saving the result
            $result = $auth->authenticate($authAdapter);

            if (!$result->isValid()) {
                // Authentication failed; print the reasons why
                foreach ($result->getMessages() as $message) {
                    echo "$message<br>";
                }
            } else {
                echo 'Authentication is Ok';
                echo '<br />';
                echo 'Username is :';
                echo $auth->getIdentity();
            }
        }
    }

    /**
     * Logout Action
     *
     */
    public function logoutAction() {

        if (Zend_Auth::getInstance()->hasIdentity()) {
// Get Idenity
            $user = Zend_Auth::getInstance()->getIdentity();

// Log logout
            $logger = Zend_Registry::get('logger');
            $logger->log('User: ' . $user->username . ' has logged out.', Zend_Log::INFO);

// Clear Idenity
            Zend_Auth::getInstance()->clearIdentity();
        }
        $this->_helper->redirector('index', 'index');
    }

}

?>
