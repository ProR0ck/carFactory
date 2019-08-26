<?php require "auth.php";?>
<?php 
if (isset($_GET['id_delete_brigade']) || isset ($_GET['add_brigade']) || isset($_GET['id_delete_worker']) || isset($_GET['add_worker_complete']))
	{ 
		$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
		
		mysqli_query($link,"UPDATE `working_staff` SET `id_brigade`= NULL WHERE `id_brigade` = {$_GET['id_delete_brigade']}");
		mysqli_query($link,"UPDATE `plots` SET `id_brigade`= NULL WHERE `id_brigade` = {$_GET['id_delete_brigade']}");
		mysqli_query($link,"DELETE FROM `brigades` WHERE `id_brigade` = {$_GET['id_delete_brigade']}");
		mysqli_query($link,"UPDATE `plots` SET id_brigade`=null WHERE `id_brigade` = {$_GET['id_delete_brigade']}");
		
		mysqli_query($link,"UPDATE `working_staff` SET `id_brigade`= NULL WHERE `id_worker` = {$_GET['id_delete_worker']}");
		
		header("Location: brigade.php");	
	}?>
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
				<?if (!isset($_GET['new_position'])&& !isset($_POST['submit_position']) && !isset($_GET['position_change']) && !isset($_GET['new_worker'])) echo "<h2>УПРАВЛЕНИЕ БРИГАДАМИ</h2>";?>
				
				
				<? 
				//ТАБЛИЦА ДО СОРТИРОВКИ
				if (!isset($_GET['new_brigade']) && !isset($_GET['new_worker']) && !isset($_GET['id_info']))
				{
				
				$result1=mysqli_query($link, "SELECT `id_brigade`,`brigade_name` FROM `brigades`"); 
				$count=1;
				$plots="";
				
				while ($row1=mysqli_fetch_array($result1))
				{
				
				$result=mysqli_query($link,"SELECT b.`id_brigade`, b.`brigade_name`,w.`id_worker`, w.`last_name`, w.`first_name`, w.`patronymic`, wp.`position`, 
												IF(w.`id_worker`= b.`brigadier`,'бригадир','-')
                                                
												FROM `working_staff` w 
												LEFT JOIN `worker_position` wp ON w.`id_position`=wp.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade`
                                             
												WHERE b.`id_brigade`= {$row1[0]}");
												
				echo "<table class='table_price' ' border='1' > <caption>{$row1['brigade_name']}</caption>
					<tr>
						<th>№</th>
						
						<th>ФИО сотрудника</th>
						
						<th>Должность</th>
						
						<th>Статус бригадира</th>
						
						<th>Участок</th>
						
						<th></th>
						<th></th>
					</tr>";
				while($row=mysqli_fetch_array($result))
					{
					
					$result3=mysqli_query($link,"SELECT `plot_name` FROM `plots` WHERE `id_brigade`={$row[0]}");
					while ($row3=mysqli_fetch_array($result3))
					{
						$plots = $plots." ".$row3[0];
					}
					echo "
					
					<tr>
						<td>{$count}</td>
						
						<td><a href='worker_info.php?id_info={$row[2]}'>{$row[3]} {$row[4]} {$row[5]}</a></td>
						
						<td>{$row[6]}</td>
						
						<td>{$row[7]}</td>
						<td>{$plots}</td>
						<td><a class='button2' href='change_worker.php?id_change={$row[2]}'>Изменить сотрудника<i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
						
						<td><a class='button2' href='brigade.php?id_delete_worker={$row[2]}' onclick=".'"'."return confirm('Вы точно хотите удалить сотрудника из бригады?')".'"'.">Удалить из бригады<i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
					</tr>
					
					";
					$count++;
					$plots="";
					}
					$count=1;
					$plots="";
					echo "</table>
					<br><a class='button2' href='brigade.php?new_worker&id={$row1[0]}'> Добавить сотрудников в бригаду &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a> &nbsp;&nbsp; <a class='button2' href='brigade.php?id_delete_brigade={$row1['id_brigade']}' onclick=".'"'."return confirm('Вы точно хотите удалить бригаду из списка?')".'"'.">Удалить бригаду <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a><hr>
					";
				}	
				}
				?>
				
				<?
				//Добавление новой бригады
				if (isset($_GET['new_brigade']) && !isset($_GET['new_worker'])) 
				{
					echo"
				<form action='brigade.php' method='GET'>
					Бригада &nbsp;&nbsp;
					<input type='text' name='name' class='textedit' placeholder='Введите название' required> <br>
					<br>
					Добавьте сотрудников в бригаду:<br><br>";
				
				$result=mysqli_query($link,"SELECT w.`id_worker`,w.`last_name`,w.`first_name`,w.`patronymic`,b.`brigade_name`, p.`position`
											FROM `working_staff` w
											LEFT JOIN `brigades`b ON w.`id_brigade`=b.`id_brigade`
                                            LEFT JOIN `worker_position` p ON w.`id_position`=p.`id_position`");
				echo "<table class='table_info' border='1'>

					<tr><th>Сотрудник</th><th>Бригада</th><th>Должность</th></tr>";
				while ($row=mysqli_fetch_array($result))
				{
					echo "<tr><td><input type='checkbox' name='{$row[0]}' value='{$row[0]}'> {$row[1]} {$row[2]} {$row[3]}</input></td> <td>{$row[4]}</td><td>{$row[5]}</td></tr>";
				}
				echo '</table>';
				
				echo "<br><select size='1' name='brigadier' class='select' required>
						<option  class='textedit' value=''>Выберите бригадира</option>";
					$result=mysqli_query($link, "SELECT * FROM `working_staff`");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row['id_worker']}'>{$row['last_name']} {$row['first_name']} {$row['patronymic']}</option>";
						}
								
					echo "</select><br><br>";
					
					echo "<br><a class='button2' href='brigade.php'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;вернуться назад </a>&nbsp;&nbsp;<button  class='button1' name='add_brigade' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
				</form>";
				}
				
				if (isset ($_GET['add_brigade']) && !isset($_GET['new_worker']))
				{
					mysqli_query($link,"INSERT INTO `brigades` (`id_brigade`, `brigade_name`, `brigadier`) VALUES (NULL, '{$_GET['name']}', '{$_GET['brigadier']}')");
					
					$result = mysqli_query($link, "SELECT MAX(`id_brigade`) FROM `brigades`");
					$row = mysqli_fetch_array($result);
					$last_id=$row[0];
					mysqli_query($link,"UPDATE `working_staff` SET `id_brigade`= {$last_id} WHERE `id_worker` = {$_GET['brigadier']}");
					$result=mysqli_query($link,"SELECT `id_worker`, `last_name`, `first_name`, `patronymic`, `id_position`, `id_brigade` FROM `working_staff` WHERE 1");
					
					while($row=mysqli_fetch_array($result))
					{
						$id=$row[0];
						if ($row[0] == $_GET[$id])
						{
							mysqli_query($link,"UPDATE `working_staff` SET `id_brigade`= {$last_id} WHERE `id_worker` = {$_GET[$id]}");
						}
					}
					
				}
				
				
				?>
				

				
				
				
				<?if (!isset($_GET['new_brigade']) && !isset($_GET['new_worker']) && !isset($_GET['id_info'])) echo "<br><a class='button2' href='brigade.php' class='button2'><i class='fa fa-list-alt' aria-hidden='true'></i>&nbsp;&nbsp;Список бригад</a>&nbsp;&nbsp;
				<a href='brigade.php?new_brigade' class='button2'> Добавить новую бригаду&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";?>
				
			<? if(isset($_GET['new_worker'])) 
			{
				echo "
				<h2>Добавьте сотрудников в бригаду</h2> 
				<form action='brigade.php' method='GET'>
					<input type='hidden' value='{$_GET['id']}' name='add_worker_complete'>";
								$result=mysqli_query($link,"SELECT w.`id_worker`,w.`last_name`,w.`first_name`,w.`patronymic`,b.`brigade_name`, p.`position`
											FROM `working_staff` w
											LEFT JOIN `brigades`b ON w.`id_brigade`=b.`id_brigade`
                                            LEFT JOIN `worker_position` p ON w.`id_position`=p.`id_position`");
				echo "<table class='table_info' border='1'>

					<tr><th>Сотрудник</th><th>Бригада</th><th>Должность</th></tr>";
				while ($row=mysqli_fetch_array($result))
				{
					echo "<tr><td><input type='checkbox' name='{$row[0]}' value='{$row[0]}'> {$row[1]} {$row[2]} {$row[3]}</input></td> <td>{$row[4]}</td><td>{$row[5]}</td></tr>";
				}
				echo "</table>  <br> <a class='button2' href='brigade.php'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;вернуться назад </a>&nbsp;&nbsp; <button  class='button1' name='add_brigade' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button> </form>";
			}
			 if (isset($_GET['add_worker_complete'])) 
			 {
			 	$result=mysqli_query($link,"SELECT `id_worker`, `last_name`, `first_name`, `patronymic`, `id_position`, `id_brigade` FROM `working_staff` WHERE 1");
					
					while($row=mysqli_fetch_array($result))
					{
						$id=$row[0];
						if ($row[0] == $_GET[$id])
						{
							mysqli_query($link,"UPDATE `working_staff` SET `id_brigade`= {$_GET['add_worker_complete']} WHERE `id_worker` = {$_GET[$id]}");
						}
					}
			 }

			 if(isset($_GET['id_info']))
			 {

				
				$result=mysqli_query($link,"SELECT b.`id_brigade`, b.`brigade_name`,w.`id_worker`, w.`last_name`, w.`first_name`, w.`patronymic`, wp.`position`, 
												IF(w.`id_worker`= b.`brigadier`,'бригадир','-')
                                                
												FROM `working_staff` w 
												LEFT JOIN `worker_position` wp ON w.`id_position`=wp.`id_position`
												LEFT JOIN `brigades` b ON w.`id_brigade`=b.`id_brigade`
                                             
												WHERE b.`id_brigade`= {$_GET['id_info']}");
				$row1=mysqli_fetch_array($result);								
				echo "<table class='table_price' ' border='1' > <caption>{$row1['brigade_name']}</caption>
					<tr>
						<th>№</th>
						
						<th>ФИО сотрудника</th>
						
						<th>Должность</th>
						
						<th>Статус бригадира</th>
						
						<th>Участок</th>
						
						<th></th>
						<th></th>
					</tr>";
					$count=1;
				while($row=mysqli_fetch_array($result))
					{
					
					$result3=mysqli_query($link,"SELECT `plot_name` FROM `plots` WHERE `id_brigade`={$row[0]}");
					while ($row3=mysqli_fetch_array($result3))
					{
						$plots = $plots." ".$row3[0];
					}
					echo "
					
					<tr>
						<td>{$count}</td>
						
						<td><a href='worker_info.php?id_info={$row[2]}'>{$row[3]} {$row[4]} {$row[5]}</a></td>
						
						<td>{$row[6]}</td>
						
						<td>{$row[7]}</td>
						<td>{$plots}</td>
						<td><a class='button2' href='change_worker.php?id_change={$row[2]}'>Изменить сотрудника<i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
						
						<td><a class='button2' href='brigade.php?id_delete_worker={$row[2]}' onclick=".'"'."return confirm('Вы точно хотите удалить сотрудника из бригады?')".'"'.">Удалить из бригады<i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
					</tr>
					
					";
					$count++;
					$plots="";
					}
					$count=1;
					$plots="";
					echo "</table>
					<br><a class='button2' href='brigade.php?new_worker&id={$row1[0]}'> Добавить сотрудника в бригаду &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>&nbsp;&nbsp;<a class='button2' href='brigade.php?id_delete_brigade={$row1['id_brigade']}' onclick=".'"'."return confirm('Вы точно хотите удалить бригаду из списка?')".'"'.">Удалить бригаду <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a>&nbsp;&nbsp;<a class='button2' href='brigade.php' class='button2'><i class='fa fa-list-alt' aria-hidden='true'></i>&nbsp;&nbsp;Полный список бригад</a>
					";
			 }
			?>

			</div>

			<div class='footer'>&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>