<?php include("cabecera.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Transporte - Acta</title>
<link href="letras.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {	color: #FFFFFF;
	font-weight: bold;
}
.Estilo2 {color: #235261}
-->
</style>
</head>

<body background="img/Fondo.jpg">
<table width="750">
  <tr>
    <td colspan="2"><div align="center"><img src="img/titulo.jpg" ></div></td>
  </tr>
  <tr>
    <td width="180" align="center" valign="top"><a href="submenu.php?SID&menu=15"><IMG SRC="img/volver.gif" WIDTH="35" HEIGHT="35" BORDER="0" ALT=""><BR>
    Menu Principal</a> </td>
    <td width="664" align="center" valign="middle">
<?php 
include('funcionesGrales.php');
$afecha=pg_fetch_row(pg_query("select fecha()"));
$fecha_actual=$fecha[0];
$ahora=pg_fetch_row(pg_query("select hora()"));
$hora_actual=$ahora[0];
if(isset($_POST['aceptar']))
{
	$opcion=$_POST['opcion'];
	$valor=$_POST['valor'];
	if(isset($valor))
	{
		$b_menu="Select id_menu,id_submenu,descripcion, nombre, link, img from tmenu where nombre ilike'%$valor%' order by nombre";
		$c_menu=pg_query($b_menu);
		$cant=pg_num_rows($c_menu);
	}
	else 
	{
		echo "<script language='JavaScript'>alert ('Debe ingresar algún valor')</script>";
	}
}//fin aceptar
		
if(isset($_POST['modificar']))
{
	$ids=$_POST['menu'];
//	$idss=$_POST['submenu'];
	if(isset($ids[0]))
	{
		$cuento=count($ids);
		$nuevo_nombre=$_POST['nombre'];
		$nuevo_link=$_POST['link'];
		$nuevo_desc=$_POST['descrip'];
/*		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		echo "****************************************************************************************************";*/
		for($i=0; $i<$cuento; $i++)
		{
			$nom=ucfirst($nuevo_nombre[$i]);
			$desc=strtoupper($nuevo_desc[$i]);
			$mod_menu="update tmenu set nombre='$nom', link='$nuevo_link[$i]', descripcion='$desc' where id_menu=$ids[$i] " ;
			/*echo "<pre >";
			print_r($_FILES);
			echo "</pre>";
			echo $mod_menu;
			*/
			echo "NO SE GUARDARA LA INFORMACIÓN - EN DESARROLLO...";
			//pg_query($mod_menu);
		}
	}
	else 
	{
		echo "<script language='JavaScript'>alert ('No se cuenta con registros para modificar')</script>";
	}
}
?>
<form action="" name="mod_menu" method="post" enctype="multipart/form-data" >

<span class="Estilo2"><font size="+1" face="Arial, Helvetica, sans-serif">Modificar Menues y Submenues</font></span>
<hr>
<table class="letra">
<tr>
	<td><font class="letra">Buscar : </font></td>
    <td>
	<!--<select name="opcion">
    	<option value="1" <?php // echo($_POST['opcion']==1 or !$_POST['opcion']) ? " selected" : "";?>>ID</option>
        <option value="2" <?php // echo($_POST['opcion']==2 ) ? "selected" : "";?>>NOMBRE</option>
    </select>-->
	</td>
    <td><input type="text" name="valor" size="20" maxlength="100"></td>
	<td><input type="submit" name="aceptar" value="Aceptar"></td>
</tr>
</table>
<hr>
<?php 
if(isset($_POST['aceptar']))
{
?>
	<table width="500" class="letra">
        <tr bgcolor="#99CCCC">
          <td align="center">Nombre del men&uacute;</td>
          <td align="center">Direcci&oacute;n de la p&aacute;gina</td>
          <td align="center" bgcolor="#99CCCC">Comentario</td>
         <!-- <td align="center" bgcolor="#99CCCC">Archivo</td>		  -->
        </tr>
<?php 
	for($i=0; $i<$cant; $i++)
	{
		$datos=pg_fetch_array($c_menu,$i);
?>
		<tr>
          <td>
		  <input type="hidden" name="menu[]" value="<? echo $datos['id_menu']?>" > 
		  <input type="hidden" name="submmenu[]" value="<? echo $datos['id_submenu']?>" >
		  <input type="text" name="nombre[]" value="<? echo $datos['nombre']?>" size="30"></td>
          <td><input type="text" name="link[]" value="<? echo $datos['link']?>" size="30"></td>
          <td><input name="descrip[]" type="text" id="descrip[]" value="<? echo $datos['descripcion']?>" size="40" ></td>
          <!--<td><input type="file" name="file[]" value="<?php //echo $datos['img']?>" ></td>-->
		</tr>
<?php 
	}//cierre del for
?>
        <tr>
          <td colspan="4" align="center">
              <input type="submit" name="modificar" value="Modificar">
          </td>
        </tr>
      </table>
<?php 
}
?>
</form>
</td>
</tr>
<tr>
<td colspan="2"><hr>
<CENTER>
        <font color="#000000" size="3">Sistema</font><img src="img/ojos0ju.gif" width="34" height="31"><BR>
        <FONT color="#000000" size=1>800x600 - Internet Explorer 5 o superior</FONT>
      </CENTER>
    <p>&nbsp;</p></td>
  </tr>
</table>
<br>
<br>
</body>
</html>
