<?php 
include("cabecera.php");
include("funcionesGrales.php");

 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>MENU ALTA</title>


</head>
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
<body >
<form name="form1" id="form1" method="post"action="" enctype="multipart/form-data" >
<div align="center" class="Estilo1"> <font face="Arial, Helvetica, sans-serif" size="4">- Alta Men&uacute;es - </font> </div>
            
      Link  Men&uacute; (nombre) : <input type="text" size="50" maxlength="100" name="nombre">
          <input name="chksub" type="checkbox" id="chksub" onClick="submenu(this)">
          Submen&uacute;
          Direcci&oacute;n Link Men&uacute;: 
<input type="text" size="50" maxlength="50" name="pagina" >

     
Descripcion del Link Men&uacute;: 
<input type="text" size="50"  name="desc" >
Subir imagen: 
 <input type="file" name="file" >&nbsp;<FONT SIZE="1" COLOR="">*El archivo no debe superar los 1024 kb</FONT><BR>  


            <input type="submit" name="agregar" value="Agregar Men&uacute;">
         
<div align="center" class="Estilo1"> <font face="Arial, Helvetica, sans-serif" size="4">- Alta Men&uacute;es de SubMen&uacute;es - </font> </div>

Seleccionar Men&uacute;: 

        

        <select name="submenu" >
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
<input name="subnombre" type="text" id="subnombre" value="<? echo $subnombre; ?>" size="50" maxlength="50">

     
Direcci&oacute;n Link Sub-Men&uacute;: 
<input type="text" size="50" maxlength="100" name="subpagina" value="<? echo $subpagina; ?>">

     
Descripcion del Link Sub-Men&uacute;: 
<input type="text" size="50"  name="sdesc" >
Subir imagen: 
<input type="file" name="sfile" >&nbsp;<FONT SIZE="1" COLOR="">*El archivo no debe superar los 1024 kb</FONT><BR>  
 

            <input type="submit" name="subagregar" value="Agregar Submen&uacute;">
          
<b>Esta opci&oacute;n permite incorporar Submen&uacute;es a los men&uacute;es correspondientes <br>
            
</form>

</body>
</html>
