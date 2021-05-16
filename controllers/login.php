<?php

class Login extends Controller{
	
	function __construct(){
		parent::__construct();
		$this->view->render('login/login');
		$this->loadModel('login');
		if (isset($_COOKIE['token']) ){
			$this->model->run();	
		}
	}
	function run(){
		$this->model->run();
		
	}
}