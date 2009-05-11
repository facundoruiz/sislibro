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

<script language="JavaScript">

// configuration variable for the hint object, these setting will be shared among all hints created by this object
var HINTS_CFG = {
	'wise'       : true, // don't go off screen, don't overlap the object in the document
	'margin'     : 10, // minimum allowed distance between the hint and the window edge (negative values accepted)
	'gap'        : -7, // minimum allowed distance between the hint and the origin (negative values accepted)
	'align'      : 'brtl', // align of the hint and the origin (by first letters origin's top|middle|bottom left|center|right to hint's top|middle|bottom left|center|right)
	'css'        : 'wrapped', // a style class name for all hints, applied to DIV element (see style section in the header of the document)
	'show_delay' : 200, // a delay between initiating event (mouseover for example) and hint appearing
	'hide_delay' : 500, // a delay between closing event (mouseout for example) and hint disappearing
	'follow'     : false, // hint follows the mouse as it moves
	'z-index'    : 100, // a z-index for all hint layers
	'IEfix'      : false, // fix IE problem with windowed controls visible through hints (activate if select boxes are visible through the hints)
	'IEtrans'    : ['blendTrans(DURATION=.3)'], // [show transition, hide transition] - transition effects, only work in IE5+
	'opacity'    : 90 // opacity of the hint in %%
};
// text/HTML of the hints
var HINTS_ITEMS = [
	wrap('Fecha de Realizada la venta','img/question.gif'),
	wrap('Numero de Chequera', 'img/question.gif'),
	wrap2('Datos Necesarios para registrar quien vendio y en caso de que corresponda quien cobrara la chequera'),
	wrap('Debe seleccionar un vendedor apareceran los nombres', 'img/question.gif'),
	wrap('Debe seleccionar un cobrador apareceran los Perfiles', 'img/warning.gif'),
	wrap('tooltip with the <a href="http://www.softcomplex.com">link</a>', 'img/question.gif'),
	wrap2('another wrapper'),
	wrap2('this one can stretch<br />both horizontally and vertically')
];

// this custom function receives what's unique about individual hint and wraps it in the HTML template
function wrap (s_text, s_icon) {
	return '<table><tr><td rowspan="2"><img src="' + s_icon + '"></td><td colspan="2"><img src="img/pixel.gif" width="1" height="15" border="0"></td></tr><tr><td background="img/2.gif" height="28" nowrap>' + s_text + '</td><td><img src="img/4.gif"></td></tr></table>';
}
// multiple templates/functions can be used in the same page
function wrap2 (s_text) {
	return [
		'<table>',
		'<tr><td><img src="img/corner_tl.gif" width="10" height="10" /></td><td style="background-image:url(img/side_t.gif)"></td><td><img src="img/corner_tr.gif" width="10" height="10" /></td></tr>',
		'<tr><td style="background-image:url(img/side_l.gif)"></td><td class="hintText">', s_text ,'</td><td style="background-image:url(img/side_r.gif)"></td></tr>',
		'<tr><td><img src="img/corner_bl.gif" width="10" height="10" /></td><td style="background-image:url(img/side_b.gif)"></td><td><img src="img/corner_br.gif" width="10" height="10" /></td></tr>',
		'</table>'
	].join('');
}

var myHint = new THints (HINTS_ITEMS, HINTS_CFG);
</script>

</head><body dir="ltr" lang="es" onload="<?php if(isset($_POST['OcultarEmpleados'])||$_POST['ME']==1){echo isset($_POST['MostrarEmpleados'])?"\t":"\tocultar('tbl_empleado');ocultar('tbl_cliente');"; } ?>">
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
     
	
	  <form  method="post" action="registro_ventas.php" name="form" ></td></tr>
