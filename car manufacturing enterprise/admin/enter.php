<?php
session_start();
$flag=0;
$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
if($_SESSION['admin']){
 header("Location: index.php");
 exit;
 }
$admin = 'admin';
$pass = '12345';
if($_POST['submit']){
 if($admin == $_POST['user'] AND $pass == ($_POST['pass'])){
  $_SESSION['admin'] = $admin;
  header("Location: index.php");
  exit;
 }else $flag=1;
}
?>
<html>
	<head>
		<link rel="stylesheet" href="../style/style.css" type="text/css"/>
		<link rel="stylesheet" href="../style/css/font-awesome.min.css">
	</head>

	<body>
		<div class="container">
			<div class="sidebar">
				<p><a class="left-menu" href="../index.php"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Вернуться на главную</a></p>
			</div>
			<div class="header">АВТОМОБИЛЕСТРОИТЕЛЬНОЕ ПРЕДПРИЯТИЕ</div>

			<div class="content" style='height: 80%; width: 70%;'>
				<form method="post">
					<table>
						<tr><td>Логин:</td><td><input class='textedit' style='width: 130px;' type="text" name="user" required></td></tr>
						<tr><td>Пароль:</td><td><input class='textedit' style='width: 130px;' type="password" name="pass" required></td></tr>
						<tr><td></td><td></td></tr>
					</table>
					<input type="submit" name="submit" value="Войти" class='button1' style='width: 195px;'>
				</form>
				<br> <? if ($flag) echo "<p style='color: red;'><b>Логин или пароль неверны!</b></p>";?>
			</div>
			
			<div class="footer">&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>




