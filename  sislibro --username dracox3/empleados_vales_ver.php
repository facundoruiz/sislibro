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

 
<script type="text/javascript" src="js/tablesorter/jquery-latest.js"></script>
	<script type="text/javascript" src="js/tablesorter/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
	
	 
<link rel="stylesheet" href="js/tablesorter/css/jq.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript"> 
     $(document).ready(function() {     // call the tablesorter plugin
     $("#overlay").show(); 
     $("table").tablesorter({   sortMultiSortKey: 'altKey' ,widthFixed: true, widgets: ['zebra']    }); 
     $("table").tablesorterPager({container: $("#pager")}); 
     $("#overlay").hide(); 
     }); 
  
    </script>

</head><body dir="ltr" lang="es">
<div align="center">
<div >
<div class="banner"><span class="logo3">
</span><br>
</div>
<div class="bienvenidos">
<?php echo $r->inf2('empleados_vales.php'); 
$gEmpleado=new gestorEmpleado($c);


if(isset($_POST['empleado'])&&!empty($_POST['empleado'])){ 	
	$id_empleado=$_POST['empleado'];
	 $cmd="select v.fecha,v.monto,v.* from t_empleados e inner join t_vales v on (e.id_empleados=v.id_empleado ) where e.id_empleados=".$id_empleado." ORDER BY V.FECHA  ";
	$query=pg_query($cmd);
	if(pg_num_rows($query)>0){
		
		$empleado=$gEmpleado->get_EmpleadoId($_POST['empleado']);
		
?>

</div>

<div class="t_datos"><div class="titulos">VALES REGISTRADOS : <br> Num Empleado:<? echo $empleado->get_num_empleado()." ".$empleado->get_apellido()."; ".$empleado->get_nombre(); ?></div></div>

<p> 



<div id="overlay">
		Por Favor espere...
		</div>
<TABLE  cellspacing="1" class="tablesorter"  >
<thead> 
<TR>
	<th >FECHA </th><th >N° RECIBO</th><th >VALE MONTO</th>
	<th width="30" >DETALLE</th>
</TR>
</thead> 
<tbody>
<?		
//	echo $cmdSQL;
	$query=pg_query($cmd);
	while($rows=pg_fetch_array($query)){
	
	?>
<TR >
	
	<TD align="center"><?PHP echo $rows['fecha'];?></TD>
	<TD><?PHP echo $rows['numrecibo'] ?></TD>
		<TD><?PHP echo $rows['monto'] ?></TD>
			<TD><?PHP echo $rows['detalle'] ?></TD>
 	 
</TR>
<?php }	
		?>
</tbody>
</TABLE>

</div><br>
		<div id="pager" class="pager">
	 <form name="datos">
		<img src="js/tablesorter/addons/pager/icons/first.png" class="first"/>
		<img src="js/tablesorter/addons/pager/icons/prev.png" class="prev"/>
		<input type="text" class="pagedisplay"/>
		<img src="js/tablesorter/addons/pager/icons/next.png" class="next"/>
		<img src="js/tablesorter/addons/pager/icons/last.png" class="last"/>
		<select class="pagesize">
			<option selected="selected"  value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option  value="40">40</option>
			<option value="50">50</option>
		</select>
	</form> 
</div>
<?php
	}else{
		echo "<b>no tiene registrado vales</b>";
		
	}
		
}

?>

<p><br>
</p>
<?php 

	if(isset($_POST['guardar'])&&!empty($_POST['monto'])&&!empty($_POST['fecha'])&&!empty($_POST['empleado'])){ 
		$fecha=$_POST['fecha'];
		$monto=$_POST['monto'];
		echo $cmdVale="insert into t_vales (id_empleado, monto ,  fecha ,  fecha_aud,  hora_aud ,  usuario_aud ) values($id_empleado,$monto,'".$fecha."',(select fecha()),(select hora()),'".$r->getUser()."')";
		$rs=pg_fila($cmdVale);
			
		}else{
		echo "<b>Campos Basios, todos los datos son importante</b>";
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