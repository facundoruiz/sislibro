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


<form name="form1" method="post" action="">
<table >
<tr> <td>
  INGRESE LOS DATOS DEL USUARIO A DAR DE ALTA
  </td></tr>
<tr> <td>  
USUARIO<input name=" alta_user" type="text"  id="alta_user" value="<?php echo $_POST['alta_user'];?>" onBlur="submit();">
</td></tr> 
  <tr> <td>
  CONTRASE&Ntilde;A<input name="alta_pass" type="password"  id="alta_pass" value="<?php echo $_POST['alta_pass'];?>">
  </td></tr>
  <tr> <td>
  NOMBRE<input name="alta_nombre" type="text"  id="alta_nombre" value="<?php echo $_POST['alta_nombre'];?>">
  </td></tr>
  <tr> <td>
  APELLIDO<input name="alta_apellido" type="text"  id="alta_apellido" value="<?php echo $_POST['alta_apellido'];?>">
  </td></tr>
  <tr> <td>FUNCION
  <select name="alta_funcion" id="alta_funcion">
			<?php
				$q_fin="select item,descrip from diccionario where codigo = 3"; //combo estados finalizacion
				$r_fin=pg_query($q_fin);
				while ($a_fin=pg_fetch_array($r_fin)){
			?>
				<option value="<?php echo $a_fin['item'];?>" <?php echo ($_POST['alta_funcion']==$a_fin['item'])?"selected":"";?>><?php echo $a_fin['descrip'];?>
				</option>
			<?php }?>
			</select>
</td></tr>
<tr><td>		 <input type="submit" name="Submit" value="AGREGAR" onClick='document.form1.action="usuario_guardar.php"' >
        
        <input name="reestablecer" type="reset" id="reestablecer" value="RESTABLECER">
     </td></tr>
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