<?php include("cabecera.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>ALTA DE USUARIOS</title>

</head>
<body >
<form name="form1" method="post" action="">
  INGRESE LOS DATOS DEL USUARIO A DAR DE ALTA
  USUARIO<input name=" alta_user" type="text"  id="alta_user" value="<?php echo $_POST['alta_user'];?>" onBlur="submit();">
  CONTRASE&Ntilde;A<input name="alta_pass" type="password"  id="alta_pass" value="<?php echo $_POST['alta_pass'];?>">
  NOMBRE<input name="alta_nombre" type="text"  id="alta_nombre" value="<?php echo $_POST['alta_nombre'];?>">
  APELLIDO<input name="alta_apellido" type="text"  id="alta_apellido" value="<?php echo $_POST['alta_apellido'];?>">
  FUNCION
  <select name="alta_funcion" id="alta_funcion">
			<?php
				$q_fin="select item,descrip from diccionario where codigo = 7"; //combo estados finalizacion
				$r_fin=pg_query($q_fin);
				while ($a_fin=pg_fetch_array($r_fin)){
			?>
				<option value="<?php echo $a_fin['item'];?>" <?php echo ($_POST['alta_funcion']==$a_fin['item'])?"selected":"";?>><?php echo $a_fin['descrip'];?>
				</option>
			<?php }?>
			</select>
		 <input type="submit" name="Submit" value="AGREGAR" onClick='document.form1.action="usuario_guardar.php"' >
        
        <input name="reestablecer" type="reset" id="reestablecer" value="RESTABLECER">
     
<?php
$username=trim(strtr(strtoupper($_POST['alta_user']), 'áéíóúñ', 'AEIOUÑ'));
$qvtemp="select usuario from t_usuarios where usuario='$username'";
$rvtemp=pg_query($qvtemp);
if (pg_num_rows($rvtemp) > 0)
{?>
<script javascript>
	alert('Usuario Existente');
	document.form1.Submit.disabled=true;
	document.form1.alta_user.select();
</script>
<?php
} 
else
{
?>
<script javascript>
	document.form1.Submit.disabled=false;
	document.form1.alta_pass.select();
</script>
<?php }?>
</form>

	
</body>
</html>
