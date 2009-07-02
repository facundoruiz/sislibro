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
<?php echo $r->inf2('submenu.php?menu=4');  ?>

<div class="t_datos"><div class="titulos">INGRESO DE VALES</div></div>
<div class="descripcion">

<FORM NAME="testform" METHOD="post">Seleccione Perfil 
<?PHP
		$gEmpleado=new gestorEmpleado($c);
		$grupo=new HtmlGrupo();
		/*
			$comboO=$gEmpleado->ComboOficios();
   			$comboO->setOnChange('submit()');
			$comboO->__wakeup();
   			 
   			 $grupo->addControl($comboO);
   			 		*/
//if(isset($_POST['oficio'])&&!empty($_POST['oficio'])){ 	
		  		
			$comboE=$gEmpleado->ComboEmpleado($_POST['oficio']);
			$comboE->setOnChange('submit()');
   			$comboE->__wakeup();
			$grupo->addControl($comboE);
			
	//				}
   			echo $grupo->toString();

?><table border=1>

<tr>
<td>
Fecha</td> <td><input type="text" name="fecha" onBlur="valFecha(this)" value="" size="10" maxlength="10">
<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'testform',
		// input name
		'controlname': 'fecha'
	});

	</script>
</td>
</tr>
<tr>
<td>
Recibo N°</td> <td><input type="text" name="recibo" value="" size="4" onKeyPress="return soloNum(event)"></td>
<tr>
<td>
Monto $ </td> <td><input type="text" name="monto" value="" size="4" onKeyPress="return soloNumPto(event)"></td>
</tr>
<tr>
<td >
detalle:</td> <td><input type="text" name="detalle" value="" size="30" ></td>
<tr>
<td><input type="submit" value="Guardar" name="guardar"></td>

</tr>
</table>



<p> 
<?PHP

if(isset($_POST['empleado'])&&!empty($_POST['empleado'])){ 	
	$id_empleado=$_POST['empleado'];
	$cmd="select v.fecha,v.monto from t_empleados e inner join t_vales v on (e.id_empleados=v.id_empleado ) where e.id_empleados=".$id_empleado."  ";
	$query=pg_query($cmd);
	if(pg_num_rows($query)>0){
		echo "<b>Tiene vales quiere ver los registro<br></b><input type='submit' value='Ver Registros' onclick=\"document.testform.action='empleados_vales_ver.php'\" ";

	}else{
		echo "<b>no tiene registrado vales</b>";
		
	}
}	


?></FORM>

<p><br>
</p>
<?php 

	if(isset($_POST['guardar'])&&!empty($_POST['monto'])&&!empty($_POST['fecha'])&&!empty($_POST['empleado'])&&!empty($_POST['recibo'])){ 
		$fecha=$_POST['fecha'];
		$monto=$_POST['monto'];
		$recibo=$_POST['recibo'];
		$detalle=$_POST['detalle'];
		$cmdVale="insert into t_vales (id_empleado, monto ,numrecibo,  fecha ,detalle, fecha_aud,  hora_aud ,  usuario_aud ) values($id_empleado,$monto,$recibo,'".$fecha."','".$detalle."',(select fecha()),(select hora()),'".$r->getUser()."')";
		$rs=pg_fila($cmdVale);
			echo "<b>Vale cargado</b> $recibo";
		}else{
		echo "<b>Campos Vacios, todos los datos son importante</b>";
		}
	
 ?>
 <p>
 <br>
 <p>

<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div>
</div>
</body></html>