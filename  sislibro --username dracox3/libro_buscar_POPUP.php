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
		
	});
    </script>


</head><body dir="ltr" lang="es">
<div align="center">

<div class="t_datos"><div class="titulos">BUSCAR LIBROS</div></div>
<div class="descripcion">
<? $ttitulo=strtoupper ($_POST['ttitulo']);


?>
<form  method="post" action="" name="form">
 
  <table >          


<tr>
      <th scope="row" >Titulo</th>
	  <td>	
	  <input type="text" name="ttitulo" onBlur="document.form.submit()" value="<?php echo $ttitulo ?>"> 
	   
  <?php 
   if(isset($_POST['ttitulo']) && !empty($ttitulo)){
  
			?>
				
		    
   	
  </td> </tr>
  </table>
  
  </form>
    <?php } 
		     if(!empty($ttitulo)){
$sql= " Select  codigo,f_desc_genero(idgenero),f_desc_editorial(ideditorial),f_desc_titulo(idtitulo) from t_libros l 
inner join t_ejemplares e on e.idtitulo=l.idlibro
where descrip ilike'%$ttitulo%'  order by descrip";

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
		     
		     }
?>
</div></td>
</tr>
</table>
</div>

</body></html>