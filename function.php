<?php
require_once 'connection.php';

class func{
		public static function createString($len){
		
		$string="1qay2wsx3edc4rfv5tgb6zhn7ujm8ik9olpAQWSXEDCVFRTGNHYZUJMKILOP";
		$s='';
		$r_new='';
		$r_old='';
		
		for ($i=1; $i< $len; $i++){
			
			while ($r_old == $r_new){
				
				$r_new=rand(0,59);
				
			}
			$r_old=$r_new;
			$s=$s.$string[$r_new];
			
		}
		
		return $s;
		
	}
	
	public static function checkLoginState($pdo){
		
		if (isset($_COOKIE['token']) ){
		session_start();
		$newtoken='';
		$token=$_COOKIE['token'];
		$nRows = $pdo->query("SELECT COUNT(*) FROM trusers WHERE token='$token'")->fetchColumn();
			if($nRows==1){
				$newtoken=func::createString(32);
				$_SESSION['name'] = $row['Name'];
				$_SESSION['surname'] = $row['LastName'];
				$stmt=$pdo->prepare("UPDATE trusers SET token=? WHERE token=?");
				$stmt->execute([$newtoken, $token]);
				setcookie('token', $newtoken, time()+3600, '/');
				return true;
			}
		}
	}

}