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

<div class="t_datos">ADMINISTRADOR DE USUARIOS</div>
<div class="descripcion">

    
	<form name="form1" method="post" action=""  >
	
    <strong>
    <input name="orden" type="radio" value="usuario" onClick="submit()" <?php echo (!$_POST['orden'] or $_POST['orden'])=='usuario'?'checked':''; ?>>
      USUARIO</strong>
    <strong>
    <input name="orden" type="radio" value="nombres" onClick="submit()" <?php echo ($_POST['orden']=='nombres')?'checked':''; ?>>
      APELLIDO Y NOMBRE </strong>
    <strong>
    <input name="orden" type="radio" value="funcion" onClick="submit()" <?php echo ($_POST['orden']=='funcion')?'checked':''; ?>>
      PERFIL</strong>
        <strong>
          <input name="orden" type="radio" value="habilitado" onClick="submit()" <?php echo ($_POST['orden']=='habilitado')?'checked':''; ?>>
          HABILITADO</strong>
  <table class="c_menu"> 
 
	  <?php
	  $orden_f=($_POST['orden'])?$_POST['orden']:'usuario';
	  $quser =" select u.id_usuario,u.usuario,u.apellido||', '||u.nombre as nombres,d.descrip as funcion, habilitado from t_usuarios u ";
	  $quser.=" left join diccionario d on (d.item=u.funcion and d.codigo=3 ) order by $orden_f";
	  $ruser=pg_query($quser);
	  $i=1;
	  while($auser=pg_fetch_assoc($ruser)){
	  ?>
      <tr  bgcolor="<?php echo (!$banfondo)?'':'#CCCCCC'; $banfondo=!$banfondo;?>">
	  	
        <td><?php echo $auser['usuario'];?></td>
        <td><?php echo $auser['nombres'];?></td>
        <td><?php echo $auser['funcion'];?></td>
        <td>
			<input type="checkbox" name="habil<?php echo $i;?>" value="1" <?php echo ($auser['habilitado']==1)?'checked':'';?> disabled>
	        <a href="usuario_mod.php?id_user=<?php echo $auser['id_usuario'];?>">Modificar</a>
		</td>
      </tr>
	  <?php $i++;}?>
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