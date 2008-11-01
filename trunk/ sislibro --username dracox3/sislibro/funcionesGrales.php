<script language="JavaScript" src="/js/funcionesGral.js"></script>
<?php


function add_user($username,$password,$nombre,$apellido,$funcion) 
{
	$userLog=$_SESSION['miuser'];
	$qtemp="select funcion from t_usuarios where usuario='$userLog'";
	$rtemp=pg_query($qtemp);
	$atemp=pg_fetch_row($rtemp);
	if ($atemp[0]==1)
	{
		//convertir todo a mayusculas	
		$username=trim(strtr(strtoupper($username), 'áéíóúñ', 'AEIOUÑ'));
		$password=trim(strtr(strtoupper($password), 'áéíóúñ', 'AEIOUÑ'));
		$password = encrypt($password);
		$nombre=trim(strtr(strtoupper($nombre), 'áéíóúñ', 'AEIOUÑ'));	
		$apellido=trim(strtr(strtoupper($apellido), 'áéíóúñ', 'AEIOUÑ'));

		$cad = " insert into t_usuarios (usuario,pass,nombre,apellido,funcion,fecha_aud,hora_aud,usuario_aud) values (";
		$cad.= " '$username', '$password','$nombre','$apellido','$funcion',(select fecha()),(select hora()),'$userLog')";
//		echo $cad;
		$aaa=pg_query($cad);
	}
	else 
	{
		echo "<script javascript>alert('No tiene un perfil autorizado para agregar un usuario')</script>";
		echo "<script javascript>parent.window.location.href='menu.php?SID' </script>";
	}
}

function Formafecha($fecha){
 
$fecha=explode("/",$fecha);
$formatear_mes=$fecha[1];
$mes =   array("Enero"=>"1","Febrero"=>"2","Marzo"=>"3","Abril"=>"4","Mayo"=>"5","Junio"=>"6","Julio"=>"7","Agosto"=>"8","Septiembre"=>"9","Otubre"=>"10","Noviembre"=>"11","Diciembre"=>"12");
       
foreach ($mes as $k => $v) 
{
	if ($v == $formatear_mes) 
	{
        $fecha[1] = $k;
    }
}

return $fecha;}

function pg_fila($cmd){
	$result=pg_query($cmd); 
	$rows=pg_fetch_array($result);
return $rows;
}

function submenu($pag){
$qmenu="select id_menu from tmenu where nombre='$pag'";
$amenu=pg_fila($qmenu);
if ($amenu>0)
{
	$elsubmenu=$amenu['id_menu'];
	echo "<script javascript>parent.window.location.href='submenu.php?SID&menu=$elsubmenu' </script>";
}
else
{
	echo '<script>alert("No encontro el menu")</script>';
}
}
?>