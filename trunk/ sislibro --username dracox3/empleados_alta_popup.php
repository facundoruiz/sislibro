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
<form  method="post" action="" name="form1">
	<?PHP if(isset($_GET['dato'])||isset($_POST['dato'])){
	$id_empleado=isset($_GET['dato'])?$_GET['dato']:$_POST['dato'];
			$gEmpleado=new gestorEmpleado($c);
			$empleado=$gEmpleado->get_EmpleadoId($id_empleado);
			
		
		$b=1;
}else{
	$b=0;
  			$dni= $_POST['dni'];
				
				if(!empty($dni))
					{              
	       $gEmpleado=new gestorEmpleado($c);
			$empleado=$gEmpleado->get_EmpleadoDni($dni);
				}?>
<input type="hidden" name="form" value="empleados_alta_popup"> 
<? }?>

   
 <div class="t_datos"><div class="titulos"> <?PHP echo (isset($_GET['dato'])||isset($_POST['dato']))?'Modificar Empleados':'Carga Empleados'?> 
   </div></div>
   


 <TABLE align="center">
    
   <tr>		  
      <th   scope="row">DNI</th>	  
      <td  >	  	  
	  <?  
	  
	  if(empty($dni)&&$empleado==0) {?>     
	  <input type="text" name="dni"   maxlength="8" onKeyPress="return soloNum(event)"  title="Ingrese el DNI" onBlur="document.form1.submit()" value="<?php echo $dni?>">	
		 </td>
    </tr>				
	  <?php }else{?>
	  <input type="text" name="dni"   value="<?php echo isset($_POST['dni'])?$_POST['dni']:$empleado->get_dni(); ?>" readonly>	
<INPUT TYPE="hidden" name="id" value="<?PHP echo isset($_POST['id'])?$_POST['id']:$empleado->get_id_empleado() ?>">
		   </td>
    </tr>
 <th  scope="row">Num de empleado</th>	  
      <td >			
		<input type="text" name="num" onKeyPress="return soloNum(event)" maxlength="3" onBlur="document.form1.submit()" value="<?php echo isset($_POST['num'])?$_POST['num']:$empleado->get_num_empleado();  ?>" >	
		</td>
    </tr>	
     <tr>
      <th>Apellido</th>
      <td ><input type="text"  maxlength="30" name="apellido" title="Ingrese el Apellido" value="<?php echo isset($_POST['apellido'])?strtoupper ($_POST['apellido']):$empleado->get_apellido(); ?>"></td>
    </tr>
       <tr>
       <th scope="row">Nombre</th>
         <td ><input type="text"   maxlength="30" name="nombre" title="Ingrese el Nombre" value="<?php echo isset($_POST['nombre'])?strtoupper ($_POST['nombre']):$empleado->get_nombre();  ?>"></td>
      </tr>
    <tr>
       <th scope="row" >Domicilio</th>
         <td ><input type="text"   maxlength="100" name="domicilio" title="Ingrese el Domicilio" value="<?php echo isset($_POST['domicilio'])?strtoupper ($_POST['domicilio']):$empleado->get_domicilio();  ?>"></td>
      </tr>
 <tr>
       <th scope="row" >Telefono</th>
         <td ><input type="text" onKeyPress="return soloNum(event)" name="telefono" title="Ingrese el Telefeno" maxlength="7" value="<?php echo isset($_POST['telefono'])?$_POST['telefono']:$empleado->get_telefono();  ?>"></td>
      </tr>	
	    <tr>
      <th scope="row">Celular(*)</th>
        <td ><input type="text"  onKeyPress="return soloNum(event)" name="cel" title="Ingrese el Telefeno" value="<?php echo isset($_POST['cel'])?$_POST['cel']:$empleado->get_celular();  ?>" maxlength="10"> </td>
   </tr>	
	 <tr>
   <th scope="row" >Provincia</th>
   <td  align="left"><select name="prov" onChange="document.form1.submit()">
    <option value="-1" >-- Provincia --</option>
 <?php 	$qprov="select idprovincia,descrip from t_provincias  order by descrip desc";
		$rprov=pg_query($qprov);
		$Prov=isset($_POST['prov'])?$_POST['prov']:$empleado->get_provincia();
		while ($aprov=pg_fetch_array($rprov)){	
			
			?>
<option value="<?php echo $aprov['idprovincia'];?>"<?php echo($Prov==$aprov['idprovincia'])?'selected':'';?>><?php echo $aprov['descrip'];?>   </option><?php }?>
</select></td>
    </tr>    
 
   <tr>
   <th scope="row" >Localidad</th>
   <td  align="left"><select name="Loc"   >
    <option value="-1" >-- Localidad --</option>
 <?php 	$qLoc="select idlocalidad,descrip from t_localidades where idprovincia=".$Prov." order by descrip asc";
		$rLoc=pg_query($qLoc);
		$loc=isset($_POST['Loc'])?$_POST['Loc']:$empleado->get_localidad(); 
		while ($aLoc=pg_fetch_array($rLoc)){	
			
			?>
<option value="<?php echo $aLoc['idlocalidad'];?>"<?php echo($loc==$aLoc['idlocalidad'])?'selected':'';?>><?php echo $aLoc['descrip'];?>   </option><?php }?>
</select><A HREF="localidad_alta.php" class="button" target="_blank">&nbsp;Cargar Localidades</A></td>
    </tr>
<tr>
    <th scope="row" >Barrio</th>
 <td ><input type="text"  name="barrio"  title="Ingrese el Barrio" value="<?php echo isset($_POST['barrio'])?strtoupper($_POST['barrio']):$empleado->get_barrio();  ?>"></td>
   </tr>
    <tr>
   <th scope="row" >Trabaja de:</th>
   <td  align="left"><select name="oficio"   onChange="document.form1.submit()">
    <option value="-1" >-- seleccionar --</option>
 <?php 	$qof="select item,descrip from diccionario where codigo=1 order by descrip asc";
		$rof=pg_query($qof);
		$of=isset($_POST['oficio'])?$_POST['oficio']:$empleado->get_id_oficio(); 
		while ($aof=pg_fetch_array($rof)){	?>
<option value="<?php echo $aof['item'];?>"<?php echo($of==$aof['item'])?'selected':'';?>><?php echo $aof['descrip'];?>   </option><?php }?>
</select></td>
    </tr>
<?php if($of==2){?>
 <tr>
   <th scope="row" >Se asigna Zona:</th>
   <td  align="left"><select name="zona" >
    <option value="-1" >-- seleccionar --</option>
 <?php 	$qzona="select item,descrip from diccionario where codigo=2 order by item asc";
		$rzona=pg_query($qzona);
		$Zona=isset($_POST['zona'])?$_POST['zona']:$empleado->get_id_zona(); 
		while ($azona=pg_fetch_array($rzona)){	?>
<option value="<?php echo $azona['item'];?>"<?php echo($Zona==$azona['item'])?'selected':'';?>><?php echo $azona['descrip'];?>   </option>
		<?php }?>
</select></td>
    </tr>
	<?php }?>
   <tr>
    <th scope="row">Observacion</th>
 <td ><TEXTAREA name="obs" ROWS="5"   COLS="25"><?php echo isset($_POST['obs'])?strtoupper ($_POST['obs']):$empleado->get_obs();  ?></TEXTAREA></td>
   </tr><tr>
<td colspan="2"  >(*)se coloca el numero sin 0 y sin 15 ej: 0<B>381</B>15<B>4498244</B> </td>
	</tr>
  </TABLE>
			
	<? } ?>
</TABLE>   
 			         

  <?php if(!empty($dni)&&isset($empleado)&&$empleado->get_id_empleado()<1){?>
    <INPUT TYPE="submit" onclick="document.form1.action='empleados_guardar.php'" value="Guardar" class="button">
<?php }	else { 
	if(isset($empleado)&&$empleado->get_id_empleado()>0){?>

  </TABLE>
<INPUT TYPE="submit"  onclick="document.form1.action='empleados_guardar_mod.php'" class="button" value="Guardar Modificacion"> 
	
<?php } }?>

  <A HREF="javascript:document.location.href='empleados_alta.php'" class="button">Limpiar Formulario</A>

  </form>
    
</td>
</tr>
</table>
</div>
<div class="pie">

<p>Desarrollado por  </p>
<p class="copy">Copyright &copy; 2008  &reg; Todos los derechos reservados</p>
</div></div>
</div>
</body></html>