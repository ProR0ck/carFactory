<?php require "auth.php";?>
<?php 
$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
if (isset($_GET['id_delete_car']) || isset ($_GET['add_car']) || isset($_GET['change_car']) || isset($_GET['change_car_complete']) || isset($_GET['add_bus']) || isset($_GET['change_bus_complete']) || isset($_GET['id_delete_bus']))
	{ 
		mysqli_query($link,"DELETE FROM `products` WHERE `id_product`={$_GET['id_delete_car']}");
		mysqli_query($link,"DELETE FROM `cars` WHERE `id_product`={$_GET['id_delete_car']}");
		mysqli_query($link,"DELETE FROM `work` WHERE `id_product`={$_GET['id_delete_car']}");
		
		mysqli_query($link,"DELETE FROM `products` WHERE `id_product`={$_GET['id_delete_bus']}");
		mysqli_query($link,"DELETE FROM `buses` WHERE `id_product`={$_GET['id_delete_bus']}");
		mysqli_query($link,"DELETE FROM `work` WHERE `id_product`={$_GET['id_delete_bus']}");
		header("Location: products.php");	
	}
?>
<html>
<?
	$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");

?>
	<head>
		<link rel="stylesheet" href="../../style/style.css" type="text/css"/>
		<link rel="stylesheet" href="../../style/css/font-awesome.min.css">
<style type="text/css">
.tabs { width: 100%; padding: 0px; margin: 0 auto; }
.tabs>input { display:none; }
.tabs>div {
    display: none;
    padding: 12px;
    border: 1px solid #C0C0C0;
    background: #FFFFFF;
}
.tabs>label {
    display: inline-block;
    padding: 7px;
    margin: 0 -5px -1px 0;
    text-align: center;
    color: #666666;
    border: 1px solid #C0C0C0;
    background: #E0E0E0;
    cursor: pointer;
}
.tabs>input:checked + label {
    color: #000000;
    border: 1px solid #C0C0C0;
    border-bottom: 1px solid #FFFFFF;
    background: #FFFFFF;
}
#tab_1:checked ~ #txt_1,
#tab_2:checked ~ #txt_2,
#tab_3:checked ~ #txt_3,
#tab_4:checked ~ #txt_4 { display: block; }
</style>
	</head>

	<body>
		<div class="container">
			<div class="header">АВТОМОБИЛЕСТРОИТЕЛЬНОЕ ПРЕДПРИЯТИЕ</div>
			
			<div class="sidebar">
				<p><a class="left-menu" href="../index.php"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Главная</a></p>
				<p><a class="left-menu" href="products.php">Выпускаемые изделия</a></p>
				<p><a class="left-menu" href="../workshops/workshops.php">Цеха</a></p>
				<p><a class="left-menu" href="../plots/plots.php">Участки</a></p>
				<p><a class="left-menu" href="../working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="../working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="../engineering_staff/engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>
	
	
			<div class="content">
