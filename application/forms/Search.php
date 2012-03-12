
<?php

class Application_Form_Search extends Zend_Form {

    public function init() {

             $this->setName('search');
             $this->setMethod('get');
        
        $column = new Zend_Form_Element_Select('column');
        $column->setLabel('Search By:')
              ->setMultiOptions(array('p.specialty'=>'Specialty', 
                  'o.firstName'=>'Name'))
              ->setRequired(true)->addValidator('NotEmpty', true);
        $keyword = new Zend_Form_Element_Text('keyword');
        $keyword->setLabel('Search For: ')
                  ->setRequired(true)
                  ->addValidator('NotEmpty'); 
        
        $submit = new Zend_Form_Element_Submit('search');
        $submit->setLabel('Search');
        
        $this->addElements(array($column, $keyword, $submit));
    }

}

