<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <title>Личный кабинет</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>

	
		<?php
                echo '<div class="form"> <h1>Profile</h1> <h2> Hello, <b>' . $_SESSION['name'] . ' ' . $_SESSION['surname'] . ' !</h2>';
        ?>
	</div>
</body>
</html>