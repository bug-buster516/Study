<?php 

class Data extends Controller{
	
	function __construct(){
		parent::__construct();
		if (isset($_COOKIE['token']) ){
		$this->loadModel('data');
		$this->model->tokenCheck();	
		}
		else{
			header('Location: /index.php/login');
		}
		
	}
	
	public function show(){
		$this->view->content=$this->model->getAllRecords();
		$this->view->render('data/data');
	}
	public function filter(){
		$this->view->content=$this->model->filterRecords();
		$this->view->render('data/data');
	}
}
?>