<?php 
include("cabecera.php");

$user=$_SESSION['miuser'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="es"><head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<title>Sislibro</title>
<META HTTP-EQUIV="Content-Script-Type" CONTENT="text/javascript">
<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
<META HTTP-EQUIV="Content-language" CONTENT="es">

<?php include("funcionesGrales.php");?>



</head><body dir="ltr" lang="es">
<div align="center">
<div >
<div class="banner"><span class="logo3">
</span><br>
</div>
<div class="bienvenidos">
<?php echo $r->inf();  ?>
</div><table border="0" cellpadding="0" cellspacing="0" width="100%" summary="Contenido">
<tr>
<td  class="izquierda"  valign="top">
<div class="t_menu">SubMENU</div>
 <div id="c_menu"> 
<?php echo $r->Submenu(2); ?>
      </div>
<td  class="centro">

<div class="t_datos">SISTEMAS</div>
<div class="descripcion">


<?php
$usuario=$r;		
if($_POST['Submit']){
	$pass_old=trim(strtr(strtoupper($_POST['pass_old']), 'áéíóúñ', 'AEIOUÑ'));
	if ($pass_old == $_SESSION['clave_global']){
		if ($_POST['pass']==$_POST['repass']){
			$password=trim(strtr(strtoupper($_POST['pass']), 'áéíóúñ', 'AEIOUÑ'));
			$encpass = encrypt($password);
			$upUser="update t_usuarios set pass ='".$encpass."' where id_usuario = ".$_POST['id_us_pass'];
	//		echo $upUser;
			if (pg_query($upUser)){
			$usuario->setPass($password);
			$_SESSION['miUser']=serialize($usuario);
				echo '<script> alert("El cambio de CONTRASEÑA se efectuó correctamente");</script>';
			}
		}
		else
			echo '<script> alert("Reingrese la contraseña porque es incorrecta la repetición") </script>';
	}
	else{
		echo '<script> alert("La contraseña es incorrecta") </script>';
	}
}
?>
<form name="form1" method="post" action="">
	<?php
		$quser="select u.id_usuario,u.usuario,u.nombre,u.apellido,d.descrip as func from t_usuarios u left join diccionario d on (d.codigo=3 and u.funcion=d.item)";
		$quser.=" where upper(usuario) = '".strtoupper($_SESSION['miuser'])."'";
		$ruser=pg_query($quser);
		$auser=pg_fetch_array($ruser);
	?>
	
	<table width="398" height="324" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr valign="middle" >
        <td height="33" colspan="3" align="center" ><strong>MODIFICAR CONTRASE&Ntilde;A </strong></td>
      </tr>
      <tr>
        <td width="23" align="center" valign="middle"></td>
        <td width="143" height="33" align="left" valign="middle"> USUARIO</td>
        <td width="232" height="33"align="center" valign="middle"><input name="usuario_pass" type="text"  id="alta_user" value="<?php echo $auser['usuario'];?>" readonly>
          <input name="id_us_pass" type="hidden" id="id_us_pass" value="<?php echo $auser['id_usuario'];?>"></td>
      </tr>
      <tr>
        <td  align="center" valign="middle" ></td>
        <td height="33"  align="left" valign="middle" > NOMBRE</td>
        <td height="33" align="center" valign="middle"><input name="alta_nombre" type="text"  id="alta_nombre" value="<?php echo $auser['nombre'];?>" readonly></td>
      </tr>
      <tr>
        <td  align="center" valign="middle"></td>
        <td height="33"  align="left" valign="middle" > APELLIDO</td>
        <td height="33" align="center" valign="middle"><input name="alta_apellido" type="text"  id="alta_apellido" value="<?php echo $auser['apellido'];?>" readonly></td>
      </tr>
      <tr>
        <td  align="center" valign="middle"></td>
        <td height="33"  align="left" valign="middle" > FUNCION</td>
        <td height="33" align="center" valign="middle"><input name="funcion" type="text"  id="funcion" value="<?php echo $auser['func'];?>" readonly></td>
      </tr>
      <tr>
        <td  align="center" valign="middle" ></td>
        <td height="33"  align="left" valign="middle" > CONTRASE&Ntilde;A </td>
        <td height="33" align="center" valign="middle"><input name="pass_old" type="password"  id="pass_old" value="">
        </td>
      </tr>
      <tr>
        <td  align="center" valign="middle" ></td>
        <td height="33"  align="left" valign="middle" > CONTRASE&Ntilde;A NUEVA</td>
        <td height="33" align="center" valign="middle"><input name="pass" type="password" id="pass" value="">
        </td>
      </tr>
      <tr>
        <td  align="center" valign="middle" ></td>
        <td height="33"  align="left" valign="middle" > REPETIR <br>
          CONTRASE&Ntilde;A NUEVA </td>
        <td height="33" align="center" valign="middle"><input name="repass" type="password" id="repass" value=""></td>
      </tr>
      <tr>
        <td align="center" valign="middle"></td>
        <td height="20" align="center" valign="middle"></td>
        <td height="20" align="center" valign="middle"></td>
      </tr>
      <tr>
        <td align="center" valign="middle"></td>
        <td height="20" align="center" valign="middle"><input type="submit" name="Submit" value="MODIFICAR" class="button" ></td>
        <td height="20" align="center" valign="middle" bordercolor="#F8EAFD"><input type="reset" name="Submit" value="RESTABLECER" class="button"></td>
      </tr>
      <tr class="titulo">
        <td width="23" align="center" valign="middle"></td>
        <td width="143" height="20" align="center" valign="middle">&nbsp;        </td>
        <td width="232" height="20" align="center" valign="middle" bordercolor="#F8EAFD">&nbsp;</td>
      </tr>
    </table>
	
	
</form>

</div></td>
</tr>
</table>
</div>
<div class="pie">

<p>Desarrollado por  </p>
<p class="copy">Copyright &copy; 2008  &reg; Todos los derechos reservados</p>
</div></div>
</div>
</body></html>
