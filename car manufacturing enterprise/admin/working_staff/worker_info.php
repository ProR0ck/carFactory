<?php require "auth.php";?>
<html>
	<head>
		<link rel="stylesheet" href="../../style/style.css" type="text/css"/>
		<link rel="stylesheet" href="../../style/css/font-awesome.min.css">
		<?$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");?>
	</head>

	<body>
		<div class="container">
			<div class="header">АВТОМОБИЛЕСТРОИТЕЛЬНОЕ ПРЕДПРИЯТИЕ</div>

			<div class="sidebar">
				<p><a class="left-menu" href="../index.php"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Главная</a></p>
				<p><a class="left-menu" href="../products/products.php">Выпускаемые изделия</a></p>
				<p><a class="left-menu" href="../workshops/workshops.php">Цеха</a></p>
				<p><a class="left-menu" href="../plots/plots.php">Участки</a></p>
				<p><a class="left-menu" href="brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="../engineering_staff/engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class="content">
	
				<h2>ИНФОРМАЦИЯ О СОТРУДНИКЕ</h2>
				<?
				
				$result1=mysqli_query($link, "SELECT `last_name`,`first_name`,`patronymic`,`position`,`working_staff`.`id_brigade`,`id_worker`, if(`working_staff`.`id_worker`=`brigades`.`brigadier`,'да','нет') FROM `working_staff`,`worker_position`,`brigades` WHERE `working_staff`.`id_position`=`worker_position`.`id_position` 
				AND `working_staff`.`id_worker`='{$_GET['id_info']}' AND `working_staff`.`id_brigade`=`brigades`.`id_brigade`");
				
				$result2=mysqli_query($link,"SELECT `id_worker`, `tel`, `email`, `dob`, `adress`, `photo` FROM `worker_info` WHERE `id_worker`={$_GET['id_info']}");
				
				$row1=mysqli_fetch_array($result1);
				$row2=mysqli_fetch_array($result2);
				?>
				<table class='table_price'> <caption><?echo "{$row1[0]} {$row1[1]} {$row1[2]}";?></caption>
				<?
							echo "
							<tr>
								<td><b>Фамилия</b></td>
								<td>{$row1[0]}</td>
							</tr>
							<tr>
								<td><b>Имя</b></td>
								<td>{$row1[1]}</td>
							</tr>
							<tr>
								<td><b>Отчество</b></td>
								<td>{$row1[2]}</td>
							</tr>
							<tr>
								<td><b>Должность</b></td>
								<td>{$row1[3]}</td>
							</tr>
							<tr>
								<td><b>№ Бригады</b></td>
								<td>{$row1[4]}</td>
							</tr>
								<tr>
								<td><b>Статус бригадира</b></td>
								<td>{$row1[6]}</td>
							</tr>
							<td><b>Телефон</b></td>
								<td><a href='tel:{$row2[1]}'>{$row2[1]}</a></td>
							</tr>
							<td><b>E-mail</b></td>
								<td><a href='mailto:{$row2[2]}'>{$row2[2]}</a></td>
							</tr>
							<td><b>Дата рождения</b></td>
								<td>{$row2[3]}</td>
							</tr>
							<td><b>Адрес</b></td>
								<td>{$row2[4]}</td>
							</tr>
							<td><b>Фотография</b></td>
								<td><img src='{$row2[5]}' style='width: 200px;'></td>
							</tr>							
							";
				
				?>
				
				</table>
				<br>
				<a class='button2' href='working_staff.php'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;вернуться назад </a>&nbsp;&nbsp;
				<a class='button2' href='change_worker.php?id_change=<?{echo $row1[5];}?>'>Изменить данные <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
				
				</div>

			<div class="footer">&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>