<tr><td  valign="top">
<TABLE    border=0>

 <TR><TD onmouseover="myHint.show(0, this)" onmouseout="myHint.hide()">Fecha :</TD>	<TD><INPUT  TYPE="text" size="10" NAME="fecha" maxlength="10" onBlur="valFecha(this)" value=<?php echo (isset($_POST['fecha']))?$fecha=$_POST['fecha']:'';?>><script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form',
		// input name
		'controlname': 'fecha'
	});

	</script></TD></TR>
 <TR ><TD onmouseover="myHint.show(1, this)" onmouseout="myHint.hide()" >Nº de Chequera:</TD> <TD><INPUT  TYPE="text" NAME="n_chequera" size="4" onKeyPress="return soloNum(event)" value="<?PHP echo $_POST['n_chequera']?>">

 </TD></TR>
 	<?php  
	      $cmd= "select Max(idchequera)+1 from t_chequeras";
          $rows=pg_fila($cmd);
          $Max=empty($rows[0])?1:$rows[0];
		  ?>
	<TR>
	<TD><INPUT TYPE="hidden" name="id_chequera" value=<?php echo$Max?>></TD></TR>
 
 
 </TABLE>

 <div  class="t_user" valign="top" onmouseover="myHint.show(2, this)" onmouseout="myHint.hide()">Datos de la ventas <?PHP
if(isset($_POST['OcultarEmpleados'])||$_POST['ME']==1){
?> <input type="hidden" value="<?PHP echo isset($_POST['MostrarEmpleados'])?0:1; ?>" name="ME">
 <input type="submit" value="Mostrar" name="MostrarEmpleados" class="c_user">
 <?PHP }else{ ?>
 <input type="submit" value="Ocultar" name="OcultarEmpleados" class="c_datos">
 <?PHP } ?></div>
  <TABLE border=0 class="c_datos" id='tbl_empleado' align="center" >
  <!-- Empleado -->
<tr > <th  colspan="2" onmouseover="myHint.show(3, this)" onmouseout="myHint.hide()">
Vendedor
<?PHP      
			$gEmpleado=new gestorEmpleado($c);
 			$comboV=$gEmpleado->ComboVendedor();
			$comboV->__wakeup();
			echo $comboV->toString();
	        
   ?></th>
</tr>
<tr>
<td  colspan="2" class='c_datos' onmouseover="myHint.show(4, this)" onmouseout="myHint.hide()">Cobrador
<?PHP	 $grupo=new HtmlGrupo();
			$comboO=$gEmpleado->ComboOficios(true);
			$comboO->setOnChange('submit()');
			$comboO->__wakeup();
			$grupo->addControl($comboO);
			
if(isset($_POST['oficio'])&&!empty($_POST['oficio'])){ ?>


<?PHP  				
	
	  		
			$comboE=$gEmpleado->ComboEmpleado($_POST['oficio']);
   			$comboE->__wakeup();
			$grupo->addControl($comboE);
			
}
  	
  echo $grupo->toString();
	
			
?></td>
    </tr>
