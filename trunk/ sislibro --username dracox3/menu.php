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
<div class="banner"><br>
</div>
<div class="bienvenidos">
<?php echo $r->inf();  ?>
</div><table border="0" cellpadding="0" cellspacing="0" width="100%" summary="Contenido">
<tr>

<td  class="izquierda">
<div class="t_menu">MENU</div>
 <div id="c_menu"> 
<?php echo $r->Menu(); ?>
      

</div>



<td width="580" class="centro">
<div class="titulos">SISTEMA LIBROS</div>
<div class="descripcion">
 <FONT SIZE="3" COLOR="#FF0000"><div id="description" class="c_datos"><FONT SIZE="" COLOR="#FFFFFF">.</FONT></div>
	 </FONT>


</div></td>
</tr>
</table>
</div>
<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p></div></div>
</div>
</body></html>
  
    



   
	  
	