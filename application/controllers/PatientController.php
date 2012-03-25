<?php

class PatientController extends Zend_Controller_Action {

    private $_entityManager = null;
    private $_flashMessenger = null;
    private $_page = null;
    private $_itemNumber = null;

    public function init() {

        $this->_itemNumber = 30;
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');

        $form = new Application_Form_Patient();
        $this->view->form = $form;
    }

    public function indexAction() {

        $p = $this->getRequest()->getParams('keyword');

        if (isset($p['keyword'])) {

            $column = $p['column'];
            $column2 = 't.firstName';

            $qb = $this->_entityManager->createQueryBuilder()
                    ->select('p', 'o', 's', 't')
                    ->from('Entity\Patient', 'p')
                    ->leftJoin('p.assignedPhysician', 'o')
                    ->leftJoin('o.physician', 's')
                    ->leftJoin('p.patient', 't')
                    ->where($column . ' LIKE :specialty')
                    ->orWhere($column2 . ' LIKE :specialty')
                    ->setParameter('specialty', '%' . $p['keyword'] . '%')
                    ->orderBy($column);
            $q = $qb->getQuery();

            $result = $q->getArrayResult();

            return $this->view->patient = $result;
        }
        //print_r($result);
    }

    public function registerAction() {
        $form = new Application_Form_Register();
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
                $emailTest = $fn . "." . $ln . "@basewebdesign.ca";
                $docId = $sessionRole->physicianId;

                $qb = $this->_entityManager->createQueryBuilder()
                        ->select('p')
                        ->from('Entity\Person', 'p')
                        ->where('p.email = ' . "'$emailTest'");
                $q = $qb->getQuery();

                $result = $q->getArrayResult();

                // $urlOptions = array('controller' => 'patient', 'action' => 'index');
                // $this->_helper->redirector->gotoRoute($urlOptions);
            }

            //Redisplay form with values and error messages
            else {

                $form->populate($formData);
                $this->view->form = $form;
            }
            //If patient is an employee update Person table to change them as a Patient.
            if (count($result) > 0) {
                $qt = $this->_entityManager->createQueryBuilder()
                        ->select('c')
                        ->from('Entity\Person', 'c')
                        ->where('c.email = ' . "'$emailTest'");
                $q = $qt->getQuery();
                $result1 = $q->getResult();
                $cc = $result1[0];
                $cc->patient = 1;
                $this->_entityManager->persist($cc);
                $this->_entityManager->flush();
            } else {

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
                    $ldaprecord["description"] = "patient";
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
                        $person->patient = '1';
                        // $careCenterData->assignedPhysician = $docId;
                        //$careCenterData->contactDate = date("Y-m-d");
                        // $careCenterData->patientType = $type;
                        $person->email = $fn . "." . $ln . "@basewebdesign.ca";

                        $this->_entityManager->persist($person);
                        $this->_entityManager->flush();
                        $this->_entityManager->close();

                        $qb = $this->_entityManager->createQueryBuilder()
                                ->select('p')
                                ->from('Entity\Person', 'p')
                                ->where('p.email = ' . "'$emailTest'");
                        $q = $qb->getQuery();

                        $result = $q->getArrayResult();

                        $patient = new Entity\Patient;
                        print_r($patient);

                        $patient->assignedPhysician = $sessionRole->physicianId;

                        $patient->contactDate = date("Y-m-d");
                        $patient->patientId = $result[0][personId];
                        $patient->patientType = $type;
                        
                       
                        $this->_entityManager->persist($patient);
                        $this->_entityManager->flush();
                        echo "works";
                        exit();



                        //redirect to patient/index on successfull registration
                        $urlOptions = array('controller' => 'patient', 'action' => 'index');
                        $this->_helper->redirector->gotoRoute($urlOptions);
                    }
                } else {
                    echo "Unable to connect to LDAP server";
                }
            }
        }
    }

}

