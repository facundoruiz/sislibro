<?php 
session_start();

function __autoload($clase){
	$PATH_CLASS='./clases/';
	require_once($PATH_CLASS.$clase.'.class.php');
} 


$c=new gestorConexion();

if(isset($_POST['user']) and isset($_POST['pass'])){
	// una sola vez
	
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$r=new gestorUsuario($user,$pass,$c);
	
	//$r->setTurno($_POST['turnoT']);

	$_SESSION['miUser']=serialize($r);
}

if (isset($_SESSION['miUser']))
{//&& get_class()
	$r=unserialize($_SESSION['miUser']);
				
	$vali=$r->login();
	if (!empty($vali))
	{
		echo "<script javascript>alert('$vali')</script>";
		echo "<script javascript>parent.window.location.href='index.php'</script>";
	}
	
	$_SESSION['miUser']=serialize($r);
	
}
else
{
	echo "<script javascript>alert('Debe Loguearse en el sistema')</script>";
	echo "<script javascript>parent.window.location.href='index.php'</script>";
}	

 ?>


