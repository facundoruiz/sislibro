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
 <form  method="post" action="" name="form1" >
  
	<?PHP if(isset($_GET['dato'])||isset($_POST['dato'])){
	$id_clientes=isset($_GET['dato'])?$_GET['dato']:$_POST['dato'];
			$gcliente=new gestorcliente($c);
			$cliente=$gcliente->get_clienteId($id_clientes);
		$b=1;
}else{
	$b=0;
 $dni= $_POST['dni'];
				
				if(!empty($dni))
					{              
	           	$gcliente=new gestorCliente($c);
				$cliente=$gcliente->get_clienteDni($dni);
					}?>
					<input type="hidden" name="form" value="clientes_alta_popup">
					<? }?>
 <div class="t_datos"><div class="titulos">  
        <?PHP echo (isset($_GET['dato'])||isset($_POST['dato']))?'Modificar Clientes':'Carga Clientes'?> 
      </div></div>
 
 <TABLE align="center" >
      <tr>		  
      <th    scope="row" class="rotulo">DNI</th>	  
      <td  >	  	  
	  <?php if(isset($cliente)&&$cliente->get_id_cliente()>0)
	      {			    
			?>	
			<!-- SI EXITE PASA POR AQUI -->
  
   	<input type="text" name="dni"   value="<?php echo isset($_POST['dni'])?$_POST['dni']:$cliente->get_dni(); ?>" readonly >	
<INPUT TYPE="hidden" name="id"  value="<?PHP echo isset($_POST['id'])?$_POST['id']:$cliente->get_id_cliente() ?>">
		   Dni Existente</td>
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
</select><A HREF="localidad_alta.php"  target="_blank" CLASS="button">&nbsp;Cargar Localidades</A></td>
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
  </TABLE>
 
	

 <?php  }else{
			           if(empty($dni)) {?>     
					   <input type="text" name="dni"   maxlength="8" onKeyPress="return soloNum(event)"  title="Ingrese el DNI" onBlur="document.form1.submit()" value="<?php echo $dni?>">	
						<?php } else {?>
			<!-- Si mandaron amodificar desde get  --> 	 
   	<input type="text" name="dni"   value="<?php echo isset($_POST['dni'])?$_POST['dni']:$cliente->get_dni(); ?>" readonly>	
	<INPUT TYPE="hidden" name="id" value="<?PHP echo isset($_POST['id'])?$_POST['id']:$cliente->get_id_cliente(); ?>">
		   </td>
    </tr>
 
     <tr >
      <th scope="row" class="rotulo">Apellido</th>
      <td ><input type="text"  maxlength="30" name="apellido" title="Ingrese el Apellido" value="<?php echo isset($_POST['apellido'])?strtoupper ($_POST['apellido']):$cliente->get_apellido(); ?>"></td>
    </tr>
       <tr>
       <th scope="row" class="rotulo">Nombre</th>
         <td ><input type="text"  maxlength="30" name="nombre" title="Ingrese el Nombre" value="<?php echo isset($_POST['nombre'])?strtoupper ($_POST['nombre']):$cliente->get_nombre();  ?>"></td>
      </tr>
    <tr>
       <th scope="row" class="rotulo">Domicilio</th>
         <td><input type="text"  maxlength="100" name="domicilio" title="Ingrese el Domicilio" value="<?php echo isset($_POST['domicilio'])?strtoupper ($_POST['domicilio']):$cliente->get_domicilio();  ?>"></td>
      </tr>
 <tr>
       <th scope="row" class="rotulo">Telefono</th>
         <td ><input type="text"  onKeyPress="return soloNum(event)" name="telefono" title="Ingrese el Telefeno" value="<?php echo isset($_POST['telefono'])?$_POST['telefono']:$cliente->get_telefono();  ?>" maxlength="7"></td>
      </tr>	
  <tr>
      <th scope="row" class="rotulo">Celular(*)</th>
        <td ><input type="text"  onKeyPress="return soloNum(event)" name="cel" title="Ingrese el Telefeno" value="<?php echo isset($_POST['cel'])?$_POST['cel']:$cliente->get_celular();  ?>" maxlength="10"> </td>
   </tr>	
	 <tr>
   <th scope="row" class="rotulo">Provincia</th>
   <td  align="left"><select name="prov"  onChange="document.form1.submit()">
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
   <td  align="left"><select name="Loc"  >
    <option value="-1" >-- Localidad --</option>
 <?php 	$qLoc="select idlocalidad,descrip from t_localidades where idprovincia=".$Prov." order by descrip asc";
		$rLoc=pg_query($qLoc);
		$loc=isset($_POST['Loc'])?$_POST['Loc']:$cliente->get_localidad(); 
		while ($aLoc=pg_fetch_array($rLoc)){	
			
			?>
<option value="<?php echo $aLoc['idlocalidad'];?>"<?php echo($loc==$aLoc['idlocalidad'])?'selected':'';?>><?php echo $aLoc['descrip'];?>   </option><?php }?>
</select><A HREF="a_localidad.php" CLASS="button">&nbsp;Cargar Localidades</A></td>
    </tr>
<tr>
    <th scope="row" class="rotulo">Barrio</th>
 <td ><input type="text"  name="barrio" title="Ingrese el Barrio" value="<?php echo isset($_POST['barrio'])?strtoupper($_POST['barrio']):$cliente->get_barrio();  ?>"></td>
   </tr>
   <tr>
    <th scope="row" class="rotulo">Moroso</th>
 <td ><select name="moroso"   onChange="document.form1.submit()">
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
</select></td>
   </tr>
   <tr>
    <th scope="row" class="rotulo" >Observacion</th>
 <td "><TEXTAREA name="obs"   ROWS="5" COLS="25"><?php echo isset($_POST['obs'])?strtoupper ($_POST['obs']):$cliente->get_obs();  ?></TEXTAREA></td>
   </tr>

	<tr>
<td colspan="2"  class="c_datos">(*)se coloca el numero sin 0 y sin 15 ej: 0<B>381</B>15<B>4498244</B> </td>
	</tr>
  </TABLE>

	<?php }}?>
  </TABLE>

  <?php if(!empty($dni)&&isset($cliente)&&$cliente->get_id_cliente()<=1){?>
    <INPUT TYPE="submit"   onclick="document.form1.action='clientes_guardar.php'" value="Guardar" class="button">
<?php }	else { 
			if(isset($cliente)&&$cliente->get_id_cliente()>0){?>

  </TABLE>
<INPUT TYPE="submit"   onclick="document.form1.action='clientes_guardar_mod.php'" value="Guardar Modificacion " class="button">

	
<?php } }?>
  <A HREF="javascript:document.location.href='clientes_alta.php'" class="button">Limpiar Formulario</A>
 
  </form>
    


</div>
</body></html>