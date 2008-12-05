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



</head>
<form  method="post" action="" name="form1" >
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
</td>

<td>
<select name="editorial"  onchange="document.form1.submit()">
	  		 <option value="-1">---Seleccione editorial </option>
			<?php 
			
				$tgenero=isset($_POST['Tipo'])?$_POST['Tipo']:0;
				echo $qeditorial="select * from f_dame_editorial_genero($tgenero)";
				$reditorial=pg_query($qeditorial);
				
				while ($aeditorial=pg_fetch_array($reditorial)){
			?>
      <option value="<?php echo $aeditorial['ideditorial'];?>" <?php echo ($_POST['editorial']==$aeditorial['ideditorial'])?'selected':'';?>><?php echo $aeditorial['descrip'];?>
			<?php }?>
          </select> 
</td>

<td>
<select name="titulo"  onchange="document.form1.submit()">
	  		 <option value="-1">---Seleccione Titulo </option>
			<?php 
		
			 $teditorial=isset($_POST['editorial'])?$_POST['editorial']:0;
	$qtitulo="select j.codigo ,t.descrip as id_titulo from t_editoriales e
inner join t_ejemplares j on(e.ideditorial=j.ideditorial)
inner join t_libros t on(t.idlibro=j.idtitulo)
where j.idgenero=$tgenero and j.ideditorial=$teditorial";
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
<td><input type="text" name="codigo" onKeyPress="return soloNum(event)"  title="Ingrese el Codigo de Libro" onBlur="document.form1.submit()" size="4" value=<?php echo$_POST['codigo']?>></td>
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
<td><input type="text" name="cant"  size="3" onKeyPress="return soloNum(event)"></td>
   <!-- precio -->
<td><input type="text" name="precio"  size="3" onKeyPress="return soloNumPto(event)"></td>
			<?php }?>
 </tr>

 </table>
 <input type="submit" name="mas" value="agregar" onClick="document.from1.submit()">&nbsp;&nbsp;<a href="libros_alta.php" target="_blank">Cargar Libros</a>
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
</from>



















<?PHP 
			$gEmpleado=new gestorEmpleado($c);
 
			$comboO=$gEmpleado->ComboOficios();
			$comboO->__wakeup();
	echo $comboO->toString();
	
   ?></th>
</tr>

<?PHP	if(isset($_POST['oficio'])&&!empty($_POST['oficio'])){ ?>
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
<table  border="0" class="c_datos" id='tbl_empleado'>
<?php if((isset($_POST['agregarE'])&& !empty($_POST['empleado']))||$_POST['mostrar_empleados']==1 ){?>

<tr > 
<td  colspan="4" class="t_datos" id='tbl_empleado'>DETALLE</td></tr>
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