</TABLE>

 <!-- Fin empleado -->
 <!-- onclick="javascript:show_hide_menus('cliente')" -->
 <div class="t_user"><CENTER>Cliente <?php echo ((isset($_POST['dni'])and !empty($_POST['dni']))||isset($_SESSION['cliente']))?'Cargado':'Vacio' ?></CENTER></div>
 <table class="c_datos" id="tbl_cliente">
 
     <?php  
     		$dni= $_POST['dni'];
			
     		if(isset($_POST['limpiar']))
					{      
			$dni='';			
						
					}
     
	            
				
			            
	          if(!empty($dni))
					{      
				$gConexion=new gestorConexion();		        
	           	$gcliente=new gestorCliente($gConexion);
				$cliente=$gcliente->get_clienteDni($dni);
				
				}
				
							
	  ?> 
  	  
	  <?php if(empty($dni)&&$cliente==0)
	      {?> 
	    <tr>		  
      <th  scope="row" class="rotulo">DNI</th>	  
      <td >	  	
		<input type="text" name="dni" maxlength="8" onKeyPress="return soloNum(event)"  title="Ingrese el DNI" onBlur="document.form.submit()" value="<?php echo $dni ?>" >	
		 </td>
    </tr>	    

	      <?PHP }else{
	      			if($cliente==0){
	      	?>
		<!-- NO EXITE PASA POR AQUI -->      	
  <tr>		  
      <th  scope="row" class="rotulo">DNI</th>	  
      <td >	  
<input type="text" name="dni"   value="<?php echo isset($_POST['dni'])?$_POST['dni']:''; ?>" >	
<INPUT TYPE="hidden" name="id_clientes"  value="<?PHP echo isset($_POST['id'])?$_POST['id_clientes']:'' ?>">
<?PHP if($cliente!=0){?>
<INPUT TYPE="hidden" name="existe"  value="1">
<?} ?>
</td>
    </tr>
 
     <tr>
      <th scope="row"  class="rotulo">Apellido</th>
      <td ><input type="text"   maxlength="30" name="apellido" title="Ingrese el Apellido" value="<?php echo isset($_POST['apellido'])?strtoupper ($_POST['apellido']):'' ?>"></td>
    </tr>
       <tr>
       <th scope="row" class="rotulo" >Nombre</th>
         <td ><input type="text"   maxlength="30" name="nombre" title="Ingrese el Nombre" value="<?php echo isset($_POST['nombre'])?strtoupper ($_POST['nombre']):''  ?>"></td>
      </tr>
    <tr>
       <th scope="row" class="rotulo" >Domicilio</th>
         <td ><input type="text"   maxlength="100" name="domicilio" title="Ingrese el Domicilio" value="<?php echo isset($_POST['domicilio'])?strtoupper ($_POST['domicilio']):''  ?>"></td>
      </tr>
 <tr>
       <th scope="row" class="rotulo">Telefono</th>
         <td ><input type="text"    onKeyPress="return soloNum(event)" name="telefono" title="Ingrese el Telefeno" value="<?php echo isset($_POST['telefono'])?$_POST['telefono']:''  ?>" maxlength="7"></td>
      </tr>	
	    <tr>
      <th scope="row" class="rotulo">Celular(*)</th>
        <td ><input type="text"  onKeyPress="return soloNum(event)" name="cel" title="Ingrese el Telefeno" value="<?php echo isset($_POST['cel'])?$_POST['cel']:''  ?>" maxlength="10"> </td>
   </tr>	
	 <tr>
   <th scope="row" class="rotulo">Provincia</th>
   <td  align="left"><select name="prov"   onChange="document.form.submit()">
    <option value="-1" >-- Provincia --</option>
 <?php 	$qprov="select idprovincia,descrip from t_provincias  order by descrip desc";
		$rprov=pg_query($qprov);
		$Prov=isset($_POST['prov'])?$_POST['prov']:0;
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
		$loc=isset($_POST['Loc'])?$_POST['Loc']:0; 
		while ($aLoc=pg_fetch_array($rLoc)){	
			
			?>
<option value="<?php echo $aLoc['idlocalidad'];?>"<?php echo($loc==$aLoc['idlocalidad'])?'selected':'';?>><?php echo $aLoc['descrip'];?>   </option><?php }?>
</select><br><A HREF="a_localidad.php" CLASS="button">&nbsp;Cargar Localidades</A></td>
    </tr>
<tr>
    <th scope="row" class="rotulo">Barrio</th>
 <td width="281"><input type="text"   name="barrio"   title="Ingrese el Barrio" value="<?php echo isset($_POST['barrio'])?strtoupper($_POST['barrio']):'' ?>"></td>
   </tr>
   <tr>
 <th scope="row" class="rotulo">Moroso</th>
 <td > 
<select name="moroso"  >
 <option value="1"  <?php if(isset($_POST['moroso'])){
							echo $_POST['moroso']==1?'selected':'';
						  					 } ?>>No es moroso</option>
 <option value="2"  <?php if(isset($_POST['moroso'])){
							echo $_POST['moroso']==2?'selected':'';
						  			 } ?>>SI es Moroso  </option>
</select>

</td>
   </tr>
   <tr>
    <th scope="row" class="rotulo">Observacion</th>
 <td ><TEXTAREA name="obs" ROWS="5"    COLS="25" class="datos"><?php echo isset($_POST['obs'])?strtoupper ($_POST['obs']):''  ?></TEXTAREA></td>
   </tr><tr>
<td colspan="2"  >(*)se coloca el numero sin 0 y sin 15 ej: 0<B>381</B>15<B>4498244</B> </td>
	</tr>
	      	
	     <? }else{
	     ?><tr><td><?	
	     	//$cliente=unserialize($_SESSION['cliente']);
			$ic=new interfazCliente();
	     	echo $ic->mostrar_cliente($cliente);
?>
		<INPUT TYPE="hidden" name="id_clientes"  value="<?PHP echo $cliente->get_id_cliente()?>">
		<INPUT TYPE="hidden" name="existe"  value="1">
		<INPUT TYPE="hidden" name="dni"  value="<?PHP echo $cliente->get_dni()?>">
	<?    		}
	      }?>

