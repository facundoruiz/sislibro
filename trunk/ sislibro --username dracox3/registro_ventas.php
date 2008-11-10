<?php 
include("cabecera.php");

$user=$_SESSION['miuser'];
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
<?php echo $r->inf();  ?>
</div>
<?php 
if(!isset($_POST['id_venta'])){
$qcant="select cod_libro,cant,costo from stock";
		$rcant=pg_query($qcant);
while ($acant=pg_fetch_array($rcant)){
pg_fila("update stock1 SET cant=".$acant[1].",costo=".$acant[2]." where cod_libro=".$acant[0]."");
}

}
?>

<body >

<table border="0" width="528" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="100%" valign="top" colspan="2">
     
	
	  <form  method="post" action="venta.php" name="form1" ></td></tr>
<tr><td  valign="top">
<TABLE    border=0>

 <TR><TD>Fecha :</TD>	<TD><INPUT  TYPE="text" size="13" NAME="fecha" maxlength="10" onBlur="valFecha(this)" value=<?php echo (isset($_POST['fecha']))?$fecha=$_POST['fecha']:'dd/mm/aaaa';?>></TD></TR>
 <TR><TD>Nº de Chequera:</TD> <TD><INPUT  TYPE="text" NAME="n_chequera" size="4" onKeyPress="return soloNum(event)" value="<?PHP echo $_POST['n_chequera']?>"></TD></TR>
 	<?php  
	      $cmd= "select Max(id_venta)+1 from compras";
          $rows=pg_fila($cmd);
          $Max=empty($rows[0])?1:$rows[0];
		  ?>
	<TR><TD>Nº de Sistema :<B><?php echo$Max?></B><INPUT TYPE="hidden" name="id_venta" value=<?php echo$Max?>></TD></TR>
 
 
 </TABLE>

