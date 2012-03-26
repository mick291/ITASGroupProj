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
        $this->_itemNumber = 30;
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->_customerRepo = $this->_entityManager->getRepository('Entity\Person');
    }

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
                $sessionRole = new Zend_Session_Namespace('sessionRole');

                echo $email = $auth->getIdentity();


                $qb = $this->_entityManager->createQueryBuilder()
                        ->select('p', 'o')
                        ->from('Entity\Physician', 'p')
                        ->leftJoin('p.physician', 'o')
                        ->where('o.email = ' . "'$email'");
                //   ->setParameter('email', $auth->getIdentity());

                $result = $qb->getQuery();
                $userInfo = $result->getArrayResult();
                $sessionRole->physicianId = $userInfo[0]['physicianId'];
                // exit();
                //
                //test
                $SearchFor = $auth->getIdentity();               //What string do you want to find?
                $SearchField = "userprincipalname";   //In what Active Directory field do you want to search for the string?

                $LDAPHost = "142.25.97.201";       //Your LDAP server DNS Name or IP Address
                $dn = "DC=basewebdesign,DC=ca"; //Put your Base DN here
                $LDAPUserDomain = "@basewebdesign.ca";  //Needs the @, but not always the same as the LDAP server domain
                $LDAPUser = "vmail";        //A valid Active Directory login
                $LDAPUserPassword = "GR0UP!M@!L";
                $LDAPFieldsToFind = array("cn", "sn", "givenname", "samaccountname", "description", "telephonenumber", "userprincipalname");

                $cnx = ldap_connect($LDAPHost) or die("Could not connect to LDAP");
                ldap_set_option($cnx, LDAP_OPT_PROTOCOL_VERSION, 3);  //Set the LDAP Protocol used by your AD service
                ldap_set_option($cnx, LDAP_OPT_REFERRALS, 0);         //This was necessary for my AD to do anything
                ldap_bind($cnx, $LDAPUser . $LDAPUserDomain, $LDAPUserPassword) or die("Could not bind to LDAP");
                error_reporting(E_ALL ^ E_NOTICE);   //Suppress some unnecessary messages
                $filter = "($SearchField=$SearchFor*)"; //Wildcard is * Remove it if you want an exact match
                $sr = ldap_search($cnx, $dn, $filter, $LDAPFieldsToFind);
                $info = ldap_get_entries($cnx, $sr);


                for ($x = 0; $x < $info["count"]; $x++) {
                    $sam = $info[$x]['samaccountname'][0];
                    $giv = $info[$x]['givenname'][0];
                    $last = $info[$x]['sn'][0];
                    $tel = $info[$x]['telephonenumber'][0];
                    $upn = $info[$x]['userprincipalname'][0];
                    $nam = $info[$x]['cn'][0];
                    $dis = $info[$x]['description'][0];
                    $pos = strpos($dir, "home");
                    $pos = $pos + 5;
                }


                if ($x == 0) {

                    print "Oops, $SearchField $SearchFor was not found. Please try again.\n";
                }
                //end test


                $sessionRole->role = $dis;
                $sessionRole->email = $upn;

                $user = $auth->getIdentity();

                   $urlOptions = array('controller' => 'index', 'action' => 'index');
                   $this->_helper->redirector->gotoRoute($urlOptions);
            }
        }
    }

    /**
     * Logout Action
     *
     */
    public function logoutAction() {

        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            Zend_Session::destroy();
            $this->_helper->redirector('login'); // back to login page
        }
    }

}

?>
