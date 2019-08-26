<?php require "auth.php";?>
<?php 
	$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
if (isset($_GET['id_delete']) || isset($_GET['add_plot']))
	{ 
		mysqli_query($link,"DELETE FROM `plots` WHERE `id_plot`= {$_GET['id_delete']}");
		mysqli_query($link,"DELETE FROM `work` WHERE `id_plot`= {$_GET['id_delete']}");
		header("Location: plots.php");
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
				<p><a class="left-menu" href="../workshops/workshops.php">Цеха</a></p>
				<p><a class="left-menu" href="plots.php">Участки</a></p>
				<p><a class="left-menu" href="../working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="../working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="../engineering_staff/engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class="content">	
				<? if (!isset($_GET['new_plot']) && !isset($_GET['id_change']) && !isset($_GET['save_change']))echo "<h2>УПРАВЛЕНИЕ УЧАСТКАМИ</h2>";?>
					
					<?
					if (!isset($_GET['search']) && !isset($_GET['new_plot']) && !isset($_GET['add_plot']) && !isset($_GET['id_change']) && !isset($_GET['save_change']))
					{
						echo "<form action='plots.php' method='GET'>
						<p>Поиск участка:</p>
						<input class='textedit'type='text' name ='search' placeholder='Введите название участка'>
					
						<button class='button1' type='submit' name='submit'> <i class='fa fa-search' aria-hidden='true'></i>&nbsp;&nbsp;поиск</button>
					</form>";
					}
					?>
					

					<?
					//НАЧАЛЬНАЯ ТАБЛИЦА
					$result=mysqli_query($link, "SELECT DISTINCT pl.`id_plot`, pl.`plot_name`, e.`id_worker`, e.`last_name`, e.`first_name`, e.`patronymic`, b.`id_brigade`, b.`brigade_name`, w.`id_workshop`, w.`workshop_name`,wr.`type_of_work`
												FROM `plots` pl
												LEFT JOIN `engineering_staff` e ON pl.`plot_manager`=e.`id_worker`
												LEFT JOIN `brigades` b ON pl.`id_brigade`=b.`id_brigade`
												LEFT JOIN `workshops` w ON pl.`id_workshop`=w.`id_workshop`
                                                LEFT JOIN `work` wr on pl.`id_plot`=wr.`id_plot`");
					if (!isset($_GET['search']) && !isset($_GET['sort_plot'])&& !isset($_GET['sort_last'])&& !isset($_GET['sort_brigade'])&& !isset($_GET['sort_workshop']) && !isset($_GET['new_plot']) && !isset($_GET['add_plot']) && !isset($_GET['id_change']) && !isset($_GET['save_change']))
					{
						$count=1;
						echo "<table class='table_price' ' border='1'> <caption>Участки</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Участок <a class='button2' href='plots.php?sort_plot=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник участка <a class='button2' href='plots.php?sort_last=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Бригада <a class='button2'href='plots.php?sort_brigade=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Цех <a class='button2'href='plots.php?sort_workshop=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Вид работ на участке</th>
							<th></th>
							<th></th>
						</tr>";
						while($row=mysqli_fetch_array($result))
						{
							if ($row[2] == NULL) {$row[3]='';$row[4]='';$row[5]='';}
							if ($row[6] == NULL) $row[7]=''; 							
							echo "
							<tr>
								<td>{$count}</td>
								<td>{$row[1]}</td>
								<td><a href='../engineering_staff/engineering_info.php?id_info={$row[2]}'>{$row[3]} {$row[4]} {$row[5]}</a></td>
								<td><a href='../working_staff/brigade.php?id_info={$row[6]}'>{$row[7]}</a></td>
								<td><a href='../workshops/workshops.php?search=$row[9]&submit='>{$row[9]}</a></td>
								<td>{$row[10]}</td>
								<td><a class='button2' href='plots.php?id_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='plots.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить участок из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "<br><a class='button2' href='plots.php?new_plot'> Добавить новый участок &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>
						&nbsp;&nbsp; <a href='works.php' class='button2'> Управление видами работ&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
						
					}
					?>
					
					
					<?
					if (isset($_GET['search']))
					{	
						//ТАБЛИЦА ПОСЛЕ ПОИСКА
						echo "Результаты поиска: <br><br>";
						$result=mysqli_query($link,"SELECT DISTINCT pl.`id_plot`, pl.`plot_name`, e.`id_worker`, e.`last_name`, e.`first_name`, e.`patronymic`, b.`id_brigade`, b.`brigade_name`, w.`id_workshop`, w.`workshop_name`,wr.`type_of_work`
												FROM `plots` pl
												LEFT JOIN `engineering_staff` e ON pl.`plot_manager`=e.`id_worker`
												LEFT JOIN `brigades` b ON pl.`id_brigade`=b.`id_brigade`
												LEFT JOIN `workshops` w ON pl.`id_workshop`=w.`id_workshop`
                                                LEFT JOIN `work` wr on pl.`id_plot`=wr.`id_plot`
												WHERE pl.`plot_name` LIKE '%{$_GET['search']}%'");
						if ($_GET['search'] == "") $result=NULL;
						$count=1;
						echo "<table class='table_price' ' border='1'> <caption>Инженерно технический персонал</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Участок <a class='button2' href='plots.php?sort_plot=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник участка <a class='button2' href='plots.php?sort_last=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Бригада <a class='button2'href='plots.php?sort_brigade=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Цех <a class='button2'href='plots.php?sort_workshop=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Вид работ на участке</th>
							<th></th>
							<th></th>
						</tr>";
				
						while($row=mysqli_fetch_array($result))
						{
							if ($row[2] == NULL) {$row[3]='';$row[4]='';$row[5]='';}
							if ($row[6] == NULL) $row[7]=''; 							
							echo "
							<tr>
								<td>{$count}</td>
								<td>{$row[1]}</td>
								<td><a href='../engineering_staff/engineering_info.php?id_info={$row[2]}'>{$row[3]} {$row[4]} {$row[5]}</a></td>
								<td><a href='../working_staff/brigade.php?id_info={$row[6]}'>{$row[7]}</a></td>
								<td><a href='../workshops/workshops.php?search=$row[9]&submit='>{$row[9]}</a></td>
								<td>{$row[10]}</td>
								<td><a class='button2' href='plots.php?id_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='plots.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить участок из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "<br>
						
						<a class='button2' href='plots.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a>  &nbsp;&nbsp;<a class='button2' href='plots.php?new_plot'> Добавить новый участок &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>
						&nbsp;&nbsp; <a href='works.php' class='button2'> Управление видами работ&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";						
					}
					?>
					
					<?
					//СОРТИРОВКА
					if (isset($_GET['sort_plot'])|| isset($_GET['sort_last'])|| isset($_GET['sort_brigade'])|| isset($_GET['sort_workshop']))
					{
						$asc="ASC";
						$desc="DESC";
						$sort=$asc;
						if ((($_GET['sort_plot'])=='0') || (($_GET['sort_last'])=='0') || (($_GET['sort_brigade'])=='0') || (($_GET['sort_workshop'])=='0')) 
						{
							$sort=$asc;
							$flag=1;
						} 
						else
						{
							$sort=$desc;
							$flag=0;
						}
						
						if (isset($_GET['sort_plot'])) $result=mysqli_query($link,"SELECT DISTINCT pl.`id_plot`, pl.`plot_name`, e.`id_worker`, e.`last_name`, e.`first_name`, e.`patronymic`, b.`id_brigade`, b.`brigade_name`, w.`id_workshop`, w.`workshop_name`,wr.`type_of_work`
												FROM `plots` pl
												LEFT JOIN `engineering_staff` e ON pl.`plot_manager`=e.`id_worker`
												LEFT JOIN `brigades` b ON pl.`id_brigade`=b.`id_brigade`
												LEFT JOIN `workshops` w ON pl.`id_workshop`=w.`id_workshop`
                                                LEFT JOIN `work` wr on pl.`id_plot`=wr.`id_plot` ORDER BY pl.`plot_name` ".$sort);
						
						
						if (isset($_GET['sort_last'])) $result=mysqli_query($link,"SELECT DISTINCT pl.`id_plot`, pl.`plot_name`, e.`id_worker`, e.`last_name`, e.`first_name`, e.`patronymic`, b.`id_brigade`, b.`brigade_name`, w.`id_workshop`, w.`workshop_name`,wr.`type_of_work`
												FROM `plots` pl
												LEFT JOIN `engineering_staff` e ON pl.`plot_manager`=e.`id_worker`
												LEFT JOIN `brigades` b ON pl.`id_brigade`=b.`id_brigade`
												LEFT JOIN `workshops` w ON pl.`id_workshop`=w.`id_workshop`
                                                LEFT JOIN `work` wr on pl.`id_plot`=wr.`id_plot` ORDER BY e.`last_name`  ".$sort);
						
						if (isset($_GET['sort_brigade'])) $result=mysqli_query($link,"SELECT DISTINCT pl.`id_plot`, pl.`plot_name`, e.`id_worker`, e.`last_name`, e.`first_name`, e.`patronymic`, b.`id_brigade`, b.`brigade_name`, w.`id_workshop`, w.`workshop_name`,wr.`type_of_work`
												FROM `plots` pl
												LEFT JOIN `engineering_staff` e ON pl.`plot_manager`=e.`id_worker`
												LEFT JOIN `brigades` b ON pl.`id_brigade`=b.`id_brigade`
												LEFT JOIN `workshops` w ON pl.`id_workshop`=w.`id_workshop`
                                                LEFT JOIN `work` wr on pl.`id_plot`=wr.`id_plot` ORDER BY b.`brigade_name` ".$sort);
						
						if (isset($_GET['sort_workshop'])) $result=mysqli_query($link,"SELECT DISTINCT pl.`id_plot`, pl.`plot_name`, e.`id_worker`, e.`last_name`, e.`first_name`, e.`patronymic`, b.`id_brigade`, b.`brigade_name`, w.`id_workshop`, w.`workshop_name`,wr.`type_of_work`
												FROM `plots` pl
												LEFT JOIN `engineering_staff` e ON pl.`plot_manager`=e.`id_worker`
												LEFT JOIN `brigades` b ON pl.`id_brigade`=b.`id_brigade`
												LEFT JOIN `workshops` w ON pl.`id_workshop`=w.`id_workshop`
                                                LEFT JOIN `work` wr on pl.`id_plot`=wr.`id_plot` ORDER BY w.`workshop_name` ".$sort);
						
						
						$count=1;
						echo "<table class='table_price' ' border='1'> <caption>Участки</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Участок <a class='button2' href='plots.php?sort_plot={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Начальник участка <a class='button2' href='plots.php?sort_last={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Бригада <a class='button2'href='plots.php?sort_brigade={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Цех <a class='button2'href='plots.php?sort_workshop={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Вид работ на участке</th>
							<th></th>
							<th></th>
						</tr>";
						while($row=mysqli_fetch_array($result))
						{
							if ($row[2] == NULL) {$row[3]='';$row[4]='';$row[5]='';}
							if ($row[6] == NULL) $row[7]=''; 							
							echo "
							<tr>
								<td>{$count}</td>
								<td>{$row[1]}</td>
								<td><a href='../engineering_staff/engineering_info.php?id_info={$row[2]}'>{$row[3]} {$row[4]} {$row[5]}</a></td>
								<td><a href='../working_staff/brigade.php?id_info={$row[6]}'>{$row[7]}</a></td>
								<td><a href='../workshops/workshops.php?search=$row[9]&submit='>{$row[9]}</a></td>
								<td>{$row[10]}</td>
								<td><a class='button2' href='plots.php?id_change={$row[0]}'>Изменить <i style='color: blue;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
								<td><a class='button2' href='plots.php?id_delete={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить участок из списка?')".'"'.">Удалить <i style='color: red;'class='fa fa-times' aria-hidden='true'></i></a></td>
							</tr>";
							$count++;
						}
						echo "</table>";
						echo "<br><a class='button2' href='plots.php?new_plot'> Добавить новый участок &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>
							&nbsp;&nbsp; <a href='works.php' class='button2'> Управление видами работ&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
					}
					
					//ДОБАВЛЕНИЕ НОВОГО УЧАСТКА
					if (isset($_GET['new_plot']))
					{
						echo "<h2>ЗАПОЛНИТЕ ДАННЫЕ ДЛЯ НОВОГО УЧАСТКА</h2>
						
						<form action='plots.php' method='GET'>
							<input type='text' class='textedit' name='plot_name' placeholder='введите название название участка' required> <br><br>
							<select size='1' name='manager' class='select' required>
								<option  class='textedit' value=''>Выберите начальника участка</option>";
								$result=mysqli_query($link, "SELECT * FROM `engineering_staff`");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_worker']}'>{$row['last_name']} {$row['first_name']} {$row['patronymic']}</option>";
								}
								
						echo "</select><br><br>";
						
						echo"	<select size='1' name='brigade' class='select' required>
								<option  class='textedit' value=''>Выберите бригаду</option>";
								$result=mysqli_query($link, "SELECT * FROM `brigades`");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_brigade']}'>{$row['brigade_name']}</option>";
								}
								
						echo "</select><br><br>";
						
						echo"	<select size='1' name='workshop' class='select' required>
								<option  class='textedit' value=''>Выберите цех</option>";
								$result=mysqli_query($link, "SELECT * FROM `workshops`");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_workshop']}'>{$row['workshop_name']}</option>";
								}
								
						echo "</select><br><br>";
						//ВИД РАБОТ
						echo"	<select size='1' name='work' class='select' required>
								<option  class='textedit' value=''>Выберите вид работ</option>";
								$result=mysqli_query($link, "SELECT * FROM `type_of_work` WHERE 1");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['type_of_work']}'>{$row['type_of_work']}</option>";
								}
								
						echo "</select><br><br>";
							
							echo "<br>
							<a class='button2' href='plots.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a>  &nbsp;&nbsp;
							<button  class='button1' name='add_plot' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
						</form>";
						
					}
					
					if (isset($_GET['add_plot']))
					{
						
						mysqli_query($link,"INSERT INTO `plots`(`plot_name`, `plot_manager`, `id_brigade`, `id_workshop`) VALUES ('{$_GET['plot_name']}','{$_GET['manager']}','{$_GET['brigade']}','{$_GET['workshop']}')");
						
						$result = mysqli_query($link, "SELECT MAX(`id_plot`) FROM `plots`");
						$row = mysqli_fetch_array($result);
						$last_id=$row[0];
						echo $last_id;
						mysqli_query($link,"INSERT INTO `work`(`id_workshop`, `id_plot`, `id_product`, `type_of_work`) VALUES ({$_GET['workshop']},{$last_id},NULL,'{$_GET['work']}')");
						
						
					}
					
					//ИЗМЕНЕНИЕ УЧАСТКА
					
					if (isset($_GET['id_change']))
					{
						$result1=mysqli_query($link,"SELECT pl.`id_plot`, pl.`plot_name`, e.`id_worker`, e.`last_name`, e.`first_name`, e.`patronymic`, b.`id_brigade`, b.`brigade_name`, w.`id_workshop`, w.`workshop_name`,wr.`type_of_work`
												FROM `plots` pl
												LEFT JOIN `engineering_staff` e ON pl.`plot_manager`=e.`id_worker`
												LEFT JOIN `brigades` b ON pl.`id_brigade`=b.`id_brigade`
												LEFT JOIN `workshops` w ON pl.`id_workshop`=w.`id_workshop`
                                                LEFT JOIN `work` wr on pl.`id_plot`=wr.`id_plot`
												WHERE pl.`id_plot` = {$_GET['id_change']}");
						$row1=mysqli_fetch_array($result1);
						if($row1['id_brigade']=="") 
						{
							$brigade='Выберите бригаду';
						}
						else
						{
							$brigade=$row1['brigade_name'];
						}
						echo "<h2>ИЗМЕНИТЕ ДАННЫЕ УЧАСТКА</h2>
			
						<form action='plots.php' method='GET'>
							<input type='hidden' name='id' value='{$row1[0]}'>
							<input type='text' class='textedit' name='plot_name' value='{$row1['plot_name']}' placeholder='введите название название участка' required> <br><br>
							<select size='1' name='manager' class='select' required>
								<option  class='textedit' value='{$row1['id_worker']}'>{$row1[3]} {$row1[4]} {$row1[5]}</option>";
								$result=mysqli_query($link, "SELECT * FROM `engineering_staff`");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_worker']}'>{$row['last_name']} {$row['first_name']} {$row['patronymic']}</option>";
								}
								
						echo "</select><br><br>";
						
						echo"	<select size='1' name='brigade' class='select' required>
								<option  class='textedit' value='{$row1['id_brigade']}'>{$brigade}</option>";
								$result=mysqli_query($link, "SELECT * FROM `brigades`");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_brigade']}'>{$row['brigade_name']}</option>";
								}
								
						echo "</select><br><br>";
						
						echo"	<select size='1' name='workshop' class='select' required>
								<option  class='textedit' value='{$row1['id_workshop']}'>{$row1['workshop_name']}</option>";
								$result=mysqli_query($link, "SELECT * FROM `workshops`");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_workshop']}'>{$row['workshop_name']}</option>";
								}
								
						echo "</select><br><br>";
						
						//ВИД РАБОТ
						echo"	<select size='1' name='work' class='select' required>
								<option  class='textedit' value='{$row1['type_of_work']}'>{$row1['type_of_work']}</option>";
								$result=mysqli_query($link, "SELECT * FROM `type_of_work` WHERE 1");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['type_of_work']}'>{$row['type_of_work']}</option>";
								}
								
						echo "</select><br><br>";
							
							echo "<br>
							<a class='button2' href='plots.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a>  &nbsp;&nbsp;
							<button  class='button1' name='save_change' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить изменения</button>
						</form>";
						
					}
					
					if (isset($_GET['save_change']))
					{
						echo "Изменения успешно сохранены";
						echo "<br><br>
						<a class='button2' href='plots.php' class='button2'><i class='fa fa-list-alt' aria-hidden='true'></i>&nbsp;&nbsp; Список участковв</a>&nbsp;&nbsp;
						<a class='button2' href='plots.php?new_plot'> Добавить новый участок &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>
						&nbsp;&nbsp; <a href='works.php' class='button2'> Управление видами работ&nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
						
						mysqli_query($link,"UPDATE `plots` SET `plot_name`='{$_GET['plot_name']}', `plot_manager`='{$_GET['manager']}', `id_brigade`='{$_GET['brigade']}', `id_workshop`='{$_GET['workshop']}' WHERE `id_plot`={$_GET['id']}");
						
						mysqli_query($link,"UPDATE `work` SET `type_of_work`='{$_GET['work']}' WHERE `id_plot`={$_GET['id']}");
					}					
					?>
									
			</div>

			<div class="footer">&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>