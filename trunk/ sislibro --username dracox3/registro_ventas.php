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
/*if(!isset($_POST['id_venta'])){
//$qcant="select cod_libro,cant,costo from stock";
		$rcant=pg_query($qcant);
while ($acant=pg_fetch_array($rcant)){
//pg_fila("update stock1 SET cant=".$acant[1].",costo=".$acant[2]." where cod_libro=".$acant[0]."");
}

}*/
?>

<body >

<table border="0" width="528" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="100%" valign="top" colspan="2">
     
	
	  <form  method="post" action="registro_ventas.php" name="form1" ></td></tr>
<tr><td  valign="top">
<TABLE    border=0>

 <TR><TD>Fecha :</TD>	<TD><INPUT  TYPE="text" size="13" NAME="fecha" maxlength="10" onBlur="valFecha(this)" value=<?php echo (isset($_POST['fecha']))?$fecha=$_POST['fecha']:'dd/mm/aaaa';?>></TD></TR>
 <TR><TD>Nº de Chequera:</TD> <TD><INPUT  TYPE="text" NAME="n_chequera" size="4" onKeyPress="return soloNum(event)" value="<?PHP echo $_POST['n_chequera']?>"></TD></TR>
 	<?php  
	      $cmd= "select Max(idchequera)+1 from t_chequeras";
          $rows=pg_fila($cmd);
          $Max=empty($rows[0])?1:$rows[0];
		  ?>
	<TR>
	<TD><INPUT TYPE="hidden" name="id_chequera" value=<?php echo$Max?>></TD></TR>
 
 
 </TABLE>

<tr><td valign="top">

 <TABLE border=0 class="c_user" >
  <!-- Empleado -->
<tr > <th colspan="2" class="t_user">Datos de la ventas
<?PHP 
			$gEmpleado=new gestorEmpleado($c);
 
			$comboO=$gEmpleado->ComboOficios();
			$comboO->__wakeup();
	echo $comboO->toString();
	
   ?></th>
</tr>

<?PHP	if(isset($_POST['oficio'])){ ?>
<tr>
<td  colspan="2" class='c_datos'>Seleccione
<?PHP
			
	  $grupo=new HtmlGrupo();
	  		
			$combov=$gEmpleado->ComboEmpleado($_POST['oficio']);
   			$combov->__wakeup();
			$grupo->addControl($combov);
		   $agregarE= new HtmlBoton("Agregar Empleado","agregarE",true,"submit");
		   $agregarE->setfull(true);
		   $agregarE->setClassEstilo('CLASS="button"');
   $agregarE->setScript('onClick="javascript:document.form1.submit()"');
  			$grupo->addControl($agregarE);
  	
  echo $grupo->toString();
	
			}
?></td>
    </tr>
<tr>
<td>
<table  border="0" class="c_datos">
<?php if((isset($_POST['agregarE'])&& !empty($_POST['empleado']))||$_POST['mostrar_empleados']==1 ){?>

<tr > 
<td  colspan="4" class="t_datos">DETALLE</td></tr>
   <tr class="rotulo" >
          <td  >Empleado</td>
		  <td  >Oficio</td>
          <td  >eliminar</td>
		  <input type="hidden" name="mostrar_empleados" value="1" > 
         </tr>
   <?php }
$c=1;
while ($_POST['empleado_'.$c]){
?>
     <input type="hidden" name="empleado_<?php echo$c; ?>" value="<?php echo $empleadoE=$_POST['empleado_'.$c];?>" >
     <input type="hidden" name="oficio_<?php echo $c; ?>" value="<?php echo $oficio=$_POST['oficio_'.$c];?>" >
	 <?php	

if(isset($_POST['eliminarE'.$c])){
$_POST['estadoEmpleado'.$c]=FALSE;
}
echo'<input type="hidden" name="estadoEmpleado'.$c.'" value="'.$_POST['estadoEmpleado'.$c].'">';

if($_POST['estadoEmpleado'.$c]){
	echo "<tr class='c_datos'> ";
          $obj_empleado=$gEmpleado->get_EmpleadoId($empleadoE);
		echo "<td>".$obj_empleado->get_nombre().",".$obj_empleado->get_apellido()."</td>";
		echo "<td>".$obj_empleado->get_oficio()."</td>";
		echo"<td> <input type=submit name=eliminarE".$c." value='Eliminar' onClick='document.from1.submit()' class='button'></td></tr>";

		  }
	
		   

$c++; 
 }	

