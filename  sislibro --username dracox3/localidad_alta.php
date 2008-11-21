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
<?php echo $r->Submenu(6); ?>
      </div>
<td  class="centro">

<div class="t_datos"><div class="titulos">Localidad Alta</div></div>
<div class="descripcion">


<form  method="post" action="" name="form">
 
  <table >          
<tr>
      <th scope="row" class="rotulo" >Provincia</th>
      <td >  	   
	  <select name="Tipo" onChange="document.form.submit()">
	  		 <option value="-1">---Seleccione Provincia</option>
			<?php 
			$qtipo="select idprovincia,descrip from t_provincias order by(descrip)";
			$rtipo=pg_query($qtipo);
			while ($atipo=pg_fetch_array($rtipo)){
			?>
            <option value="<?php echo $atipo['idprovincia'];?>" <?php echo ($_POST['Tipo']==$atipo['idprovincia'])?'selected':'';?>
			><?php echo $atipo['descrip'];?>
			<?php }?>
          </select> 

</tr>

    <tr>
      <th scope="row" class="rotulo" >Localidad</th>
      <td >	 
 <?php $Loc=strtoupper ($_POST['Loc']); ?>
	             <input type="text" name="Loc" title="Ingrese un Localidad" onBlur="document.form.submit()" value="<?php echo $Loc?>">	
       	
  </td> </tr>
 
  
      
 <?php if(!empty($Loc)){?>
  <tr>
  <td colspan="2" class="copy">Asegurarce que la localidad no figure en la lista</td>
   </tr>
   <tr>   <th colspan="2" class="rotulo" >Localidades</th></tr><tr>
  <td colspan="2" class="caja" >	
 <?php 
$q= pg_query(" Select * from t_localidades where descrip ilike'%$Loc%' and idprovincia=".$_POST['Tipo']." order by descrip");
 while ($r=pg_fetch_array($q)){
 echo "<FONT SIZE=2>".$r['descrip']."</FONT><br>";
 }} ?>
   	
  </td> </tr>


 </table>
<?php if(!empty($_POST['Loc'])){ ?>
<INPUT TYPE="submit" onclick="document.form.action='localidad_guardar.php'"  value="Guardar Formulario" class="button"> 

<?php }?>
  <A HREF="javascript:document.location.href='localidad_alta.php'" class="button">Limpiar Formulario</A>

  <INPUT TYPE="hidden" NAME="form" value="localidad_alta">
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