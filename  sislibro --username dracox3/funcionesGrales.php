<script language="JavaScript" src="js/funcionesGral.js"></script>
<link rel="stylesheet" type="text/css" href="css/normal.css">
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
$qmenu="select id_menu from t_menu where nombre='$pag'";
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
/**//*----Muestra ERROR -----*/

function error($error){ 
	echo"	
	<CENTER>
		<TABLE border=1 cellpadding='0' cellspacing='0' >
		<TR>
			<TD bgcolor='#C0C0C0'><FONT SIZE=4 COLOR=>A Ocurrido un Error</FONT></TD>
		</TR>";
	for($i=0;$i<sizeof($error);$i++){
		echo"
		<TR>
			<TD align='center' valign='top' ><FONT COLOR='#FF0000' size=3 face='Book Antiqua'>".$error[$i]."</FONT></TD>
		</TR>";
	}
	echo'</TABLE>';
}

function compara_fechas($fecha1,$fecha2)
{          
	if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
		list($dia1,$mes1,$ano1)=split("/",$fecha1);
	if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
		list($dia1,$mes1,$ano1)=split("-",$fecha1);
	if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
		list($dia2,$mes2,$ano2)=split("/",$fecha2);
	if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
		list($dia2,$mes2,$ano2)=split("-",$fecha2);
	$dif = mktime(0,0,0,$mes1,$dia1,$ano1) - mktime(0,0,0, $mes2,$dia2,$ano2);
	return ($dif);      
		/*
		if (compara_fechas($f1,$f2) <0)
	      echo "$f1 es menor que $f2 <br>";
		if (compara_fechas($f1,$f2) >0)
          echo "$f1 es mayor que $f2 <br>";
		if (compara_fechas($f1,$f2) ==0)
          echo "$f1 es igual  que $f2 <br>";
		*/
}
?>
