<?php require "auth.php";?>
<?php if (isset($_POST['submit']))header("Location: change_worker_complete.php");?>
<html>
<?
$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");	
?>
	<head>
		<link rel='stylesheet' href='../../style/style.css' type='text/css'/>
		<link rel='stylesheet' href='../../style/css/font-awesome.min.css'>
	</head>

	<body>
		<div class='container'>
			<div class='header'>АВТОМОБИЛЕСТРОИТЕЛЬНОЕ ПРЕДПРИЯТИЕ</div>

			<div class='sidebar'>
				<p><a class="left-menu" href="../index.php"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Главная</a></p>
				<p><a class="left-menu" href="../products/products.php">Выпускаемые изделия</a></p>
				<p><a class="left-menu" href="../workshops/workshops.php">Цеха</a></p>
				<p><a class="left-menu" href="../plots/plots.php">Участки</a></p>
				<p><a class="left-menu" href="brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="../engineering_staff/engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class='content'>
				<h2>Изменения успешно сохранены!</h2>
				<?
				if (isset($_POST['submit']))
				{ 
					
					mysqli_query($link,"UPDATE `working_staff` SET `last_name`='{$_POST['last_name']}', `first_name`='{$_POST['first_name']}', `patronymic`='{$_POST['patronymic']}', `id_position`='{$_POST['position_select']}' WHERE `working_staff`.`id_worker`='{$_POST['id_worker_change']}'");
					
					mysqli_query($link,"UPDATE `working_staff` SET `working_staff`.`id_brigade`= '{$_POST['bragade_select']}' WHERE `working_staff`.`id_worker`='{$_POST['id_worker_change']}'");

					$uploadfile = "../../images/".$_FILES['img0']['name'];
					
					if ($_FILES['img0']['name']!='') 
					{
						move_uploaded_file($_FILES['img0']['tmp_name'], $uploadfile);
						mysqli_query($link,"UPDATE `worker_info` SET  `tel`='{$_POST['phone']}', `email`='{$_POST['email']}', `dob`='{$_POST['dob']}', `adress`='{$_POST['address']}', `photo`='../../images/{$_FILES['img0']['name']}' WHERE `id_worker`={$_POST['id_worker_change']}");
					}
					else 
					{
						mysqli_query($link,"UPDATE `worker_info` SET  `tel`='{$_POST['phone']}', `email`='{$_POST['email']}', `dob`='{$_POST['dob']}', `adress`='{$_POST['address']}' WHERE `id_worker`={$_POST['id_worker_change']}");
					}
					
					if (($_POST['status_brigadier']) == 'да') 
					{
						mysqli_query($link,"UPDATE `brigades` SET `brigadier`=NULL WHERE `brigadier`='{$_POST['id_worker_change']}'");
						mysqli_query($link,"UPDATE `brigades` SET `brigadier`='{$_POST['id_worker_change']}' WHERE `id_brigade`='{$_POST['bragade_select']}'");
					} 
					else 
					{
						mysqli_query($link,"UPDATE `brigades` SET `brigadier`=NULL WHERE `id_brigade`='{$_POST['bragade_select']}'");
					}
				}
				?>
				<br>
				<a class='button2' href='working_staff.php' class='button2'><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;&nbsp; Список сотрудников</a>&nbsp;&nbsp;
				<a href='new_worker.php' class='button2'> Добавить нового сотрудника &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>
			</div>

			<div class='footer'>&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>