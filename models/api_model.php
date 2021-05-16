<?php
class Api_Model extends Model{
	
	private const key = 'aesEncryptionKeyaesEncryptionKey';
	private const iv = 'encryptionIntVec';
	private const encrypt_method = "AES-256-CBC";

	public function __construct(){
		parent::__construct();
	}
	
	private function checkHeaders(){
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

		if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 		  header( "HTTP/1.1 200 OK" );
  		 exit;
		}
	}


	public function login(){
		self::checkHeaders();
		$sth = $this->db->query("UPDATE users SET Token=NULL WHERE LastTimeLogin< DATE_SUB(NOW(), INTERVAL 1 HOUR) ");
		$json_str = file_get_contents('php://input');
		$info = json_decode($json_str,true);
		$login=openssl_decrypt($info["login"], self::encrypt_method, self::key, 0, self::iv);
		$password=openssl_decrypt($info["password"], self::encrypt_method, self::key, 0, self::iv);
		$sth = $this->db->query("SELECT COUNT(*)FROM users WHERE login='$login' AND password=md5('$password')")->fetchColumn();
		
		if ($sth ==1){
			$today = date("Y-m-d H:i:s"); 
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
			$s = openssl_encrypt($s, self::encrypt_method, self::key, 0, self::iv);
                        $respons= array('token'=>$s);
			header('Content-type: application/json');
			echo json_encode( $respons,  JSON_UNESCAPED_SLASHES );
		}
		else{
			$respons = array('response'=> 'Wrong login/password!');
			
			 header('Content-type: application/json');
			echo json_encode( $respons,  JSON_UNESCAPED_SLASHES);
		}
	}

	public function AddRecord(){
		self::checkHeaders();
		$json_str = file_get_contents('php://input');
		$info = json_decode($json_str,true);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		foreach($info['data'] as $mydata)
		{
			$phon=($mydata['phone']);
			$us=($mydata['user']);
			$ev=($mydata['event']);
			$ps=($mydata['pass']);
			$nrows= $this->db->query("SELECT COUNT(*)FROM passwords WHERE pass='$ps'")->fetchColumn();
			if($nrows==1){
			$sth = $this->db->query("INSERT INTO `data`( `Date`, `Time`, `Phone`, `UserId`, `EventsId`) VALUES ('$date', '$time','$phon','$us','$ev')");}
		}    
		$results[0]='succes';
		header('Content-type: application/json');
		echo json_encode( $results,  JSON_UNESCAPED_SLASHES );
		}

	public function NewPassword(){
		self::checkHeaders();
		$json_str = file_get_contents('php://input');
		$info = json_decode($json_str,true);
		$login=openssl_decrypt($info["login"], self::encrypt_method, self::key, 0, self::iv);
		$password= openssl_decrypt($info["password"], self::encrypt_method, self::key, 0, self::iv);
		$password2=openssl_decrypt($info["password2"], self::encrypt_method, self::key, 0, self::iv);
		$sth = $this->db->query("SELECT COUNT(*)FROM users WHERE login='$login' AND password=md5('$password')")->fetchColumn();
		if ($sth ==1){
			$sth = $this->db->query("UPDATE `users` SET password=md5('$password2'), Token=NULL WHERE login='$login' ");
			$response = array();
			$response[0] = 'Success';
			header('Content-type: application/json');
			echo json_encode( $response,  JSON_UNESCAPED_SLASHES );
		}
		else{
			$response = array();
			$response[0] = 'Wrong login/password';
			header('Content-type: application/json');
			echo json_encode( $response,  JSON_UNESCAPED_SLASHES );
		}	
	}

	public function getRecords(){
		self::checkHeaders();
		$json_str = file_get_contents('php://input');
		$info = json_decode($json_str,true);
		$tkn=openssl_decrypt($info["token"], self::encrypt_method, self::key, 0, self::iv);
		$sth = $this->db->query("SELECT COUNT(*)FROM users WHERE token='$tkn'")->fetchColumn();
		if ($sth ==1){
		$stmt = $this->db->prepare("SELECT  Date, Time, Phone, 
			(SELECT Events FROM eventscode
			WHERE eventscode.Id = data.EventsId) AS Event,
			(SELECT User FROM userscode 
			WHERE userscode.Id = data.UserId) AS Name
			FROM data ORDER BY Date DESC, Time DESC");

		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($results as $key => $v){
			$results[$key]['Date']=openssl_encrypt($results[$key]['Date'], self::encrypt_method, self::key, 0, self::iv);	
			$results[$key]['Phone']=openssl_encrypt($results[$key]['Phone'], self::encrypt_method, self::key, 0, self::iv);	
			$results[$key]['Event']=openssl_encrypt($results[$key]['Event'], self::encrypt_method, self::key, 0, self::iv);	
			$results[$key]['Name']=openssl_encrypt($results[$key]['Name'], self::encrypt_method, self::key, 0, self::iv);	
			$results[$key]['Time']=openssl_encrypt($results[$key]['Time'], self::encrypt_method, self::key, 0, self::iv);	
		}
		header('Content-type: application/json');
		echo json_encode( $results );
		}
		else{
		$response = array();
		$response[0] = 'Wrong/outdated token';
		header('Content-type: application/json');
		echo json_encode( $response,  JSON_UNESCAPED_SLASHES );
}
          }	
		  
	public function NewUser(){
			
		self::checkHeaders();
		
		$json_str = file_get_contents('php://input');
		$info = json_decode($json_str,true);
		$login=openssl_decrypt($info["login"], self::encrypt_method, self::key, 0, self::iv);
		$password=openssl_decrypt($info["password"], self::encrypt_method, self::key, 0, self::iv);
		$name=openssl_decrypt($info["name"], self::encrypt_method, self::key, 0, self::iv);
		$surname=openssl_decrypt($info["surname"], self::encrypt_method, self::key, 0, self::iv);
		$email=openssl_decrypt($info["email"], self::encrypt_method, self::key, 0, self::iv);
		$sth = $this->db->query("SELECT COUNT(*)FROM users WHERE login='$login'")->fetchColumn();
		if ($sth ==1){
			$respons = array('response'=> 'This login already exists!');
			header('Content-type: application/json');
			echo json_encode( $respons,  JSON_UNESCAPED_SLASHES);
		} else{
			$sth = $this->db->query("INSERT INTO `users`( `Name`, `Lastname`, `Email`, `Login`, `Password`) VALUES ('$name', '$surname','$email','$login',md5('$password'))");
			$respons = array('response'=> 'Success');
			header('Content-type: application/json');
			echo json_encode( $respons,  JSON_UNESCAPED_SLASHES);
		}
		}

		
		public function TestHash(){

		self::checkHeaders();
		$json_str = file_get_contents('php://input');
		$req = json_decode($json_str,true);
		$string=($req["key"]);
		$dehash = openssl_decrypt($string, self::encrypt_method, self::key, 0, self::iv);
		$ehsh = openssl_encrypt($dehash, self::encrypt_method, self::key, 0, self::iv);
		$respons = array();
		$respons['decrypted']=$dehash;
		$respons['encrypted']=$ehsh;
		header('Content-type: application/json');
		echo json_encode( $respons,  JSON_UNESCAPED_SLASHES);
		}
}
?>