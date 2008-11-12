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
</div><table border="0" cellpadding="0" cellspacing="0" width="100%" summary="Contenido">
<tr>
<td  class="izquierda"  valign="top">
<div class="t_menu">SubMENU</div>
 <div id="c_menu"> 
<?php echo $r->Submenu(5); ?>
      </div>
<td  class="centro">

<div class="t_datos">SISTEMAS</div>
<div class="descripcion">


     
        Carga Libros 
<form  method="post" action="" name="form">
 
  <table >          
   

<tr>
      <th scope="row"  >Generos</th>
      <td width="319">  	   
	  <select name="Tipo" >
	  		 <option value="-1">---Seleccione un Genero</option>
			<?php 
			$qtipo="select item,descrip from t_generos where codigo=1 order by(descrip)";
			$rtipo=pg_query($qtipo);
			while ($atipo=pg_fetch_array($rtipo)){
			?>
            <option value="<?php echo $atipo['item'];?>" <?php echo ($_POST['Tipo']==$atipo['item'])?'selected':'';?>
			><?php echo $atipo['descrip'];?>
			<?php }?>
          </select> 
</td>
</tr>
<tr>
      <th scope="row" >Editoriales</th>
	  <td width="319">	
   <?php $beditorial=$_POST['beditorial'];
   if(isset($_POST['beditorial']) && !empty($beditorial)){
	   $teditor=strtoupper ($_POST['teditor']);                  
	if(!empty($teditor))
					{
	            $cmd="select * from t_editoriales where codigo='6' and descrip='$teditor'";
				$q=pg_query($cmd);
				$r=pg_fetch_array($q);
					}		
	       if($r!=0)
	       {			
			?>
		<?php			
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
					 $editorial=ingresa($teditor);?>
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
			$qeditorial="select item,descrip from diccionario where codigo=6 order by(descrip)";
			$reditorial=pg_query($qeditorial);
			while ($aeditorial=pg_fetch_array($reditorial)){
			?>
            <option value="<?php echo $aeditorial['item'];?>" <?php echo ($_POST['editorial']==$aeditorial['item'])?'selected':'';?>
			><?php echo $aeditorial['descrip'];?>
			<?php }?>
          </select> 
<INPUT TYPE="submit" name="beditorial"  value="Cargar" title="Click para cargar una nueva Editorial" onclick="document.form.submit()">
	<?php }?>
</td>
			
    </tr>


    <tr>
      <th scope="row" >Titulo del libro </th>
      <td width="319">	 
<?php $ttitulo=strtoupper ($_POST['ttitulo']); ?>
	             <input type="text" name="ttitulo" title="Ingrese un titulo" onBlur="document.form.submit()" value="<?php echo $ttitulo?>">	
	         	
  </td> </tr>
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

  </table>
  <?php if(!empty($_POST['ttitulo'])){?>
<INPUT TYPE="submit"  onclick="document.form.action='libros_guardar.php'"  value="Guardar Formulario"> <?php }?>
  <A HREF="javascript:document.location.href='libros_alta.php'"><IMG SRC="images/limpiar.gif" WIDTH="100" HEIGHT="40" BORDER="0" ALT="Limpiar Formulario"></A>

  <INPUT TYPE="hidden" NAME="form" value="a_libro">
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