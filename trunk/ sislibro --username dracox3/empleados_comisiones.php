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
<?php echo $r->inf2('submenu.php?menu=4');  ?>

<div class="t_datos"><div class="titulos">COMISIONES NO PAGADAS</div></div>
<div class="descripcion">

<FORM NAME="datos" METHOD="post">Seleccione Perfil 
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


<p>
<?PHP
if(isset($_POST['empleado'])&&!empty($_POST['empleado'])){ 	
	$id_empleado=$_POST['empleado'];
	echo $cmd="select f_dame_num_chequera(c.idchequera) as chequera,c.idcuota,tc.porcentaje,tp.fecha_pago from t_empleados e 
inner join t_comisiones tc on (e.id_empleados=tc.idempleado )
inner join t_cuotas c on (c.idcuota=tc.idcuota )
inner join t_pago tp on(tp.idcuota=c.idcuota)
	 where e.id_empleados=".$id_empleado."  ";
	
	$query=pg_query($cmd);
	if(pg_num_rows($query)>0){
?>


<div id="overlay">
		Por Favor espere...
		</div>
<TABLE  cellspacing="1" class="tablesorter" >
<thead> 
<TR>
	<th width="80">FECHA </th>
	<th >MONTO</th>
	<th >N° DE CHEQUERA</th>
	<th >N° DE CUOTAS</th>
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
	<TD><?PHP echo $rows['monto'] ?></TD>
 	 
</TR>
<?php }	
		?>
</tbody>
</TABLE>

		<div id="pager" class="pager">
	<!-- <form name="datos"> -->
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

<p><br>
</p>


<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div></div>
</div>
</body></html>