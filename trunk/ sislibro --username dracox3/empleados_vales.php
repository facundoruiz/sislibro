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
<?php echo $r->Submenu(4); ?>
      </div>
<td  class="centro">

<div class="t_datos"><div class="titulos">INGRESO DE VALES</div></div>
<div class="descripcion">

<FORM NAME="form1" METHOD="post">Seleccione Perfil 
<?PHP
		$gEmpleado=new gestorEmpleado($c);
		$grupo=new HtmlGrupo();
		
			$comboO=$gEmpleado->ComboOficios();
   			$comboO->setOnChange('submit()');
			$comboO->__wakeup();
   			 
   			 $grupo->addControl($comboO);
   			 		
if(isset($_POST['oficio'])&&!empty($_POST['oficio'])){ 	
		  		
			$comboE=$gEmpleado->ComboEmpleado($_POST['oficio']);
			$comboE->setOnChange('submit()');
   			$comboE->__wakeup();
			$grupo->addControl($comboE);
			
					}
   			echo $grupo->toString();

?>

Monto $ <input type="text" name="monto" value="" size="4" >
<input type="submit" value="Guardar">
</FORM>
<p>
<?PHP
if(isset($_POST['empleado'])&&!empty($_POST['empleado'])){ 	
	$id_empleado=$_POST['empleado'];
	pg_fila();
	echo ;	
}

?>

</p>
<p><br>
</p>
<p><br>
</p>
<p><br>
</p>

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