<?php

/*
*   Auth Form
*   Has fields for the Auth model.
*/

class Application_Form_Auth extends Zend_Form
{
    public function init()
    {
        // *
        //Set Form Options
        // *

        //Set the name of the form
        $this->setName('Auth');


        // *
        //Create Elements
        // *

        //Username Field
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username:');

        //Password Field
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password:');

        //Submit Button
        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->removeDecorator('DtDdWrapper');

        //Elements to be added to form
        $elements = array(
            $username,
            $password,
            $submit
        );
        $this->addElements($elements);

        // *
        //Create Display Groups
        // *

        //Auth Display Group
        $this->addDisplayGroup(array(
            'username',
            'password',
        ), 'auth', array('legend' => 'Login Information'));
        $authDisplayGroup = $this->getDisplayGroup('auth');
        $authDisplayGroup->setDecorators(array(
            'FormElements',
            array(array('deflist' => 'HtmlTag'), array('tag' => 'dl')),
            'Fieldset',
            array(array('div' => 'HtmlTag'), array('tag'=>'div','class'=>'auth')),
        ));

        //Submit Display Group
        $this->addDisplayGroup(array(
            'Submit',
        ), 'submit');
        $submitDisplayGroup = $this->getDisplayGroup('submit');
        $submitDisplayGroup->setDecorators(array(
            'FormElements',
            array(array('deflist' => 'HtmlTag'), array('tag' => 'dl')),
            'Fieldset',
            array(
                array('div' => 'HtmlTag'), array(
                    'tag'=>'div',
                    'class'=>'submit',
                    'style'=>'clear:both; padding-top:10px;'
                )),
        ));


        //Form Decorators to format form
        $this->setDecorators(array(
            'FormElements',
            'Form'
        ));
    }
}

?>