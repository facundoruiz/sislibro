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
<?php echo $r->inf2("submenu.php?menu=5");  ?>


<div class="t_datos"><div class="titulos">MODIFICAR LIBROS</div></div>
<div class="descripcion"></div>
</div>


<form action="" method="post" name="form">
<table  border="1" class="c_user">
        
        <tr>
          <td width="50" bgcolor=#99CCFF>Codigo</td>
		  <td  bgcolor=#99CCFF>Genero</td>
          <td  bgcolor=#99CCFF>Editorial</td>
		  <td  bgcolor=#99CCFF>Titulo</td>
         <td  width="50" bgcolor=#99CCFF>Cant.</td>  
		 <td  width="50" bgcolor=#99CCFF>Costo</td>
         </tr>
	   

   

        <tr>
<td><input type="text" name="codigo" onKeyPress="return soloNum(event)"  title="Ingrese el Codigo de Libro" onBlur="document.form.submit()" size="4" value=<?php echo$_POST['codigo']?>></td>
<?php 
	if(!empty($_POST['codigo'])||$_POST['codigo']!=0){
		$codigo=$_POST['codigo'];
		$sql="Select  * from f_desc_ejemplares($codigo)
				inner join t_ejemplares t on t.codigo=$codigo   ";	 
	
 		$rows=pg_fila($sql);
			if( $rows==0){
				echo"<SCRIPT> alert('No existe este ".$codigo." codigo ')</SCRIPT>";
				$_POST['codigo']='' ;
			}
 ?>
<td >	
  <?php 
  //-------------------- GENEREO
?>
 <select name="genero" >
	  		 <option value="-1">---Seleccione Genero </option>
			<?php 
		
			$qgenero="select idgenero,descrip from t_generos  order by(descrip) ";
			$rgenero=pg_query($qgenero);
			while ($agenero=pg_fetch_array($rgenero)){
			?>
            <option value="<?php echo $agenero['idgenero'];?>" <?php echo ($rows['idgenero']==$agenero['idgenero'])?'selected':'';?>
			><?php echo $agenero['descrip'];?>
			<?php }?>
          </select> 
	<?php 
	// FIN GENERO ?>
</td>
 <td >	
  <?php 
  //----------------EDITORIAL
 ?> <select name="editorial" >
	  		 <option value="-1">---Seleccione editorial </option>
			<?php 
		
			$qeditorial="select ideditorial,descrip from t_editoriales  order by(descrip)";
			$reditorial=pg_query($qeditorial);
			while ($aeditorial=pg_fetch_array($reditorial)){
			?>
            <option value="<?php echo $aeditorial['ideditorial'];?>" <?php echo ($rows['ideditorial']==$aeditorial['ideditorial'])?'selected':'';?>
			><?php echo $aeditorial['descrip'];?>
			<?php }?>
          </select> 
	<?php
	//FIN EDITORIAL----------------
	?>
</td>

<td>	
  <?php 
  // ------------------------------------TITULO
  
 ?>
 <select name="titulo"  >
	  		 <option value="-1">---Seleccione titulo</option>
			<?php 
			
			$qtitulo="select idlibro,descrip from t_libros  order by(descrip)";
			$rtitulo=pg_query($qtitulo);
			while ($atitulo=pg_fetch_array($rtitulo)){
			?>
            <option value="<?php echo $atitulo['idlibro'];?>" <?php echo ($rows['idtitulo']==$atitulo['idlibro'])?'selected':'';?>
			><?php echo $atitulo['descrip'];?>
			<?php }?>
          </select> 
	<?php	
	//---------titulo
	?>
</td>
<td><input type="text" name="cant"  size="3" onKeyPress="return soloNum(event)" value=<?php echo $rows['cant'] ?>></td>
   <!-- precio -->
 <td>$<input type="text" name="costo"  size="3" onKeyPress="return soloNumPto(event)" value="<?php echo $rows['costo'] ?>"></td>
			<?php }?>
 </tr>

 </table>
 
 <P>
 <P>
 <input type="submit" name="mas" value="Guardar Modificacion" onClick="document.form.action='libros_mod_guardar.php'" class="button">&nbsp;&nbsp;
<A HREF="javascript:document.location.href='libros_modificar.php'" class="button">Limpiar Formulario</A></CENTER>
<input type="hidden" name="form" value="libros_modificar">
</form>


<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div></div>
</div>
</body></html>