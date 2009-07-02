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

<?php include("funcionesGrales.php");


?>

</head><body dir="ltr" lang="es">
<div align="center">
<div >
<div class="banner"><span class="logo3">
</span><br>
</div>
<div class="bienvenidos">
<?php echo $r->inf2("submenu.php?menu=4");  ?>
</div>

<div class="t_datos">
  <div class="titulos">Cuotas que estas retrazadas </div>
</div> 

<form name="form1" method="post" target="_blank" >
  <table width="500" border="1">
 
    <tr>
      <td colspan="3">
    <?PHP  $grupo=new HtmlGrupo();
		   $gEmpleado=new gestorEmpleado($c);
 			
				$comboE=$gEmpleado->ComboCobrador();
				$grupo->addControl($comboE);
			
				 echo $grupo->toString();
?>   </td>
      
    </tr>
   
  </table>
  <p>&nbsp;</p>
  <p>
   
   
      <input type="submit" name="consultar" onClick="document.form1.action='informe_cobrador.php'">
    </p>
</form>

</div>	



<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div></div>
</div>
</body></html>
