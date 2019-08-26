<?php require "auth.php";?>
<html>
<?
	$link=mysqli_connect("localhost","cb33831_company","Muhammed4815162342","cb33831_company");
?>
	<head>
		<link rel='stylesheet' href='../../style/style.css' type='text/css'/>
		<link rel='stylesheet' href='../../style/css/font-awesome.min.css'>
		<script src="../../js/query-3.4.1.min.js"></script>
	</head>

	<body>
		<div class='container'>
			<div class='header'>АВТОМОБИЛЕСТРОИТЕЛЬНОЕ ПРЕДПРИЯТИЕ</div>

			<div class='sidebar'>
				<p><a class="left-menu" href="../index.php"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Главная</a></p>
				<p><a class="left-menu" href="../working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="../working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class='content'>
				
				<? 

				?>
				<h2>Заполните данные для нового сотрудника</h2>
				<form action='new_engineering_added.php'  method="post" name="form_id" onsubmit="javascript:return validate('form_id','email');" enctype="multipart/form-data">
				<div class='box'>
				<div class='frame'>
				
					<table class='table_info'>
						<tr>
							<td>Фамилия:</td>
							<td><input type='text' class='textedit' name='last_name' placeholder='введите фамилию' required><td>
						</tr> 
					
						<tr>
							<td>Имя:</td>
							<td><input type='text' class='textedit' name='first_name' placeholder='введите имя' required></td>
						</tr>
					
						<tr>
							<td>Отчество:</td> 
							<td><input type='text' class='textedit' name='patronymic' placeholder='введите отчество' required></td>
						</tr>
					
						<tr>
							<td>Должность:</td> 
							<td>
								<select size='1' name='position_select' class='select' required>
								<option  class='textedit' value=''>Выберите должность</option>
								<?
								$result=mysqli_query($link, "SELECT * FROM `engineering_position` WHERE `position` <> '-'");
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_position']}'>{$row['position']}</option>";
								}
								?>
								</select>
							</td>
						</tr>
					
						<tr>
							<td>Участок:</td>
							<td>
								<select size='1' name='plot_select' class='select'>
								<option class='textedit' value=''>Выберите участок</option>
								<?
								$result=mysqli_query($link, 'SELECT * FROM `plots`');
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_plot']}'>{$row['plot_name']}</option>";
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Цех:</td>
							<td>
								<select size='1' name='workshop_select' class='select'>
								<option class='textedit' value=''>Выберите цех</option>
								<?
								$result=mysqli_query($link, 'SELECT * FROM `workshops`');
								while($row=mysqli_fetch_array($result))
								{
									echo "<option class='textedit' value='{$row['id_workshop']}'>{$row['workshop_name']}</option>";
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
					</table>

				
				
				
				</div>				
				
				<div class='frame'>
				<table class='table_info'>
					
						<tr>
							<td>Телефон:</td>
							<td><input type='text' class='textedit' name='phone' placeholder='введите номер телефона' required><td>
						</tr> 					
						<tr>
							<td>E-mail:</td>
							<td><input type='text' id="email" class='textedit' name='email' placeholder='example@mail.ru' required><td>
						</tr> 					
						<tr>
							<td>Дата рождения:</td>
							<td><input class='textedit' type='date' id='date' name='dob' required><td>
						</tr> 					
						<tr>
							<td>Адрес:</td>
							<td><input type='text' class='textedit' name='address' placeholder='введите адрес' required><td>
						</tr>
						<tr>
							<td>Фотография:</td>
							<td><div><input required class='textedit' type="file" id="g5" name="img0" onchange="imgVal(this,10485760);"/> <br><output id="outImg0"></output></div><td>
						</tr>						
				</table>
				</div>
				</div>
					<br><a class='button2' href='engineering_staff.php'><i class='fa fa-arrow-left' aria-hidden='true'></i>&nbsp;&nbsp;вернуться назад </a>&nbsp;&nbsp;
						 <button  class='button1' name='submit' value='true'><i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;&nbsp;сохранить</button>
				</form>

				</div>

			<div class='footer'>&copy; Автомобилестроительное предприятие</div>

		</div>
	</body>

<script type="application/javascript">
 <!--
function imgVal(el,lim)
{
    var doc=el.parentNode.lastChild;
    if(el.files[0].size<=lim)
    {
        var file=new FileReader();
        file.onloadend=function(e)
        {
            var arr=(new Uint8Array(e.target.result)).subarray(0,4);
            for(var i=0,l=arr.length,header='';i<l;i++)
                header+=arr[i].toString(16);
            var type=false;
            switch(header){case'89504e47':type='PNG';break;case'47494638':type='GIF';break;case'ffd8ffe0':case'ffd8ffe1':case'ffd8ffe2':type='JPG';break;}
            if (type)
            {
                doc.setAttribute('class','good');
                doc.innerHTML=Math.round(el.files[0].size/1024)+'kB'+' '+type;
            }
            else
            {
                el.value=null;
                doc.setAttribute('class','bad');
                doc.value='Изображение должно быть в формате JPG или PNG';
            }
        };
        file.readAsArrayBuffer(el.files[0]);
    }
    else
    {
        el.value=null;
        doc.setAttribute('class','bad');
        doc.value='Файл не должен привышать 10 MB';
    }
}

function validate(form_id,email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = document.forms[form_id].elements[email].value;
   if(reg.test(address) == false) {
      alert('Введите корректный e-mail');
      return false;
   }
}
 //-->
 </script>

</html>