<tr><td valign="top">
 <TABLE border=0 id="capa2"  >
  <tr ><th width="99" bgcolor=#66CCFF  scope="row" colspan="3"><CENTER>Cliente</CENTER></th></tr>
 

     <?php   if($b==0){  
	            $dni= $_POST['dni'];
				
				if(!empty($dni))
					{              
	            $cmdMO="select * from t_clientes  where dni='$dni'";
				$q=pg_query($cmdMO);
				$r=pg_fetch_array($q);
		//$dni=$r['dni'];
		$id=$r['id_clientes'];
		$apellido=$r['apellido'];
		$nombre=$r['nombre'];
	   $domicilio=$r['domicilio'];
		$telefono=$r['tel'];
		$cel=	$r['cel'];
		$Loc=$r['id_localidad'];
		$prov=$r['id_provincia'];
		$barrio=$r['barrio'];
		$obs=$r['obs'];
			
				}
				}
							
	  ?> 
   <tr>		  
      <th width="99" bgcolor=#66CCFF  scope="row">DNI</th>	  
      <td width="281"  >	  	  
	  <?php if($r!=0)
	      {			    
			?>			
		<!-- 	<input type="text" name="dni" onKeyPress="return soloNum(event)" maxlength="8" onBlur="document.form1.submit()" value="<?php echo $dni ?>" readonly="TRUE">	
			
			<?php echo "<FONT  COLOR=red>DNI Existente</FONT>";
				echo "<BR>".$apellido.", ".$nombre;
				echo "<br>".$_POST['barrio'];



			?>	 -->	  
			<!-- SI EXITE PASA POR AQUI -->
  
<input type="text" name="dni"   value="<?php echo isset($_POST['dni'])?$_POST['dni']:$dni; ?>" readonly>	
<INPUT TYPE="hidden" name="existe" value="1">
<INPUT TYPE="hidden" name="id_clientes" value="<?php echo$id?>">
		   </td>
    </tr>
 
     <tr>
      <th scope="row" bgcolor=#66CCFF>Apellido</th>
      <td width="281"><?php echo $apellido; ?></td>
	      </tr>
<tr>
       <th scope="row" bgcolor=#66CCFF>Nombre</th>
       <td width="281"><?php echo $nombre;  ?></td>
      </tr>
    <tr>
       <th scope="row" bgcolor=#66CCFF>Domicilio</th>
         <td width="281" ><?php echo $domicilio;  ?></td>
      </tr>
 <tr>
       <th scope="row" bgcolor=#66CCFF>Telefono</th>
         <td width="281"><?php echo $telefono;  ?></td>

    </tr>
<tr>
      <th scope="row" bgcolor=#66CCFF>Celular(*)</th>
        <td width="281"><?php echo $cel;  ?> </td>
   </tr>	
	 <tr>
   <th scope="row" bgcolor=#66CCFF>Provincia</th>
   <td  align="left">
 <?php 	$qprov="select item,descrip from diccionario where codigo='4' order by descrip desc";
		$rprov=pg_query($qprov);
		
		while ($aprov=pg_fetch_array($rprov)){	
	echo($prov==$aprov['item'])?$aprov['descrip']:''; }?>
</select>
</td>
    </tr>
<tr>
    <th scope="row" bgcolor=#66CCFF>Localidad</th>
   <td  align="left">
 <?php 	$qLoc="select item,descrip from t_localidades where codigo=".$prov." order by descrip asc";
		$rLoc=pg_query($qLoc);
		 
		while ($aLoc=pg_fetch_array($rLoc)){	
	 echo ($Loc==$aLoc['item'])?$aLoc['descrip']:''; }?>
</td>
    </tr>
<tr>
    <th scope="row" bgcolor=#66CCFF>Barrio</th>
 <td width="281" ><?php echo $barrio;  ?></td>
   </tr>
   <tr>
    <th scope="row" bgcolor=#66CCFF>Observacion</th>
 <td width="281" ><?php echo $obs;  ?></td>
   </tr>

 
	

 <?php  }else{
			           if(empty($dni)) {?>     
					   <input type="text" name="dni"   maxlength="8" onKeyPress="return soloNum(event)"  title="Ingrese el DNI" onBlur="document.form1.submit()" value="<?php echo $dni?>">	
						<?php } else {?>
				 
   	<input type="text" name="dni"     value="<?php echo isset($_POST['dni'])?$_POST['dni']:$dni; ?>" readonly>	
<INPUT TYPE="hidden" name="id" value="<?PHP echo isset($_POST['id'])?$_POST['id']:$id ?>">
		   </td>
    </tr>
 
     <tr>
      <th scope="row" bgcolor=#66CCFF>Apellido</th>
      <td width="281"><input type="text"  maxlength="30" name="apellido" title="Ingrese el Apellido" value="<?php echo isset($_POST['apellido'])?strtoupper ($_POST['apellido']):$apellido; ?>"></td>
    </tr>
       <tr>
       <th scope="row" bgcolor=#66CCFF>Nombre</th>
         <td width="281"><input type="text"  maxlength="30" name="nombre" title="Ingrese el Nombre" value="<?php echo isset($_POST['nombre'])?strtoupper ($_POST['nombre']):$nombre;  ?>"></td>
      </tr>
    <tr>
       <th scope="row" bgcolor=#66CCFF>Domicilio</th>
         <td width="281"><input type="text"  maxlength="100" name="domicilio" title="Ingrese el Domicilio" value="<?php echo isset($_POST['domicilio'])?strtoupper ($_POST['domicilio']):$domicilio;  ?>"></td>
      </tr>
 <tr>
       <th scope="row" bgcolor=#66CCFF>Telefono</th>
         <td width="281"><input type="text"  onKeyPress="return soloNum(event)" name="telefono" title="Ingrese el Telefeno" value="<?php echo isset($_POST['telefono'])?$_POST['telefono']:$telefono;  ?>" maxlength="7"></td>
      </tr>	
  <tr>
      <th scope="row" bgcolor=#66CCFF>Celular(*)</th>
        <td width="281"><input type="text"  onKeyPress="return soloNum(event)" name="cel" title="Ingrese el Telefeno" value="<?php echo isset($_POST['cel'])?$_POST['cel']:$cel;  ?>" maxlength="10"> </td>
   </tr>	
	 <tr>
   <th scope="row" bgcolor=#66CCFF>Provincia</th>
   <td  align="left"><select name="prov"  onChange="document.form1.submit()">
    <option value="-1" >-- Provincia --</option>
 <?php 	$qprov="select item,descrip from diccionario where codigo='4' order by descrip desc";
		$rprov=pg_query($qprov);
		$Prov=isset($_POST['prov'])?$_POST['prov']:$prov;
		while ($aprov=pg_fetch_array($rprov)){	
			
			?>
<option value="<?php echo $aprov['item'];?>"<?php echo($Prov==$aprov['item'])?'selected':'';?>><?php echo $aprov['descrip'];?>   </option><?php }?>
</select></td>
    </tr>    
 
   <tr>
   <th scope="row" bgcolor=#66CCFF>Localidad</th>
   <td  align="left"><select name="Loc"  >
    <option value="-1" >-- Localidad --</option>
 <?php 	$qLoc="select item,descrip from t_localidades where codigo=".$Prov." order by descrip asc";
		$rLoc=pg_query($qLoc);
		$loc=isset($_POST['Loc'])?$_POST['Loc']:$Loc; 
		while ($aLoc=pg_fetch_array($rLoc)){	
			
			?>
<option value="<?php echo $aLoc['item'];?>"<?php echo($loc==$aLoc['item'])?'selected':'';?>><?php echo $aLoc['descrip'];?>   </option><?php }?>
</select><A HREF="a_localidad.php">&nbsp;Cargar Localidades</A></td>
    </tr>
<tr>
    <th scope="row" bgcolor=#66CCFF>Barrio</th>
 <td width="281"><input type="text"  name="barrio" title="Ingrese el Barrio" value="<?php echo isset($_POST['barrio'])?strtoupper($_POST['barrio']):$barrio;  ?>"></td>
   </tr>
   <tr>
    <th scope="row" bgcolor=#66CCFF>Observacion</th>
 <td width="281"><TEXTAREA name="obs"  ROWS="5" COLS="25"><?php echo isset($_POST['obs'])?strtoupper ($_POST['obs']):$obs;  ?></TEXTAREA></td>
   </tr>

	<tr>
<td  width="100%"  colspan="2" >(*)se coloca el numero sin 0 y sin 15 ej: 0<B>381</B>15<B>4498244</B> </td>
	</tr>


	<?php }}?>


 
 </td>
     </tr>
	 <!-- FIN NO ESTA CARGADO -->

