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
				<p><a class="left-menu" href="../working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="../working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class="content">
	
				<h2>ИНФОРМАЦИЯ О СОТРУДНИКЕ</h2>
				<?
				
				$result1=mysqli_query($link, "SELECT e.`last_name`,e.`first_name`, e.`patronymic`, p.`position`, pl.`plot_name`,w.`workshop_name`
											FROM `engineering_staff` e
											INNER JOIN `engineering_position` p ON p.`id_position` = e.`id_position`
											LEFT JOIN `plots` pl ON e.`id_worker`=pl.`plot_manager`
											LEFT JOIN `workshops` w ON e.`id_worker`=w.`workshop_manager`
											WHERE e.`id_worker`= '{$_GET['id_info']}'");
				
				$result2=mysqli_query($link,"SELECT `tel`,`email`,`dob`,`adress`,`photo` FROM `engineering_info` WHERE `id_worker` = {$_GET['id_info']}");
				
				$row1=mysqli_fetch_array($result1);
				if ($row1[4] == NULL) $row1[4]='-';
				if ($row1[5] == NULL) $row1[5]='-'; 
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
								<td><b>Менеджер участка</b></td>
								<td>{$row1[4]}</td>
							</tr>
								<tr>
								<td><b>Менеджер цеха</b></td>
								<td>{$row1[5]}</td>
							</tr>
							<td><b>Телефон</b></td>
								<td><a href='tel:{$row2[0]}'>{$row2[0]}</a></td>
							</tr>
							<td><b>E-mail</b></td>
								<td><a href='mailto:{$row2[1]}'>{$row2[1]}</a></td>
							</tr>
							<td><b>Дата рождения</b></td>
								<td>{$row2[2]}</td>
							</tr>
							<td><b>Адрес</b></td>
								<td>{$row2[3]}</td>
							</tr>
							<td><b>Фотография</b></td>
								<td><img src='{$row2[4]}' style='width: 200px;'></td>
							</tr>							
							";
				
				?>
				
				</table>
				<br>
				<a class='button2' href='engineering_staff.php'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;вернуться назад </a>&nbsp;&nbsp;
				<a class='button2' href='change_engineering.php?id_change=<?{echo $_GET['id_info'];}?>'>Изменить данные <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
				
				</div>

			<div class="footer">&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>