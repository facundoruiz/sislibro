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

<script>
function submenu(obj)
{
	if (obj.checked)
	{
		
		document.form1.pagina.disabled=true;
	}
	else
	{
		
<!--		document.form1.pagina.value='';-->
		document.form1.pagina.disabled=false;
	}

}
</script>
<?php
if($_POST['agregar']&&$_POST['nombre'])
{
$destino = 'img';  
// Leemos el tamaño del fichero  
$tamano = $_FILES['file']['size']; 
$tamano=$tamano/1024;
// Comprovamos el tamaño  
if($tamano < 1024){  
 copy($_FILES['file']['tmp_name'], $destino.'/'.$_FILES['file']['name']) ; 
 
}  
else $error[]= "El tamaño es superior al permitido ".$tamano." Kb";  

	$qidmenu="select max(id_menu)+1 from t_menu";
	$aidmenu=pg_fila($qidmenu);
	$vidmenu=$aidmenu[0];
	
	$vnombre=$_POST['nombre'];
	
	$vpagina=(isset($_POST['chksub']))?'enlacesubmenu.php?menu='.$vidmenu:$_POST['pagina'];
	$vdes=$_POST['desc'];

	$img=$_FILES['file']['name'];
	$qinmenu =" insert into t_menu(id_menu,id_submenu,nombre,link,descripcion,img)values(";
	$qinmenu.="$vidmenu,0,'$vnombre','$vpagina','$vdes','$img')";

if(sizeof($error)>0){
error($error);
}else{
	
	if(@pg_query($qinmenu))
	{
		echo '<script>alert("Datos ingresados satisfactoriamente");</script>';
	}
	else
	{
		echo '<script>alert("Se produjo un Error y no se registraron los datos");</script>';
	}
	
	}
}
if($_POST['subagregar']&&$_POST['subnombre'])
{
$destino = 'img';  
// Leemos el tamaño del fichero  
$tamano = $_FILES['sfile']['size']; 
$tamano=$tamano/1024;
// Comprovamos el tamaño  
if($tamano > 1024){  
 $error[]= "El tamaño es superior al permitido ".$tamano." Kb";  }


	$vidmenu=$_POST['submenu'];
	$qidsubmenu="select max(id_submenu)+1 from t_menu where id_menu=$vidmenu";
	$aidsubmenu=pg_fila($qidsubmenu);
	$vidsubmenu=$aidsubmenu[0];
	
	$vsubnombre=$_POST['subnombre'];
	
	$vsubpagina=$_POST['subpagina'];
		$vdes=$_POST['sdesc'];

	$img=$_FILES['sfile']['name'];
	$qinsubmenu =" insert into t_menu(id_menu,id_submenu,nombre,link,descripcion,img)values(";
	$qinsubmenu.="$vidmenu,$vidsubmenu,'$vsubnombre','$vsubpagina','$vdes','$img')";
	//echo $qinsubmenu;
	
if(sizeof($error)>0){
error($error);
}else{	
	if(@pg_query($qinsubmenu))
	{ copy($_FILES['sfile']['tmp_name'], $destino.'/'.$_FILES['sfile']['name']) ; 
		echo '<script>alert("Datos ingresados satisfactoriamente");</script>';
	}
	else
	{
		echo '<script>alert("Se produjo un Error y no se registraron los datos");</script>';
	}}
}
?>

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
<?php echo $r->Submenu(1); ?>
      </div>
<td  class="centro">

<div class="t_datos"><div class="titulos">- Alta Men&uacute;es - </div></div>
<div class="descripcion">

<form name="form1" id="form1" method="post"action="" enctype="multipart/form-data" >
           
    Link  Men&uacute; (nombre) : <input type="text" size="50" maxlength="100" name="nombre">
     <input name="chksub" type="checkbox" id="chksub" onClick="submenu(this)">
          Submen&uacute;
         <br> Direcci&oacute;n Link Men&uacute;:<input type="text" size="50" maxlength="50" name="pagina" ><br>
Descripcion del Link Men&uacute;:<input type="text" size="50"  name="desc" ><br>
Subir imagen:  <input type="file" name="file" >&nbsp;<FONT SIZE="1" COLOR="">*El archivo no debe superar los 1024 kb</FONT><BR>  
            <input type="submit" name="agregar" value="Agregar Men&uacute;">
 <br>
    <div class="t_datos"><div class="titulos">- Alta Men&uacute;es de SubMen&uacute;es -</div></div>      


Seleccionar Men&uacute;:<select name="submenu" >
        <?php
			$qsmenu="Select id_menu,nombre from t_menu where link ilike 'enlacesubmenu.php?menu=%' order by nombre";
			$rsmenu=pg_query($qsmenu); 
			while ($asmenu=pg_fetch_assoc($rsmenu))
			{
		?>
              <option value="<?php echo $asmenu['id_menu']?>" <?php echo ($_POST['submenu']==$asmenu['id_menu'])?"selected":"";?>><?php echo $asmenu['nombre']?></option>
		<?php 
			} 
		?>
        </select>
        

      <? 
	if($_POST['submenu']==$id_max[0])
	{
	?>
      <? }
	
?>
      
Link (nombre) Sub-Men&uacute;: 
<input name="subnombre" type="text" id="subnombre" value="<? echo $subnombre; ?>" size="50" maxlength="50"><br>

     
Direcci&oacute;n Link Sub-Men&uacute;: 
<input type="text" size="50" maxlength="100" name="subpagina" value="<? echo $subpagina; ?>"><br>

     
Descripcion del Link Sub-Men&uacute;: 
<input type="text" size="50"  name="sdesc" ><br>
Subir imagen: 
<input type="file" name="sfile" >&nbsp;<FONT SIZE="1" COLOR="">*El archivo no debe superar los 1024 kb</FONT><BR>  
 

            <input type="submit" name="subagregar" value="Agregar Submen&uacute;">
          
<b>Esta opci&oacute;n permite incorporar Submen&uacute;es a los men&uacute;es correspondientes <br>
            
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