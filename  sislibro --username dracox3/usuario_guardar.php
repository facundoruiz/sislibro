<?PHP include("cabecera.php");
include("funcionesGrales.php");
$a_username=$_POST['alta_user'];
$a_password=$_POST['alta_pass'];
$a_nombre=$_POST['alta_nombre'];
$a_apellido=$_POST['alta_apellido'];
$a_funcion=$_POST['alta_funcion'];

if($a_username=="" || $a_password=="" || $a_nombre=="" || $a_apellido=="" || $a_funcion=="") 
		{echo "<script language='JavaScript'>
		alert ('COMPLETE TODOS LOS CASILLEROS');
			window.location.href='usuario_alta.php';		
		</script>";
		}
else
	{		
$r->add_user($a_username,$a_password,$a_nombre,$a_apellido,$a_funcion);
echo "<script language='JavaScript'>
		alert ('EL usuario fue dado de alta ');
			window.location.href='usuario_alta.php';	
		</script>";
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>GUARDAR USUARIO</title>

</head>
<body >
<?php
 	}
?>
</body>
</html>
