<?php

class EmployeeController extends Zend_Controller_Action {

    private $_entityManager = null;
    private $_flashMessenger = null;
    private $_page = null;
    private $_itemNumber = null;

    public function init() {


        $this->_itemNumber = 30;
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');

        $form = new Application_Form_Employee();
        $this->view->form = $form;
    }

    public function indexAction() {
       
    }
    
    public function techAction(){
    
              $params = array(
            'dbname' => 'itas288_medds',
            'user' => 'zend',
            'password' => 'medds',
            'host' => '142.25.97.201',
            'driver' => 'pdo_mysql'
        );

        $conn = Doctrine\DBAL\DriverManager::getConnection($params);
        $sql = "SELECT * FROM tech";
        $stmt = $conn->query($sql);
        
        $this->view->tech = $stmt->fetchAll();
    }

    public function empregisterAction() {
        $form = new Application_Form_Employee();
        $sessionRole = new Zend_Session_Namespace('sessionRole');

        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {

                $formData = $this->_request->getPost();

                $fn = $form->getValue('firstname');
                $ln = $form->getValue('lastname');
                $address = $form->getValue('address');
                $postal = $form->getValue('postal');
                $phone = $form->getValue('phone');
                $dob = $form->getValue('date');
                $type = $form->getValue('type');
                $skill = $form->getValue('skill');

                // $urlOptions = array('controller' => 'patient', 'action' => 'index');
                // $this->_helper->redirector->gotoRoute($urlOptions);
            }


            //Redisplay form with values and error messages
            else {

                $form->populate($formData);
                $this->view->form = $form;
            }

            $LDAPHost = "142.25.97.201";       //Your LDAP server DNS Name or IP Address
            $dn = "DC=basewebdesign,DC=ca"; //Put your Base DN here
            $LDAPUserDomain = "@basewebdesign.ca";  //Needs the @, but not always the same as the LDAP server domain
            $LDAPUser = "administrator";        //A valid Active Directory login
            $LDAPUserPassword = "GR0UP!M@!L";

            $cnx = ldap_connect($LDAPHost) or die("Could not connect to LDAP");
            if ($cnx) {

                ldap_set_option($cnx, LDAP_OPT_PROTOCOL_VERSION, 3);  //Set the LDAP Protocol used by your AD service
                ldap_set_option($cnx, LDAP_OPT_REFERRALS, 0);         //This was necessary for my AD to do anything
                ldap_bind($cnx, $LDAPUser . $LDAPUserDomain, $LDAPUserPassword) or die("Could not bind to LDAP");
                error_reporting(E_ALL ^ E_NOTICE);

                $cn = $fn . " " . $ln;

                $dn = "cn=$cn , ou=Patient, dc=basewebdesign,dc=ca";

                $newPassword = "GR0UP!M@!l";
                $len = strlen($newPassword);
                $newPassw = "";
                for ($i = 0; $i < $len; $i++) {
                    $newPassw .= "{$newPassword{$i}}\000";
                }

                $ldaprecord['cn'] = $fn . " " . $ln;
                $ldaprecord['displayName'] = $fn . " " . $ln;
                $ldaprecord['name'] = $fn . " " . $ln;
                $ldaprecord['givenname'] = $fn;
                $ldaprecord['sn'] = $ln;
                $ldaprecord['homephone'] = $phone;
                $ldaprecord["description"] = "employee";
                $ldaprecord["userpassword"] = $newPassw;
                $ldaprecord["streetAddress"] = $address;
                $ldaprecord["postalCode"] = $postal;
                $ldaprecord["userprincipalname"] = $fn . "." . $ln . "@basewebdesign.ca";
                $ldaprecord['objectclass'] = array("top", "person", "organizationalPerson", "user");
                $ldaprecord["sAMAccountName"] = $fn . "." . $ln;
                // $ldaprecord["unicodepwd"] = $newPassw;
                $ldaprecord["UserAccountControl"] = "544";

                if (ldap_add($cnx, $dn, $ldaprecord) != false) {



                    // $email = $fn . "." . $ln . "@basewebdesign.ca";
                    // $employee = 1;
                    // $nurse = new Entity\Nurse($skill, $address, $dob, $fn, $ln, $email, $phone, $postal, $employee);
//                    $this->_entityManager->persist($nurse);
//                    $this->_entityManager->flush();


                    $person = new Entity\Person;
                    $person->firstName = $fn;
                    $person->lastName = $ln;
                    $person->address = $address;
                    $person->birthDate = $dob;
                    $person->phoneNumber = $phone;
                    $person->zipCode = $postal;
                    $person->employee = 1;
                    $person->email = $fn . "." . $ln . "@basewebdesign.ca";

                    $this->_entityManager->persist($person);
                    $this->_entityManager->flush();

                    $employee = new Entity\Employee;
                    $employee->employee = $person;
                    $employee->dateHired = date("Y-m-d");

                    $this->_entityManager->persist($employee);
                    $this->_entityManager->flush();

                    if ($type == "nurse") {
                        $params = array(
                            'dbname' => 'itas288_medds',
                            'user' => 'zend',
                            'password' => 'medds',
                            'host' => '142.25.97.201',
                            'driver' => 'pdo_mysql'
                        );

                        $conn = Doctrine\DBAL\DriverManager::getConnection($params);
                        $conn->insert('nurse', array('certificate' => $skill, 'nurse_id' => $person->personId));


                        echo "works";
                    } elseif ($type == "staff") {
                        $params = array(
                            'dbname' => 'itas288_medds',
                            'user' => 'zend',
                            'password' => 'medds',
                            'host' => '142.25.97.201',
                            'driver' => 'pdo_mysql'
                        );

                        $conn = Doctrine\DBAL\DriverManager::getConnection($params);
                        $conn->insert('staff', array('job_class' => $skill, 'staff_id' => $person->personId));
                    } elseif ($type == "technician") {
                        $params = array(
                            'dbname' => 'itas288_medds',
                            'user' => 'zend',
                            'password' => 'medds',
                            'host' => '142.25.97.201',
                            'driver' => 'pdo_mysql'
                        );

                        $conn = Doctrine\DBAL\DriverManager::getConnection($params);
                        $conn->insert('technician', array('skill' => $skill, 'technician_id' => $person->personId));
                        
                    } elseif ($type == "volunteer") {
                        $volunteer = new Entity\Volunteer;

                        $volunteer->skill = $skill;
                        $volunteer->volunteer = $person;

                        $this->_entityManager->persist($volunteer);
                        $this->_entityManager->flush();
                    }
                }
            } else {
                echo "Unable to connect to LDAP server";
            }
        }
    }

    public

    function docregisterAction() {
        $form = new Application_Form_docEmployee();
        $sessionRole = new Zend_Session_Namespace('sessionRole');

        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {

                $formData = $this->_request->getPost();

                $fn = $form->getValue('firstname');
                $ln = $form->getValue('lastname');
                $address = $form->getValue('address');
                $postal = $form->getValue('postal');
                $phone = $form->getValue('phone');
                $pager = $form->getValue('pager');
                $dob = $form->getValue('date');
                $type = $form->getValue('type');


                // $urlOptions = array('controller' => 'patient', 'action' => 'index');
                // $this->_helper->redirector->gotoRoute($urlOptions);
            }


            //Redisplay form with values and error messages
            else {

                $form->populate($formData);
                $this->view->form = $form;
            }

            $LDAPHost = "142.25.97.201";       //Your LDAP server DNS Name or IP Address
            $dn = "DC=basewebdesign,DC=ca"; //Put your Base DN here
            $LDAPUserDomain = "@basewebdesign.ca";  //Needs the @, but not always the same as the LDAP server domain
            $LDAPUser = "administrator";        //A valid Active Directory login
            $LDAPUserPassword = "GR0UP!M@!L";

            $cnx = ldap_connect($LDAPHost) or die("Could not connect to LDAP");
            if ($cnx) {

                ldap_set_option($cnx, LDAP_OPT_PROTOCOL_VERSION, 3);  //Set the LDAP Protocol used by your AD service
                ldap_set_option($cnx, LDAP_OPT_REFERRALS, 0);         //This was necessary for my AD to do anything
                ldap_bind($cnx, $LDAPUser . $LDAPUserDomain, $LDAPUserPassword) or die("Could not bind to LDAP");
                error_reporting(E_ALL ^ E_NOTICE);

                $cn = $fn . " " . $ln;

                $dn = "cn=$cn , ou=Physician, dc=basewebdesign,dc=ca";

                $newPassword = "GR0UP!M@!l";
                $len = strlen($newPassword);
                $newPassw = "";
                for ($i = 0; $i < $len; $i++) {
                    $newPassw .= "{$newPassword{$i}}\000";
                }

                $ldaprecord['cn'] = $fn . " " . $ln;
                $ldaprecord['displayName'] = $fn . " " . $ln;
                $ldaprecord['name'] = $fn . " " . $ln;
                $ldaprecord['givenname'] = $fn;
                $ldaprecord['sn'] = $ln;
                $ldaprecord['homephone'] = $ldaprecord['homephone'] = $phone;
                $ldaprecord['mobile'] = $pager;
                $ldaprecord["description"] = "doctor";
                $ldaprecord["userpassword"] = $newPassw;
                $ldaprecord["streetAddress"] = $address;
                $ldaprecord["postalCode"] = $postal;
                $ldaprecord["userprincipalname"] = $fn . "." . $ln . "@basewebdesign.ca";
                $ldaprecord['objectclass'] = array("top", "person", "organizationalPerson", "user");
                $ldaprecord["sAMAccountName"] = $fn . "." . $ln;
                // $ldaprecord["unicodepwd"] = $newPassw;
                $ldaprecord["UserAccountControl"] = "544";

                if (ldap_add($cnx, $dn, $ldaprecord) != false) {

                    $person = new Entity\Person;

                    $person->firstName = $fn;
                    $person->lastName = $ln;
                    $person->address = $address;
                    $person->birthDate = $dob;
                    $person->phoneNumber = $phone;
                    $person->zipCode = $postal;
                    $person->physician = 1;
                    // $careCenterData->patientType = $type;
                    $person->email = $fn . "." . $ln . "@basewebdesign.ca";

                    $this->_entityManager->persist($person);
                    $this->_entityManager->flush();


                    $physician = new Entity\Physician;
                    $physician->specialty = $type;
                    $physician->pagerNumber = $pager;
                    //$physician->physicianId = $person->personId;
                    $physician->physician = $person;

                    $this->_entityManager->persist($physician);

                    $this->_entityManager->flush();
                }
            } else {
                echo "Unable to connect to LDAP server";
            }
        }
    }

}

