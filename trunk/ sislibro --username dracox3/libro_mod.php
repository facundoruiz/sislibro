<html>

<head>
<?php 
include('cabecera.php');
include("funcionesGrales.php");
?>
<title>::---Modificar Libros---::</title>
</head>

<body>

<table border="0" width="528" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="100%"><img border="0" src="images/hr_top.gif" width="528" height="58"></td>
  </tr>
  <tr>
    <td width="100%" valign="top">
      <blockquote>
        <p align="center"><font color="#000000" face="Arial" size="2"><strong><img border="0" src="images/ballet_lg.gif" width="19" height="18">Modificar Libros (Stock, Monto)
        <img border="0" src="images/ballet_lg.gif" width="19" height="18"></strong></font></p>
      </blockquote>
<?php $codigo=$_GET['dato'];
$sql="Select codigo,descdic(1,id_genero),descdic(6,id_editor),id_titulo from tipos_libros where codigo=$codigo order by id_genero ";
$rows=pg_fila($sql);
$ri=pg_fila("select * from stock where cod_libro=".$rows[0]."");

?>

 <FORM METHOD=POST ACTION="" name="form">
 <table width="434" border="1">          
   <tr>
      <th scope="row" bgcolor=#66CCFF >CODIGO</th>
      <td width="319">&nbsp;  <?PHP echo $rows[0]?>	
	  <INPUT TYPE="hidden" name="codigo" value="<?PHP echo $rows[0]?>"></td>
</tr>

<tr>
      <th scope="row" bgcolor=#66CCFF >Genero</th>
      <td width="319">  <?PHP echo $rows[1]?>	    </td>
</tr>
<tr>
      <th scope="row" bgcolor=#66CCFF>Editorial</th>
	  <td width="319"> <?PHP echo $rows[2]?> </td>
			
    </tr>


    <tr>
      <th scope="row" bgcolor=#66CCFF>Titulo del libro </th>
      <td width="319"><INPUT TYPE="text" NAME="nombre" value="<?PHP echo $_POST['nombre']?strtoupper($_POST['nombre']):$rows[3]?>" onblur="document.form.submit()" >    	
  </td> </tr>
	 <tr>
      <th scope="row" bgcolor=#66CCFF>Cantidad </th>
      <td width="319"><?php $cant=$ri[1]?> 
	            <input type="text" name="cant" size="5" onKeyPress="return soloNum(event)" title="Ingrese Cantidad de libros "  value="<?php echo $cant?>">	
  </td> </tr>
   <tr>
      <th scope="row" bgcolor=#66CCFF>Costo </th>
      <td width="319">	 
<?php $costo=$ri[2] ?>
	            $ <input type="text" name="costo" size="5" onKeyPress="return soloNumPto(event)" title="Ingrese Costo del libro unitario"  value="<?php echo $costo?>">	
	         	
  </td> </tr>
   <tr>
      <th scope="row" bgcolor=#66CCFF>Dar de Baja </th>
      <td width="319">	<SELECT NAME="baja" >
	<option value="-1" <?php echo ($_POST['baja']==-1)?'selected':' ';?>>- -</option>
		<option value="2" <?php echo ($_POST['baja']==2)?'selected':' ';?>>Si</option>
	</SELECT>      	
  </td> </tr>
  </table>

    </td>
  </tr>
  <tr>  <td align="center"> <INPUT TYPE="image" SRC="images/bmodificar.gif" onclick="document.form.action='gm_libro.php'"  ALT="Modificar Costo y Cantidad " name="consulta">
 <!--  <A HREF="javascript:document.location.href='m_libro.php'"><IMG SRC="images/limpiar.gif" WIDTH="100" HEIGHT="40" BORDER="0" ALT="Limpiar Formulario"></A> -->
 <INPUT TYPE="hidden" NAME="form" value="m_s_libro">
 </FORM>
  </td> </tr>
  <tr>
    <td width="100%"><img border="0" src="images/hr_bot.gif" width="528" height="44"></td>
  </tr>
</table>
<br>

</body>

</html>
