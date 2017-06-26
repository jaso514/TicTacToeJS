<?php
class RestController {
	/**
   * Property: method
   * The HTTP method this request was made in, either GET, POST, PUT or DELETE
   */
  protected $method = '';
  /**
   * Property: endpoint
   * The Model requested in the URI. eg: /files
   */
  protected $endpoint = '';
  /**
   * Property: args
   * Any additional URI components after the endpoint have been removed, in our
   * case, an integer ID for the resource. eg: /<endpoint>/<arg0>/<arg1>
   */
  protected $args = Array();
  /**
   * Property: request
   * All request params. eg: $_POST, $_GET
   */
  protected $request = Array();
  /**
   * Property: file
   * Stores the input of the PUT request
   */
	protected $file = Null;

  /**
   * Constructor: __construct
   * Allow for CORS, assemble and pre-process the data
   */
  public function __construct($controllerName, $action, $request) {
  	Global $__config;

    $this->method = $_SERVER['REQUEST_METHOD'];
    if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
      if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
        $this->method = 'DELETE';
      } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
        $this->method = 'PUT';
      } else {
        throw new Exception("Unexpected Header");
      }
    }

		$validAction = $this->_verifyAction($controllerName, $action, $__config);
		if ($validAction!==false) {
		//	$this->_response('Action Not Found', 404);
		//} else {
	    $this->args = $request;
	    $this->endpoint = $validAction;

	    switch($this->method) {
	      case 'DELETE':
	      case 'POST':
	        $this->request = $this->_cleanInputs($_POST);
	        break;
	      case 'GET':
	        $this->request = $this->_cleanInputs($_GET);
	        break;
	      case 'PUT':
	        $this->request = $this->_cleanInputs($_GET);
	        $this->file = file_get_contents("php://input");
	        break;
	      default:
	        $this->_response('Invalid Method', 405);
	        break;
	    }
		}
  }

	public function response($dataResponse, $status=200) {
    if (method_exists($this, $this->endpoint)) {
      return $this->_response($dataResponse, $status);
    }
    return $this->_response("No Endpoint: $this->endpoint", 404);
  }

  private function _response($data, $status = 200) {
    header("Access-Control-Allow-Orgin: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");
    header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
    return json_encode($data);
  }

  private function _cleanInputs($data) {
    $clean_input = Array();
    if (is_array($data)) {
      foreach ($data as $k => $v) {
        $clean_input[$k] = $this->_cleanInputs($v);
      }
    } else {
      $clean_input = trim(strip_tags($data));
    }
    return $clean_input;
  }

  private function _requestStatus($code) {
    $status = array(  
        200 => 'OK',
        404 => 'Not Found',   
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
    	); 
    return ($status[$code])?$status[$code]:$status[500]; 
  }

  private function _verifyAction($controllerName, $action, $config){
  	if (array_key_exists('rest', $config) && 
  			array_key_exists($controllerName, $config['rest']) &&
  			array_key_exists($this->method, $config['rest'][$controllerName]) &&
  			$config['rest'][$controllerName][$this->method]==strtolower($action)
  			) {
			return $config['rest'][$controllerName][$this->method];
  	}
  	return false;
  }
}