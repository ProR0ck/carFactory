<?php require "auth.php";?>

<?php $link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");?>
<html>
	<head>
		<link rel="stylesheet" href="../style/style.css" type="text/css"/>
		<link rel="stylesheet" href="../style/css/font-awesome.min.css">
	</head>

	<body>
		<div class="container">
			<div class="header">АВТОМОБИЛЕСТРОИТЕЛЬНОЕ ПРЕДПРИЯТИЕ</div>

			<div class="sidebar">
				<p><a class="left-menu" href="index.php"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Главная</a></p>
				<p><a class="left-menu" href="working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="engineering_staff/engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class="content">
	
				<h2>СТРУКТУРА ПРЕДПРИЯТИЯ</h2>
				
				<?
				$result1=mysqli_query($link,"SELECT DISTINCT w.`id_workshop`, w.`workshop_name`, e.`id_worker`, e.`last_name`, e.`first_name`, e.`patronymic` FROM `workshops` w
LEFT JOIN `engineering_staff` e ON w.`workshop_manager`=e.`id_worker`");
				while($workshop=mysqli_fetch_array($result1))
				{
					echo "<div class='workshop'>{$workshop[1]}<br>Начальник цеха:<a href='engineering_staff/engineering_info.php?id_info={$workshop[2]}'>{$workshop[3]} {$workshop[4]} {$workshop[5]}</a><br>";
					$result2=mysqli_query($link,"SELECT DISTINCT pl.`id_plot`, pl.`plot_name`, e.`id_worker`, e.`last_name`, e.`first_name`, e.`patronymic`,wr.`type_of_work` FROM `plots` pl
												LEFT JOIN `engineering_staff` e ON pl.`plot_manager`= e.`id_worker`
												LEFT JOIN `work` wr on pl.`id_plot`=wr.`id_plot`
												WHERE pl.`id_workshop` = {$workshop[0]}");
					while ($plot=mysqli_fetch_array($result2))
					{
						echo "<div class='plot'><b>{$plot[1]}</b><br>Вид работ: {$plot[6]} <br>Начальник участка:<br><b><a href='engineering_staff/engineering_info.php?id_info={$plot[2]}'> {$plot[3]} {$plot[4]} {$plot[5]}</a></b><br>";
						$result3=mysqli_query($link,"SELECT DISTINCT b.`id_brigade`,b.`brigade_name`, w.`id_worker`, w.`last_name`, w.`first_name`, w.`patronymic` FROM `brigades` b
						LEFT JOIN `working_staff` w ON b.`brigadier`=w.`id_worker` 
						LEFT JOIN `plots` p ON  b.`id_brigade`=p.`id_brigade`
                        WHERE p.`id_plot`={$plot[0]}");
						while($brigade=mysqli_fetch_array($result3))
						{
							echo "<div class='brigade'><a href='working_staff/brigade.php?id_info={$brigade[0]}'>{$brigade[1]}</a><br>Бригадир: <a href='working_staff/worker_info.php?id_info={$brigade[2]}'>{$brigade[3]} {$brigade[4]} {$brigade[5]}</a></div>";
						}
						echo "</div>";
					}
					echo "</div>";
				}
					
				?>
				
							
	
				</div>

			<div class="footer">&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>