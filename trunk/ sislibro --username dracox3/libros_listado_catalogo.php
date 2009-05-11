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
<div >
<div class="banner"><span class="logo3">
</span><br>
</div>
<div class="bienvenidos">
<?php echo $r->inf2("submenu.php?menu=5");  ?>
</div>
<div class="descripcion">

<?PHP
if(!isset($_GET['id'])){

$sql="select * from catalogo order by  fecha_aud asc";
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
	
	<th >N° CATALOGO</th>
	<th >NOMBRE</th>
	<th >FECHA</th>
	 
</TR>
</thead> 
<tfoot> 
<TR >
	<th >N° CATALOGO</th>
	<th >NOMBRE</th>
	<th >FECHA</th>
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
<TR onclick="javascript:ir('<?PHP echo "libros_listado_catalogo.php?id=".$r[1]?>')" >
	
	<TD align="center"><?PHP echo$r[1]?></TD>
		<TD  ><?PHP echo$r[0]?></TD>
	<TD align="center"  ><?PHP echo$r[2]?></TD>
	
</TR>
<?php }	
		?>
</tbody>
</TABLE>
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


<?php } 

}else{
	
echo$sql="select * from catalogo 
inner join detalle_catalogo using(idcatalogo)
WHERE idcatalogo=".$_GET['id']."";
$b=1;
 $banfondo=true;
	$q=pg_query($sql);
?>
<div id="overlay">
		Por Favor espere...
		</div>
<table cellspacing="1"  >
<thead> 
<TR >	
	<th >CODIGO</th>
	<th >NOMBRE</th>
	<th >PRECIO</th>
	 
</TR>
</thead> 
<tbody>
<?php  

while($r=pg_fetch_array($q)){
	
	?>
<TR  >
	
	<TD align="center"><?PHP echo$r[0]?></TD>
		<TD  ><?PHP echo$r[1]?></TD>
	<TD align="center"  ><?PHP echo$r[2]?></TD>
	
</TR>
<?php }	
		?>
</tbody>
</TABLE>
	
		<?
}?>
	
	
	</div>


</td>
</tr>
</table>
</div>
<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div></div>
</div>
</body></html>
	