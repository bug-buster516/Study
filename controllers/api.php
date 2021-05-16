<?php
class Api extends Controller{
	
	function __construct(){
		parent::__construct();
		
		
	}
	function Login(){
		$this->model->login();
	}
	function AddRecord(){
		$this->model->AddRecord();
	}
	function NewPassword(){
		$this->model->NewPassword();
	}
	function getRecords(){
		$this->model->getRecords();
	}
	function NewUser(){
		$this->model->NewUser();
	}
	function TestHash(){
		$this->model->TestHash();
	}
}

?>