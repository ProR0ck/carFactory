<?php require "auth.php";?>
<?php 
if (isset($_GET['id_delete']) || isset($_POST['submit_works']))
	{ 
		$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
		mysqli_query($link,"DELETE FROM `type_of_work` WHERE `type_of_work`='{$_GET['id_delete']}'");
		header("Location: works.php");	
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
				<?if (!isset($_GET['new_works'])&& !isset($_POST['submit_works']) && !isset($_GET['works_change'])) echo "<h2>УПРАВЛЕНИЕ ВИДАМИ РАБОТ</h2>";?>
				
				
				<? 
				//ТАБЛИЦА ДО СОРТИРОВКИ
				if (!isset($_GET['sort_works'])&& !isset($_GET['new_works'])&& !isset($_POST['submit_works']) && !isset($_GET['works_change']) && !isset($_GET['new_works_change']))
				{
				
				$result=mysqli_query($link,"SELECT * FROM `type_of_work` WHERE 1"); $count=1;
				
				echo "<table class='table_price'> <caption>Виды работ на участках</caption>
					<tr>
						<th>№</th>
						<th> вид работы <a class='button2'href='works.php?sort_works=1'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
						<th></th>
						<th></th>
					</tr>";
				while($row=mysqli_fetch_array($result))
					{
					
					echo"
					<tr>
						<td>{$count}</td>
						<td>{$row[0]}</td>
						<td><a class='button2' href='works.php?works_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
						<td><a class='button2' href='works.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить вид работы из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
					</tr>
					";
					$count++;
					}
				echo "</table>";
				}
				?>
				
				
				<?
				if (isset($_GET['sort_works']) && !isset($_GET['new_works'])&& !isset($_POST['submit_works']) && !isset($_GET['works_change']) && !isset($_GET['new_works_change']))
				{
				
				$asc="ASC";
				$desc="DESC";
				$sort=$asc;
				if (($_GET['sort_works'])=='0') 
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
				$result=mysqli_query($link,"SELECT * FROM `type_of_work` WHERE 1 ORDER BY `type_of_work` ".$sort);
				echo "<table class='table_price'> <caption>Виды работ на участках</caption>
					<tr>
						<th>№</th>
						<th> вид работы <a class='button2'href='works.php?sort_works={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
						<th></th>
						<th></th>
					</tr>";
				$count=1;
				while($row=mysqli_fetch_array($result))
					{
					
					echo"
					<tr>
						<td>{$count}</td>
						<td>{$row[0]}</td>
						<td><a class='button2' href='works.php?works_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
						<td><a class='button2' href='works.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить вид работы из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
					</tr>
					";
					$count++;
					}
				echo "</table>";
				}
				?>
				
				
				<?if (!isset($_GET['new_works'])&& !isset($_POST['submit_works']) && !isset($_GET['works_change']) && !isset($_GET['new_works_change'])) echo "<br><a class='button2' href='plots.php' class='button2'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Назад</a>&nbsp;&nbsp;
				<a href='works.php?new_works' class='button2'> добавить новый вид работы&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";?>
				
			<?
			if (isset($_GET['new_works']) && !isset($_POST['submit_works']) && !isset($_GET['works_change']) && !isset($_GET['new_works_change']))
			{
				echo "<h2>ДОБАВЛЕНИЕ ВИДА РАБОТ </h2>";
				echo "вид работы работы:<br><br>
				<form action='works.php' method='POST'>
					<input type='text' class='textedit' name='works' placeholder='вид работы' required>
					<br><br>
					<a class='button2' href='works.php'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;вернуться назад </a>&nbsp;&nbsp;
					<button  class='button1' name='submit_works' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
				</form>";
			}
			
			if (isset($_POST['submit_works']))
			{
				echo "вид работы успешно добавлена в базу! <br><br>";
				
				mysqli_query($link,"INSERT IGNORE INTO `type_of_work` (`type_of_work`) VALUES ('{$_POST['works']}')");
				
				echo "<a class='button2' href='works.php' class='button2'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Список должностей</a>&nbsp;&nbsp;<a class='button2' href='plots.php' class='button2'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Назад</a>&nbsp;&nbsp;
				<a href='works.php?new_works' class='button2'> добавить новый вид работы&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
				
			}
			
			?>
			<?
			//ИЗМЕНЕНИЕ ДОЛЖНОСТИ
			if (isset($_GET['works_change']))
			{
				$result=mysqli_query($link, "SELECT `type_of_work` FROM `type_of_work` WHERE `type_of_work`='{$_GET['works_change']}'");
				$row=mysqli_fetch_array($result);
				echo"
				<h2>ИЗМЕНИТЕ вид работы ДОЛЖНОСТИ</h2>
				<form action='works.php' nethod='GET'>
					<input type='text' class='textedit' name='new_works_change' value='{$row[0]}'>
					<input type='hidden' name='id' value='{$_GET['works_change']}'>
					<br> <br>
					<a class='button2' href='works.php'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;вернуться назад </a>
					<button  class='button1' name='submit_new_works'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp; сохранить изменения</button>
				</form>
				";
			}
			
			if(isset($_GET['new_works_change']))
			{
				echo "
					<h2>Изменения успешно сохранены</h2>
					<a class='button2' href='works.php' class='button2'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Список должностей</a>&nbsp;&nbsp;<a class='button2' href='plots.php' class='button2'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Назад</a>&nbsp;&nbsp;
				<a href='works.php?new_works' class='button2'> добавить новый вид работы&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>;
				";
				mysqli_query($link, "UPDATE `type_of_work` SET `type_of_work`='{$_GET['new_works_change']}' WHERE `type_of_work`= '{$_GET['id']}'");
				
			}
			
			?>
			</div>

			<div class='footer'>&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>