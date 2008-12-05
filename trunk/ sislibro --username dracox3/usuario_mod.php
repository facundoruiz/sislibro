<?php 
include("cabecera.php");


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

<div class="t_datos"><div class="titulos">Modificar Usuario</div></div>
<div class="descripcion">
<table>
<tr><td>
	<form name="form1" method="post" action="">
<?php
$usuario=$r;
if ($_POST['Submit']){
	$id_usu=$_POST['id_usuario'];
	$nom_up=trim(strtr(strtoupper($_POST['up_nombre']), 'áéíóúñ', 'AEIOUÑ'));
	$ape_up=trim(strtr(strtoupper($_POST['up_apellido']), 'áéíóúñ', 'AEIOUÑ'));
	if ($_POST['up_pass']<>$_POST['pass_ref'])
		$pass_up=$r->encrypt(trim(strtr(strtoupper($_POST['up_pass']), 'áéíóúñ', 'AEIOUÑ')));
	else
		$pass_up=$_POST['pass_ref'];
		
	$func_up=$_POST['up_funcion'];
	$habil_up=($_POST['up_habili'])?$_POST['up_habili']:0;
	
	$upUser ="update t_usuarios set nombre='$nom_up', apellido='$ape_up', funcion=$func_up, habilitado=$habil_up, pass='$pass_up'";
	$upUser.=" where id_usuario=$id_usu ";
//	echo $upUser;
	if (pg_query($upUser))
		{	if($usuario->getid()==$id_usu&&$band!=false){
				
			$usuario->setPass($pass_up);
			$_SESSION['miUser']=serialize($usuario);
			echo '<script> alert("su cambio de CONTRASEÑA se efectuó CORRECTAMENTE");</script>';
		}
		}
	echo "</form>";
	echo '<script>location="usuario_admin.php"; </script>';
//	echo '<script>document.form1.action="admin_user.php"; submit(); </script>';
}
?>
	 USUARIO A MODIFICAR 
	  <?php
	  $qeluser =" select u.id_usuario, u.usuario,u.pass,u.apellido,u.nombre ,u.funcion, habilitado from t_usuarios u where u.id_usuario=".$_GET['id_user'];
	  $reluser=pg_query($qeluser);
	  $aeluser=pg_fetch_assoc($reluser);
	  ?>
       USUARIO
			<input name=" alta_user" type="text" class="Estilo3" id="alta_user" value="<?php echo $aeluser['usuario'];?>" onBlur="submit();" readonly>
            <input type="hidden" name="id_usuario" value="<?php echo $aeluser['id_usuario'];?>">
         <br>
 CONTRASE&Ntilde;A
      <input name="up_pass" type="password" class="Estilo3" id="up_pass" value="<?php echo $aeluser['pass'];?>">
          <input name="pass_ref" type="hidden" id="pass_ref" value="<?php echo $aeluser['pass'];?>">
          <br>
       NOMBRE
       <input name="up_nombre" type="text" class="Estilo3" id="up_nombre" value="<?php echo $aeluser['nombre'];?>">
       <br>
      APELLIDO<input name="up_apellido" type="text" class="Estilo3" id="up_apellido" value="<?php echo $aeluser['apellido'];?>">
      <br>
      FUNCION
       <select name="up_funcion" id="up_funcion">
            <?php
				$q_fin="select item,descrip from diccionario where codigo = 3"; //combo estados finalizacion
				$r_fin=pg_query($q_fin);
				while ($a_fin=pg_fetch_array($r_fin)){
			?>
            <option value="<?php echo $a_fin['item'];?>" <?php echo ($aeluser['funcion']==$a_fin['item'])?"selected":"";?>><?php echo $a_fin['descrip'];?> </option>
            <?php }?>
          </select><br>
       HABILITADO
       <input name="up_habili" type="checkbox" id="up_habili" value="1" <?php echo ($aeluser['habilitado']==1)?'checked':'';?> ><br>
        <input type="submit" name="Submit" value="GUARDAR"  >
       <input name="reestablecer" type="reset" id="reestablecer" value="RESTABLECER">
	</form>

</td></tr>
</table>

</div></td>
</tr>
</table>
</div>
<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div></div>
</div>
</body></html>