<tr> <th scope="row" bgcolor=#99CCFF>vendedor</th>
 <td  align="left" colspan="2" ><select name="vendedor" >
    <option value="0" >-- vendedor --</option>
 <?php 	$qven="select id_empleados,(apellido||','||nombre) as empleado from t_empleados where id_oficio='1' order by apellido asc";
		$rven=pg_query($qven);
		while ($aven=pg_fetch_array($rven)){	?>
<option value="<?php echo $aven['id_empleados'];?>"<?php echo($_POST['vendedor']==$aven['id_empleados'])?'selected':'';?>><?php echo $aven['empleado'];?>   </option><?php }?>
</select> 
 </td></tr>
 <th scope="row" bgcolor=#99CCFF>Cobrador</th>
   <td  align="left" colspan="2"><select name="cobrador" >
    <option value="0" >-- Cobrador --</option>
 <?php 	$qcob="select id_empleados,(apellido||','||nombre) as empleado from t_empleados where id_oficio='2' order by apellido asc";
		$rcob=pg_query($qcob);

		while ($acob=pg_fetch_array($rcob)){	?>
<option value="<?php echo $acob['id_empleados'];?>"<?php echo($_POST['cobrador']==$acob['id_empleados'])?'selected':'';?>><?php echo $acob['empleado'];?>   </option><?php }?>
</select>
 </td>
    </tr>