<h2>ВЫПУСКАЕМЫЕ ИЗДЕЛИЯ</h2>			
			<div class="tabs">
	<input type="radio" name="inset" value="" id="tab_1" checked>
    <label for="tab_1">Легковые автомобили</label>

    <input type="radio" name="inset" value="" id="tab_2" <?if (isset($_GET['sort_mark_bus']) || isset($_GET['sort_model_bus']) || isset($_GET['sort_engine_bus']) || isset($_GET['sort_weight_bus']) || isset($_GET['sort_color_bus']) || isset($_GET['sort_content_bus']) || isset($_GET['new_bus']) || isset($_GET['add_bus']) || isset($_GET['id_change_bus']) || isset($_GET['id_delete_bus'])) echo "checked"; ?>>
    <label for="tab_2">Автобусы</label>

    <input type="radio" name="inset" value="" id="tab_3">
    <label for="tab_3">Грузовые машины</label>

    <input type="radio" name="inset" value="" id="tab_4">
    <label for="tab_4">Мотоциклы</label>

    <div id="txt_1">
	<?
	
	//Легковые машины до сортировки
	if (!isset($_GET['new_car']) && !isset($_GET['id_change_car']) && !isset($_GET['sort_mark']) && !isset($_GET['sort_model']) && !isset($_GET['sort_engine']) && !isset($_GET['sort_weight']) && !isset($_GET['sort_color']) && !isset($_GET['sort_body'])){
	echo "<table class='table_price' border='1' border='1'> <caption>ЛЕГКОВЫЕ АВТОМОБИЛИ</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Марка <a class='button2' href='products.php?sort_mark=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Модель <a class='button2' href='products.php?sort_model=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Объем двигателя <a class='button2'href='products.php?sort_engine=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Вес <a class='button2'href='products.php?sort_weight=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Цвет <a class='button2'href='products.php?sort_color=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Кузов <a class='button2'href='products.php?sort_body=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Участок</th>
							<th>Вид работ</th>
							<th></th>
							<th></th>";
	
	$result = mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`body`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `cars` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot`");
	
	$count=1;
	
	while ($row=mysqli_fetch_array($result))
	{
		echo "
		<tr>
		<td>{$count}</td>
		<td>{$row[1]}</td>
		<td>{$row[2]}</td>
		<td>{$row[3]}</td>
		<td>{$row[4]}</td>
		<td>{$row[5]}</td>
		<td>{$row[6]}</td>
		<td><a href='../plots/plots.php?search={$row[8]}&submit='>{$row[8]}</td>
		<td>{$row[9]}</td>
		<td><a class='button2' href='products.php?id_change_car={$row[0]}'><i style='color: white;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
		<td><a class='button2' href='products.php?id_delete_car={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить автомобиль из списка?')".'"'."><i style='color: white;'class='fa fa-times' aria-hidden='true'></i></a></td>
		</tr>
		";
		$count++;
	}
	echo "</table>";
	echo "<br><a class='button2' href='products.php?new_car'> Добавить новый автомобиль &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
	}
	//ЛЕГКОВЫЕ МАШИНЫ ПОСЛЕ СОРТИРОВКИ
	
	if (isset($_GET['sort_mark']) || isset($_GET['sort_model']) || isset($_GET['sort_engine']) || isset($_GET['sort_weight']) || isset($_GET['sort_color']) || isset($_GET['sort_body']))
	{
		$asc="ASC"; $desc="DESC"; $sort=$asc;
		if ((($_GET['sort_mark'])=='0') || (($_GET['sort_model'])=='0') || (($_GET['sort_engine'])=='0') || (($_GET['sort_weight'])=='0') || (($_GET['sort_color'])=='0') || (($_GET['sort_body'])=='0')) 
			{
				$sort=$asc; $flag=1;
			} 
		else
			{
				$sort=$desc; $flag=0;
			}
		if (isset($_GET['sort_mark'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`body`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `cars` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`mark` ".$sort);
		if (isset($_GET['sort_model'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`body`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `cars` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`model` ".$sort);
		if (isset($_GET['sort_engine'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`body`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `cars` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`engine_capacity` ".$sort);
		if (isset($_GET['sort_color'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`body`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `cars` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`color` ".$sort);
		if (isset($_GET['sort_body'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`body`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `cars` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`body` ".$sort);
		if (isset($_GET['sort_weight'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`body`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `cars` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`weight` ".$sort);
	echo "<table class='table_price' border='1' border='1'> <caption>ЛЕГКОВЫЕ АВТОМОБИЛИ</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Марка <a class='button2' href='products.php?sort_mark={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Модель <a class='button2' href='products.php?sort_model={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Объем двигателя <a class='button2'href='products.php?sort_engine={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Вес <a class='button2'href='products.php?sort_weight={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Цвет <a class='button2'href='products.php?sort_color={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Кузов <a class='button2'href='products.php?sort_body={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Участок</th>
							<th>Вид работ</th>
							<th></th>
							<th></th>";		
	$count=1;
	
	while ($row=mysqli_fetch_array($result))
	{
		echo "
		<tr>
		<td>{$count}</td>
		<td>{$row[1]}</td>
		<td>{$row[2]}</td>
		<td>{$row[3]}</td>
		<td>{$row[4]}</td>
		<td>{$row[5]}</td>
		<td>{$row[6]}</td>
		<td><a href='../plots/plots.php?search={$row[8]}&submit='>{$row[8]}</td>
		<td>{$row[9]}</td>
		<td><a class='button2' href='products.php?id_change_car={$row[0]}'><i style='color: white;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
		<td><a class='button2' href='products.php?id_delete_car={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить автомобиль из списка?')".'"'."><i style='color: white;'class='fa fa-times' aria-hidden='true'></i></a></td>
		</tr>
		";
		$count++;
	}
	echo "</table>";
	echo "<br><a class='button2' href='products.php?new_car'>Добавить новый автомобиль &nbsp;&nbsp;<i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
		
		
	}
	
	//ДОБАВЛЕНИЕ НОВОГО АВТО
	if (isset($_GET['new_car'])){
		echo "<h2>ДОБАВЛЕНИЕ НОВОГО АВТОМОБИЛЯ</h2>";

		echo"<form action='products.php' method='GET'>
		<select size='1' name='car_mark' class='select' requiwhite>
				<option  class='textedit' value=''>Выберите марку авто</option>";
				$result=mysqli_query($link, "SELECT * FROM `car_mark` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo"
		<select size='1' name='car_model' class='select' requiwhite>
				<option  class='textedit' value=''>Выберите модель</option>";
				$result=mysqli_query($link, "SELECT * FROM `car_model` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo "Укажите объем двигателя <br> <br><input type='text' name='car_engine_capacity' class='textedit' placeholder='объем двигателя'><br> <br>";
		echo "Укажите вес автомобиля <br> <br><input type='text' name='car_weight' class='textedit' placeholder='вес'><br> <br>";

		echo"
		<select size='1' name='car_color' class='select' requiwhite>
				<option  class='textedit' value=''>Выберите цвет</option>";
				$result=mysqli_query($link, "SELECT * FROM `colors` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo"
		<select size='1' name='car_body' class='select' requiwhite>
				<option  class='textedit' value=''>Выберите тип кузова</option>";
				$result=mysqli_query($link, "SELECT * FROM `car_body` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}	
		echo "</select><br><br>";
		//ЦЕХ и УЧАСТОК
		echo"
		<select size='1' name='plot' class='select' requiwhite>
				<option  class='textedit' value=''>Выберите цех и участок</option>";
				$result=mysqli_query($link, "SELECT DISTINCT w.`id_plot`, ws.`workshop_name`, p.`plot_name`, w.`type_of_work` FROM `work` w
LEFT JOIN `plots` p ON w.`id_plot`=p.`id_plot`
LEFT JOIN `workshops` ws ON ws.`id_workshop`=w.`id_workshop`");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[1]}, {$row[2]} - {$row[3]}</option>";
						}	
		echo "</select><br><br>";
		echo "<br>
				<a class='button2' href='products.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a>  &nbsp;&nbsp;
				<button  class='button1' name='add_car' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
		</form>";
	}

	if (isset($_GET['add_car']))
	{
		mysqli_query($link,"INSERT INTO `products` (`id_product`, `date`) VALUES (NULL,NOW())");
		$result = mysqli_query($link, "SELECT MAX(`id_product`) FROM `products`");
		$row = mysqli_fetch_array($result);
		$last_id=$row[0];
		mysqli_query($link,"INSERT INTO `cars` (`id_product`, `mark`, `model`, `engine_capacity`, `weight`, `color`, `body`) 
			VALUES ('{$last_id}', '{$_GET['car_mark']}', '{$_GET['car_model']}', '{$_GET['car_engine_capacity']}', '{$_GET['car_weight']}', '{$_GET['car_color']}', '{$_GET['car_body']}')");
		
		$result=mysqli_query($link,"SELECT `id_workshop` FROM `plots` WHERE `id_plot`='{$_GET['plot']}'");
		$workshop=mysqli_fetch_array($result);
		
		$result=mysqli_query($link,"SELECT `type_of_work` FROM `work` WHERE `id_plot`='{$_GET['plot']}'");
		$type_of_work=mysqli_fetch_array($result);
		
		mysqli_query($link,"INSERT INTO `work` (`id_workshop`, `id_plot`, `id_product`, `type_of_work`) VALUES ('{$workshop[0]}', '{$_GET['plot']}', '{$last_id}', '{$type_of_work[0]}')");
	}
	
	
		//ИЗМЕНЕНИЕ МАШИН
	if (isset($_GET['id_change_car']))
	{
		echo "<h2>ИЗМЕНЕНИЕ ДАННЫХ АВТОМОБИЛЯ</h2>";
		$result=mysqli_query($link,"SELECT * FROM `cars` WHERE `id_product` = {$_GET['id_change_car']}");
		$old=mysqli_fetch_array($result);
		
		echo"<form action='products.php' method='GET'>
		<select size='1' name='car_mark' class='select' requiwhite>
				<option  class='textedit' value='{$old[1]}'>{$old[1]}</option>";
				$result=mysqli_query($link, "SELECT * FROM `car_mark` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo"
		<select size='1' name='car_model' class='select' requiwhite>
				<option  class='textedit' value='{$old[2]}'>{$old[2]}</option>";
				$result=mysqli_query($link, "SELECT * FROM `car_model` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo "Укажите объем двигателя <br> <br><input type='text' name='car_engine_capacity' class='textedit' placeholder='объем двигателя' value='{$old[3]}'><br> <br>";
		echo "Укажите вес автомобиля <br> <br><input type='text' name='car_weight' class='textedit' placeholder='вес' value='{$old[4]}'><br> <br>";

		echo"
		<select size='1' name='car_color' class='select' requiwhite>
				<option  class='textedit' value='{$old[5]}'>{$old[5]}</option>";
				$result=mysqli_query($link, "SELECT * FROM `colors` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo"
		<select size='1' name='car_body' class='select' requiwhite>
				<option  class='textedit' value='{$old[6]}'>{$old[6]}</option>";
				$result=mysqli_query($link, "SELECT * FROM `car_body` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}	
		echo "</select><br><br>";
		//ЦЕХ и УЧАСТОК
		$result=mysqli_query($link, "SELECT DISTINCT w.`id_plot`, ws.`workshop_name`, p.`plot_name`, w.`type_of_work` FROM `work` w
									 LEFT JOIN `plots` p ON w.`id_plot`=p.`id_plot`
									 LEFT JOIN `workshops` ws ON ws.`id_workshop`=w.`id_workshop` 
                                     where w.`id_product`= '{$_GET['id_change_car']}'");
		$old_worksop_plot=mysqli_fetch_array($result);
		echo"
		<select size='1' name='plot' class='select' requiwhite>
				<option  class='textedit' value='{$old_worksop_plot[0]}'>{$old_worksop_plot[1]}, {$old_worksop_plot[2]} - {$old_worksop_plot[3]}";
				$result=mysqli_query($link, "SELECT DISTINCT w.`id_plot`, ws.`workshop_name`, p.`plot_name`, w.`type_of_work` FROM `work` w
LEFT JOIN `plots` p ON w.`id_plot`=p.`id_plot`
LEFT JOIN `workshops` ws ON ws.`id_workshop`=w.`id_workshop`");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[1]}, {$row[2]} - {$row[3]}</option>";
						}	
		echo "</select><br><br>";
		
		echo "<br>
				<a class='button2' href='products.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a>  &nbsp;&nbsp;
				<button  class='button1' name='change_car_complete' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
				<input type='hidden' name='id' value='{$_GET['id_change_car']}'>
		</form>";
	}
	
	if (isset($_GET['change_car_complete']))
	{
		mysqli_query($link,"UPDATE `cars` SET `mark`='{$_GET['car_mark']}',`model`='{$_GET['car_model']}',`engine_capacity`='{$_GET['car_engine_capacity']}',`weight`='{$_GET['car_weight']}',`color`='{$_GET['car_color']}',`body`='{$_GET['car_body']}' WHERE `id_product`='{$_GET['id']}'");
		
		$result=mysqli_query($link,"SELECT `id_workshop` FROM `plots` WHERE `id_plot`='{$_GET['plot']}'");
		$workshop=mysqli_fetch_array($result);
		
		$result=mysqli_query($link,"SELECT `type_of_work` FROM `work` WHERE `id_plot`='{$_GET['plot']}'");
		$type_of_work=mysqli_fetch_array($result);
		
		mysqli_query($link, "UPDATE `work` SET `id_workshop`='{$workshop[0]}',`id_plot`='{$_GET['plot']}',`type_of_work`='{$type_of_work[0]}' WHERE `id_product`='{$_GET['id']}'");
		
		
	}
	
	
	?>
    </div>
   
   
   
   
   <div id="txt_2">
		<?
	
	//АВТОБУСЫ ДО СОРТИРОВКИ
	if (!isset($_GET['new_bus']) && !isset($_GET['id_change_bus']) && !isset($_GET['sort_mark_bus']) && !isset($_GET['sort_model_bus']) && !isset($_GET['sort_engine_bus']) && !isset($_GET['sort_weight_bus']) && !isset($_GET['sort_color_bus']) && !isset($_GET['sort_content_bus'])){
	echo "<table class='table_price' border='1' border='1'> <caption>АВТОБУСЫ</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Марка <a class='button2' href='products.php?sort_mark_bus=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Модель <a class='button2' href='products.php?sort_model_bus=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Объем двигателя <a class='button2'href='products.php?sort_engine_bus=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Вес <a class='button2'href='products.php?sort_weight_bus=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Цвет <a class='button2'href='products.php?sort_color_bus=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Вместимость <a class='button2'href='products.php?sort_content_bus=0'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Участок</th>
							<th>Вид работ</th>
							<th></th>
							<th></th>";
	
	$result = mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`content`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `buses` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot`");
	
	$count=1;
	
	while ($row=mysqli_fetch_array($result))
	{
		echo "
		<tr>
		<td>{$count}</td>
		<td>{$row[1]}</td>
		<td>{$row[2]}</td>
		<td>{$row[3]}</td>
		<td>{$row[4]}</td>
		<td>{$row[5]}</td>
		<td>{$row[6]}</td>
		<td><a href='../plots/plots.php?search={$row[8]}&submit='>{$row[8]}</td>
		<td>{$row[9]}</td>
		<td><a class='button2' href='products.php?id_change_bus={$row[0]}'><i style='color: white;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
		<td><a class='button2' href='products.php?id_delete_bus={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить автобус из списка?')".'"'."><i style='color: white;'class='fa fa-times' aria-hidden='true'></i></a></td>
		</tr>
		";
		$count++;
	}
	echo "</table>";
	echo "<br><a class='button2' href='products.php?new_bus'> Добавить новый автобус &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
	}
	//АВТОБУСЫ ПОСЛЕ СОРТИРОВКИ
	
	if (isset($_GET['sort_mark_bus']) || isset($_GET['sort_model_bus']) || isset($_GET['sort_engine_bus']) || isset($_GET['sort_weight_bus']) || isset($_GET['sort_color_bus']) || isset($_GET['sort_content_bus']))
	{
		$asc="ASC"; $desc="DESC"; $sort=$asc;
		if ((($_GET['sort_mark_bus'])=='0') || (($_GET['sort_model_bus'])=='0') || (($_GET['sort_engine_bus'])=='0') || (($_GET['sort_weight_bus'])=='0') || (($_GET['sort_color_bus'])=='0') || (($_GET['sort_content_bus'])=='0')) 
			{
				$sort=$asc; $flag=1;
			} 
		else
			{
				$sort=$desc; $flag=0;
			}
		if (isset($_GET['sort_mark_bus'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`content`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `buses` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`mark` ".$sort);
		if (isset($_GET['sort_model_bus'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`content`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `buses` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`model` ".$sort);
		if (isset($_GET['sort_engine_bus'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`content`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `buses` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`engine_capacity` ".$sort);
		if (isset($_GET['sort_color_bus'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`content`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `buses` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`color` ".$sort);
		if (isset($_GET['sort_content_bus'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`content`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `buses` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`content` ".$sort);
		if (isset($_GET['sort_weight_bus'])) $result=mysqli_query($link,"SELECT C.`id_product`, C.`mark`, C.`model`, C.`engine_capacity`, C.`weight`, C.`color`, C.`content`, P.`id_plot`, P.`plot_name`, W.`type_of_work` FROM `buses` C
									LEFT JOIN `work` W ON C.`id_product` = W.`id_product`
								LEFT JOIN `plots` P ON W.`id_plot`=P.`id_plot` ORDER BY C.`weight` ".$sort);
	echo "<table class='table_price' border='1' border='1'> <caption>АВТОБУСЫ</caption>";
						echo "
						<tr>
							<th>№</th>
							<th>Марка <a class='button2' href='products.php?sort_mark_bus={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Модель <a class='button2' href='products.php?sort_model_bus={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Объем двигателя <a class='button2'href='products.php?sort_engine_bus={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Вес <a class='button2'href='products.php?sort_weight_bus={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Цвет <a class='button2'href='products.php?sort_color_bus={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Вместимость <a class='button2'href='products.php?sort_content_bus={$flag}'><i class='fa fa-sort' aria-hidden='true'></i></a></th>
							<th>Участок</th>
							<th>Вид работ</th>
							<th></th>
							<th></th>";		
	$count=1;
	
	while ($row=mysqli_fetch_array($result))
	{
		echo "
		<tr>
		<td>{$count}</td>
		<td>{$row[1]}</td>
		<td>{$row[2]}</td>
		<td>{$row[3]}</td>
		<td>{$row[4]}</td>
		<td>{$row[5]}</td>
		<td>{$row[6]}</td>
		<td><a href='../plots/plots.php?search={$row[8]}&submit='>{$row[8]}</td>
		<td>{$row[9]}</td>
		<td><a class='button2' href='products.php?id_change_bus={$row[0]}'><i style='color: white;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
		<td><a class='button2' href='products.php?id_delete_bus={$row[0]}' onclick=".'"'."return confirm('Вы точно хотите удалить автобус из списка?')".'"'."><i style='color: white;'class='fa fa-times' aria-hidden='true'></i></a></td>
		</tr>
		";
		$count++;
	}
	echo "</table>";
	echo "<br><a class='button2' href='products.php?new_bus'> Добавить новый автобус &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>";
		
		
	}
	
	//ДОБАВЛЕНИЕ НОВОГО АВТОБУСА
	if (isset($_GET['new_bus'])){
		echo "<h2>ДОБАВЛЕНИЕ НОВОГО АВТОБУСА</h2>";

		echo"<form action='products.php' method='GET'>
		<select size='1' name='bus_mark' class='select' requiwhite>
				<option  class='textedit' value=''>Выберите марку автобуса</option>";
				$result=mysqli_query($link, "SELECT * FROM `bus_mark` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo"
		<select size='1' name='bus_model' class='select' requiwhite>
				<option  class='textedit' value=''>Выберите модель автобуса</option>";
				$result=mysqli_query($link, "SELECT * FROM `bus_model` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo "Укажите объем двигателя <br> <br><input type='text' name='bus_engine_capacity' class='textedit' placeholder='объем двигателя'><br> <br>";
		echo "Укажите вес автобуса <br> <br><input type='text' name='bus_weight' class='textedit' placeholder='вес'><br> <br>";

		echo"
		<select size='1' name='bus_color' class='select' requiwhite>
				<option  class='textedit' value=''>Выберите цвет</option>";
				$result=mysqli_query($link, "SELECT * FROM `colors` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo "Укажите вместимость <br><br><input type='text' name='bus_content' class='textedit' placeholder='вместимость' requiwhite> <br><br>";
		//ЦЕХ и УЧАСТОК
		echo"
		<select size='1' name='plot' class='select' requiwhite>
				<option  class='textedit' value=''>Выберите цех и участок</option>";
				$result=mysqli_query($link, "SELECT DISTINCT w.`id_plot`, ws.`workshop_name`, p.`plot_name`, w.`type_of_work` FROM `work` w
											LEFT JOIN `plots` p ON w.`id_plot`=p.`id_plot`
											LEFT JOIN `workshops` ws ON ws.`id_workshop`=w.`id_workshop`");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[1]}, {$row[2]} - {$row[3]}</option>";
						}	
		echo "</select><br><br>";
		echo "<br>
				<a class='button2' href='products.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a>  &nbsp;&nbsp;
				<button  class='button1' name='add_bus' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
		</form>";
	}

	if (isset($_GET['add_bus']))
	{
		mysqli_query($link,"INSERT INTO `products` (`id_product`, `date`) VALUES (NULL,NOW())");
		$result = mysqli_query($link, "SELECT MAX(`id_product`) FROM `products`");
		$row = mysqli_fetch_array($result);
		$last_id=$row[0];
		mysqli_query($link,"INSERT INTO `buses` (`id_product`, `mark`, `model`, `engine_capacity`, `weight`, `color`, `content`) 
			VALUES ('{$last_id}', '{$_GET['bus_mark']}', '{$_GET['bus_model']}', '{$_GET['bus_engine_capacity']}', '{$_GET['bus_weight']}', '{$_GET['bus_color']}', '{$_GET['bus_content']}')");
		
		$result=mysqli_query($link,"SELECT `id_workshop` FROM `plots` WHERE `id_plot`='{$_GET['plot']}'");
		$workshop=mysqli_fetch_array($result);
		
		$result=mysqli_query($link,"SELECT `type_of_work` FROM `work` WHERE `id_plot`='{$_GET['plot']}'");
		$type_of_work=mysqli_fetch_array($result);
		
		mysqli_query($link,"INSERT INTO `work` (`id_workshop`, `id_plot`, `id_product`, `type_of_work`) VALUES ('{$workshop[0]}', '{$_GET['plot']}', '{$last_id}', '{$type_of_work[0]}')");
	}
	
	
		//ИЗМЕНЕНИЕ АВТОБУСА
	if (isset($_GET['id_change_bus']))
	{
		echo "<h2>ИЗМЕНЕНИЕ ДАННЫХ АВТОБУСА</h2>";
		$result=mysqli_query($link,"SELECT * FROM `buses` WHERE `id_product` = {$_GET['id_change_bus']}");
		$old=mysqli_fetch_array($result);
		
		echo"<form action='products.php' method='GET'>
		<select size='1' name='bus_mark' class='select' requiwhite>
				<option  class='textedit' value='{$old[1]}'>{$old[1]}</option>";
				$result=mysqli_query($link, "SELECT * FROM `bus_mark` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo"
		<select size='1' name='bus_model' class='select' requiwhite>
				<option  class='textedit' value='{$old[2]}'>{$old[2]}</option>";
				$result=mysqli_query($link, "SELECT * FROM `bus_model` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo "Укажите объем двигателя <br> <br><input type='text' name='bus_engine_capacity' class='textedit' placeholder='объем двигателя' value='{$old[3]}'><br> <br>";
		echo "Укажите вес автобуса <br> <br><input type='text' name='bus_weight' class='textedit' placeholder='вес' value='{$old[4]}'><br> <br>";

		echo"
		<select size='1' name='bus_color' class='select' requiwhite>
				<option  class='textedit' value='{$old[5]}'>{$old[5]}</option>";
				$result=mysqli_query($link, "SELECT * FROM `colors` WHERE 1");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[0]}</option>";
						}
								
		echo "</select><br><br>";
		echo "Укажите вместимость <br><br><input type='text' name='bus_content' value='{$old[6]}'class='textedit' placeholder='вместимость' requiwhite> <br><br>";	
		//ЦЕХ и УЧАСТОК
		$result=mysqli_query($link, "SELECT DISTINCT w.`id_plot`, ws.`workshop_name`, p.`plot_name`, w.`type_of_work` FROM `work` w
									 LEFT JOIN `plots` p ON w.`id_plot`=p.`id_plot`
									 LEFT JOIN `workshops` ws ON ws.`id_workshop`=w.`id_workshop` 
                                     where w.`id_product`= '{$_GET['id_change_bus']}'");
		$old_worksop_plot=mysqli_fetch_array($result);
		echo"
		<select size='1' name='plot' class='select' requiwhite>
				<option  class='textedit' value='{$old_worksop_plot[0]}'>{$old_worksop_plot[1]}, {$old_worksop_plot[2]} - {$old_worksop_plot[3]}";
				$result=mysqli_query($link, "SELECT DISTINCT w.`id_plot`, ws.`workshop_name`, p.`plot_name`, w.`type_of_work` FROM `work` w
LEFT JOIN `plots` p ON w.`id_plot`=p.`id_plot`
LEFT JOIN `workshops` ws ON ws.`id_workshop`=w.`id_workshop`");
					while($row=mysqli_fetch_array($result))
						{
							echo "<option class='textedit' value='{$row[0]}'>{$row[1]}, {$row[2]} - {$row[3]}</option>";
						}	
		echo "</select><br><br>";
		
		echo "<br>
				<a class='button2' href='products.php'> <i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;Вернуться назад </a>  &nbsp;&nbsp;
				<button  class='button1' name='change_bus_complete' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
				<input type='hidden' name='id' value='{$_GET['id_change_bus']}'>
		</form>";
	}
	
	if (isset($_GET['change_bus_complete']))
	{
		mysqli_query($link,"UPDATE `buses` SET `mark`='{$_GET['bus_mark']}',`model`='{$_GET['bus_model']}',`engine_capacity`='{$_GET['bus_engine_capacity']}',`weight`='{$_GET['bus_weight']}',`color`='{$_GET['bus_color']}',`content`='{$_GET['bus_content']}' WHERE `id_product`='{$_GET['id']}'");
		
		$result=mysqli_query($link,"SELECT `id_workshop` FROM `plots` WHERE `id_plot`='{$_GET['plot']}'");
		$workshop=mysqli_fetch_array($result);
		
		$result=mysqli_query($link,"SELECT `type_of_work` FROM `work` WHERE `id_plot`='{$_GET['plot']}'");
		$type_of_work=mysqli_fetch_array($result);
		
		mysqli_query($link, "UPDATE `work` SET `id_workshop`='{$workshop[0]}',`id_plot`='{$_GET['plot']}',`type_of_work`='{$type_of_work[0]}' WHERE `id_product`='{$_GET['id']}'");
		
		
	}
	
	
	?>
    </div>
    <div id="txt_3">
        <p>Размеры содержимого вкладок</p>
        <p>могут отличаться по высоте!</p>
    </div>
    <div id="txt_4">
        <img src="image/logo.png" width="533" height="77" alt="Лого">
    </div>
</div>
					
			</div>

			<div class="footer">&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>
</html>