</td></tr>
<tr><td><input type="submit" name="limpiar" value="Limpiar Cliente" class="button" ></td>
</tr> 
 
	 <!-- FIN cliente -->
</table>	
</td>
 
<td valign=top>
<div class="t_user">LIBROS     </div>
(*)Para que funcione el campo codigo, la seleccion de titulo debe estar vacia.<a href="libros_alta.php" target="_blank" class="button">Cargar Libros</a>
<table width="530" border="1" class="c_user">
        
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
	  <select name="Tipo"   onchange="document.form.submit()">
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
</td>

<td>
<select name="editorial"  onchange="document.form.submit()">
	  		 <option value="-1">---Seleccione editorial </option>
			<?php 
			
				$tgenero=isset($_POST['Tipo'])?$_POST['Tipo']:0;
				$qeditorial="select distinct * from f_dame_editorial_genero($tgenero)";
				$reditorial=pg_query($qeditorial);
				
				while ($aeditorial=pg_fetch_array($reditorial)){
			?>
      <option value="<?php echo $aeditorial['ideditorial'];?>" <?php echo ($_POST['editorial']==$aeditorial['ideditorial'])?'selected':'';?>><?php echo $aeditorial['descrip'];?>
			<?php }?>
          </select> 
</td>

<td>
<select name="titulo"  onchange="document.form.submit()">
	  		 <option value="-1">---Seleccione Titulo </option>
			<?php 
		
			 $teditorial=isset($_POST['editorial'])?$_POST['editorial']:0;
	$qtitulo="select j.codigo ,t.descrip as id_titulo from t_editoriales e
inner join t_ejemplares j on(e.ideditorial=j.ideditorial)
inner join t_libros t on(t.idlibro=j.idtitulo)
where j.idgenero=$tgenero and j.ideditorial=$teditorial order by(t.descrip)";
			$rtitulo=pg_query($qtitulo);
			
			while ($atitulo=pg_fetch_array($rtitulo)){
			?>
     <option value="<?php echo $atitulo['codigo'];?>" <?php echo ($_POST['titulo']==$atitulo['codigo'])?'selected':'';?>>
     <?php echo $atitulo['id_titulo'];?>
			<?php }?>
          </select> 
</td><td><? //$ri=$_POST['titulo']?pg_fila("select cant from stock1 where cod_libro=".$_POST['titulo'].""):0;
			//echo$ri!=0?$ri[0]:0
			
?><td>
</tr>
<?php  $_POST['codigo']=($_POST['titulo']!=-1)?$_POST['titulo']:$_POST['codigo']?> 
        <tr>