</table>
</td><td >(*)Para que funcione el campo codigo, la seleccion de titulo debe estar vacia.
     <table width="530" border="1" class="formulario">
        <tr>
          <td width="50" bgcolor=#99CCFF>Codigo</td>
		  <td  bgcolor=#99CCFF>Genero</td>
          <td  bgcolor=#99CCFF>Editorial</td>
		  <td  bgcolor=#99CCFF>Titulo</td>
         <td  width="50" bgcolor=#99CCFF>Cant.</td>  
		 <td  width="50" bgcolor=#99CCFF>Precio</td>
         </tr>
	   <tr>
<td><?php echo ($_POST['titulo']!=-1)?$_POST['titulo']:''?></td>
   <td width="319">  	   
	  <select name="Tipo"   onchange="document.form1.submit()">
	  		 <option value="-1">---Seleccione un Genero</option>
			<?php 
			$qtipo="select item,descrip from diccionario where codigo=1 order by(descrip)";
			$rtipo=pg_query($qtipo);
			while ($atipo=pg_fetch_array($rtipo)){
			?>
            <option value="<?php echo $atipo['item'];?>" <?php echo ($_POST['Tipo']==$atipo['item'])?'selected':'';?>
			><?php echo $atipo['descrip'];?>
			<?php }?>
          </select> 
</td><td>
<select name="editorial"  onchange="document.form1.submit()">
	  		 <option value="-1">---Seleccione editorial </option>
			<?php 
				$tgenero=isset($_POST['Tipo'])?$_POST['Tipo']:0;
	$qeditorial="select distinct item,descrip from tipos_libros tl ";
echo$qeditorial.="inner join diccionario d on (d.item=tl.id_editor) where d.codigo=6 and tl.id_genero=$tgenero order by(descrip)";
			$reditorial=pg_query($qeditorial);
			while ($aeditorial=pg_fetch_array($reditorial)){
			?>
            <option value="<?php echo $aeditorial['item'];?>" <?php echo ($_POST['editorial']==$aeditorial['item'])?'selected':'';?>
			><?php echo $aeditorial['descrip'];?>
			<?php }?>
          </select> 
</td>

<td>
<select name="titulo"  onchange="document.form1.submit()">
	  		 <option value="-1">---Seleccione Titulo </option>
			<?php 
			 $teditorial=isset($_POST['editorial'])?$_POST['editorial']:0;
	$qtitulo="select distinct codigo,id_titulo from tipos_libros tl ";
$qtitulo.=" where   tl.id_editor=$teditorial and tl.id_genero=$tgenero and tl.estado=0 order by(id_titulo)";
			$rtitulo=pg_query($qtitulo);
			while ($atitulo=pg_fetch_array($rtitulo)){
			?>
            <option value="<?php echo $atitulo['codigo'];?>" <?php echo ($_POST['titulo']==$atitulo['codigo'])?'selected':'';?>
			><?php echo $atitulo['id_titulo'];?>
			<?php }?>
          </select> 
</td><td><? $ri=$_POST['titulo']?pg_fila("select cant from stock1 where cod_libro=".$_POST['titulo'].""):0;
			echo$ri!=0?$ri[0]:0
			?><td>
</tr>
<?php  $_POST['codigo']=($_POST['titulo']!=-1)?$_POST['titulo']:$_POST['codigo']?> 







        <tr>
