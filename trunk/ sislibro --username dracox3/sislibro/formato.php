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


<link rel="stylesheet" type="text/css" href="css/normal.css">

<script>
function change(html){
  description.innerHTML=html
}
</script>
</head><body dir="ltr" lang="es">
<div align="center">
<div >
<!--<div style="width:850px;">-->
<div class="titular"><span class="logo3">
</span><br>
</div>
<div class="bienvenidos">
<p><?php echo " Usuario: ". $user ?></p>
</div><table border="0" cellpadding="0" cellspacing="0" width="100%" summary="Contenido">
<tr>
<td  class="izquierda">
<div class="cuad1_cat2">MENU</div>
<div class="cuad2_cat2">
volver

</div>
<td width="580" class="centro">
<div class="cuad1_subcat">SISTEMAS</div>
<div class="cuad2_busca">






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