if(isset($_POST['agregarE'])){
	if(isset($_POST['empleado']) && !empty($_POST['empleado'])){
		$oficio=$_POST['oficio'];
						
		?>

<input type="hidden" name="empleado_<?php echo $c; ?>" value="<?php echo $empleado=$_POST['empleado'];?>" >
<input type="hidden" name="oficio_<?php echo $c; ?>" value="<?php echo $oficio=$_POST['oficio'];?>" >
<input type="hidden" name="estadoEmpleado<?php echo $c; ?>" value="TRUE">
	  <?php
 
$empleadoE=$gEmpleado->get_EmpleadoId($empleado);
echo "<tr class='c_datos'> ";
          $obj_empleadoE=$gEmpleado->get_EmpleadoId($empleado);
//echo "<td>".$empleadoE->get_id_empleado()."</td>";
echo "<td>".$obj_empleadoE->get_nombre().",".$obj_empleadoE->get_apellido()."</td>";
echo "<td>".$obj_empleadoE->get_oficio()."</td>";
echo"<td> <input type=submit name=eliminarE".$c." value='Eliminar' onClick='document.from1.submit()' class='button'> </td></tr>";
}	      

}
?>
</table>
</td></tr>
 </table>
 <!-- Fin empleado -->
 
 
 <table class="c_user">
  <tr ><th width="99" class="t_user" scope="row" colspan="3"><CENTER>Cliente</CENTER></th></tr>
     <?php     
	            $dni= $_POST['dni'];
				
			            
	          if(!empty($dni))
					{      
				$gConexion=new gestorConexion();		        
	           	$gcliente=new gestorCliente($gConexion);
				$cliente=$gcliente->get_clienteDni($dni);
			
				}
				
							
	  ?> 
   <tr>		  
      <th  scope="row" class="rotulo">DNI</th>	  
      <td  >	  	  
	  <?php if(empty($dni)&&$cliente==0)
	      {?>	
	      	<input type="text" name="dni" maxlength="8" onKeyPress="return soloNum(event)"  title="Ingrese el DNI" onBlur="document.form1.submit()" value="<?php echo $dni ?>" >	
		 </td>
    </tr>	    

	      <?PHP }else{?>
			
			<!-- SI EXITE PASA POR AQUI -->
  
<input type="text" name="dni"   value="<?php echo isset($_POST['dni'])?$_POST['dni']:$cliente->get_dni(); ?>" readonly >	
<INPUT TYPE="hidden" name="id"  value="<?PHP echo isset($_POST['id'])?$_POST['id']:$cliente->get_id_cliente() ?>">
</td>
    </tr>
 
     <tr>
      <th scope="row"  class="rotulo">Apellido</th>
      <td ><input type="text"   maxlength="30" name="apellido" title="Ingrese el Apellido" value="<?php echo isset($_POST['apellido'])?strtoupper ($_POST['apellido']):$cliente->get_apellido(); ?>"></td>
    </tr>
       <tr>
       <th scope="row" class="rotulo" >Nombre</th>
         <td ><input type="text"   maxlength="30" name="nombre" title="Ingrese el Nombre" value="<?php echo isset($_POST['nombre'])?strtoupper ($_POST['nombre']):$cliente->get_nombre();  ?>"></td>
      </tr>
    <tr>
       <th scope="row" class="rotulo" >Domicilio</th>
         <td ><input type="text"   maxlength="100" name="domicilio" title="Ingrese el Domicilio" value="<?php echo isset($_POST['domicilio'])?strtoupper ($_POST['domicilio']):$cliente->get_domicilio();  ?>"></td>
      </tr>
 <tr>
       <th scope="row" class="rotulo">Telefono</th>
         <td ><input type="text"    onKeyPress="return soloNum(event)" name="telefono" title="Ingrese el Telefeno" value="<?php echo isset($_POST['telefono'])?$_POST['telefono']:$cliente->get_telefono();  ?>" maxlength="7"></td>
      </tr>	
	    <tr>
      <th scope="row" class="rotulo">Celular(*)</th>
        <td ><input type="text"  onKeyPress="return soloNum(event)" name="cel" title="Ingrese el Telefeno" value="<?php echo isset($_POST['cel'])?$_POST['cel']:$cliente->get_celular();  ?>" maxlength="10"> </td>
   </tr>	
	 <tr>
   <th scope="row" class="rotulo">Provincia</th>
   <td  align="left"><select name="prov"   onChange="document.form1.submit()">
    <option value="-1" >-- Provincia --</option>
 <?php 	$qprov="select idprovincia,descrip from t_provincias  order by descrip desc";
		$rprov=pg_query($qprov);
		$Prov=isset($_POST['prov'])?$_POST['prov']:$cliente->get_provincia();
		while ($aprov=pg_fetch_array($rprov)){	
			
			?>
<option value="<?php echo $aprov['idprovincia'];?>"<?php echo($Prov==$aprov['idprovincia'])?'selected':'';?>><?php echo $aprov['descrip'];?>   </option><?php }?>
</select></td>
    </tr>    
 
   <tr>
   <th scope="row" class="rotulo">Localidad</th>
   <td  align="left"><select name="Loc"    >
    <option value="-1" >-- Localidad --</option>
 <?php 	$qLoc="select idlocalidad,descrip from t_localidades where idprovincia=".$Prov." order by descrip asc";
		$rLoc=pg_query($qLoc);
		$loc=isset($_POST['Loc'])?$_POST['Loc']:$cliente->get_localidad(); 
		while ($aLoc=pg_fetch_array($rLoc)){	
			
			?>
<option value="<?php echo $aLoc['idlocalidad'];?>"<?php echo($loc==$aLoc['idlocalidad'])?'selected':'';?>><?php echo $aLoc['descrip'];?>   </option><?php }?>
</select><br><A HREF="a_localidad.php" CLASS="button">&nbsp;Cargar Localidades</A></td>
    </tr>
<tr>
    <th scope="row" class="rotulo">Barrio</th>
 <td width="281"><input type="text"   name="barrio"   title="Ingrese el Barrio" value="<?php echo isset($_POST['barrio'])?strtoupper($_POST['barrio']):$cliente->get_barrio();  ?>"></td>
   </tr>
   <tr>
 <th scope="row" class="rotulo">Moroso</th>
 <td > 
<select name="moroso"   onChange="document.form1.submit()">
 <option value="1"  <?php if(isset($_POST['moroso'])){
							echo $_POST['moroso']==1?'selected':'';
						  }else{ 
							 echo($cliente->get_moroso()==1)?'selected':'';
							 } ?>>No es moroso</option>
 <option value="2"  <?php if(isset($_POST['moroso'])){
							echo $_POST['moroso']==2?'selected':'';
						  }else{ 
							 echo($cliente->get_moroso()==2)?'selected':'';
							 } ?>>SI es Moroso  </option>
</select>

</td>
   </tr>
   <tr>
    <th scope="row" class="rotulo">Observacion</th>
 <td ><TEXTAREA name="obs" ROWS="5"    COLS="25"><?php echo isset($_POST['obs'])?strtoupper ($_POST['obs']):$cliente->get_obs();  ?></TEXTAREA></td>
   </tr><tr>
<td colspan="2"  >(*)se coloca el numero sin 0 y sin 15 ej: 0<B>381</B>15<B>4498244</B> </td>
	</tr>

 

	<?php }?>


 
 </td>
     </tr>
	 <!-- FIN cliente -->
