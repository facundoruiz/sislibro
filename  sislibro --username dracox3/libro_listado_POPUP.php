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
<script type="text/javascript" src="js/tablesorter/jquery-latest.js"></script>
	<script type="text/javascript" src="js/tablesorter/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
		
	 

<script type="text/javascript">$(function() {
		$("table")
			.tablesorter({widthFixed: true, widgets: ['zebra']})
		.tablesorterPager({container: $("#pager")});
	});
    </script>


</head><body dir="ltr" lang="es">
<div align="center">

<div class="t_datos"><div class="titulos">BUSCAR LIBROS</div></div>
<div class="descripcion"><?
$sql="select codigo,f_desc_genero(idgenero),f_desc_editorial(ideditorial),f_desc_titulo(idtitulo) from t_ejemplares order by  codigo";


$b=1;
 $banfondo=true;
	$q=pg_query($sql);

if($b!=0){
	?>
<div id="overlay">
		Por Favor espere...
		</div>
<table cellspacing="1" class="tablesorter"  >
<thead> 
<TR >
	
	<th >CODIGO</th>
	<th >GENERO</th>
	<th >EDITORIAL</th>
	<th >TITULO</th>
	<!--  <TD>EN STOCK</TD>	
	<TD >Modificar</TD> --> 
</TR>
</thead> 
<tfoot> 
<TR >
	
	<th >CODIGO</th>
	<th >GENERO</th>
	<th >EDITORIAL</th>
	<th >TITULO</th>
	<!--  <TD>EN STOCK</TD>	
	<TD >Modificar</TD> --> 
</TR>
</tfoot>
<tbody>
<?php  
$conexion=new gestorConexion();
$conexion->getMiconexion();
	$q=pg_query($sql);
while($r=pg_fetch_array($q)){
	//$ri=pg_fila("select * from stock where cod_libro=".$r[0]."");
	
	?>
<TR  >
	
	<TD align="center"><?PHP echo$r[0]?></TD>
		<TD  ><?PHP echo$r[1]?></TD>
	<TD align="center"  ><?PHP echo$r[2]?></TD>
	<TD><?PHP echo$r[3]?></TD>
 	<!-- <TD align="center"><?PHP echo$ri[1]?></TD>
	<TD align="center"><A HREF="javascript:v_abrir2('m_libro.php?dato=<?PHP echo$r[0]?>')">modificar</A></TD> --> 
</TR>
<?php }	
		?>
</tbody>

<?php } 
		     
?>

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
		</select>
	</form>
</div>
</div></td>
</tr>
</table>
</div>

</body></html>