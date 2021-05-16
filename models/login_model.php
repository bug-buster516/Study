<?php

class Login_Model extends Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function run(){
		$today = date("Y-m-d H:i:s"); 
		if (isset($_COOKIE['token']) ){
			$sth = $this->db->query("UPDATE users SET Token=NULL WHERE LastTimeLogin< DATE_SUB(NOW(), INTERVAL 1 HOUR) ");
			$tk=$_COOKIE['token'];
			$sth = $this->db->query("SELECT COUNT(*)FROM users WHERE Token='$tk'")->fetchColumn();
			if($sth==1){
			$login=$this->db->query("SELECT Login FROM users WHERE Token='$tk'")->fetchColumn();
			$temp=1;
			while($temp==1){
			$string="1qay2wsx3edc4rfv5tgb6zhn7ujm8ik9olpAQWSXEDCVFRTGNHYZUJMKILOP";
			$s='';
			$r_new='';
			$r_old='';
		
			for ($i=1; $i< 32; $i++){
			
				while ($r_old == $r_new){
					
					$r_new=rand(0,59);
				
				}
				$r_old=$r_new;
				$s=$s.$string[$r_new];
				
			
			}
			$temp= $this->db->query("SELECT COUNT(*)FROM users WHERE Token='$s'")->fetchColumn();
			}
			$sth = $this->db->query("UPDATE users SET Token='$s', LastTimeLogin='$today' WHERE Login = '$login'");
			$sth->execute();
			setcookie('token', $s, time()+3600, '/');
			header('Location: /index.php/data/show');
			} else {
				header('Location: /index.php/login');
			}
		} else{
		$login = $_POST['login'];
		$password = $_POST['password'];
		$sth = $this->db->query("UPDATE users SET Token=NULL WHERE LastTimeLogin< DATE_SUB(NOW(), INTERVAL 1 HOUR) ");
		$sth = $this->db->query("SELECT COUNT(*)FROM users WHERE login='$login' AND password=md5('$password')")->fetchColumn();
		
		if ($sth ==1){
			$temp=1;
			while($temp==1){
			$string="1qay2wsx3edc4rfv5tgb6zhn7ujm8ik9olpAQWSXEDCVFRTGNHYZUJMKILOP";
			$s='';
			$r_new='';
			$r_old='';
		
			for ($i=1; $i< 32; $i++){
			
				while ($r_old == $r_new){
					
					$r_new=rand(0,59);
				
				}
				$r_old=$r_new;
				$s=$s.$string[$r_new];
				
			
			}
			$temp= $this->db->query("SELECT COUNT(*)FROM users WHERE Token='$s'")->fetchColumn();
			}
			$sth = $this->db->query("UPDATE users SET Token='$s', LastTimeLogin='$today' WHERE Login = '$login'");
			$sth->execute();
			setcookie('token', $s, time()+3600, '/');
			header('Location: /index.php/data/show');
		}
		else{
			header('Location: /index.php/login');
			
		}
		}
	}
}
?>