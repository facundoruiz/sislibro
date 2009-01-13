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
<link rel="stylesheet" href="css/jq.css" type="text/css" media="print, projection, screen" />


<!--<script type="text/javascript">
 $(document).ready(function() {  
      
$("table").tablesorter({widthFixed: true, widgets: ['zebra']})     
$("table").tablesorterPager({container: $("#pager")}); 
    });     </script> -->
 
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
<?php echo $r->inf2("submenu.php?menu=3");  ?>
</div>

<div class="t_datos"><div class="titulos">Buscar clientes</div></div> 

<form name="form1" method="post">
Dato a Buscar
   <input type="text" name="dato" value="<?PHP echo $_POST['dato'] ?>" >

<select name="tipo">
<option value=2 <?PHP echo $_POST['tipo']==2?' selected':'';?>>Documento</option>
<option value=3 <?PHP echo $_POST['tipo']==3?' selected':'';?>>Apellido</option>
<option value=1 <?PHP echo $_POST['tipo']==1?' selected':'';?>>TODOS</option>
</select>
<input type="submit">
</form>

</div>
<?PHP 
if(isset($_POST['dato']) &&!empty($_POST['dato'])||$_POST['tipo']==1){
 
		if($_POST['tipo']==1){
			$cmdSQL="select * from t_clientes c
			left join t_chequeras t  on (c.id_clientes=t.id_cliente)";

		}
		if($_POST['tipo']==2){
			$cmdSQL="select * from t_clientes c  
			left join t_chequeras t  on (c.id_clientes=t.id_cliente)
			where c.dni=".$_POST['dato']."";
							}
		if($_POST['tipo']==3){
			$dato=explode(' ',$_POST['dato']);
			echo sizeof($dato);
			echo $dato[0];
			
			$cmdSQL="select * from t_clientes c  
			left join t_chequeras t on (c.id_clientes=t.id_cliente)";
					if(sizeof($dato)>1){
						if(sizeof($dato)<=2){
						$cmdSQL.="where (c.apellido ilike '%".$dato[0]."%' and c.nombre ilike '%".$dato[1]."%' and c.nombre ilike '%".$dato[2]."%') OR (c.apellido ilike '%".$dato[1]."%' and c.nombre ilike '%".$dato[2]."%' and c.nombre ilike '%".$dato[1]."%') " ;
						}else{
						$cmdSQL.="where (c.apellido ilike '%".$dato[0]."%' and c.nombre ilike '%".$dato[1]."%') OR (c.apellido ilike '%".$dato[1]."%' and c.nombre ilike '%".$dato[0]."%')" ;
						}
					}else{
					$cmdSQL.="where c.apellido ilike '%".$dato[0]."%' OR c.nombre ilike '%".$dato[0]."%'" ;	
					}
				}			
?>


<div id="overlay">
		Por Favor espere...
		</div>
<TABLE  cellspacing="1" class="tablesorter">
<thead> 
<TR >
	<th >Nº DOCUMENTO </th>
	<th >CLIENTE </th>
	<th >Nº CHEQUERA</th>
	<th >ESTADO</th>
	<th >PLAN</th>
	<th >CUOTAS</th>
	<!--  <TD>EN STOCK</TD>	
	<TD >Modificar</TD> --> 
</TR>
</thead> 
<tbody>
<?		
//	echo $cmdSQL;
	$query=pg_query($cmdSQL);
	while($rows=pg_fetch_array($query)){
	
	?>
<TR  >
	<td><?PHP echo$rows['dni']?></td>
	<TD><?PHP ECHO $rows['apellido'].';'.$rows['nombre']?></TD>
	<TD align="center"><?PHP echo$rows['num_chequera']?></TD>
	<TD><?PHP echo$rows['estado']?></TD>
	<TD align="center"  ><?PHP echo $rows['cant_cuotas']."X $".$rows['importe_cuota'];?></TD>
	<TD><?PHP ?></TD>
 	<!-- <TD align="center"><?PHP echo$$rows[1]?></TD>
	<TD align="center"><A HREF="javascript:v_abrir2('m_libro.php?dato=<?PHP echo$rows[0]?>')">modificar</A></TD> --> 
</TR>
<?php }	
		?>
</tbody>
</TABLE>

</div>
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

<?
	
}

?>


<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div></div>
</div>
</body></html>