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
</div><table border="0" cellpadding="0" cellspacing="0" width="100%" summary="Contenido">
<tr>
<td  class="izquierda"  valign="top">
<div class="t_menu">SubMENU</div>
 <div id="c_menu"> 
<?php echo $r->Submenu(5); ?>
      </div>
<td  class="centro">

<div class="t_datos"><div class="titulos"> Carga Libros </div></div>
<div class="descripcion">


     
       
<form  method="post" action="" name="form">
 
  <table >          
   


<tr>
      <th scope="row" >Generos</th>
	  <td >	
  <?php $bgenero=$_POST['bgenero'];
   if(isset($_POST['bgenero']) && !empty($bgenero)){
	$tgenero=strtoupper ($_POST['tgenero']);     
	   
	if(!empty($_POST['tgenero']))
					{
						
	          $cmd="select * from t_generos where descrip ilike '".$teditor."'";
				$q=pg_query($cmd);
				$rows_libro=pg_fetch_array($q);
					}		
	       if(isset($rows_libro)&&$rows_libro!=0)
	       {				
			echo"<SCRIPT >
			<!--
			        alert('Genero Existente');
					document.form.tgenero.select();
			    	document.form.tgenero.focus();									
			//-->
			</SCRIPT>";
			?>
				<input type="text" name="tgenero" onBlur="document.form.submit()" value="<?php echo $tgenero ?>"> 
	         <INPUT TYPE="hidden" NAME="bgenero" value="TRUE">			
		     <?php } else
				 {
				 
				 if(empty($tgenero)){?>
		<input type="text" name="tgenero" onBlur="document.form.submit()" value="<?php echo $tgenero ?>"> 
	         <INPUT TYPE="hidden" NAME="bgenero" value="TRUE">
						<?php }else{?>
	   <input type="text" name="tgenero" onBlur="document.form.submit()" value="<?php echo $tgenero ?>"> 
	    <INPUT TYPE="hidden" NAME="bgenero" value="TRUE">
		<?php $ggenero=$_POST['ggenero'];
					 if(isset($_POST['ggenero']) && !empty($ggenero)){
					 
					 	$genero=ingresa_genero($tgenero,$r->getUser());?>
			 <INPUT TYPE="hidden" NAME="genero" value="<?php echo $genero?>">
			 <INPUT TYPE="hidden" NAME="bgenero" value="">
			  <INPUT TYPE="hidden" NAME="ggenero" value="">
			  <SCRIPT LANGUAGE="JavaScript">
			  document.form.submit()
			  </SCRIPT>
			<? }else{?>
					 <BR><INPUT TYPE="submit" name="ggenero"  value="Guardar" title="Click para guardar Genero" onclick="document.form.submit()">
					 <?php }//elseggenero
						}//elseempty	
						}	//else r
				}else{?>


 <select name="genero" >
	  		 <option value="-1">---Seleccione Genero </option>
			<?php 
			$qgenero="select idgenero,descrip from t_generos  order by(descrip)";
			$rgenero=pg_query($qgenero);
			while ($agenero=pg_fetch_array($rgenero)){
			?>
            <option value="<?php echo $agenero['idgenero'];?>" <?php echo ($_POST['genero']==$agenero['idgenero'])?'selected':'';?>
			><?php echo $agenero['descrip'];?>
			<?php }?>
          </select> 
<INPUT TYPE="submit" name="bgenero"  value="Cargar" title="Click para cargar Genero" onclick="document.form.submit()">
	<?php }?>
</td>
			
    </tr>





