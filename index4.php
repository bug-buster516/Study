<?php 
require_once 'connection.php';
require_once 'function.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <title>Authentication</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
<?php 
 if (func::checkLoginState($pdo)){
	 header('Location: ../index3.php');
 }
 else{
	 echo '
		<form action="signin.php" method="POST">
			<div class="form">
				<h1>Authentication</h1>
				<div class="input-form">
				<input type="text" name="login" placeholder="Login">
				</div>
				<div class="input-form">
				<input type="password" name="password" placeholder="Password">
				</div>
				<div class="input-form">
				<input type="submit" value="Log in">
				</div>
				<div class="input-form">
				<input type="button" onclick="window.location.href ="index.php" ;" value="Sign up"/>
				</div>
			</div>
		</form>
		';
		}
 ?>

</body>
</html>