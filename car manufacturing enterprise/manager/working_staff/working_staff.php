<?php require "auth.php";?>
<?php 
	$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
if (isset($_GET['id_delete']))
	{ 
		mysqli_query($link,"UPDATE `brigades` SET `brigadier`= NULL WHERE `brigadier`={$_GET['id_delete']}");
		mysqli_query($link,"DELETE FROM `worker_info` WHERE `id_worker`={$_GET['id_delete']}");
		mysqli_query($link,"DELETE FROM `working_staff` WHERE `id_worker`={$_GET['id_delete']}");
		header("Location: working_staff.php");	
	}
?>
<html>
<?
	$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");

?>
	<head>
		<link rel="stylesheet" href="../../style/style.css" type="text/css"/>
		<link rel="stylesheet" href="../../style/css/font-awesome.min.css">
	</head>

	<body>
		<div class="container">
			<div class="header">АВТОМОБИЛЕСТРОИТЕЛЬНОЕ ПРЕДПРИЯТИЕ</div>
			
			<div class="sidebar">
				<p><a class="left-menu" href="../index.php"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Главная</a></p>
				<p><a class="left-menu" href="brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="../engineering_staff/engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class="content">	
				<h2>УПРАВЛЕНИЕ РАБОЧИМ ПЕРСОНАЛОМ</h2>
					
					<?
					if (!isset($_GET['search']))
					{
						echo "					<form action='working_staff.php' method='GET'>
						<p>Поиск сотрудника:</p>
						<input class='textedit'type='text' name ='search' placeholder='Введите фамилию'>
					
						<button class='button1' type='submit' name='submit'> <i class='fa fa-search' aria-hidden='true'></i>&nbsp;&nbsp;поиск</button>
					</form>";
					}
					?>
					

					<?
					//НАЧАЛЬНАЯ ТАБЛИЦА
					$result=mysqli_query($link, "SELECT w.`last_name`, w.`first_name`, w.`patronymic`, ps.`position`, b.`brigade_name`, 	 	
												IF(w.`id_worker`=b.`brigadier`,'бригадир','-'),w.`id_worker`,b.`id_brigade`
												FROM `working_staff` w
												LEFT JOIN `worker_position` ps ON ps.`id_position`=w.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade`");
					if (!isset($_GET['search']) && !isset($_GET['sort_last'])&& !isset($_GET['sort_first'])&& !isset($_GET['sort_patronymic'])&& !isset($_GET['sort_position'])&& !isset($_GET['sort_bragade'])&& !isset($_GET['query'])&& !isset($_GET['sort_status']))
					{
						$count=1;
						echo "<table class='table_price' ' border='1'> <caption>Рабочий персонал</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>	Фамилия <a class='button2' href='working_staff.php?sort_last=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Имя <a class='button2' href='working_staff.php?sort_name=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Отчество <a class='button2'href='working_staff.php?sort_patronymic=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Должность <a class='button2'href='working_staff.php?sort_position=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>№ Бригады <a class='button2'href='working_staff.php?sort_bragade=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Статус <a class='button2'href='working_staff.php?sort_status=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th></th>
							<th></th>
						</tr>";
						
						while($row=mysqli_fetch_array($result))
						{
							echo "
							<tr>
								<td>{$count}</td>
								<td><a href='worker_info.php?id_info={$row[6]}'>{$row[0]}</a></td>
								<td><a href='worker_info.php?id_info={$row[6]}'>{$row[1]}</a></td>
								<td><a href='worker_info.php?id_info={$row[6]}'>{$row[2]}</a></td>
								<td>{$row[3]}</td>
								<td><a href='../working_staff/brigade.php?id_info={$row[7]}'>{$row[4]}</a></td>
								<td>{$row[5]}</td>
								<td><a class='button2' href='change_worker.php?id_change={$row[6]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='working_staff.php?id_delete={$row[6]}' onclick=".'"'."return confirm('Вы точно хотите удалить сотрудника из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "<br><a class='button2' href='new_worker.php'> Добавить нового сотрудника &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
						echo "&nbsp;&nbsp; <a class='button2' href='position.php'> Управление должностями &nbsp;&nbsp; <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>";
						echo "&nbsp;&nbsp; <a class='button2' href='brigade.php'> Управление бригадами &nbsp;&nbsp; <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>";
					}
					?>
					
					
					<?
					if (isset($_GET['search']))
					{	
						//ТАБЛИЦА ПОСЛЕ ПОИСКА
						echo "Результаты поиска: <br><br>";
						$query=$_GET['search'];
						$result=mysqli_query($link,"SELECT w.`last_name`, w.`first_name`, w.`patronymic`, ps.`position`, b.`brigade_name`, 	 	
												IF(w.`id_worker`=b.`brigadier`,'бригадир','-'),w.`id_worker`
												FROM `working_staff` w
												LEFT JOIN `worker_position` ps ON ps.`id_position`=w.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade` WHERE w.`last_name` like '%{$_GET['search']}%'");
						if ($_GET['search'] == "") $result=NULL;
						$count=1;
						echo "
						<table class='table_price' ' border='1'> 
							<caption>Рабочий персонал</caption> 
							<tr>
								<th>№</th>
								<th>Фамилия</th>
								<th>Имя</th>
								<th>Отчество</th>
								<th>Должность</th>
								<th>№ Бригады</th>
								<th>Статус</th>
								<th></th>
								<th></th>
							</tr>";
						
						if ($result){
						while($row=mysqli_fetch_array($result))
						{
							echo "
							<tr>
								<td>{$count}</td>
								<td><a href='worker_info.php?id_info={$row[6]}'>{$row[0]}</a></td>
								<td><a href='worker_info.php?id_info={$row[6]}'>{$row[1]}</a></td>
								<td><a href='worker_info.php?id_info={$row[6]}'>{$row[2]}</a></td>
								<td>{$row[3]}</td>
								<td><a href='../working_staff/brigade.php?id_info={$row[7]}'>{$row[4]}</a></td>
								<td>{$row[5]}</td>
								<td><a class='button2' href='change_worker.php?id_change={$row[6]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='working_staff.php?id_delete={$row[6]}' onclick=".'"'."return confirm('Вы точно хотите удалить сотрудника из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr> ";
							$count++;
						}
						}
						echo "</table>";
						echo "
						<br><a class='button2' href='working_staff.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a> 
						<a class='button2' href='new_worker.php'> Добавить нового сотрудника &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
						echo "&nbsp;&nbsp; <a class='button2' href='position.php'> Управление должностями &nbsp;&nbsp; <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>";
					}
					?>
					
					<?
					//СОРТИРОВКА
					if (isset($_GET['sort_last']) || isset($_GET['sort_first']) || isset($_GET['sort_patronymic']) || isset($_GET['sort_position']) || isset($_GET['sort_bragade'])|| isset($_GET['sort_status']))
					{
						$asc="ASC";
						$desc="DESC";
						$sort=$asc;
						if ((($_GET['sort_last'])=='0') || (($_GET['sort_first'])=='0') || (($_GET['sort_patronymic'])=='0') || (($_GET['sort_position'])=='0') || (($_GET['sort_bragade'])=='0') || (($_GET['sort_status'])=='0')) 
						{
							$sort=$asc;
							$flag=1;
						} 
						else
						{
							$sort=$desc;
							$flag=0;
						}
						
						if (isset($_GET['sort_last'])) $result=mysqli_query($link,"SELECT w.`last_name`, w.`first_name`, w.`patronymic`, ps.`position`, b.`brigade_name`, 	 	
												IF(w.`id_worker`=b.`brigadier`,'бригадир','-'),w.`id_worker`
												FROM `working_staff` w
												LEFT JOIN `worker_position` ps ON ps.`id_position`=w.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade` ORDER BY w.`last_name` ".$sort);
						
						
						if (isset($_GET['sort_first'])) $result=mysqli_query($link,"SELECT w.`last_name`, w.`first_name`, w.`patronymic`, ps.`position`, b.`brigade_name`, 	 	
												IF(w.`id_worker`=b.`brigadier`,'бригадир','-'),w.`id_worker`
												FROM `working_staff` w
												LEFT JOIN `worker_position` ps ON ps.`id_position`=w.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade` ORDER BY w.`first_name` ".$sort);
						
						if (isset($_GET['sort_patronymic'])) $result=mysqli_query($link,"SELECT w.`last_name`, w.`first_name`, w.`patronymic`, ps.`position`, b.`brigade_name`, 	 	
												IF(w.`id_worker`=b.`brigadier`,'бригадир','-'),w.`id_worker`
												FROM `working_staff` w
												LEFT JOIN `worker_position` ps ON ps.`id_position`=w.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade` ORDER BY w.`patronymic` ".$sort);
						
						if (isset($_GET['sort_position'])) $result=mysqli_query($link,"SELECT w.`last_name`, w.`first_name`, w.`patronymic`, ps.`position`, b.`brigade_name`, 	 	
												IF(w.`id_worker`=b.`brigadier`,'бригадир','-'),w.`id_worker`
												FROM `working_staff` w
												LEFT JOIN `worker_position` ps ON ps.`id_position`=w.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade` ORDER BY ps.`position` ".$sort);
						
						if (isset($_GET['sort_bragade'])) $result=mysqli_query($link,"SELECT w.`last_name`, w.`first_name`, w.`patronymic`, ps.`position`, b.`brigade_name`, 	 	
												IF(w.`id_worker`=b.`brigadier`,'бригадир','-'),w.`id_worker`
												FROM `working_staff` w
												LEFT JOIN `worker_position` ps ON ps.`id_position`=w.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade` ORDER BY b.`brigade_name` ".$sort);
												
						if (isset($_GET['sort_status'])) $result=mysqli_query($link,"SELECT w.`last_name`, w.`first_name`, w.`patronymic`, ps.`position`, b.`brigade_name`, 	 	
												IF(w.`id_worker`=b.`brigadier`,'бригадир','-'),w.`id_worker`
												FROM `working_staff` w
												LEFT JOIN `worker_position` ps ON ps.`id_position`=w.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade` ORDER BY IF (w.`id_worker`=b.`brigadier`,'бригадир','-') ".$sort);
						
						$count=1;
						echo "
						<table class='table_price' ' border='1'> <caption>Рабочий персонал</caption>
						<tr>
							<th>№</th>
							<th>Фамилия <a class='button2' href='working_staff.php?sort_last={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Имя <a class='button2' href='working_staff.php?sort_first={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Отчество <a class='button2' href='working_staff.php?sort_patronymic={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Должность <a class='button2'href='working_staff.php?sort_position={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>№ Бригады <a class='button2'href='working_staff.php?sort_bragade={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Статус <a class='button2'href='working_staff.php?sort_status={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th></th>
							<th></th>
						</tr>";

						while($row=mysqli_fetch_array($result))
						{
							echo "
							<tr>
								<td>{$count}</td>
								<td><a href='worker_info.php?id_info={$row[6]}'>{$row[0]}</a></td>
								<td><a href='worker_info.php?id_info={$row[6]}'>{$row[1]}</a></td>
								<td><a href='worker_info.php?id_info={$row[6]}'>{$row[2]}</a></td>
								<td>{$row[3]}</td>
								<td><a href='../working_staff/brigade.php?id_info={$row[7]}'>{$row[4]}</a></td>
								<td>{$row[5]}</td>
								<td><a class='button2' href='change_worker.php?id_change={$row[6]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='working_staff.php?id_delete={$row[6]}' onclick=".'"'."return confirm('Вы точно хотите удалить сотрудника из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "<br><a class='button2' href='new_worker.php'> Добавить нового сотрудника &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
						echo "&nbsp;&nbsp; <a class='button2' href='position.php'> Управление должностями &nbsp;&nbsp; <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>";
					}
					?>
					
					<?
					//УДАЛЕНИЕ СОТРУДНИКА
					if (isset ($_GET['id_delete']))
					{
						unset($_GET);
						$url='http://module1/workshops.php';
						header("Location: $url"); 
						
					};
					?>
					
			</div>

			<div class="footer">&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>