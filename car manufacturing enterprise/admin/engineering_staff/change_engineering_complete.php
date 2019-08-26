<?php require "auth.php";?>
<?php //if (isset($_POST['submit']))header("Location: change_engineering_complete.php");?>
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
				<p><a class="left-menu" href="../products/products.php">Выпускаемые изделия</a></p>
				<p><a class="left-menu" href="../workshops/workshops.php">Цеха</a></p>
				<p><a class="left-menu" href="../plots/plots.php">Участки</a></p>
				<p><a class="left-menu" href="../working_staff/brigade.php">Бригады</a></p>
				<p><a class="left-menu" href="../working_staff/working_staff.php">Рабочий персонал</a></p>
				<p><a class="left-menu" href="engineering_staff.php">Инженерно-технический персонал</a></p>
				<p><a style='background: #000;'class="left-menu" href="../index.php?do=logout"><i class="fa fa-arrow-left" aria-hidden="true"> ВЫХОД </i></a></p>
			</div>

			<div class='content'>
				

				<h2>Данные успешно сохранены!</h2>
				<?
					
				
					mysqli_query($link,"UPDATE `engineering_staff` SET `last_name`='{$_POST['last_name']}',`first_name`='{$_POST['first_name']}',`patronymic`='{$_POST['patronymic']}',`id_position`= {$_POST['position_select']} WHERE `id_worker`= {$_POST['id_worker_change']}");
					
					if ($_POST['plot_select'] <> 'NULL' )
					{
						mysqli_query($link,"UPDATE `plots` SET `plot_manager`= null WHERE `plot_manager`={$_POST['id_worker_change']}");
						mysqli_query($link,"UPDATE `plots` SET `plot_manager`= {$_POST['id_worker_change']} WHERE `id_plot`={$_POST['plot_select']}");					
					}

					if ($_POST['workshop_select'] <> 'NULL' )
					{
						mysqli_query($link,"UPDATE `workshops` SET `workshop_manager`= null WHERE `workshop_manager`={$_POST['id_worker_change']}");
						mysqli_query($link,"UPDATE `workshops` SET `workshop_manager`= {$_POST['id_worker_change']} WHERE `id_workshop`={$_POST['workshop_select']}");					
					}

					$uploadfile = "../../images/".$_FILES['img0']['name'];
					if ($_FILES['img0']['name']!='') 
					{
						move_uploaded_file($_FILES['img0']['tmp_name'], $uploadfile);
						mysqli_query($link,"UPDATE `engineering_info` SET  `tel`='{$_POST['phone']}', `email`='{$_POST['email']}', `dob`='{$_POST['dob']}', `adress`='{$_POST['address']}', `photo`='../../images/{$_FILES['img0']['name']}' WHERE `id_worker`={$_POST['id_worker_change']}");
					}
					else 
					{
						mysqli_query($link,"UPDATE `engineering_info` SET  `tel`='{$_POST['phone']}', `email`='{$_POST['email']}', `dob`='{$_POST['dob']}', `adress`='{$_POST['address']}' WHERE `id_worker`={$_POST['id_worker_change']}");
					}
					
				
				
				
				?>
				
				<br>
				<a class='button2' href='engineering_staff.php' class='button2'><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;&nbsp; Список сотрудников</a>&nbsp;&nbsp;
				<a href='new_engineering.php	' class='button2'> Добавить нового сотрудника &nbsp;&nbsp; <i class='fa fa-plus-circle' aria-hidden='true'></i> </a>
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
            var arr=(new Uint8Array(e.tarPOST.result)).subarray(0,4);
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