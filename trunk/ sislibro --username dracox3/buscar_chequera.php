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
<script type="text/javascript"> $(document).ready(function() {     // call the tablesorter plugin
     $("table").tablesorter({         // change the multi sort key from the default shift to alt button 
             sortMultiSortKey: 'altKey'     }); }); 
  
    </script>

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
<?php echo $r->Submenu(6); ?>
      </div>
<td  class="centro">

<div class="t_datos"><div class="titulos">BUSQUEDAS DE CHEQUERAS</div></div>
<div class="descripcion">

<form name="form1" method="post">
   <input type="text" name="dato" value="<?PHP echo $_POST['dato'] ?>" >

<select name="tipo">
<option value=1 <?PHP echo $_POST['tipo']==1?' selected':'';?>>Nº Chequera</option>
<option value=2 <?PHP echo $_POST['tipo']==2?' selected':'';?>>Documento</option>
<option value=3 <?PHP echo $_POST['tipo']==3?' selected':'';?>>Apellido</option>
</select>
<input type="submit">
</form>

<?PHP 
if(isset($_POST['dato']) &&!empty($_POST['dato'])){

?>

<div id="overlay">
		Por Favor espere...
		</div>
<TABLE  cellspacing="1" class="tablesorter">
<thead> 
<TR >
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
<?php  
		if($_POST['tipo']==1){
			$cmdSQL="select * from t_chequeras t inner join t_clientes c on (c.id_clientes=t.id_cliente) where num_chequera=".$_POST['dato']." ";
				}
		if($_POST['tipo']==2){
			$cmdSQL="select * from t_chequeras t 
			inner join t_clientes c on (c.id_clientes=t.id_cliente)
			where c.dni=".$_POST['dato']."";
							}
		if($_POST['tipo']==3){
			$cmdSQL="select * from t_chequeras t 
			inner join t_clientes c on (c.id_clientes=t.id_cliente)
			where c.apellido ilike '".$_POST['dato']."'";
				}					
	echo $cmdSQL;
	$query=pg_query($cmdSQL);
	while($rows=pg_fetch_array($query)){
	
	?>
<TR  >
	<td><?PHP echo $rows['apellido']."; ".$rows['nombre'];?></td>
	<TD align="center"><?PHP echo$rows['num_chequera']?></TD>
		<TD  ><?PHP echo$rows[8]?></TD>
	<TD align="center"  ><?PHP echo $rows['cant_cuotas']."X $".$rows['importe_cuota'];?></TD>
	<TD align="center"><A HREF="javascript:v_abrir2('registro_cuotas.php?idchequera=<?PHP echo$rows['idchequera']?>')">ingresar cuotas</A></TD>  
</TR>
<?php }	
		?>
</tbody>
</TABLE>

</div>


<?
	
}

?>

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