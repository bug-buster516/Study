<?php
	session_start();
	require_once 'connection.php';
	require_once 'function.php';
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	
	$nRows = $pdo->query("SELECT COUNT(*) FROM trusers WHERE login='$login'")->fetchColumn();
	$stmt = $pdo->prepare("SELECT * FROM trusers WHERE login = :login");
	if ($nRows ==1){
		$stmt->execute(array('login' => $login));
		while ($row= $stmt->fetch()){
			$hash = $row['Password'];
			$_SESSION['name'] = $row['Name'];
			$_SESSION['surname'] = $row['LastName'];
			}
	}else{
		$_SESSION['message'] = 'Wrong login or password!' ;
		 header('Location: ../index.php');
	}
	
	
	if (password_verify($password, $hash)){
		$token=func::createString(32);
		$stmt=$pdo->prepare("UPDATE trusers SET token=? WHERE login=?");
		$stmt->execute([$token, $login]);
		setcookie('token', $token, time()+3600, '/');
		header('Location: ../index3.php');
	}else{
		$_SESSION['message'] = 'Wrong login or password!' ;
		 header('Location: ../index.php');
	}
?>