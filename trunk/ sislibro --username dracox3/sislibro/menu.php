<?php include("cabecera.php");
include("funcionesGrales.php");
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
	  
	  	 $qFun="select funcion from t_usuarios where usuario='".$_SESSION['miuser']."'";
		$rFun=pg_query($qFun);
		$aFun=pg_fetch_assoc($rFun);
	  	$funcion=$aFun['funcion'];
	  	$qMenu =" select nombre,link,descripcion,img from t_funcion_menu f inner join t_menu m on (f.id_menu = m.id_menu and f.id_submenu=m.id_submenu) ";
		$qMenu.=" where f.id_funcion=".$funcion." and m.id_submenu=0 ";
		$rMenu=pg_query($qMenu);
		while($aMenu=pg_fetch_assoc($rMenu)){
	  ?>
<div class="cuad2_cat2">	     
	 
      
<?php if(!empty($aMenu['img'])){?> 
<IMG SRC="img/<?php echo $aMenu['img'];?>" WIDTH="40" HEIGHT="40" BORDER="0" ALT="">
<?php }?> 
<a href="<?php echo $aMenu['link']; ?>" onmouseover="javascript:change('<?php echo$aMenu['descripcion']?>')" onmouseout="javascript:change('')"><?php echo $aMenu['nombre'];?></a>
</div>
	  <?php } ?>




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

<p>Desarrollado por Action2 </p>
<p class="copy">Sislibro</p>
</div></div>
</div>
</body></html>
  
    



   
	  
	