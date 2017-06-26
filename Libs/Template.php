<?php

class Template {
  protected $_controller;
   
  function __construct($controller) {
    $this->_controller = $controller;
  }
 
  /** Display Template **/
  function render($view, $data=[]) {
    extract($data);
    if (file_exists(BASEPATH . DS . 'App' . DS . 'Views' . DS . 'header.php')) {
      include (BASEPATH . DS . 'App' . DS . 'Views' . DS . 'header.php');
    }
 
    include (BASEPATH . DS . 'App' . DS . 'Views' . DS . $this->_controller . DS . $view . '.php'); 
       
    if (file_exists(BASEPATH . DS . 'App' . DS . 'Views' . DS . 'footer.php')) {
      include (BASEPATH . DS . 'App' . DS . 'Views' . DS . 'footer.php');
    }
  }
 
}