<?php 
$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
if (isset($_GET['id_delete']))
	{ 
		mysqli_query($link,"UPDATE `plots` SET `plot_manager`= NULL WHERE `plot_manager`= {$_GET['id_delete']}");
		mysqli_query($link,"UPDATE `workshops` SET `workshop_manager`=NULL WHERE `workshop_manager`= {$_GET['id_delete']}");
		mysqli_query($link,"DELETE FROM `engineering_info` WHERE `id_worker`={$_GET['id_delete']}");
		mysqli_query($link,"DELETE FROM `engineering_staff` WHERE `id_worker`={$_GET['id_delete']}");
		header("Location: engineering_staff.php");	
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
				<p><a class="left-menu" href="../working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="../working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class="content">	
				<h2>УПРАВЛЕНИЕ ИНЖЕНЕРНО ТЕХНИЧЕСКИМ ПЕРСОНАЛОМ</h2>
					
					<?
					if (!isset($_GET['search']))
					{
						echo "<form action='engineering_staff.php' method='GET'>
						<p>Поиск сотрудника:</p>
						<input class='textedit'type='text' name ='search' placeholder='Введите фамилию'>
					
						<button class='button1' type='submit' name='submit'> <i class='fa fa-search' aria-hidden='true'></i>&nbsp;&nbsp;поиск</button>
					</form>";
					}
					?>
					

					<?
					//НАЧАЛЬНАЯ ТАБЛИЦА
					$result=mysqli_query($link, "SELECT e.`last_name`,e.`first_name`, e.`patronymic`, p.`position`, pl.`plot_name`,w.`workshop_name`, e.`id_worker`
												FROM `engineering_staff` e
												INNER JOIN `engineering_position` p ON p.`id_position` = e.`id_position`
												LEFT JOIN `plots` pl ON e.`id_worker`=pl.`plot_manager`
												LEFT JOIN `workshops` w ON e.`id_worker`=w.`workshop_manager`");
					if (!isset($_GET['search']) && !isset($_GET['sort_last'])&& !isset($_GET['sort_name'])&& !isset($_GET['sort_patronymic'])&& !isset($_GET['sort_position'])&& !isset($_GET['sort_plots'])&& !isset($_GET['query'])&& !isset($_GET['sort_workshops']))
					{
						$count=1;
						echo "<table class='table_price' border='1' border='1'> <caption>Инженерно технический персонал</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Фамилия <a class='button2' href='engineering_staff.php?sort_last=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Имя <a class='button2' href='engineering_staff.php?sort_name=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Отчество <a class='button2'href='engineering_staff.php?sort_patronymic=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Должность <a class='button2'href='engineering_staff.php?sort_position=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник участка <a class='button2'href='engineering_staff.php?sort_plots=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник цеха <a class='button2'href='engineering_staff.php?sort_workshops=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th></th>
							<th></th>
						</tr>";
						while($row=mysqli_fetch_array($result))
						{
							if ($row[4] == NULL) 
							{$href=""; $row[4]='-';} 
							else 
								$href="href='../plots/plots.php?search={$row[4]}&submit='";
							if ($row[5] == NULL) 
							{$href2="";$row[5]='-';}
							else
								$href2="href='../workshops/workshops.php?search={$row[5]}&submit='";
							echo "
							<tr>
								<td>{$count}</td>
								<td><a href='engineering_info.php?id_info={$row[6]}'>{$row[0]}</a></td>
								<td><a href='engineering_info.php?id_info={$row[6]}'>{$row[1]}</a></td>
								<td><a href='engineering_info.php?id_info={$row[6]}'>{$row[2]}</a></td>
								<td>{$row[3]}</td>
								<td>{$row[4]}</td>
								<td>{$row[5]}</td>
								<td><a class='button2' href='change_engineering.php?id_change={$row[6]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='engineering_staff.php?id_delete={$row[6]}' onclick=".'"'."return confirm('Вы точно хотите удалить сотрудника из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "<br><a class='button2' href='new_engineering.php'> Добавить нового сотрудника &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
						echo "&nbsp;&nbsp; <a class='button2' href='engineering_position.php'> Управление должностями &nbsp;&nbsp; <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>";
						
					}
					?>
					
					
					<?
					if (isset($_GET['search']))
					{	
						//ТАБЛИЦА ПОСЛЕ ПОИСКА
						echo "Результаты поиска: <br><br>";
						$result=mysqli_query($link,"SELECT e.`last_name`,e.`first_name`, e.`patronymic`, p.`position`, 					pl.`plot_name`,w.`workshop_name`, e.`id_worker`
													FROM `engineering_staff` e
													INNER JOIN `engineering_position` p ON p.`id_position` = e.`id_position`
													LEFT JOIN `plots` pl ON e.`id_worker`=pl.`plot_manager`
													LEFT JOIN `workshops` w ON e.`id_worker`=w.`workshop_manager`
													WHERE e.`last_name` LIKE '%{$_GET['search']}%'");
						if ($_GET['search'] == "") $result=NULL;
						$count=1;
						echo "<table class='table_price' border='1'> <caption>Инженерно технический персонал</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Фамилия <a class='button2' href='engineering_staff.php?sort_last=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Имя <a class='button2' href='engineering_staff.php?sort_name=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Отчество <a class='button2'href='engineering_staff.php?sort_patronymic=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Должность <a class='button2'href='engineering_staff.php?sort_position=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник участка <a class='button2'href='engineering_staff.php?sort_plots=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник цеха <a class='button2'href='engineering_staff.php?sort_workshops=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th></th>
							<th></th>
						</tr>";
						while($row=mysqli_fetch_array($result))
						{
							if ($row[4] == NULL) 
							{$href=""; $row[4]='-';} 
							else 
								$href="href='../plots/plots.php?search={$row[4]}&submit='";
							if ($row[5] == NULL) 
							{$href2="";$row[5]='-';}
							else
								$href2="href='../workshops/workshops.php?search={$row[5]}&submit='";
							echo "
							<tr>
								<td>{$count}</td>
								<td><a href='engineering_info.php?id_info={$row[6]}'>{$row[0]}</a></td>
								<td><a href='engineering_info.php?id_info={$row[6]}'>{$row[1]}</a></td>
								<td><a href='engineering_info.php?id_info={$row[6]}'>{$row[2]}</a></td>
								<td>{$row[3]}</td>
								<td>{$row[4]}</td>
								<td>{$row[5]}</td>
								<td><a class='button2' href='change_engineering.php?id_change={$row[6]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='engineering_staff.php?id_delete={$row[6]}' onclick=".'"'."return confirm('Вы точно хотите удалить сотрудника из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "
						<br><a class='button2' href='engineering_staff.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a> 
						<a class='button2' href='new_engineering.php'> Добавить нового сотрудника &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
						echo "&nbsp;&nbsp; <a class='button2' href='engineering_position.php'> Управление должностями &nbsp;&nbsp; <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>";						
					}
					?>
					
					<?
					//СОРТИРОВКА
					if (isset($_GET['sort_last']) || isset($_GET['sort_name']) || isset($_GET['sort_patronymic']) || isset($_GET['sort_position']) || isset($_GET['sort_plots'])|| isset($_GET['sort_workshops']))
					{
						$asc="ASC";
						$desc="DESC";
						$sort=$asc;
						if ((($_GET['sort_last'])=='0') || (($_GET['sort_name'])=='0') || (($_GET['sort_patronymic'])=='0') || (($_GET['sort_position'])=='0') || (($_GET['sort_plots'])=='0') || (($_GET['sort_workshops'])=='0')) 
						{
							$sort=$asc;
							$flag=1;
						} 
						else
						{
							$sort=$desc;
							$flag=0;
						}
						
						if (isset($_GET['sort_last'])) $result=mysqli_query($link,"SELECT e.`last_name`,e.`first_name`, e.`patronymic`, p.`position`, pl.`plot_name`,w.`workshop_name`, e.`id_worker`
												FROM `engineering_staff` e
												INNER JOIN `engineering_position` p ON p.`id_position` = e.`id_position`
												LEFT JOIN `plots` pl ON e.`id_worker`=pl.`plot_manager`
												LEFT JOIN `workshops` w ON e.`id_worker`=w.`workshop_manager` ORDER BY e.`last_name` ".$sort);
						
						
						if (isset($_GET['sort_name'])) $result=mysqli_query($link,"SELECT e.`last_name`,e.`first_name`, e.`patronymic`, p.`position`, pl.`plot_name`,w.`workshop_name`, e.`id_worker`
												FROM `engineering_staff` e
												INNER JOIN `engineering_position` p ON p.`id_position` = e.`id_position`
												LEFT JOIN `plots` pl ON e.`id_worker`=pl.`plot_manager`
												LEFT JOIN `workshops` w ON e.`id_worker`=w.`workshop_manager` ORDER BY e.`first_name`  ".$sort);
						
						if (isset($_GET['sort_patronymic'])) $result=mysqli_query($link,"SELECT e.`last_name`,e.`first_name`, e.`patronymic`, p.`position`, pl.`plot_name`,w.`workshop_name`, e.`id_worker`
												FROM `engineering_staff` e
												INNER JOIN `engineering_position` p ON p.`id_position` = e.`id_position`
												LEFT JOIN `plots` pl ON e.`id_worker`=pl.`plot_manager`
												LEFT JOIN `workshops` w ON e.`id_worker`=w.`workshop_manager` ORDER BY e.`patronymic` ".$sort);
						
						if (isset($_GET['sort_position'])) $result=mysqli_query($link,"SELECT e.`last_name`,e.`first_name`, e.`patronymic`, p.`position`, pl.`plot_name`,w.`workshop_name`, e.`id_worker`
												FROM `engineering_staff` e
												INNER JOIN `engineering_position` p ON p.`id_position` = e.`id_position`
												LEFT JOIN `plots` pl ON e.`id_worker`=pl.`plot_manager`
												LEFT JOIN `workshops` w ON e.`id_worker`=w.`workshop_manager` ORDER BY p.`position` ".$sort);
						
						if (isset($_GET['sort_plots'])) $result=mysqli_query($link,"SELECT e.`last_name`,e.`first_name`, e.`patronymic`, p.`position`, pl.`plot_name`,w.`workshop_name`, e.`id_worker`
												FROM `engineering_staff` e
												INNER JOIN `engineering_position` p ON p.`id_position` = e.`id_position`
												LEFT JOIN `plots` pl ON e.`id_worker`=pl.`plot_manager`
												LEFT JOIN `workshops` w ON e.`id_worker`=w.`workshop_manager` ORDER BY  pl.`plot_name` ".$sort);
						
						if (isset($_GET['sort_workshops'])) $result=mysqli_query($link,"SELECT e.`last_name`,e.`first_name`, e.`patronymic`, p.`position`, pl.`plot_name`,w.`workshop_name`, e.`id_worker`
												FROM `engineering_staff` e
												INNER JOIN `engineering_position` p ON p.`id_position` = e.`id_position`
												LEFT JOIN `plots` pl ON e.`id_worker`=pl.`plot_manager`
												LEFT JOIN `workshops` w ON e.`id_worker`=w.`workshop_manager` ORDER BY w.`workshop_name` ".$sort);
						
						$count=1;
						echo "<table class='table_price' border='1'> <caption>Инженерно технический персонал</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Фамилия <a class='button2' href='engineering_staff.php?sort_last={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Имя <a class='button2' href='engineering_staff.php?sort_name={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Отчество <a class='button2'href='engineering_staff.php?sort_patronymic={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Должность <a class='button2'href='engineering_staff.php?sort_position={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник участка <a class='button2'href='engineering_staff.php?sort_plots={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник цеха <a class='button2'href='engineering_staff.php?sort_workshops={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th></th>
							<th></th>
						</tr>";
						while($row=mysqli_fetch_array($result))
						{
							if ($row[4] == NULL) 
							{$href=""; $row[4]='-';} 
							else 
								$href="href='../plots/plots.php?search={$row[4]}&submit='";
							if ($row[5] == NULL) 
							{$href2="";$row[5]='-';}
							else
								$href2="href='../workshops/workshops.php?search={$row[5]}&submit='";
							echo "
							<tr>
								<td>{$count}</td>
								<td><a href='engineering_info.php?id_info={$row[6]}'>{$row[0]}</a></td>
								<td><a href='engineering_info.php?id_info={$row[6]}'>{$row[1]}</a></td>
								<td><a href='engineering_info.php?id_info={$row[6]}'>{$row[2]}</a></td>
								<td>{$row[3]}</td>
								<td>{$row[4]}</td>
								<td>{$row[5]}</td>
								<td><a class='button2' href='change_engineering.php?id_change={$row[6]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='engineering_staff.php?id_delete={$row[6]}' onclick=".'"'."return confirm('Вы точно хотите удалить сотрудника из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "<br><a class='button2' href='new_engineering.php'> Добавить нового сотрудника &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
						echo "&nbsp;&nbsp; <a class='button2' href='engineering_position.php'> Управление должностями &nbsp;&nbsp; <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>";
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