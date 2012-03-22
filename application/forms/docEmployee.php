<?php

class Application_Form_docEmployee extends Zend_Form {

    public function init() {
        $this->setName("Register");
        $this->setMethod('post');

        $type = new Zend_Form_Element_Select('type');
        $type->setLabel('Specialty:')
              ->setMultiOptions(array( 
                  'Heart Surgeon'=>'Heart Surgeon',
                  'Brain Surgeon' => 'Brain Surgeon',
                  'Spine Surgeon' => 'Spine Surgeon'))
              ->setRequired(true)->addValidator('NotEmpty', true);
        
        
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

        $phone = new Zend_Form_Element_Text('phone');
        $phone->setLabel('Phone Number: ')
                ->setAttrib('size', 11)
                ->addValidator('Digits')
                ->addFilter('Digits');
        $this->addElement($phone);
        
         $pager = new Zend_Form_Element_Text('pager');
        $pager->setLabel('Pager Number: ')
                ->setAttrib('size', 11)
                ->addValidator('Digits')
                ->addFilter('Digits');
        $this->addElement($pager);

        $register = $this->createElement('submit', 'register');
        $register->setLabel('Sign up')
                ->setIgnore(true);
        $this->addElement($register);
    }

}