<?php 

 class Database extends PDO{
	 public function __construct(){
		 parent::__construct('mysql:host=localhost;dbname=bmhmh', 'bmhmh', 'RghSJsn21*#12&UDshna');
	 }
 }
 ?>