</table>	
</td>
 
<td >
<div class="t_user">LIBROS     </div>
(*)Para que funcione el campo codigo, la seleccion de titulo debe estar vacia.
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
			$qtipo="select idgenero as item,descrip from t_generos  order by(descrip)";
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
				$qeditorial="select * from f_dame_editorial_genero($tgenero)";
				$reditorial=pg_query($qeditorial);
				while ($aeditorial=pg_fetch_array($reditorial)){
			?>
            <option value="<?php echo $aeditorial['ideditorial'];?>" <?php echo ($_POST['editorial']==$aeditorial['ideditorial'])?'selected':'';?>
			><?php echo $aeditorial['descrip'];?>
			<?php }?>
          </select> 
</td>

<td>
<select name="titulo"  onchange="document.form1.submit()">
	  		 <option value="-1">---Seleccione Titulo </option>
			<?php 
			 $teditorial=isset($_POST['editorial'])?$_POST['editorial']:0;
	echo$qtitulo="select j.codigo ,t.descrip as id_titulo from t_editoriales e
inner join t_ejemplares j on(e.ideditorial=j.ideditorial)
inner join t_libros t on(t.idlibro=j.idtitulo)
where j.idgenero=$tgenero and j.ideditorial=$teditorial";
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
 <A HREF="javascript:document.location.href='registro_ventas.php'"><IMG SRC="images/limpiar.gif" WIDTH="100" HEIGHT="40" BORDER="0" ALT="Limpiar Formulario"></A></CENTER>
    <input type="hidden" name="form" value="venta">

  </form>
 
</td></tr>

</table>
<br>
</body>

</html>
