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

<div class="t_datos"><div class="titulos">Produccion de Empleados</div></div> 

<form name="form1" method="post" >
  <table width="500" border="1">
 
    <tr>
      <td colspan="3">Dato a Buscar
    <?PHP  $grupo=new HtmlGrupo();
		   $gEmpleado=new gestorEmpleado($c);
 			$comboO=$gEmpleado->ComboOficios();
			$comboO->__wakeup();
			
			 $grupo->addControl($comboO);
			 
			if(isset($_POST['oficio'])&&!empty($_POST['oficio'])){ 
				if($_POST['oficio']==1){
					 $comboE=$gEmpleado->ComboVendedor();
				}elseif($_POST['oficio']==2){
				 	 $comboE=$gEmpleado->ComboCobrador();	
				}else{
					 $comboE=$gEmpleado->ComboEmpleado($_POST['oficio']);	
					}
				$grupo->addControl($comboE);
			}
				 echo $grupo->toString();
?>   </td>
      
    </tr>
    <tr>
      <td> Fecha desde:
    <INPUT  TYPE="text" size="10" NAME="fecha_desde" maxlength="10" onBlur="valFecha(this)" value=<?php echo (isset($_POST['fecha_desde']))?$fecha=$_POST['fecha_desde']:'';?>>
      <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form1',
		// input name
		'controlname': 'fecha_desde'
	});

	</script></td>
      <td>&nbsp;</td>
      <td> hasta Fecha :
    <INPUT  TYPE="text" size="10" NAME="fecha_hasta" maxlength="10" onBlur="valFecha(this)" value=<?php echo (isset($_POST['fecha_hasta']))?$fecha=$_POST['fecha_hasta']:'';?>>
      <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form1',
		// input name
		'controlname': 'fecha_hasta'
	});

	</script></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>
   
   
      <input type="submit" name="consultar" value="Consultar" onClick="document.form1.action='informe_empleado_fichas.php';document.form1.target='_blank';">
    </p>
</form>

</div>	



<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div></div>
</div>
</body></html>
