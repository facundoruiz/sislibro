<?php 
include("cabecera.php"); 
include("funcionesGrales.php"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>USUARIO MODIFICAR</title>

</head>

<body >
	<form name="form1" method="post" action="">
<?php
$usuario=$r;
if ($_POST['Submit']){
	$id_usu=$_POST['id_usuario'];
	$nom_up=trim(strtr(strtoupper($_POST['up_nombre']), '������', 'AEIOU�'));
	$ape_up=trim(strtr(strtoupper($_POST['up_apellido']), '������', 'AEIOU�'));
	if ($_POST['up_pass']<>$_POST['pass_ref'])
		$pass_up=$r->encrypt(trim(strtr(strtoupper($_POST['up_pass']), '������', 'AEIOU�')));
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
			echo '<script> alert("su cambio de CONTRASE�A se efectu� CORRECTAMENTE");</script>';
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
 CONTRASE&Ntilde;A
      <input name="up_pass" type="password" class="Estilo3" id="up_pass" value="<?php echo $aeluser['pass'];?>">
          <input name="pass_ref" type="hidden" id="pass_ref" value="<?php echo $aeluser['pass'];?>">
       NOMBRE
       <input name="up_nombre" type="text" class="Estilo3" id="up_nombre" value="<?php echo $aeluser['nombre'];?>">
      APELLIDO<input name="up_apellido" type="text" class="Estilo3" id="up_apellido" value="<?php echo $aeluser['apellido'];?>">
      FUNCION
       <select name="up_funcion" id="up_funcion">
            <?php
				$q_fin="select item,descrip from diccionario where codigo = 7"; //combo estados finalizacion
				$r_fin=pg_query($q_fin);
				while ($a_fin=pg_fetch_array($r_fin)){
			?>
            <option value="<?php echo $a_fin['item'];?>" <?php echo ($aeluser['funcion']==$a_fin['item'])?"selected":"";?>><?php echo $a_fin['descrip'];?> </option>
            <?php }?>
          </select>
       HABILITADO
       <input name="up_habili" type="checkbox" id="up_habili" value="1" <?php echo ($aeluser['habilitado']==1)?'checked':'';?> ></td>
      <input type="submit" name="Submit" value="GUARDAR"  >
       <input name="reestablecer" type="reset" id="reestablecer" value="RESTABLECER">
	</form>
</body>
</html>
