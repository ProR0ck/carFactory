<?
session_start();

if($_GET['do'] == 'logout')
{
	unset($_SESSION['manager']);
	session_destroy();
}

if(!$_SESSION['manager'])
{
	header("Location: enter.php");
	exit;
}
?>