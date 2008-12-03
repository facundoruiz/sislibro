<?php 
include('cabecera.php');
include("funcionesGrales.php");?>

<script type="text/javascript" src="js/tablesorter/jquery-latest.js"></script>
	<script type="text/javascript" src="js/tablesorter/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
	
	 
<link rel="stylesheet" href="js/tablesorter/css/jq.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript">
$(document).ready(function() {    
 $("table")
 .tablesorter({widthFixed: true, widgets: ['zebra']})
 .tablesorterPager({container: $("#pager")});  
$("table").bind("sortStart",function() {       
 $("#overlay").show();     })
 .bind("sortEnd",function() {
  $("#overlay").hide();     }); 

});

/* $(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); */

  
    </script>

<?php
/*
$b=0;
$baja=$_REQUEST ['baja']?1:0;
echo'<INPUT TYPE="hidden" name="baja" value="'.$baja.'">';

$registros=10;


    $pagina=$_REQUEST['siguiente']?$_REQUEST['siguiente']:$_REQUEST['atras'];
if (!$pagina) { 
    $inicio = 0; 
    $pagina = 1; 
} 
else { 
    $inicio = ($pagina - 1) * $registros; 
} 
/*
if(isset($_REQUEST ['btitulo'])){
	if(!empty($_REQUEST ['ttitulo'])){
echo'<INPUT TYPE="hidden" name="btitulo" value="'.$_REQUEST ['btitulo'].'">';
echo'<INPUT TYPE="hidden" name="ttitulo" value="'.$_REQUEST ['ttitulo'].'">';
echo'<INPUT TYPE="hidden" name="valor" value="1">';

$ttitulo=strtoupper ($_REQUEST ['ttitulo']);
$sql="Select codigo,descdic(1,id_genero),descdic(6,id_editor),id_titulo from tipos_libros where id_titulo ilike'%$ttitulo%' and estado=$baja order by id_editor ";
$b=1;
}else echo"<SCRIPT >alert('Titulo esta vacio')</SCRIPT>";
}

if(isset($_REQUEST ['bcodigo'])){
	if(!empty($_REQUEST ['codigo'])){
		echo'<INPUT TYPE="hidden" name="btitulo" value="'.$_REQUEST ['bcodigo'].'">';
echo'<INPUT TYPE="hidden" name="codigo" value="'.$_REQUEST ['codigo'].'">';
echo'<INPUT TYPE="hidden" name="valor" value="2">';
$codigo=$_REQUEST ['codigo'];
$sql="Select codigo,descdic(1,id_genero),descdic(6,id_editor),id_titulo from tipos_libros where codigo=$codigo and estado=$baja order by id_genero ";
$b=1;
}else echo"<SCRIPT >alert('Codigo esta vacio')</SCRIPT>";
}

if(isset($_REQUEST ['beditorial'])){
	if($_REQUEST ['editorial']!=-1){
		echo'<INPUT TYPE="hidden" name="beditorial" value="'.$_REQUEST ['beditorial'].'">';
echo'<INPUT TYPE="hidden" name="editorial" value="'.$_REQUEST ['editorial'].'">';
echo'<INPUT TYPE="hidden" name="valor" value="3">';
$editor=$_REQUEST ['editorial'];
$sql="Select codigo,descdic(1,id_genero),descdic(6,id_editor),id_titulo from tipos_libros where id_editor=$editor and estado=$baja order by id_genero";$b=1;
}else echo"<SCRIPT >alert('No se Selecciono Editorial ')</SCRIPT>";
}

if(isset($_REQUEST ['bgenero'])){
	if($_REQUEST ['Tipo']!=-1){
			echo'<INPUT TYPE="hidden" name="bgenero" value="'.$_REQUEST ['bgenero'].'">';
echo'<INPUT TYPE="hidden" name="Tipo" value="'.$_REQUEST ['Tipo'].'">';
echo'<INPUT TYPE="hidden" name="valor" value="3">';
	$Tipo=$_REQUEST ['Tipo'];
$sql="Select codigo,descdic(1,id_genero),descdic(6,id_editor),id_titulo from tipos_libros where id_genero=$Tipo and estado=$baja  order by id_editor";$b=1;
}else echo"<SCRIPT >alert('No se Selecciono Genero')</SCRIPT>";
}

if(($_GET['d']==1)){
	if($_POST['Tipo']!=-1&&$_POST['editorial']!=-1){
	$Tipo=$_POST['Tipo'];$editor=$_POST['editorial'];$ttitulo=strtoupper ($_POST['ttitulo']);;
$sql="Select f_desc_ejemplares($codigo) from t_ejemplares where idgenero=$Tipo and idtitulo =$ttitulo and ideditor=$editor and estado=$baja order by id_genero";$b=1;
}else echo"<SCRIPT >alert('Algun campo esta vacio o No se Selecciono')</SCRIPT>";

}

*/
echo$sql="select codigo,f_desc_genero(idgenero),f_desc_editorial(ideditorial),f_desc_titulo(idtitulo) from t_ejemplares";
$b=1;
 $banfondo=true;
	$q=pg_query($sql);/*
$total_registros = pg_num_rows($q); 
$sql.=" LIMIT $registros offset $inicio";
$total_paginas = ceil($total_registros / $registros); 	
	$q=pg_query($sql);
	if($total_registros){
		
	*/
if($b!=0){
	?>
<div id="overlay">
		Por Favor espere...
		</div>
<TABLE  class=tablesorter id="myTable">
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
</TABLE>
<div id="pager" class="pager">
	<form>
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

</div>
<?php }/*
if($total_registros) {
		
		echo 'Paginas:';
		
		if(($pagina - 1) > 0) {

		echo'<table><tr><td  align="left"> <FORM METHOD=POST name="form1">
	<INPUT TYPE="hidden" name="atras" value="'.($pagina-1).'">';
	echo "<input type=submit onclick='document.form1.action=empleados.php' value='< Atras'></FORM></td>";
		}
		
		for ($i=1; $i<=$total_paginas; $i++){ 
			if ($pagina == $i) 
				echo "<td><FONT SIZE=6 COLOR=RED>".$pagina."</FONT> </td>"; 
			else{
				echo "<td>".$i."</td>"; 
				/*
	echo'<INPUT TYPE="hidden" name="pagina" value="'.$i.'">';
	echo "<input type=submit onclick='document.form.action=empleados.php' value=' $i '> "; 
	
			}
				
		}
	  
		if(($pagina + 1)<=$total_paginas) {
			echo'<td  align="left"> <FORM METHOD=POST name="form2">
	<INPUT TYPE="hidden" name="siguiente" value="'.($pagina+1).'">';
	echo "<input type=submit onclick='document.form2.action=empleados.php' value='Siguiente > '>
	</FORM></td></tr> ";

		}
		
		echo "</table>";
		
		}
	}else{echo "<CENTER><font color='darkgray'>(sin resultados)</font></CENTER>";}*/ ?>
	
	
	
	