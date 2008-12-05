<? include("cabecera.php");
$ID_menu=$_SESSION['ID_menu'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<title>Modificación de menues y submenues</title>
</head>

<body>
<input type="button" name="salir" value="Volver" onClick="location.href='admin_menu.php?<? echo SID?>' ">

<form action="admin_modi_menu.php" method="post" name="form1">
<? 
if($_GET['id_menu']) { $id_menu=$_GET['id_menu']; $id_m=$_GET['id_menu']; }
if($_GET['id_submenu']) { $id_submenu=$_GET['id_submenu']; $id_subm=$_GET['id_submenu']; }

if (empty($id_subm) and empty($_POST['id_subm']) and isset($_POST['submenu']) ) { $id_subm=$id_submenu;  }  
if (empty($id_subm) and empty($id_submenu) and isset($_POST['submenu']) ) { $id_subm=$_POST['id_subm']; }
    else { $id_subm=$id_submenu; }

if (isset($_POST['aceptar']) or isset($_POST['subagregar']) or isset($_POST['agregar']))  $id_menu=$_POST['id_m'];


//-------------id_menu MAX PARA NUEVO MENU -----------
$sql_max="select max(id_menu)+1 as id_max from t_menu";
$result_1=pg_query($sql_max);
$row_1=pg_fetch_array($result_1);
$id_max[0]=$row_1[id_max];
/********** me fijo si es un submenu ***********************/
$sql_1=" select count(*) from t_menu where id_menu=$id_menu ";
$result = pg_query($sql_1);
$row_1 = pg_fetch_array($result);
$row_cant = $row_1[0];
//echo $sql_1;

// consulto los datos del menu
$sql=" select * from t_menu where id_menu=$id_menu and id_submenu=$id_subm";
//echo $sql;
$resulp = pg_query($sql);
$row = pg_fetch_array($resulp);

$plink=explode("?", substr($row['link'],2));
$mod=explode("submenu",$row['link']);
//----------------------------------------------------

//grabo nuevo menu
if(isset($_POST['agregar']))
	{
	$id=$_POST['id_menu'];
	$id_sub=$_POST['id_submenu'];
	$nombre=ucfirst($_POST['nombre']);
	$pagina="./".$_POST['pagina'];
	$descrip=strtoupper ($_POST['descrip']);
	
	if($nombre<>'' || $nombre<>NULL || $pagina<>'' || $pagina<>NULL) {
		
		//**** solo modifico
		if ($row_cant>1 and $row[id_submenu]==0) {		
		$pagina="./".$_POST['pagina']."?SID&menu=".$id;
		$a_submenu="select f_menu_update($id, $id_sub,$id,0, '$nombre', '$pagina', '$descrip')";
									//echo "<br>";
									//echo $a_submenu;
		$resulta=pg_query($a_submenu);
		$row_c=pg_fetch_row($resulta);
		if (!empty($row_c[0])) { echo "<script language='JavaScript'>alert ('El menú 0 se modificó correctamente!!');";
								 echo "	window.location='admin_menu.php?".SID."';</script>"; }
		$bandera=false;
		}
		/*** borro el menu *******/
		if ($row_cant==1 ) { 		
		$menu="select * from f_menu_delete($id, $id_sub)";
		$result=pg_query($menu);
		$row=pg_fetch_row($result);
		if($row[0]==1) $bandera=true; else $bandera=false; 
		}		
		/************************/
	if ($bandera==true) {				
					// si borro inserto					
					$a_menu="select f_menu_insert($id, $id_sub, '$nombre', '$pagina', '$descrip')";
					//echo $a_menu;
					$resulta=pg_query($a_menu);
					$row_c=pg_fetch_row($resulta);
					 if (!empty($row_c[0])) { echo "<script language='JavaScript'>alert ('El menú se modificó correctamente!!');";
											   	 echo "	window.location='admin_menu.php?".SID."';</script>"; }
					}
	}	else echo "<script language='JavaScript'>alert ('No cargó ningun dato');</script>";
}

/*********************************************************************************************************/
//grabo nuevomenu que tiene submenues
if(isset($_POST['subagregar']))
	{
	if($_POST['nommenu']<>'' || $_POST['nommenu']<>NULL || $_POST['nombre']<>'' || $_POST['nombre']<>NULL || $_POST['pagina']<>'' || $_POST['pagina']<>NULL)
				{
				$nom=ucfirst($_POST['nommenu']);
				$id=$_POST['id_menu'];     
				$id_menu2=$_POST['submenu'];
				$id_sub=$_POST['id_submenu'];
				$sublink=ucfirst($_POST['nombre']);
				$subpagina="./".$_POST['pagina'];
				$descrip=strtoupper ($_POST['descrip']);				
				$descrip_m=strtoupper ($_POST['descrip_m']);
				//---------------------------------------
				if($id<>$id_menu2 and $_POST['submenu']<>$id_max[0]) {
								//echo "SI pertenece a un nuevo menu";
								$id_maxsub="select max(id_submenu)+1 from t_menu where id_menu=$id_menu2";
								//echo "<br>";
								//echo $id_maxsub;
								$result=pg_query($id_maxsub);
								$row_maxsub=pg_fetch_row($result);
								$id_submenu2=$row_maxsub[0];
								if(!empty($row_maxsub[0]))  $bandera=1; 
								
							if($bandera==1) { 
								//echo "modifico la opcion";
								$a_submenu="select f_menu_update($id, $id_sub,$id_menu2,$id_submenu2, '$sublink', '$subpagina', '$descrip')";
								//echo "<br>";
								//echo $a_submenu;
								$resulta=pg_query($a_submenu);
								$row_c=pg_fetch_row($resulta);							
								//----------- verifico de q el submenu anterior no quede sin items o lo borro
								$sql="select count(*) from t_menu where id_menu=$id";
								//echo "<br>";
								//echo $sql;
								$result=pg_query($sql);
								$row_max=pg_fetch_row($result);
								if ($row_max[0]==1 or empty($row_max[0])) { 
										$sql_b="select * from f_menu_delete($id, 0)";
										$result=pg_query($sql_b);
										$row_max=pg_fetch_row($result);	} 					
								} 
								//---------------------------------------
							if (!empty($row_c[0])) { echo "<script language='JavaScript'>alert ('El menú se modificó correctamente!!');";
															 echo "	window.location='admin_menu.php?".SID."';</script>"; }
								
						 }
				//---------------------------------------
				if($_POST['submenu']==$id_max[0]) {
								//echo "SI pertenece a un nuevo menu NUEVO!!";
								//-------------id_menu
								$nombre=ucfirst($_POST['nommenu']);
								$pagina='./submenu.php?SID&menu='.$id_max[0];
								$a_menu="select f_menu_insert($id_max[0], 0, '$nombre', '$pagina', '$descrip_m')";
								//echo "<br>";
								//echo $a_menu;
								$result=pg_query($a_menu);
								$row_max=pg_fetch_row($result);
								if($row_max[0]==1) { $mensj="Se dio de alta el nuevo menù"; $bandera=1; }
								//-------------id_submenu
								$id_maxsub="select max(id_submenu)+1 from t_menu where id_menu=$id_max[0]";
								//echo "<br>";
								//echo $id_maxsub;
								$result=pg_query($id_maxsub);
								$row_maxsub=pg_fetch_row($result);
								$id_submenu2=$row_maxsub[0];
								if($row_maxsub[0]==1) { $bandera=1; }
								
						if($bandera==1) { 
							$a_submenu="select f_menu_update($id, $id_sub,$id_max[0],$id_submenu2, '$sublink', '$subpagina', '$descrip')";
							//echo "<br>";
							//echo $a_submenu;
							$resulta=pg_query($a_submenu);
							$row_c=pg_fetch_row($resulta);							
							//----------- verifico de q el submenu anterior no quede sin items o lo borro
								$sql="select count(*) from t_menu where id_menu=$id";
								//echo "<br>";
								//echo $sql;
								$result=pg_query($sql);
								$row_max=pg_fetch_row($result);
								if ($row_max[0]==1 or empty($row_max[0])) { 
										$sql_b="select * from f_menu_delete($id, 0)";
										//echo "<br>";
										//echo $sql_b;
								 		$result=pg_query($sql_b);
										$row_max=pg_fetch_row($result);										
										} 					
								} else $id_submenu2=$id_sub;
								//---------------------------------------
							if (!empty($row_c[0])) { echo "<script language='JavaScript'>alert ('El menú se modificó correctamente!!');";
															 echo "	window.location='admin_menu.php?".SID."';</script>"; }
								
						 }
						 //-------------------------------------------
						if($id==$id_menu2 and $_POST['submenu']<>$id_max[0]) {
							$id_submenu2=$_POST['id_submenu'];
							$a_submenu="select f_menu_update($id, $id_sub,$id_menu2,$id_submenu2, '$sublink', '$subpagina', '$descrip')";
							//echo "<br>";
							//echo $a_submenu;
							$resulta=pg_query($a_submenu);
							$row_c=pg_fetch_row($resulta);	
							if (!empty($row_c[0])) { echo "<script language='JavaScript'>alert ('El menú se modificó correctamente!!');";
													 echo "	window.location='admin_menu.php?".SID."';</script>"; }
								
						 }						
								
				}			
		else echo "<script language='JavaScript'>
				alert ('Faltan datos!!');
					</script>";
	}//cierro agregar submenu
/*********************************************************************************************************/


?>

<? if ($row_cant==1 or ($row_cant>1 and $row[id_submenu]==0)) {?>
<table align="center" class="Tabla">

<tr>
<td colspan="2"><div align="center" class="letra_submenu_2">Modifica Menúes 
</div>
  </td>
</tr>
<tr><td colspan="2">
<hr>
</td>
</tr>

<tr>
<td>Id. Menú: 
  <input type="hidden" name="id_m" value="<? if(isset($_POST[submenu])) echo $_POST['id_m']; else echo $id_menu;?>">
<td><input type="text" name="id_menu" value="<? if(isset($_POST[agregar])) echo $_POST['id_menu']; else echo $id_menu;?>" size="3" maxlength="3" readonly="true">  </td>
</tr>
<tr>
  <td>Id. SubMen&uacute;:
  <td>        <input type="text" name="id_submenu" value="<? if(isset($_POST[agregar])) echo $_POST['id_submenu']; else echo $id_submenu; ?>" size="3" maxlength="3" readonly="true"></td></tr>
<tr>
<td>Link (nombre) Menú: </td>
<td><input type="text" size="50" maxlength="50" name="nombre" value="<? if(isset($_POST[agregar])) echo $_POST['nombre']; else echo $row['nombre'];  ?>"></td>
</tr>
<tr>
  <td>Direcci&oacute;n Link Men&uacute;: </td>
  <td><input type="text" size="50" maxlength="100" name="pagina" <? if(!empty($mod[1])) { echo "readonly='yes'"; } ?>  value="<? if(isset($_POST[agregar])) echo $_POST['pagina']; else echo $plink[0]; ?>"></td>
</tr>
<tr>
<td class="letra_3">Descripci&oacute;n Men&uacute; (opcional): </td>
<td><input type="text" size="50" maxlength="100" name="descrip" value="<? if(isset($_POST[agregar])) echo $_POST['descrip']; else echo $row['descripcion']; ?>"></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input type="submit" name="agregar" value="Modificar Menú"><hr></div></td>
</tr>
<tr>
<td colspan="2"><div align="center"><font class="letra">Esta opción permite modificar sólo menues los cuales no cuentan con submenues</font>
    <hr></div></td>
</tr>
</table>
<? } else { ?>
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
<td>Seleccionar Menú: 
</td>

<td>
<select name="submenu" onChange="document.form1.submit()">
<? 
$menu="Select id_menu,nombre from t_menu where id_submenu=0 and id_menu in (select id_menu from t_menu where id_submenu>0) order by nombre";
$consultamenu=pg_query($menu);

while ($consulmenu=pg_fetch_array($consultamenu))
	{

	?>
	<option value=<? echo $consulmenu[0]?> <? if( (!isset($_POST[submenu]) and $consulmenu[0]==$row['id_menu']) or ( isset($_POST[submenu]) and $consulmenu[0]==$_POST['submenu']) ) echo 'selected'?> ><? echo $consulmenu[1]; ?></option>
	<?
	}

?>

 <option value="<? echo $id_max[0]?>" <? if(isset($_POST[submenu]) and $_POST['submenu']==$id_max[0]) echo 'selected'?> >Nuevo Menu</option> 
</select>

</td>
</tr>
<? 
if(isset($_POST[submenu]) and $_POST['submenu']<>$id_max[0]) {
$id_nuevo=$_POST[submenu];
}
?>
<tr>
  <td>Id. Nuevo Menú:
    <input type="hidden" name="id_m" value="<? if(isset($_POST[submenu])) echo $_POST['id_m']; else echo $id_menu;?>"></td>
  <td><input type="text" name="id_menu" value="<? if(isset($_POST[subagregar])) echo $_POST['id_menu']; else echo $id_menu;?>" size="3" maxlength="3" readonly="true"></td>
</tr>
<tr>
<td>Id. SubMen&uacute;: 
  <input type="hidden" name="id_subm" value="<? if(isset($_POST[submenu])) echo $_POST['id_subm']; else echo $id_submenu;?>"></td>
<td><input type="text" name="id_submenu" value="<? if(isset($_POST[subagregar])) echo $_POST['id_submenu']; else echo $id_submenu; ?>" size="3" maxlength="3" readonly="true">
<!--   <input type="text" name="id_submenu2" value="<? if(isset($_POST[subagregar]) or isset($_POST[submenu])) echo $id_nuevo; ?>" size="3" maxlength="3" readonly="true"></td>
 --></tr>
<? if(isset($_POST[submenu]) and $_POST['submenu']==$id_max[0]) { ?>
<tr>
  <td>Link (nombre) Men&uacute;: </td>
  <td><input type="text" size="50" maxlength="50" name="nommenu" value="<? if(isset($_POST[subagregar])) echo $_POST['nommenu']; ?>"></td>
</tr>
<tr>
  <td class="letra_3">Descripci&oacute;n Men&uacute; (opcional): </td>
  <td><input type="text" size="50" maxlength="100" name="descrip" value="<? if(isset($_POST[subagregar])) echo $_POST['descrip_m'];  ?>"></td>
</tr>
<? } ?>
<tr>
<td>Link (nombre) Sub-Menú: </td>
<td><input type="text" size="50" maxlength="50" name="nombre" value="<? if(isset($_POST[subagregar])) echo $_POST['nombre']; else echo $row['nombre'];  ?>"></td>
</tr>
<tr>
  <td>Direcci&oacute;n Link Sub-Men&uacute;: </td>
  <td><input type="text" size="50" maxlength="100" name="pagina" value="<? if(isset($_POST[subagregar])) echo $_POST['pagina']; else echo $plink[0]; ?>"></td>
</tr>
<tr>
<td class="letra_3">Descripci&oacute;n Sub-Men&uacute; (opcional): </td>
<td><input type="text" size="50" maxlength="100" name="descrip" value="<? if(isset($_POST[subagregar])) echo $_POST['descrip']; else echo $row['descripcion']; ?>"></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input type="submit" name="subagregar" value="Modificar Submenú">
<hr></div></td>
</tr>
</table>
<? }  ?>
</form>
</body>
</html>

