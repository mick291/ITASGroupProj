
<?php

class Application_Form_Patient extends Zend_Form {

    public function init() {

            $this->setName('search');
             $this->setMethod('post');
        
        $column = new Zend_Form_Element_Select('column');
        $column->setLabel('Search By:')
              ->setMultiOptions(array('t.lastName'=>'Name', 
                  's.lastName'=>'Assigned Physician',
                  'p.patientType'=>'Patient Type'))
              ->setRequired(true)->addValidator('NotEmpty', true);
        $keyword = new Zend_Form_Element_Text('keyword');
        $keyword->setLabel('Search For: ')
                  ->setRequired(true)
                  ->addValidator('NotEmpty'); 
      
        $this->addElements(array($column, $keyword));
    }

}

