<?php if (isset($_POST['submit']))header("Location: new_engineering_added.php");?>
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
				<p><a class="left-menu" href="../working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="../working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class='content'>
				<h2>Сотрудник успешно добавлен в базу!</h2>
				<?
				if (isset($_POST['submit']))
				{ 
					mysqli_query($link,"INSERT INTO `engineering_staff` (`id_worker`, `last_name`, `first_name`, `patronymic`, `id_position`) VALUES (NULL, '{$_POST['last_name']}', '{$_POST['first_name']}', '{$_POST['patronymic']}', '{$_POST['position_select']}')");
					$result = mysqli_query($link, "SELECT MAX(`id_worker`) FROM `engineering_staff`");
					$row = mysqli_fetch_array($result);
					$last_id=$row[0];
					
					mysqli_query($link,"UPDATE `plots` SET `plot_manager`= {$last_id} WHERE `id_plot`= {$_POST['plot_select']}");
					mysqli_query($link,"UPDATE `workshops` SET `workshop_manager`= {$last_id} WHERE `id_workshop`= {$_POST['workshop_select']}");
					
					$uploadfile = "../../images/".$_FILES['img0']['name'];
					move_uploaded_file($_FILES['img0']['tmp_name'], $uploadfile);
					mysqli_query($link,"INSERT INTO `engineering_info` (`id_worker`, `tel`, `email`, `dob`, `adress`, `photo`) VALUES ('{$last_id}', '{$_POST['phone']}', '{$_POST['email']}', '{$_POST['dob']}', '{$_POST['address']}','../../images/{$_FILES['img0']['name']}')");
				}
				
				?>
				<br>
				<a class='button2' href='engineering_staff.php' class='button2'><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;&nbsp; Список сотрудников</a>&nbsp;&nbsp;
				<a href='new_engineering.php' class='button2'> Добавить нового сотрудника &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>
			</div>

			<div class='footer'>&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>