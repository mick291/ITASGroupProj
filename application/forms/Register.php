<?php

class Application_Form_Register extends Zend_Form {

    public function init() {
        $this->setName("Register");
        $this->setMethod('post');


        $type = new Zend_Form_Element_Select('type');
        $type->setLabel('Patient Type:');

        $type->setMultiOptions(array(
            'Out Patient',
            'In Patient'
        ));
        $this->addElement($type);
        $firstname = new Zend_Form_Element_Text('firstname');
        $firstname->setLabel('First Name:')
                ->setRequired(true)
                ->addFilter('StringTrim')
                ->addFilter('StripTags')
                ->addErrorMessage("Please ensure your name only contains letters")
                ->addValidator('Regex', false, array('/[a-zA-Z ]$/')); // Only chars from a-z and spaces
        $this->addElement($firstname);

        $lastname = new Zend_Form_Element_Text('lastname');
        $lastname->setLabel('Last Name:')
                ->setRequired(true)
                ->addFilter('StringTrim')
                ->addFilter('StripTags')
                ->addErrorMessage("Please ensure your name only contains letters")
                ->addValidator('Regex', false, array('/[a-zA-Z ]$/')); // Only chars from a-z and spaces;
        $this->addElement($lastname);

        $address = new Zend_Form_Element_Text('address');
        $address->setLabel('Address:')
                ->setRequired(true)
                ->addFilter('StringTrim')
                ->addFilter('StripTags');
        $this->addElement($address);

        $postal = new Zend_Form_Element_Text('postal');
        $postal->setLabel('Postal Code')
                ->setRequired(true)
                ->addFilter('StringTrim')
                ->addFilter('StripTags')
                ->addErrorMessage("A valid Postal Code is Required")
                ->addValidator('PostCode', true, array('format' => '^[a-zA-Z]\d[a-zA-Z] ?\d[a-zA-Z]\d$'));
        $this->addElement($postal);

        $dob = new Zend_Form_Element_Text('date');
        $dob->setLabel('DoB: ')
                ->setRequired(true)
                ->addValidator('NotEmpty', true)
                ->addErrorMessage("DoB Format is YYYY-MM-DD")
                ->addValidator('date', 'YYYY-MM-DD'); // Month-Day-Year
        $this->addElement($dob);

        $email = $this->createElement('text', 'email');
        $email->setLabel('Email Address: ')
                ->setRequired(true)
                ->addValidator('EmailAddress')
                ->addValidator('Db_NoRecordExists', true, array('users', 'email',
                    'messages' => array(
                        Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND => 'Email address already exists'
                        )));
        $this->addElement($email);

        $register = $this->createElement('submit', 'register');
        $register->setLabel('Sign up')
                ->setIgnore(true);
        $this->addElement($register);
    }

}