<td><input type="text" name="codigo" onKeyPress="return soloNum(event)"  title="Ingrese el Codigo de Libro" onBlur="document.form1.submit()" size="4" value=<?php echo$_POST['codigo']?>></td>
<?php 
if(!empty($_POST['codigo'])||$_POST['codigo']!=0){
$codigo=$_POST['codigo'];
$sql="Select codigo,descdic(1,id_genero),descdic(6,id_editor),id_titulo from tipos_libros where codigo=$codigo order by id_genero ";	 
 $rows=pg_fila($sql);
if( $rows==0){
echo"<SCRIPT> alert('No existe este ".$codigo." codigo ')</SCRIPT>";
$_POST['codigo']='' ;
}

 
echo"<td>".$rows[1]."</td>";
echo"<td>". $rows[2]."</td>"; 
echo"<td>".$rows[3]."</td>"; 
echo"<td><SELECT NAME='cant'> ";
$ri=pg_fila("select cant from stock1 where cod_libro=".$rows[0]."");
if($ri[0]!=0){
for($i=1;$i<=$ri[0];$i++){ echo "<OPTION VALUE=".$i." >".$i."";  }

}else{
echo"<OPTION VALUE=0 >0";
$_POST['codigo']='';
echo"<SCRIPT >alert('no hay Stock')</SCRIPT>";

}?>
</SELECT></td>
   <!-- Costo -->
<td><input type="text" name="precio"  size="3" onKeyPress="return soloNumPto(event)"></td><?php }?>
 </tr>

 </table>












 <input type="submit" name="mas" value="agregar" onClick="document.from1.submit()">&nbsp;&nbsp;<a href="a_libro.php" target="_blank">Cargar Libros</a>
 <P>
 <P>
 <table  border="0">
<?php if((isset($_POST['mas']) && !empty($_POST['codigo']))||$_POST['mostrar']==1){?>
<table width="558" border="0" class="formulario">
<tr > 
<td  colspan="8" bgcolor=#99CC99 class='tr' align="center">DETALLE</td></tr>
   <tr class="td">
          <td width="50" bgcolor=#99CC99>Codigo</td>
		  <td  bgcolor=#99CC99>Genero</td>
          <td  bgcolor=#99CC99>Editorial</td>
		  <td  bgcolor=#99CC99>Titulo</td>
         <td  bgcolor=#99CC99>Cant.</td>  
		 <td   bgcolor=#99CC99>Precio</td>
		  <td   bgcolor=#99CC99>eliminar</td>
		  <input type="hidden" name="mostrar" value="1" > 
         </tr>
   <?php }
$c=1;
while ($_POST['codigo'.$c]){
?>
     <input type="hidden" name="codigo<?php echo$c; ?>" value="<?php echo $cod=$_POST['codigo'.$c];?>" >
     <input type="hidden" name="cant<?php echo $c; ?>" value="<?php echo $cant=$_POST['cant'.$c];?>" >
	<input type="hidden" name="precio<?php echo $c; ?>" value="<?php echo $precio=$_POST['precio'.$c];?>" >	<input type="hidden" name="mostrar" value="1" >  
      <?php	

if(isset($_POST['eli'.$c])){
$_POST['estado'.$c]=FALSE;
$up_cant=$ri[0]+$cant;
pg_fila("update stock1 SET cant=".$up_cant." where cod_libro=".$cod."");
}
echo'<input type="hidden" name="estado'.$c.'" value="'.$_POST['estado'.$c].'">';


$cmdSQL="Select codigo,descdic(1,id_genero),descdic(6,id_editor),id_titulo from tipos_libros where codigo=$cod order by id_genero ";

  $rows=pg_fila($cmdSQL); 

if($_POST['estado'.$c]){
	echo "<tr class='td'> 
          <td >".$cod."&nbsp; </td>
			<td >".$rows[1]."</td>
		  <td >".$rows[2]."</td>
 		  <td >".$rows[3]."</td>
          <td >".$cant."</td>
			<td >".$precio."</td>";
 echo"<td> <input type=submit name=eli".$c." value=Eliminar onClick=document.from.submit()>		 		 </td></tr>";

		  }
	
		   

$c++; 
 }	