<td><input type="text" name="codigo" onKeyPress="return soloNum(event)"  title="Ingrese el Codigo de Libro" onBlur="document.form.submit()" size="4" value=<?php echo$_POST['codigo']?>></td>
<?php 
	if(!empty($_POST['codigo'])||$_POST['codigo']!=0){
		$codigo=$_POST['codigo'];
		$sql="Select  * from f_desc_ejemplares($codigo)  ";	 
 		$rows=pg_fila($sql);
			if( $rows==0){
				echo"<SCRIPT> alert('No existe este ".$codigo." codigo ')</SCRIPT>";
				$_POST['codigo']='' ;
			}
 
			echo"<td>".$rows[1]."</td>";
			echo"<td>". $rows[2]."</td>"; 
			echo"<td>".$rows[3]."</td>"; 
/*echo"<td><SELECT NAME='cant'> ";
$ri=pg_fila("select cant from stock1 where cod_libro=".$rows[0]."");
if($ri[0]!=0){
for($i=1;$i<=$ri[0];$i++){ echo "<OPTION VALUE=".$i." >".$i."";  }

}else{
echo"<OPTION VALUE=0 >0";
$_POST['codigo']='';
echo"<SCRIPT >alert('no hay Stock')</SCRIPT>";
echo"</SELECT></td>";
 }*/
?>
<td><input type="text" name="cant"  size="3" onKeyPress="return soloNum(event)" value="1"></td>
   <!-- precio -->
<td><input type="text" name="precio"  size="3" onKeyPress="return soloNumPto(event)"></td>
			<?php }?>
 </tr>

 </table>
 <input type="submit" name="mas" value="agregar" onClick="document.from1.submit()" class="button">&nbsp;&nbsp;
 <P>
 <P>
 <table  border="0">
<?php if((isset($_POST['mas']) && !empty($_POST['codigo']))||$_POST['mostrar']==1){?>
<table width="558" border="1" class="c_user" align="center">
<tr > 
<td  colspan="8" bgcolor=#99CC99 class='c_user' align="center">DETALLE</td></tr>
   <tr >
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
	<input type="hidden" name="precio<?php echo $c; ?>" value="<?php echo $precio=$_POST['precio'.$c];?>" >	
	<!-- <input type="hidden" name="mostrar" value="1" > -->  
      <?php	

if(isset($_POST['eli'.$c])){
$_POST['estado'.$c]=FALSE;
/*$up_cant=$ri[0]+$cant;
pg_fila("update stock1 SET cant=".$up_cant." where cod_libro=".$cod."");
*/

}
echo'<input type="hidden" name="estado'.$c.'" value="'.$_POST['estado'.$c].'">';


$cmdSQL="Select  * from f_desc_ejemplares($cod)  ";

  $rows=pg_fila($cmdSQL); 

if($_POST['estado'.$c]){
	echo "<tr class='td'> 
          <td >".$cod."&nbsp; </td>
			<td >".$rows[1]."</td>
		  <td >".$rows[2]."</td>
 		  <td >".$rows[3]."</td>
          <td >".$cant."</td>
			<td >".$precio."</td>";
 echo"<td> <input type=submit name=eli".$c." value=Eliminar onClick=document.from.submit()> </td></tr>";

		  }
	
		  

$c++; 
 }	

