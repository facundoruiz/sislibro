<? 
include("cabecera.php"); 
if (isset($_SESSION[ID_menu]))
	unset($_SESSION[ID_menu]);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="es"><head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<title>Sislibro</title>
<META HTTP-EQUIV="Content-Script-Type" CONTENT="text/javascript">
<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
<META HTTP-EQUIV="Content-language" CONTENT="es">


<?php include("funcionesGrales.php");?>


</head>

<body dir="ltr" lang="es">
<div align="center">
<div >
<div class="banner"><span class="logo3">
</span><br>
</div>
<div class="bienvenidos">
<?php echo $r->inf();  ?>
</div><table border="0" cellpadding="0" cellspacing="0" width="100%" summary="Contenido">
<tr>
<?php
 $user=$_SESSION['miuser'];

 $menu=$_GET['menu'];
 $_SESSION['ID_menu']=$menu;
 //echo $_SESSION['ID_menu'];
 /*********************** consulto el titulo del submenu *****************/
 $sql =" select nombre from t_menu where id_menu= ".$menu." and id_submenu=0";
 //echo $sql;
 $result=pg_query($sql);
 $row=pg_fetch_array($result);
 /************************************************************************/
?>
  
 
<td  class="izquierda">
<div class="t_menu"> Submenu: <? echo $row[nombre]; ?></div>
<div class="c_menu">
<?php echo $r->Submenu($menu); ?>
</div> 



<td  class="centro">
<div class="titulos">SISTEMAS</div>
<div class="descripcion">
<FONT SIZE="3" COLOR="#FF0000"><div id="description" class="c_datos"><FONT SIZE="" COLOR="#FFFFFF">.</FONT></div>
	 </FONT>




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
