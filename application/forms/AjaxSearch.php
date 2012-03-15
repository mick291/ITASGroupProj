<?php

/*
*	AJAX Search Form
*		Has a input box for searching
*/

class Application_Form_AjaxSearch extends Zend_Form
{
	public function init()
	{
		//Set the name of the form
		$this->setName('AjaxSearch');
			
		// *
		//Create Elements
		// *
		
		//Search field
		$searchcrit = new Zend_Form_Element_Text('searchcrit');
		$searchcrit->setLabel('Search:')
							->removeDecorator('label')
							->removeDecorator('HtmlTag')
							->setAttribs(array( 
							'size' => 65));
		
		//Elements to be added to form
		$elements = array(
			$searchcrit
		);
		$this->addElements($elements);
	}
}