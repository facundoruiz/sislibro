<? include("cabecera.php"); 
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
<div class="titular"><span class="logo3">
</span><br>
</div>
<div class="bienvenidos">
<p><?php echo " Usuario: ". $user ?></p>
</div><table border="0" cellpadding="0" cellspacing="0" width="100%" summary="Contenido">
<tr>
<td  class="izquierda">
<div class="cuad1_cat2">MENU</div>
<?php
	$user=$_SESSION['miuser'];

	$menu=$_GET['menu'];
	$qSubmenu =" select img,nombre,link,m.descripcion from t_funcion_menu f inner join t_menu m on (f.id_menu = m.id_menu and f.id_submenu=m.id_submenu) ";
	$qSubmenu.=" where f.id_funcion=(select funcion from t_usuarios where usuario='$user') and m.id_submenu<>0 and f.id_menu=$menu";
	$rSubmenu=pg_query($qSubmenu);
	while($aSubmenu=pg_fetch_assoc($rSubmenu)){
?>
<div class="cuad2_cat2"> 
 <?php if(!empty($aSubmenu['img'])){?>
 	<IMG SRC="<?php echo $aSubmenu['img'];?>" WIDTH="40" HEIGHT="40" BORDER="0" ALT="">
 <?php }?>  
	<a href="<?php echo $aSubmenu['link'];?>" onmouseover="javascript:change('<?php echo$aSubmenu['descripcion']?>')" onmouseout="javascript:change('')"><?php echo $aSubmenu['nombre'];?></a>
	</div>      
<?php
}
?>




<td width="580" class="centro">
<div class="cuad1_subcat">SISTEMAS</div>
<div class="cuad2_busca">

<FONT SIZE="3" COLOR="#FF0000"><div id="description"><FONT SIZE="" COLOR="#FFFFFF">.</FONT></div>
	 </FONT>




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