if(isset($_POST['mas'])){
	if(isset($_POST['codigo']) && !empty($_POST['codigo'])){
		$cant=$_POST['cant'];
		$cod=$_POST['codigo'];
	/*	$up_cant=$ri[0]-$cant;
if($up_cant<0||$cant==0){
echo"<SCRIPT >alert('no hay Stock')</SCRIPT>";
$cant=$_POST['cant']=0;
}else{

pg_fila("update stock1 SET cant=".$up_cant." where cod_libro=".$cod."");
		*/
		?>

<input type="hidden" name="codigo<?php echo $c; ?>" value="<?php echo $cod=$_POST['codigo'];?>" >
<input type="hidden" name="cant<?php echo $c; ?>" value="<?php echo $cant=$_POST['cant'];?>" >
<input type="hidden" name="precio<?php echo $c; ?>" value="<?php echo $precio=$_POST['precio'];?>" >
<input type="hidden" name="estado<?php echo $c; ?>" value="TRUE">
	  <?php
 

$cmdSQL="Select  * from f_desc_ejemplares($cod)  ";

  $rows=pg_fila($cmdSQL); 
	
	echo " <tr >
          <td >".$codigo."&nbsp;</td>
			<td >".$rows[1]."</td>
		  <td  >".$rows[2]."</td>
 		  <td >".$rows[3]."</td>
          <td >".$cant."</td>
			<td >".$precio."</td>";

		 
echo"<td> <input type=submit name=eli".$c." value=Eliminar onClick=document.from1.submit()>		 </td></tr>";
//}	      
}
}?>

 </table><P>    

 

<TABLE align="center" >
<TR>
	<TD colspan=3 bgcolor=#66CCFF>PLAN EN CUOTAS</TD>
	</TR>
<TR>
	<TD>Primera cuota se cobro</TD><TD><SELECT NAME="cobrado" OnChange="document.form.submit()">
	<option value="-1" <?php echo ($_POST['cobrado']==-1)?'selected':' ';?>>- seleccione -</option>
	<option value="1" <?php echo ($_POST['cobrado']==1)?'selected':' ';?>>No </option>
	<option value="2" <?php echo ($_POST['cobrado']==2)?'selected':' ';?>>Si </option>
		<option value="3" <?php echo ($_POST['cobrado']==3)?'selected':' ';?>>Adelanto</option>
	</SELECT>
	<?php  if($_POST['cobrado']==3){?>
		$<input type="text"  name="adelanto" size="4" onKeyPress="return soloNumPto(event)" value="<?php echo $_POST['adelanto']?>" >';
	<?PHP }?>
	</TD></TR>
	
	<TR><TD>Cant de cuotas</TD><TD><INPUT  TYPE="text" NAME="cant_cuotas" size="2" maxlength="2" value="<?php echo $_POST['cant_cuotas']?>"  onKeyPress="return soloNum(event)"></TD></TR>
	<TR><TD>Precio X cuota</TD><TD>$<INPUT  TYPE="text" NAME="precio_cuota" size="4" onKeyPress="return soloNumPto(event)" value="<?php echo $_POST['precio_cuota']?>" onBlur="document.form.submit();"></TD></TR>
	<TR><TD>Vto de 1º cuota</TD>
	<TD><INPUT  TYPE="text" size="10" NAME="vto_fecha" maxlength="10" onBlur="valFecha(this)" value=<?php   echo (isset($_POST['vto_fecha']))?$_POST['vto_fecha']:'';?>>
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form',
		// input name
		'controlname': 'vto_fecha'
	});

	</script>
	</TD>
	</TR>
	 <TR><TD>Cobrar cada </TD><TD><INPUT  TYPE="text" NAME="dia_cada" value="<?php echo $_POST['dia_cada']?>" size="3"> dias</TD></TR> 

<TR><TD>Total </TD><TD>$<INPUT   TYPE="text" NAME="total" size="5" onKeyPress="return soloNumPto(event)" value="<?php echo $_POST['total']?$_POST['total']:($_POST['precio_cuota']*$_POST['cant_cuotas'])?>"></TD>
</TR>
</TABLE>
  
 <CENTER><INPUT TYPE="submit"  onclick="document.form.action='registro_guardar_ventas.php'" class="button" >
 <A HREF="javascript:document.location.href='registro_ventas.php'" class="button">Limpiar Formulario</A></CENTER>
    <input type="hidden" name="formu" value="registro_ventas">

  </form>
 
</td></tr>

</table>
<br>
</body>

</html>
