<?php

class Bootstrap{
	
	function __construct(){
		
		$URL_Path=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$url=explode('/',trim($URL_Path, '/'));
		//print_r($url);
		$controller_name='login';
		$action_name='__construct';
		if (empty($url[1]) || empty($url[0])){
			require_once 'controllers/login.php';
			$controller_name='login';
			
		}
		if (isset($url[1])){
			$controller_name=$url[1];
		}
		if (isset($url[2])){
			$action_name=$url[2];
		}
		$file='controllers/'. $controller_name . '.php';
		if(file_exists($file)){
			require_once $file;
		} else{
			require_once  'controllers/error.php';
			$controller=new Error_404();
			die();
		}
		
		
		$controller = new $controller_name;
		if (isset($url[1])){
		$controller->loadModel($url[1]);
		}
		else{
			$controller->loadModel('login');
		}
		if (isset($url[2])){
		
			if(method_exists($controller, $action_name))
			{
			
			$controller->$action_name();
			
			}
		}
	}
}