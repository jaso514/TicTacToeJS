<?php

class Main {
  
  function __construct($__config) {
    $this->callHook();
  }

  function callHook() {
    global $__config;

    $url = $_SERVER['REQUEST_URI'];
    $pathInfo = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';
    
    if (strripos($pathInfo, '.css')>0 || strripos($pathInfo, '.js')>0) {
        $type = strripos($pathInfo, '.css')>0?'type/css':'type/js';
        if (file_exists(BASEPATH .DS. 'public'.DS.$pathInfo)) {
            header("Content-type: ".$type.";", true);
            require_once(BASEPATH .DS. 'public'.DS.$pathInfo);
            die;
        }
    }

    if(strpos($pathInfo, '/')===0){
      $pathInfo = substr($pathInfo, 1);
    }

    if(strrpos($pathInfo, '/')===(strlen($pathInfo)-1)){
      $pathInfo = substr($pathInfo, 0, -1);
    }
    
    $urlArray = !empty($pathInfo)?explode("/", $pathInfo):[];

    $controller = null;
    if (!empty($urlArray)) {
      $controller = empty($urlArray[0])?
          $__config['default_controller']:$urlArray[0];
      array_shift($urlArray);
    } else {
      $controller = $__config['default_controller'];
    }
    
    if (empty($controller)) {
      throw new Exception('Module not found');
      exit(404);
    }
    
    $controllerName = $controller;
    $controller = ucwords($controller);
    $controller .= 'Controller';
    
    $action = 'index';
    if(!empty($urlArray)){
      if ((int)method_exists($controller, $urlArray[0])) {
        $action = $urlArray[0];
        array_shift($urlArray);
      }
    }
    
    $queryString = $urlArray;
    $dispatch = new $controller($controllerName, $action, $queryString);

    //print_r($queryString);die;
    if ((int)method_exists($controller, $action)) {
      call_user_func_array(array($dispatch,$action),$queryString);
    } else {
      throw new Exception('Not Found', 404);
    }
  }
  
}