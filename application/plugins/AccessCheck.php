<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {
    
    
   public function preDispatch() {
       
       echo 'check Mark';
   }
}


?>
