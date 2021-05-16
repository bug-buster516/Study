<?php
class Data_Model extends Model{
	
	function __construct() {
		parent::__construct();
	}
	public function tokenCheck(){
		if (isset($_COOKIE['token']) ){
			$tk=$_COOKIE['token'];
			$temp= $this->db->query("SELECT COUNT(*)FROM users WHERE Token='$tk'")->fetchColumn();
			if ($temp==0){
				header('Location: /index.php/login');
			}
		}
	}
	public function getAllRecords(){
		$stmt = $this->db->prepare("SELECT  Date, Time, Phone, 
			(SELECT Events FROM eventscode
			WHERE eventscode.Id = data.EventsId) AS Event,
			(SELECT User FROM userscode 
			WHERE userscode.Id = data.UserId) AS Name
			FROM data ORDER BY Date DESC, Time DESC");

		$stmt->execute();
		return $stmt;
	}
	public function filterRecords(){
		$query=("SELECT  Date, Time, Phone, 
			(SELECT Events FROM eventscode
			WHERE eventscode.Id = data.EventsId) AS Event,
			(SELECT User FROM userscode 
			WHERE userscode.Id = data.UserId) AS Name
			FROM data  ");
			$wh=0; // where switch?
		
			
			if((!empty($_POST['fdate'])) && (!empty($_POST['tdate'])) ){ 
				$frdate=$_POST['fdate'];
				$todate=$_POST['tdate'];
				$temp=$_POST['fdate'];
				if ($frdate>$todate){
					$frdate=$todate;
					$todate=$temp;
				}
				$query.=" WHERE (Date BETWEEN '$frdate' AND '$todate')";
				$wh=1;
			} elseif(!empty($_POST['fdate'])){
				$frdate=$_POST['fdate'];
				$query.=" WHERE (Date>='$frdate')";
				$wh=1;
			} elseif(!empty($_POST['tdate'])){
				$todate=$_POST['tdate'];
				$query.=" WHERE (Date<='$todate')";
				$wh=1;
			}
			if((!empty($_POST['ftime'])) && (!empty($_POST['ttime'])) ){ 
				$frtime=$_POST['ftime'];
				$totime=$_POST['ttime'];
				$temp=$_POST['ftime'];
				if ($frtime>$totime){
					$frtime=$totime;
					$totime=$temp;
				}
				if ($wh==1){
					$query.=" AND (Time BETWEEN '$frtime' AND '$totime')";
				}
				else{
				$query.=" WHERE (Time BETWEEN '$frtime' AND '$totime')";
				$wh=1;
				}
			} elseif(!empty($_POST['ftime'])){
				$frtime=$_POST['ftime'];
				if ($wh==1){
					$query.=" AND (Time>='$frtime')";
				}
				else{
				$query.=" WHERE (Time>='$frtime')";
				$wh=1;
				}
			} elseif(!empty($_POST['ttime'])){
				$totime=$_POST['ttime'];
				if ($wh==1){
					$query.=" AND (Time<='$totime')";
				}
				else{
				$query.=" WHERE (Time<='$totime')";
				$wh=1;
				}
			}
			if(!empty($_POST['phone'])){
				$phon='%';
				$phon.=$_POST['phone'];
				$phon.='%';
				if ($wh==1){
					$query.=" AND (Phone LIKE '$phon')";
				}
				else{
				$query.=" WHERE (Phone LIKE '$phon')";
				$wh=1;
				}
			}
			if(!empty($_POST['user'])){
				$us=$_POST['user'];
				if($us!=0){
					if ($wh==1){
					$query.=" AND (UserId='$us')";
					}
					else{
					$query.=" WHERE (UserId='$us')";
					$wh=1;
					}
				}

			}
			if(!empty($_POST['event'])){
				$ev=$_POST['event'];
				if($ev!=0){
					if ($wh==1){
					$query.=" AND (EventsId='$ev')";
					}
					else{
					$query.=" WHERE (EventsId='$ev')";
					$wh=1;
					}
				}
			}
		$query.=" ORDER BY Date DESC, Time DESC";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt;
	}
}
?>