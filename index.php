<?php
define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', str_replace('\\', '/', dirname(__FILE__)));

require BASEPATH . '/core/Main.php';
require BASEPATH . '/core/config.php';
$main = new Main($__config);

function __autoload($className){
    if (file_exists(BASEPATH .DS. 'Libs' .DS. $className . '.php')) {
    	// find some library
        require_once(BASEPATH .DS. 'Libs' .DS. $className . '.php');
    } else if (file_exists(BASEPATH .DS. 'App'.DS.'Controllers' .DS. $className . '.php')) {
    	// find and controller class, form anotther controller or url
      require_once(BASEPATH .DS. 'App'.DS.'Controllers' .DS. $className . '.php');
    } else {
        /* Error Generation Code Here */
    }
}
