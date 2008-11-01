<?PHP
session_start();
$si=session_id();

include("conexion.php");
abrir_conexion();
//include("funcionesGrales.php");

//session_register(miuser,clave_global,reslogin,box_global,mostrar,dni_global, casado_global,generar_carpeta);


if (isset($_POST['user']))
{ 
 	$_SESSION['miuser']=trim(strtr(strtoupper($_POST['user']), 'áéíóúñ', 'AEIOUÑ'));
	$_SESSION['clave_global']=trim(strtr(strtoupper($_POST['pass']), 'áéíóúñ', 'AEIOUÑ'));
}
if (isset($_SESSION['miuser']))
{
	$vali=login();
	if (!empty($vali))
	{
		echo "<script javascript>alert('$vali')</script>";
		echo "<script javascript>parent.window.location.href='index.php'</script>";
	}	
}
else
{
	echo "<script javascript>alert('Debe Loguearse en el sistema')</script>";
	echo "<script javascript>parent.window.location.href='index.php'</script>";
}
/********************************************** funciones de logueo ********************************************************************************/

function encrypt($string) {//hash then encrypt a string
   $crypted = crypt(md5($string), md5($string));
    return $crypted;
}
function login() { //valida el login

 $user = $_SESSION['miuser'];
$result = pg_query("select pass from t_usuarios where habilitado=1 and  usuario = '$user'");
if (pg_num_rows($result)>0){
	$pass = pg_fetch_array($result);
	
	$temp=encrypt($_SESSION['clave_global']);
	$auth = ($pass['pass'] == $temp)?"":"CLAVE INCORRECTA";
	$_SESSION['logeado']=true;	
}
else
{
	$auth="USUARIO INEXISTENTE O INHABILITADO";
}
/* if ($islogin==false)
{
	
$fecha=pg_query("Select fecha()");
$fecha=pg_fetch_row($fecha);
$date=$fecha[0];
$hora=pg_query("Select hora()");
$hora=pg_fetch_row($hora);
$hour=$hora[0];
$cad="select max(id_log) from logs";
	$res=pg_query($cad);
	$col=pg_fetch_row($res);
	$idf=$col[0]+1;
	//echo $idf;
	$cad="Insert into logs (id_log,nombre,fecha,hora,ingreso,box) values ('$idf','$user', '$date','$hour','$auth1','$box')";
	$aaa=pg_query($cad);
	//grabar el login en la tabla de logs
}*/
return $auth;
}
/**
 * ******************************************** funcion agregada por los chicos *****************************************************************
 */
?>