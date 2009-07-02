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
<?php echo $r->inf2("submenu.php?menu=8");  ?>


<div class="t_datos"><div class="titulos">GENERADOR DE CATALOGO</div></div>
<div class="descripcion"></div>
</div>
<!--
<form action="" method="post" name="catalogo">
nombre
<input name="Nombre" type="text"  maxlength="50" value=<?php echo $_POST['Nombre'] ?>>
<br><hr>
Codigo
<input name="codigo" type="text" size="4" maxlength="4" onblur="submit()">

 <?PHP /*
if( !empty($_POST['codigo']) && is_numeric($_POST['codigo'])){

	$gl=new gestorLibro($c);
$libro=$gl->get_libroCodigo($_POST['codigo']);
*/
?>

<table border="1">
  <? //echo $gl->show_libro($libro)?>
</table>
<? //}
?>
<br><hr>
</form> -->

<form action="" method="post" name="form">
Nombre del Catalogo
<input name="Nombre" type="text"  maxlength="50" value=<?php echo $_POST['Nombre'] ?>><BR>
(*)Para que funcione el campo codigo, la seleccion de titulo debe estar vacia.<a href="libros_alta.php" target="_blank" class="button">Cargar Libros</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:v_abrir2('libro_buscar_POPUP.php')"  class="button" >Buscar Libro</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:v_abrir2('libro_listado_POPUP.php')"  class="button">Listado de Libros</a><HR>
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
</td><td><? 			
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
<?php 


if((isset($_POST['mas']) && !empty($_POST['codigo']))||$_POST['mostrar']==1){
?>
<table width="558" border="1" class="c_user" align="center">
<tr > 
<td  colspan="8" bgcolor=#99CC99 class='c_user' align="center">CATALOGO <? echo $_POST['Nombre']?></td></tr>
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
$conexion=new gestorConexion();
$conexion->getMiconexion();

while ($_POST['codigo'.$c]){
?>
     <input type="hidden" name="codigo<?php echo$c; ?>" value="<?php echo $cod=$_POST['codigo'.$c];?>" >
     <input type="hidden" name="cant<?php echo $c; ?>" value="<?php echo $cant=$_POST['cant'.$c];?>" >
	<input type="hidden" name="precio<?php echo $c; ?>" value="<?php echo $precio=$_POST['precio'.$c];?>" >	
	<!-- <input type="hidden" name="mostrar" value="1" > -->  
      <?php	

if(isset($_POST['eli'.$c])){
$_POST['estado'.$c]=FALSE;


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
  
}
}?>

 </table><P>    
<INPUT TYPE="submit"  onclick="document.form.action='libros_catalogo_guardar.php'" class="button" >
 
    <input type="hidden" name="formu" value="libros_catalogo">
</form>


<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div></div>
</div>
</body></html>