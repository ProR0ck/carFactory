<?php require "auth.php";?>
<?php 
$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
if (isset($_GET['id_delete']) || isset ($_GET['add_workshop']) || isset($_GET['change_workshop']))
	{ 
		mysqli_query($link,"UPDATE `plots` SET `id_workshop`= NULL WHERE `id_workshop`={$_GET['id_delete']}");
		mysqli_query($link,"DELETE FROM `workshops` WHERE `id_workshop` ={$_GET['id_delete']}");
		header("Location: workshops.php");	
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
				<p><a class="left-menu" href="../products/products.php">Выпускаемые изделия</a></p>
				<p><a class="left-menu" href="workshops.php">Цеха</a></p>
				<p><a class="left-menu" href="../plots/plots.php">Участки</a></p>
				<p><a class="left-menu" href="../working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="../working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="../engineering_staff/engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>
			
			<div class="content">	
				<? if (!isset($_GET['new_workshop']) && !isset ($_GET['add_workshop']) && !isset($_GET[id_change]) && !isset($_GET['change_workshop'])) echo "<h2>УПРАВЛЕНИЕ ЦЕХАМИ ПРЕДПРИЯТИЯ</h2>";?>
					
					<?
					if (!isset($_GET['search'])&& !isset($_GET['new_workshop']) && !isset ($_GET['add_workshop']) && !isset($_GET[id_change]) && !isset($_GET['change_workshop']))
					{
						echo "
					<form action='workshops.php' method='GET'>
						<input class='textedit'type='text' name ='search' placeholder='Введите название цеха'>
						<button class='button1' type='submit' name='submit'> <i class='fa fa-search' aria-hidden='true'></i>&nbsp;&nbsp;поиск</button>
					</form>";
					}
					?>
					

					<?
					//НАЧАЛЬНАЯ ТАБЛИЦА
					$result=mysqli_query($link, "SELECT w.`id_workshop`, w.`workshop_name`, e.`id_worker`, e.`last_name`, e.`first_name`,e.`patronymic` 
												FROM `workshops` w 
												LEFT JOIN `engineering_staff` e ON w.`workshop_manager`=e.`id_worker`");
					if (!isset($_GET['search']) && !isset($_GET['sort_last']) && !isset($_GET['sort_workshop']) && !isset($_GET['new_workshop']) && !isset ($_GET['add_workshop']) && !isset($_GET[id_change]) && !isset($_GET['change_workshop']))
					{
						$count=1;
						echo "<table class='table_price' ' border='1' ' border='1'><caption>ЦЕХА ПРЕДПРИЯТИЯ</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Название цеха  <a class='button2' href='workshops.php?sort_workshop=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник цеха <a class='button2' href='workshops.php?sort_last=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Участки цеха</th>
							<th></th>
							<th></th>
						</tr>";
						
						while($row=mysqli_fetch_array($result))
						{
							$plots="";
							$result1=mysqli_query($link,"SELECT plot_name FROM plots WHERE id_workshop = {$row[0]}");
							while ($row1=mysqli_fetch_array($result1))
							{
								$plots=$plots." <a href='../plots/plots.php?search=".$row1[0]."&submit='>".$row1[0]."</a> &nbsp;&nbsp;";
								
							}
							if ($plots=='') $plots='-';
							echo "
							<tr>
								<td>{$count}</td>
								<td>{$row[1]}</td>
								<td><a href='../engineering_staff/engineering_info.php?id_info={$row[2]}'>{$row[3]} {$row[4]} {$row[5]}</a></td>
								<td>{$plots}</td>
								<td><a class='button2' href='workshops.php?id_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='workshops.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить цех из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "<br><a class='button2' href='workshops.php?new_workshop'> Добавить новый цех &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
					}
					?>
					
					
					<?
					if (isset($_GET['search']) && !isset($_GET['new_workshop']) && !isset ($_GET['add_workshop']) && !isset($_GET[id_change]) && !isset($_GET['change_workshop']))
					{	
						//ТАБЛИЦА ПОСЛЕ ПОИСКА
						echo "Результаты поиска: <br><br>";
						$result=mysqli_query($link,"SELECT w.`id_workshop`, w.`workshop_name`, e.`id_worker`, e.`last_name`, e.`first_name`,e.`patronymic` 
												FROM `workshops` w 
												LEFT JOIN `engineering_staff` e ON w.`workshop_manager`=e.`id_worker` WHERE w.`workshop_name` like '%{$_GET['search']}%'");
						if ($_GET['search'] == "") $result=NULL;
						$count=1;
						
					if ($result)
					{
						echo "<table class='table_price' ' border='1' ' border='1'> <caption>Цеха</caption>
						<tr>
							<th>№</th>
							<th>Название цеха</th>
							<th>Начальник цеха </th>
							<th>Участки цеха </th>
							<th></th>
							<th></th>
						</tr>";
						while($row=mysqli_fetch_array($result))
						{
							$plots="";
							$result1=mysqli_query($link,"SELECT plot_name FROM plots WHERE id_workshop = {$row[0]}");
							
							while ($row1=mysqli_fetch_array($result1))
							{
								$plots=$plots." ".$row1[0];
								
							}
							if ($plots=='') $plots='-';
							echo "
							<tr>
								<td>{$count}</td>
								<td>{$row[1]}</td>
								<td><a href='../engineering_staff/engineering_info.php?id_info={$row[2]}'>{$row[3]} {$row[4]} {$row[5]}</a></td>
								<td>{$plots}</td>
								<td><a class='button2' href='workshops.php?id_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='workshops.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить цех из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						
						echo "<br><a class='button2' href='workshops.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a>&nbsp;&nbsp;";
						echo "<a class='button2' href='workshops.php?new_workshop'> Добавить новый цех &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
						
					}
					else 
					{
						echo "Не нашлось результатов по запросу <br>";
						echo "<br><a class='button2' href='workshops.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a>&nbsp;&nbsp;";
						echo "<a class='button2' href='workshops.php?new_workshop'> Добавить новый цех &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
					}
					}
					?>
					
					
					
					
					<?
					
					//СОРТИРОВКА
					if (isset($_GET['sort_last']) || isset($_GET['sort_workshop']))
					{
						$asc="ASC";
						$desc="DESC";
						$sort=$asc;
						if ((($_GET['sort_last'])=='0') || (($_GET['sort_workshop'])=='0') || (($_GET['sort_plots'])=='0')) 
						{
							$sort=$asc;
							$flag=1;
						} 
						else
						{
							$sort=$desc;
							$flag=0;
						}
						
						if (isset($_GET['sort_last'])) $result=mysqli_query($link,"SELECT w.`id_workshop`, w.`workshop_name`, e.`id_worker`, e.`last_name`, e.`first_name`,e.`patronymic` 
												FROM `workshops` w 
												LEFT JOIN `engineering_staff` e ON w.`workshop_manager`=e.`id_worker` ORDER BY e.`last_name` ".$sort);
						
						
						if (isset($_GET['sort_workshop'])) $result=mysqli_query($link,"SELECT w.`id_workshop`, w.`workshop_name`, e.`id_worker`, e.`last_name`, e.`first_name`,e.`patronymic` 
												FROM `workshops` w 
												LEFT JOIN `engineering_staff` e ON w.`workshop_manager`=e.`id_worker` ORDER BY w.`workshop_name` ".$sort);			
						
						$count=1;
						echo "<table class='table_price' ' border='1' ' border='1'> <caption>Цеха</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Название цеха  <a class='button2' href='workshops.php?sort_workshop={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник цеха <a class='button2' href='workshops.php?sort_last={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Участки цеха</th>
							<th></th>
							<th></th>
						</tr>";
						
						while($row=mysqli_fetch_array($result))
						{
							$plots="";
							$result1=mysqli_query($link,"SELECT plot_name FROM plots WHERE id_workshop = {$row[0]}");
							
							while ($row1=mysqli_fetch_array($result1))
							{
								$plots=$plots." ".$row1[0];
								
							}
							if ($plots=='') $plots='-';
							echo "
							<tr>
								<td>{$count}</td>
								<td>{$row[1]}</td>
								<td><a href='../engineering_staff/engineering_info.php?id_info={$row[2]}'>{$row[3]} {$row[4]} {$row[5]}</a></td>
								<td>{$plots}</td>
								<td><a class='button2' href='workshops.php?id_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='workshops.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить цех из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "<br><a class='button2' href='workshops.php?new_workshop'> Добавить новый цех &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
					}
					?>
					
					
				<?
				//Добавление нового цеха
				if (isset ($_GET['new_workshop']) && !isset($_GET[id_change]) && !isset($_GET['change_workshop']))
				{
					echo "<h2>ДОБАВЛЕНИЕ НОВОГО ЦЕХА В  ПРЕДПРИЯТИЕ</h2>
					
						<form action='workshops.php' method='GET'>
							<input type='text' class='textedit' name='workshop_name' placeholder='введите название цеха' required> <br><br>
							<select size='1' name='manager' class='select' required>
								<option  class='textedit' value=''>Выберите начальника цеха</option>";
								$result=mysqli_query($link, "SELECT * FROM `engineering_staff`");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_worker']}'>{$row['last_name']} {$row['first_name']} {$row['patronymic']}</option>";
								}
								
						echo "</select><br><br>";
								$result1=mysqli_query($link, "SELECT * FROM `plots` WHERE 1");
								while ($row1=mysqli_fetch_array($result1))
								{
									echo "<input type='checkbox' name='{$row1['id_plot']}' value='{$row1['id_plot']}'> {$row1['plot_name']} </input> <br>";
								}
							
							echo "<br><button  class='button1' name='add_workshop' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
						</form>";
					
					
				}
				
				if (isset ($_GET['add_workshop']) && !isset($_GET[id_change]) && !isset($_GET['change_workshop']))
				{
					echo "Цех успешно добавлен в базу!";
					mysqli_query($link,"INSERT INTO `workshops` (`id_workshop`, `workshop_name`, `workshop_manager`) VALUES (NULL, '{$_GET['workshop_name']}', '{$_GET['manager']}')");
					
					$result = mysqli_query($link, "SELECT MAX(`id_workshop`) FROM `workshops`");
					$row = mysqli_fetch_array($result);
					$last_id=$row[0];
					
					$result = mysqli_query($link,"SELECT `id_plot` FROM `plots`");
					
					while ($row=mysqli_fetch_array($result))
					{
						$id=$row[0];
					if ($row[0] == $_GET[$id]) mysqli_query($link,"UPDATE `plots` SET `id_workshop`='{$last_id}' WHERE `id_plot`='{$_GET[$id]}'");
					}
					
				}
				
				//ИЗМЕНЕНИЕ ДАННЫХ ЦЕХА
				
				if(isset($_GET[id_change]) && !isset($_GET['change_workshop']))
				{
					$result1=mysqli_query($link,"SELECT w.`id_workshop`, w.`workshop_name`, w.`workshop_manager`, e.`id_worker`,e.`last_name`,e.`first_name`,e.`patronymic` FROM `workshops` w
LEFT JOIN `engineering_staff` e ON w.`workshop_manager`=e.`id_worker` WHERE w.`id_workshop`='{$_GET[id_change]}'");
					$row1=mysqli_fetch_array($result1);
					
					
					
					echo "<h2>ИЗМЕНЕНИЕ ДАННЫХ ЦЕХА: </h2>";
					
					echo"<form action='workshops.php' method='GET'>
							<input type='hidden' name='id_workshop' value='{$row1[0]}'>
							<input type='text' class='textedit' value='{$row1['workshop_name']}'name='workshop_name' placeholder='введите название цеха' required> <br><br>
							<select size='1' name='manager' class='select' required>
								<option  class='textedit' value='{$row1['workshop_manager']}'>{$row1[4]} {$row1[5]} {$row1[6]}</option>";
								$result=mysqli_query($link, "SELECT * FROM `engineering_staff`");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_worker']}'>{$row['last_name']} {$row['first_name']} {$row['patronymic']}</option>";
								}
								
						echo "</select><br><br>";
								$result1=mysqli_query($link, "SELECT * FROM `plots` WHERE 1");
								while ($row1=mysqli_fetch_array($result1))
								{
									if ($row1['id_workshop'] == $_GET[id_change])
										echo "<input type='checkbox' name='{$row1['id_plot']}' value='{$row1['id_plot']}' checked> {$row1['plot_name']} </input> <br>";
									else
										echo "<input type='checkbox' name='{$row1['id_plot']}' value='{$row1['id_plot']}'> {$row1['plot_name']} </input> <br>";
								}
							
							echo "<br><button  class='button1' name='change_workshop' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить изменения</button>
						</form>";					
				}
				
				if(isset($_GET['change_workshop']))
				{
					mysqli_query($link,"UPDATE `workshops` SET `workshop_name`='{$_GET['workshop_name']}',`workshop_manager`='{$_GET['manager']}' WHERE `id_workshop`={$_GET['id_workshop']}");
					
					mysqli_query($link,"UPDATE `plots` SET `id_workshop`= NULL WHERE `id_workshop`='{$_GET['id_workshop']}'");
					
					$result = mysqli_query($link,"SELECT `id_plot` FROM `plots`");
					
					while ($row=mysqli_fetch_array($result))
					{
						$id=$row[0];
						if ($row[0] == $_GET[$id]) mysqli_query($link,"UPDATE `plots` SET `id_workshop`='{$_GET['id_workshop']}' WHERE `id_plot`='{$_GET[$id]}'");
					}					
					
				}
				
				
				
				?>
					
			</div>

			<div class="footer">&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>