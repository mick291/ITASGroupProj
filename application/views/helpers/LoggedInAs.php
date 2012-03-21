<?php

class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract {

    public function loggedInAs() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $edit = $this->view->url(array('controller' => 'user', 'action' => 'edit'));

            $username = $auth->getIdentity();
            $logoutUrl = $this->view->url(array('controller' => 'auth',
                'action' => 'logout'), null, true);
            return 'Welcome ' . $username . '.<br /> <a href="' . $logoutUrl . '">Logout</a>' . ' | <a href="' . $edit . '">Edit</a>';
        }

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        if ($controller == 'auth' && $action == 'index') {
            return '';
        }
        $loginUrl = $this->view->url(array('controller' => 'auth', 'action' => 'login'));
       
        return '<a href="' . $loginUrl . '">Login</a>';
    }

}

?>
