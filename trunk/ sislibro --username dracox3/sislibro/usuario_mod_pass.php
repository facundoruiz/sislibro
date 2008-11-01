<?php include("cabecera.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Transporte - Acta</title>
<link href="letras.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo3 {font-size: 18px}
-->
</style>
</head>

<body background="img/Fondo.jpg">

<?php
if($_POST['Submit']){
	$pass_old=trim(strtr(strtoupper($_POST['pass_old']), 'áéíóúñ', 'AEIOUÑ'));
	if ($pass_old == $_SESSION['clave_global']){
		if ($_POST['pass']==$_POST['repass']){
			$password=trim(strtr(strtoupper($_POST['pass']), 'áéíóúñ', 'AEIOUÑ'));
			$encpass = encrypt($password);
			$upUser="update tusuarios set pass ='".$encpass."' where id_usuario = ".$_POST['id_us_pass'];
	//		echo $upUser;
			if (pg_query($upUser)){
				$_SESSION['clave_global']=$password;
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
<table width="750">
  <tr>
    <td colspan="2"><div align="center"><img src="img/titulo.JPG" ></div></td>
  </tr>
  <tr>
    <td width="175" align="center" valign="top">&nbsp;<a href="menu.php?SID"><IMG SRC="img/volver.gif" WIDTH="35" HEIGHT="35" BORDER="0" ALT=""><BR>
Menu Principal</a> </td>
    <td width="616" align="center" valign="middle">
	<?php
		$quser="select u.id_usuario,u.usuario,u.nombre,u.apellido,d.descrip as func from tusuarios u left join diccionario d on (d.codigo=8 and u.funcion=d.item)";
		$quser.=" where upper(usuario) = '".strtoupper($_SESSION['miuser'])."'";
		$ruser=pg_query($quser);
		$auser=pg_fetch_array($ruser);
	?>
	
	<table width="398" height="324" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" class="letra">
      <tr valign="middle" bgcolor="#009900" class="titulo">
        <td height="33" colspan="3" align="center" class="letras"><strong>MODIFICAR CONTRASE&Ntilde;A </strong></td>
      </tr>
      <tr>
        <td width="23" align="center" valign="middle"></td>
        <td width="143" height="33" align="left" valign="middle"> USUARIO</td>
        <td width="232" height="33"align="center" valign="middle"><input name="usuario_pass" type="text" class="inputbox" id="alta_user" value="<?php echo $auser['usuario'];?>" readonly>
          <input name="id_us_pass" type="hidden" id="id_us_pass" value="<?php echo $auser['id_usuario'];?>"></td>
      </tr>
      <tr>
        <td  align="center" valign="middle" class="titulo Estilo4"></td>
        <td height="33"  align="left" valign="middle" > NOMBRE</td>
        <td height="33" align="center" valign="middle"><input name="alta_nombre" type="text" class="inputbox" id="alta_nombre" value="<?php echo $auser['nombre'];?>" readonly></td>
      </tr>
      <tr>
        <td  align="center" valign="middle" class="titulo Estilo4"></td>
        <td height="33"  align="left" valign="middle" > APELLIDO</td>
        <td height="33" align="center" valign="middle"><input name="alta_apellido" type="text" class="inputbox" id="alta_apellido" value="<?php echo $auser['apellido'];?>" readonly></td>
      </tr>
      <tr>
        <td  align="center" valign="middle" class="titulo Estilo4"></td>
        <td height="33"  align="left" valign="middle" > FUNCION</td>
        <td height="33" align="center" valign="middle"><input name="funcion" type="text" class="inputbox" id="funcion" value="<?php echo $auser['func'];?>" readonly></td>
      </tr>
      <tr>
        <td  align="center" valign="middle" class="titulo Estilo4"></td>
        <td height="33"  align="left" valign="middle" > CONTRASE&Ntilde;A </td>
        <td height="33" align="center" valign="middle"><input name="pass_old" type="password" class="inputbox" id="pass_old" value="">
        </td>
      </tr>
      <tr>
        <td  align="center" valign="middle" class="titulo Estilo4"></td>
        <td height="33"  align="left" valign="middle" > CONTRASE&Ntilde;A NUEVA</td>
        <td height="33" align="center" valign="middle"><input name="pass" type="password" class="inputbox" id="pass" value="">
        </td>
      </tr>
      <tr>
        <td  align="center" valign="middle" class="titulo Estilo4"></td>
        <td height="33"  align="left" valign="middle" > REPETIR <br>
          CONTRASE&Ntilde;A NUEVA </td>
        <td height="33" align="center" valign="middle"><input name="repass" type="password" class="inputbox" id="repass" value=""></td>
      </tr>
      <tr class="titulo">
        <td align="center" valign="middle"></td>
        <td height="20" align="center" valign="middle"></td>
        <td height="20" align="center" valign="middle"></td>
      </tr>
      <tr class="titulo">
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
	
	</td>
  </tr>
  <tr>
    <td colspan="2"><hr>
      <CENTER>
        <font color="#000000" size="3">Sistema</font><img src="img/ojos0ju.gif" width="34" height="31"><BR>
        <FONT color="#000000" size=1>800x600 - Internet Explorer 5 o superior</FONT>
      </CENTER>
    <p>&nbsp;</p></td>
  </tr>
</table>
</form>
<br>
<br>
</body>
</html>
