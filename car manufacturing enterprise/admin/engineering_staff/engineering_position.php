<?php require "auth.php";?>
<?php 
if (isset($_GET['id_delete']))
	{ 
		$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
		mysqli_query($link,"UPDATE `engineering_staff` SET `id_position`= 5 WHERE `id_position`={$_GET['id_delete']}");
		mysqli_query($link,"DELETE FROM `engineering_position` WHERE `id_position`={$_GET['id_delete']}");
		header("Location: engineering_position.php");	
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
				<p><a class="left-menu" href="../working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="../working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class='content'>
				<?if (!isset($_GET['new_position'])&& !isset($_POST['submit_position']) && !isset($_GET['position_change'])) echo "<h2>УПРАВЛЕНИЕ ДОЛЖНОСТЯМИ</h2>";?>
				
				
				<? 
				//ТАБЛИЦА ДО СОРТИРОВКИ
				if (!isset($_GET['sort_position'])&& !isset($_GET['new_position'])&& !isset($_POST['submit_position']) && !isset($_GET['position_change']) && !isset($_GET['new_position_change']))
				{
				
				$result=mysqli_query($link,"SELECT * FROM `engineering_position` WHERE `position` <> '-'"); $count=1;
				
				echo "<table class='table_price'> <caption>Список должностей рабочего персонала</caption>
					<tr>
						<th>№</th>
						<th> должность <a class='button2'href='engineering_position.php?sort_position=1'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
						<th></th>
						<th></th>
					</tr>";
				while($row=mysqli_fetch_array($result))
					{
					
					echo"
					<tr>
						<td>{$count}</td>
						<td>{$row[1]}</td>
						<td><a class='button2' href='engineering_position.php?position_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
						<td><a class='button2' href='engineering_position.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить должность из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
					</tr>
					";
					$count++;
					}
				echo "</table>";
				}
				?>
				
				
				<?
				if (isset($_GET['sort_position']) && !isset($_GET['new_position'])&& !isset($_POST['submit_position']) && !isset($_GET['position_change']) && !isset($_GET['new_position_change']))
				{
				
				$asc="ASC";
				$desc="DESC";
				$sort=$asc;
				if (($_GET['sort_position'])=='0') 
				{
					$sort=$asc;
					$flag=1;
				}
				else 
				{
					$sort=$desc;
					$flag=0;
				}
				//таблица после сортировки
				$result=mysqli_query($link,"SELECT * FROM `engineering_position` WHERE `position` <> '-' ORDER BY `position` ".$sort);
				echo "<table class='table_price'> <caption>Список должностей рабочего персонала</caption>
					<tr>
						<th>№</th>
						<th> должность <a class='button2'href='engineering_position.php?sort_position={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
						<th></th>
						<th></th>
					</tr>";
				$count=1;
				while($row=mysqli_fetch_array($result))
					{
					
					echo"
					<tr>
						<td>{$count}</td>
						<td>{$row[1]}</td>
						<td><a class='button2' href='engineering_position.php?position_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
						<td><a class='button2' href='engineering_position.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить должность из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
					</tr>
					";
					$count++;
					}
				echo "</table>";
				}
				?>
				
				
				
				<?if (!isset($_GET['new_position'])&& !isset($_POST['submit_position']) && !isset($_GET['position_change']) && !isset($_GET['new_position_change'])) echo "<br><a class='button2' href='engineering_staff.php' class='button2'><i class='fa fa-list-alt' aria-hidden='true'></i>&nbsp;&nbsp;Список сотрудников</a>&nbsp;&nbsp;
				<a href='engineering_position.php?new_position' class='button2'> Добавить новую должность&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";?>
				
			<?
			if (isset($_GET['new_position']) && !isset($_POST['submit_position']) && !isset($_GET['position_change']) && !isset($_GET['new_position_change']))
			{
				echo "<h2>ДОБАВЛЕНИЕ НОВОЙ ДОЛЖНОСТИ </h2>";
				echo "Название должности:<br><br>
				<form action='engineering_position.php' method='POST'>
					<input type='text' class='textedit' name='position' placeholder='должность' required>
					<br><br>
					<a class='button2' href='engineering_position.php'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;вернуться назад </a>&nbsp;&nbsp;
					<button  class='button1' name='submit_position' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
				</form>";
			}
			
			if (isset($_POST['submit_position']))
			{
				echo "Должность успешно добавлена в базу! <br><br>";
				
				mysqli_query($link,"INSERT IGNORE INTO `engineering_position` (`position`) VALUES ('{$_POST['position']}')");
				
				echo "<a class='button2' href='engineering_position.php' class='button2'><i class='fa fa-list-alt' aria-hidden='true'></i>&nbsp;&nbsp;Список должностей</a>&nbsp;&nbsp;<a class='button2' href='engineering_staff.php' class='button2'><i class='fa fa-list-alt' aria-hidden='true'></i>&nbsp;&nbsp;Список сотрудников</a>&nbsp;&nbsp;
				<a href='engineering_position.php?new_position' class='button2'> Добавить новую должность&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
				
			}
			
			?>
			<?
			//ИЗМЕНЕНИЕ ДОЛЖНОСТИ
			if (isset($_GET['position_change']))
			{
				$result=mysqli_query($link, "SELECT `position` FROM `engineering_position` WHERE `id_position`='{$_GET['position_change']}'");
				$row=mysqli_fetch_array($result);
				echo"
				<h2>ИЗМЕНИТЕ НАЗВАНИЕ ДОЛЖНОСТИ</h2>
				<form action='engineering_position.php' nethod='GET'>
					<input type='text' class='textedit' name='new_position_change' value='{$row[0]}'>
					<input type='hidden' name='id' value='{$_GET['position_change']}'>
					<br> <br>
					<a class='button2' href='engineering_position.php'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;вернуться назад </a>
					<button  class='button1' name='submit_new_position'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp; сохранить изменения</button>
				</form>
				";
			}
			
			if(isset($_GET['new_position_change']))
			{
				echo "
					<h2>Изменения успешно сохранены</h2>
					<a class='button2' href='engineering_position.php' class='button2'><i class='fa fa-list-alt' aria-hidden='true'></i>&nbsp;&nbsp;Список должностей</a>&nbsp;&nbsp;<a class='button2' href='engineering_staff.php' class='button2'><i class='fa fa-list-alt' aria-hidden='true'></i>&nbsp;&nbsp;Список сотрудников</a>&nbsp;&nbsp;
				<a href='engineering_position.php?new_position' class='button2'> Добавить новую должность&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>;
				";
				mysqli_query($link, "UPDATE `engineering_position` SET `position`='{$_GET['new_position_change']}' WHERE `id_position`= {$_GET['id']}");
				
			}
			
			?>
			</div>

			<div class='footer'>&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>