if(isset($_POST['mas'])){
	if(isset($_POST['codigo']) && !empty($_POST['codigo'])){
		$cant=$_POST['cant'];
		$cod=$_POST['codigo'];
		$up_cant=$ri[0]-$cant;
if($up_cant<0||$cant==0){
echo"<SCRIPT >alert('no hay Stock')</SCRIPT>";
$cant=$_POST['cant']=0;
}else{

pg_fila("update stock1 SET cant=".$up_cant." where cod_libro=".$cod."");
		
		?>

<input type="hidden" name="codigo<?php echo $c; ?>" value="<?php echo $cod=$_POST['codigo'];?>" >
<input type="hidden" name="cant<?php echo $c; ?>" value="<?php echo $cant=$_POST['cant'];?>" >
<input type="hidden" name="precio<?php echo $c; ?>" value="<?php echo $precio=$_POST['precio'];?>" >
<input type="hidden" name="estado<?php echo $c; ?>" value="TRUE">
	  <?php
 

$cmdSQL="Select codigo,descdic(1,id_genero),descdic(6,id_editor),id_titulo from tipos_libros where codigo=$cod order by id_genero ";

  $rows=pg_fila($cmdSQL); 
	
	echo " <tr class='td'>
          <td >".$codigo."&nbsp;</td>
			<td >".$rows[1]."</td>
		  <td  >".$rows[2]."</td>
 		  <td >".$rows[3]."</td>
          <td >".$cant."</td>
			<td >".$precio."</td>";

		 
echo"<td> <input type=submit name=eli".$c." value=Eliminar onClick=document.from1.submit()>		 </td></tr>";
}	      
}
}?>

 </table><P>


 

<TABLE align="center" >
<TR>
	<TD colspan=7 bgcolor=#66CCFF> FORMAS DE PAGO</TD>
	</TR>
<TR>
	<TD>Cobrado</TD><TD><SELECT NAME="cobrado" >
	<option value="-1" <?php echo ($_POST['cobrado']==-1)?'selected':' ';?>>- -</option>
	<option value="1" <?php echo ($_POST['cobrado']==1)?'selected':' ';?>>No</option>
	<option value="2" <?php echo ($_POST['cobrado']==2)?'selected':' ';?>>Si</option>
	</SELECT></TD></TR>
	<TR><TD>Cant de cuotas</TD><TD><INPUT  TYPE="text" NAME="cant_cuotas" size="2" maxlength="2" value="<?php echo $_POST['cant_cuotas']?>"  onKeyPress="return soloNum(event)"></TD></TR>
	<TR><TD>Precio X cuota</TD><TD>$<INPUT  TYPE="text" NAME="precio_cuota" size="4" onKeyPress="return soloNumPto(event)" value="<?php echo $_POST['precio_cuota']?>" onBlur="document.form1.submit()"></TD></TR>
	<TR><TD>Vencimiento de 1º cuota</TD>
	<TD><INPUT  TYPE="text" size="13" NAME="vto_fecha" maxlength="10" onBlur="valFecha(this)" value=<?php   echo (isset($_POST['vto_fecha']))?$_POST['vto_fecha']:'dd/mm/aaaa';?>></TD></TR>
	 <TR><TD>Cobrar cada </TD><TD><INPUT  TYPE="text" NAME="dia_cada" value="<?php echo $_POST['dia_cada']?>" size="3"></TD></TR> 

<TR><TD>Total </TD><TD>$<INPUT   TYPE="text" NAME="total" size="5" onKeyPress="return soloNumPto(event)" value="<?php echo $_POST['total']?$_POST['total']:($_POST['precio_cuota']*$_POST['cant_cuotas'])?>"></TD>
</TR>
</TABLE>
  
 <CENTER><INPUT TYPE="image" SRC="images/guardar.gif" onclick="document.form1.action='gventa.php'" >
 <A HREF="javascript:document.location.href='venta.php'"><IMG SRC="images/limpiar.gif" WIDTH="100" HEIGHT="40" BORDER="0" ALT="Limpiar Formulario"></A></CENTER>
    <input type="hidden" name="form" value="venta">

  </form>
 
</td></tr>

</table>
<br>
</body>

</html>