<tr>
      <th scope="row" >Editoriales</th>
	  <td >	
  <?php $beditorial=$_POST['beditorial'];
   if(isset($_POST['beditorial']) && !empty($beditorial)){
	$teditor=strtoupper ($_POST['teditor']);     
	   
	if(!empty($_POST['teditor']))
					{
						
	          $cmd="select * from t_editoriales where descrip ilike '".$teditor."'";
				$q=pg_query($cmd);
				$rows_libro=pg_fetch_array($q);
					}		
	       if(isset($rows_libro)&&$rows_libro!=0)
	       {				
			echo"<SCRIPT >
			<!--
			        alert('Editorial Existente');
					document.form.teditor.select();
			    	document.form.teditor.focus();									
			//-->
			</SCRIPT>";
			?>
				<input type="text" name="teditor" onBlur="document.form.submit()" value="<?php echo $teditor ?>"> 
	         <INPUT TYPE="hidden" NAME="beditorial" value="TRUE">			
		     <?php } else
				 {
				 
				 if(empty($teditor)){?>
		<input type="text" name="teditor" onBlur="document.form.submit()" value="<?php echo $teditor ?>"> 
	         <INPUT TYPE="hidden" NAME="beditorial" value="TRUE">
						<?php }else{?>
	   <input type="text" name="teditor" onBlur="document.form.submit()" value="<?php echo $teditor ?>"> 
	    <INPUT TYPE="hidden" NAME="beditorial" value="TRUE">
		<?php $geditorial=$_POST['geditorial'];
					 if(isset($_POST['geditorial']) && !empty($geditorial)){
					 
					 	$editorial=ingresa_editorial($teditor,$r->getUser());?>
			 <INPUT TYPE="hidden" NAME="editorial" value="<?php echo $editorial?>">
			 <INPUT TYPE="hidden" NAME="beditorial" value="">
			  <INPUT TYPE="hidden" NAME="geditorial" value="">
			  <SCRIPT LANGUAGE="JavaScript">
			  document.form.submit()
			  </SCRIPT>
			<? }else{?>
					 <BR><INPUT TYPE="submit" name="geditorial"  value="Guardar" title="Click para guardar una nueva Editorial" onclick="document.form.submit()">
					 <?php }//elsegeditorial
						}//elseempty	
						}	//else r
				}else{?>


 <select name="editorial" >
	  		 <option value="-1">---Seleccione editorial </option>
			<?php 
			$qeditorial="select ideditorial,descrip from t_editoriales  order by(descrip)";
			$reditorial=pg_query($qeditorial);
			while ($aeditorial=pg_fetch_array($reditorial)){
			?>
            <option value="<?php echo $aeditorial['ideditorial'];?>" <?php echo ($_POST['editorial']==$aeditorial['ideditorial'])?'selected':'';?>
			><?php echo $aeditorial['descrip'];?>
			<?php }?>
          </select> 
<INPUT TYPE="submit" name="beditorial"  value="Cargar" title="Click para cargar una nueva Editorial" onclick="document.form.submit()">
	<?php }?>
</td>
			
    </tr>



