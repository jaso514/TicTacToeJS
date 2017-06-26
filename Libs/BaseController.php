<?php
class BaseController {
	protected $_template;

  public function __construct($controllerName, $action) {
  	$this->_template = new Template(
  		str_replace("Controller", "", $controllerName));
  }

}