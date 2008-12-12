<? 
include("cabecera.inc.php");
$ID_menu=$_SESSION['ID_menu'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<title>Alta de menues y submenues</title>
</head>

<body>
<? 
//include('conexion.php');
/*include('FuncGlobales.php');
include('mas_funciones.php');*/

//abrir_conexion();
//$fecha_actual=dame_fecha();
//$hora_actual=dame_hora();
?>
<form action="<? echo $PHP_SELF; ?>" method="post" name="form1">
<input type="button" name="salir" value="Volver" onClick="location.href='submenu.php?<? echo SID?>&menu=<? echo $ID_menu?>' ">
<br>
<? 
//grabo nuevo menu
if(isset($_POST['agregar']))
	{
	$id=$_POST['id'];
	$nombre=ucfirst($_POST['nombre']);
	$pagina="./".$_POST['pagina'];
	$descrip=strtoupper ($_POST['descrip']);
	
	if($nombre<>'' || $nombre<>NULL || $pagina<>'' || $pagina<>NULL)
		{
		$b_menu="select * from tmenu where nombre='$nombre'";
		$c_menu=pg_num_rows(pg_query($b_menu));
		if($c_menu==0)
			{
			$a_menu="select f_menu_insert($id, 0, '$nombre', '$pagina', '$descrip')";
			$resulta=pg_query($a_menu);
			$row_c=pg_fetch_row($resulta);
			if (!empty($row_c[0])) { echo "<script language='JavaScript'>alert ('El menú se agregó correctamente!!');";
									 echo "	window.location='alta_menu.php?".SID."';</script>"; }

			}
		else echo "<script language='JavaScript'>
				alert ('NOMBRE DE MENÚ EXISTENTE');
					</script>";
		}
	else echo "<script language='JavaScript'>
				alert ('No cargó ningun dato');
					</script>";
	}

//grabo nuevomenu que tiene submenues
if(isset($_POST['subagregar']))
	{
	if($_POST['nommenu']<>'' || $_POST['nommenu']<>NULL || $_POST['sublink']<>'' || $_POST['sublink']<>NULL || $_POST['subpagina']<>'' || $_POST['subpagina']<>NULL)
		{
		$nom=ucfirst($_POST['nommenu']);
		$nom_menu="select * from tmenu where nombre='$nom'";
		$cont_menu=pg_num_rows(pg_query($nom_menu));
		$descrip=strtoupper ($_POST['descrip_2']);				
		$descrip_m=strtoupper ($_POST['descrip_m']);
		
		if($cont_menu==0)
			{
			$max="select max(id_menu)+1 from tmenu where id_menu<>100";
			$id_max=pg_fetch_row(pg_query($max),0);
			if($_POST['submenu']==$id_max[0])
				{
				$id=$id_max[0];
				$nombre=ucfirst($_POST['nommenu']);
				$pagina='./submenu.php?SID&menu='.$id_max[0];
				$a_menu="select f_menu_insert($id, 0, '$nombre', '$pagina','$descrip_m')";
				//echo $a_menu;
				pg_query($a_menu);
				}
			else $id=$_POST['submenu'];
			//echo $id=$_POST['submenu'];
			$nom_submenu="select * from tmenu where nombre='".ucfirst($_POST['sublink'])."' and id_menu=$id";
			$cont_submenu=pg_num_rows(pg_query($nom_submenu));
			if($cont_submenu==0)
				{
				
				$id_sub="Select max (id_submenu)+1 from tmenu where id_menu=".$id;
				$idsub=pg_fetch_row(pg_query($id_sub),0);
				if($idsub[0]=='') $idsub[0]=1;
				$sublink=ucfirst($_POST['sublink']);
				$subpagina="./".$_POST['subpagina'];
				$a_submenu="select f_menu_insert($id, $idsub[0], '$sublink', '$subpagina','$descrip')";
				//echo $a_submenu;
				$resulta=pg_query($a_submenu);
				$row_c=pg_fetch_row($resulta);
				if (!empty($row_c[0])) { echo "<script language='JavaScript'>alert ('El menú se agregó correctamente!!');";
											   	 echo "	window.location='alta_menu.php?".SID."';</script>"; }
				}
			else echo "<script language='JavaScript'>
				alert ('NOMBRE DE SUBMENÚ EXISTENTE');
					</script>";

			}//ciero submenu == a nuevo menu
		else echo "<script language='JavaScript'>
				alert ('NOMBRE DE MENÚ EXISTENTE');
					</script>";
		}//cierro if igual a nada
		else echo "<script language='JavaScript'>
				alert ('No cargó ningun dato');
					</script>";
	}//cierro agregar submenu
////////////////////////////////////////////////////////////////////////////////////////////
/*$idquery="Select max (id_menu) from menu ";
$queryid=pg_query($idquery);
$id=pg_fetch_row($queryid,0);*/

$max="select max(id_menu)+1 from tmenu where id_menu<>100";
$id_max=pg_fetch_row(pg_query($max),0);
$id=$id_max[0];
?>
<table align="center" class="Tabla">

<tr>
<td colspan="2"><div align="center" class="letra_submenu_2">Alta Menúes 
</div>
  <hr></td>
</tr>
<tr>
<td>Id. Menú: </td>
<td><input type="text" size="3" maxlength="3" name="id" value="<? echo $id;//=$id[0]+1; ?>" readonly="true"></td>
</tr>
<tr>
<td>Link (nombre) Menú: </td>
<td><input type="text" size="50" maxlength="100" name="nombre" value="<? //echo $nombre; ?>"></td>
</tr>
<tr>
<td>Dirección Link Men&uacute;: </td>
<td><input type="text" size="50" maxlength="50" name="pagina" value="<? //echo $pagina; ?>"></td>
</tr>
<tr>
  <td class="letra_3">Descripci&oacute;n Men&uacute; (opcional) : </td>
  <td><input type="text" size="50" maxlength="100" name="descrip" value="<? if(isset($_POST[agregar])) echo $_POST['descrip']; ?>"></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input type="submit" name="agregar" value="Agregar Menú"><hr></div></td>
</tr>
<tr>
<td colspan="2"><div align="center"><font class="letra">Esta opción permite incorporar sólo menues los cuales no cuentan con submenues</font><hr></div></td>
</tr>
</table>
<br><br>
<table align="center" class="Tabla">
<tr>
<td colspan="2"><div align="center" class="letra_submenu_2">Alta Menú - SubMenúes y/o SubMenú
</div></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td>Seleccionar Menú: </td>
<td>
<? 

/*$max="select max(id_menu)+1 from menu";
$id_max=pg_fetch_row(pg_query($max),0);*/
?>
<select name="submenu" onChange="document.form1.submit()">
<? 
$menu="Select id_menu,nombre from tmenu where id_submenu=0 and id_menu in (select id_menu from tmenu where id_submenu>0) order by nombre";
$consultamenu=pg_query($menu);

while ($consulmenu=pg_fetch_array($consultamenu))
	{

	if($consulmenu[0]==$_POST['submenu']) $s='selected'; else $s='';
	echo "<option value='$consulmenu[0]' $s>" .$consulmenu[1]. "</option>";
	
	}

if($_POST['submenu']==$id_max[0]) $selected='selected'; else $selected='';?>

<option value="<? echo $id_max[0]?>" <? echo $selected;?>>Nuevo Menu</option>
</select>
</td>
</tr>
<? 
if($_POST['submenu']==$id_max[0])
	{
	?>
<tr>
<td>Id. Nuevo Menú: </td>
<td><input type="text" name="id" value="<? echo $id_max[0];?>" size="3" maxlength="3" readonly="true"></td>
</tr>
<tr>
<td>Link (nombre) Menú: </td>
<td><input type="text" size="50" maxlength="50" name="nommenu" value="<? echo $nommenu; ?>"></td>
</tr>
<tr>
  <td class="letra_3">Descripci&oacute;n Men&uacute; (opcional): </td>
  <td><input type="text" size="50" maxlength="100" name="descrip_m" value="<? if(isset($_POST[subagregar])) echo $_POST['descrip_m'];  ?>"></td>
</tr>
	<? }
	
?>
<tr>
<td>Link (nombre) Sub-Menú: </td>
<td><input type="text" size="50" maxlength="50" name="sublink" value="<? echo $sublink; ?>"></td>
</tr>
<tr>
<td>Dirección Link Sub-Men&uacute;: </td>
<td><input type="text" size="50" maxlength="100" name="subpagina" value="<? echo $subpagina; ?>"></td>
</tr>
<tr>
  <td class="letra_3">Descripci&oacute;n Sub-Men&uacute; (opcional): </td>
  <td><input type="text" size="50" maxlength="100" name="descrip_2" value="<? if(isset($_POST[subagregar])) echo $_POST['descrip_2']; ; ?>"></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input type="submit" name="subagregar" value="Agregar Submenú">
<hr></div></td>
</tr>
</table>

</form>
</body>
</html>