<tr>
      <th scope="row" >Titulos</th>
	  <td>	
  <?php $btitulo=$_POST['btitulo'];
   if(isset($_POST['btitulo']) && !empty($btitulo)){
	$ttitulo=strtoupper ($_POST['ttitulo']);     
	   
	if(!empty($_POST['ttitulo']))
					{
						
	          $cmd="select * from t_libros where descrip ilike '".$ttitulo."'";
				$q=pg_query($cmd);
				$rows_titulo=pg_fetch_array($q);
					}		
	       if(isset($rows_titulo)&&$rows_titulo!=0)
	       {				
			echo"<SCRIPT >
			<!--
			        alert('titulo Existente');
					document.form.ttitulo.select();
			    	document.form.ttitulo.focus();									
			//-->
			</SCRIPT>";
			?>
				<input type="text" name="ttitulo" onBlur="document.form.submit()" value="<?php echo $ttitulo ?>"> 
	         <INPUT TYPE="hidden" NAME="btitulo" value="TRUE">			
		     <?php } else
				 {
				 
				 if(empty($ttitulo)){?>
		<input type="text" name="ttitulo" onBlur="document.form.submit()" value="<?php echo $ttitulo ?>"> 
	         <INPUT TYPE="hidden" NAME="btitulo" value="TRUE">
						<?php }else{?>
	   <input type="text" name="ttitulo" onBlur="document.form.submit()" value="<?php echo $ttitulo ?>"> 
	    <INPUT TYPE="hidden" NAME="btitulo" value="TRUE">
		<?php $gtitulo=$_POST['gtitulo'];
					 if(isset($_POST['gtitulo']) && !empty($gtitulo)){
					 
					 	$titulo=ingresa_titulo($ttitulo,$r->getUser());?>
			 <INPUT TYPE="hidden" NAME="titulo" value="<?php echo $titulo?>">
			 <INPUT TYPE="hidden" NAME="btitulo" value="">
			  <INPUT TYPE="hidden" NAME="gtitulo" value="">
			  <SCRIPT LANGUAGE="JavaScript">
			  document.form.submit()
			  </SCRIPT>
			<? }else{?>
					 <BR><INPUT TYPE="submit" name="gtitulo"  value="Guardar" title="Click para guardar una nueva titulo" onclick="document.form.submit()">
					 <?php }//elsegtitulo
						}//elseempty	
						}	//else r
				}else{?>


 <select name="titulo" onChange="document.form.submit()" >
	  		 <option value="-1">---Seleccione titulo</option>
			<?php 
			$qtitulo="select idlibro,descrip from t_libros  order by(descrip)";
			$rtitulo=pg_query($qtitulo);
			while ($atitulo=pg_fetch_array($rtitulo)){
			?>
            <option value="<?php echo $atitulo['idlibro'];?>" <?php echo ($_POST['titulo']==$atitulo['idlibro'])?'selected':'';?>
			><?php echo $atitulo['descrip'];?>
			<?php }?>
          </select> 
<INPUT TYPE="submit" name="btitulo"  value="Cargar" title="Click para cargar una nueva " onclick="document.form.submit()">
	<?php }?>
</td>
			
    </tr>


    <!-- <tr>
      <th scope="row" >Titulo del libro </th>
      <td width="319">	 
<?php $ttitulo=strtoupper ($_POST['ttitulo']); ?>
	             <input type="text" name="ttitulo" title="Ingrese un titulo" onBlur="document.form.submit()" value="<?php echo $ttitulo?>">	
	         	
  </td> </tr> -->
	 <tr>
      <th scope="row" >Cantidad </th>
      <td width="319">	 
<?php $cant=strtoupper ($_POST['cant']); ?>
	             <input type="text" name="cant" size="3" onKeyPress="return soloNum(event)" title="Ingrese Cantidad de unidad"  value="<?php echo $cant?>"> unidades	
	         	
  </td> </tr>
   <tr>
      <th scope="row">Costo </th>
      <td width="319">	 
<?php $costo=strtoupper ($_POST['costo']); ?>
	            $ <input type="text" name="costo" size="5" onKeyPress="return soloNumPto(event)" title="Ingrese Costo del libro unitario"  value="<?php echo $costo?>">	
	         	
  </td> </tr>
 <tr>   <th colspan="2" class="rotulo" >Titulos de libros</th></tr><tr>
  <td colspan="2" class="caja" >	
 <?php if(!empty($ttitulo)){
$q= pg_query(" Select * from t_libros where descrip ilike'%$ttitulo%'  order by descrip");
 while ($r=pg_fetch_array($q)){
 echo "<FONT SIZE=2>".$r['descrip']."</FONT><br>";
 } }?>
   	
  </td> </tr>
  </table>
  <?php if(!empty($_POST['titulo'])){?>
<INPUT TYPE="submit"  onclick="document.form.action='libros_guardar.php'"  value="Guardar Formulario"> <?php }?>
  <A HREF="javascript:document.location.href='libros_alta.php'"><IMG SRC="images/limpiar.gif" WIDTH="100" HEIGHT="40" BORDER="0" ALT="Limpiar Formulario"></A>

  <INPUT TYPE="hidden" NAME="form" value="libro_alta">
  </form>
   

</div></td>
</tr>
</table>
</div>
<div class="pie">

<p>Desarrollado por  </p>
<p class="copy">Copyright &copy; 2008  &reg; Todos los derechos reservados</p>
</div></div>
</div>
</body></html>