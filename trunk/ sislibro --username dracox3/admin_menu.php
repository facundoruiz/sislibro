<?php  include("cabecera.php"); 

$ID_menu=$_SESSION['ID_menu'];

if($_GET['borra'])  $borra=$_GET['borra'];
if($_GET['listar'])  $listar=$_GET['listar'];
if($_GET['id_menu'])  $id_menu=$_GET['id_menu'];
if($_GET['id_submenu'])  $id_submenu=$_GET['id_submenu'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Administrar Menús</title>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="admin_menu.php" method="post" name="form1">
<table width="750" border="0"  align="left" class="boton_tabla">
	  <tr>
		<td colspan="4">
<? 

	if (empty($b) or $b==0)
	{  ?>
	 <div align="center"><span align="center" class="letra_titulo_grande">   ADMINISTRADOR DE MENUS </span></div> 
	  <?php echo "<br>";?>  
	<?
	 
	if ($borra==1 and empty($row_b[0]))
	{
			//echo "select * from f_menu_delete($id_menu,$id_submenu);";
			$result = pg_query( "select * from f_menu_delete($id_menu,$id_submenu);");
			$row_b = pg_fetch_row($result);
			if ($result and !empty($row_b) )
			{
				 $b=1;
		?>				
								 
				<table  border="0" align="center">
					<tr>
						<td   ><span class="letra_mensaje">
							<?  if (!empty($row_b[0])) { echo "El menu fue borrado correctamente!!"; } else { echo "No se pudo borrar el menu!!"; }?></span>
						</td>
					</tr>
				</table>  
		<? 
			}			
	}  
	?>
	
	
	
	<table width="750" border="0"  align="center" class="boton_tabla">
	  <tr>
		<td colspan="4">
		<table  border="0">
		  <tr>
			<td width="851" >
		      <div align="left">
		        <input type="button" name="salir" value="Volver" onClick="location.href='submenu.php?<? echo SID?>&menu=<? echo $ID_menu?>' ">
		        <input type="button" name="nuevo" value="Alta Men&uacute;" onClick="location.href='alta_menu.php?<? echo SID?>' ">
                
				<select name="submenu" onChange="document.form1.submit()">
				  <option value="nada" <? if($_POST['submenu']=='nada' or $listar=='nada' ) echo 'selected'; ?> >Todos</option>
				  <option value="raiz" <? if($_POST['submenu']=='raiz' or $listar=='raiz' ) echo 'selected'; ?>>Menu principal</option>
                  <? 
$menu="Select id_menu,nombre from t_menu where id_submenu=0 and id_menu in (select id_menu from t_menu where id_submenu>0) order by nombre";
$consultamenu=pg_query($menu);

while ($consulmenu=pg_fetch_array($consultamenu))
	{
	
	if($consulmenu[0]==$_POST['submenu'] or $consulmenu[0]==$listar) $s='selected'; else $s='';
	echo "<option value='$consulmenu[0]' $s>" .$consulmenu[1]. "</option>";
	
	}?>
	
	</select>
		      </div></td>
		  </tr>
		</table>
	   </td>
	  </tr>
	  <tr>
		<td colspan="4">
	 <?php 
	
	$sql="select * from t_menu ";
	
	if($_POST['submenu'] and $_POST['submenu']<>'nada' and $_POST['submenu']<>'raiz'  ) $sql.=" where id_menu= ".$_POST['submenu'];
	if(isset($_POST['submenu']) and  $_POST['submenu']=='raiz' ) $sql.=" where id_submenu= 0";
	
	if(!empty($listar) and $listar<>'nada' and $listar<>'raiz'  ) $sql.=" where id_menu= ".$listar;
	if(!empty($listar) and  $listar=='raiz' ) $sql.=" where id_submenu= 0";
	
	/****** orden *************/
	$orden_f=($_POST['orden'])?$_POST['orden']:'id_menu,id_submenu';
	$sql.=" order by $orden_f";
	/*************************/
	//echo $sql;
	$resulp = pg_query($sql);
	if (!$resulp)  { echo"ha ocurrido un error!"; 	}
	$row = pg_fetch_array($resulp);
	
	$totalc=pg_num_rows($resulp);
	if ($totalc >0 )
	{  
		  ?> 	
	   <table border="1" align="center" class="Tabla">
	  <tr bgcolor="DDDDDD"   class="letra_celeste">
		<td width="71" ><strong>
		  <input name="orden" type="radio" value="id_menu,id_submenu" onClick="submit()" <?php echo (!$_POST['orden'] or $_POST['orden'])=='id_menu,id_submenu'?'checked':''; ?>>
		</strong> Menu </td>
		<td width="103" bgcolor="DDDDDD" ><strong>
		  <input name="orden" type="radio" value="id_submenu" onClick="submit()" <?php echo ($_POST['orden'])=='id_submenu'?'checked':''; ?>>
		</strong>Submenu</td>
		<td width="208" bgcolor="DDDDDD" ><strong>
		  <input name="orden" type="radio" value="nombre" onClick="submit()" <?php echo ($_POST['orden'])=='nombre'?'checked':''; ?>>
		</strong>Descripci&oacute;n</td>
		<td width="70" ><strong>
		  <input name="orden" type="radio" value="link" onClick="submit()" <?php echo ($_POST['orden'])=='link'?'checked':''; ?>>
		</strong>Link</td>		
		<td width="68" ><strong>
		</strong>Modificar</td>
	  	<td width="52" ><strong>
	  	</strong>Borrar</td>
	  </tr>
	  <? 
	
	
	  while(!empty($row))
	  {
	  ?>
	
	  <tr >
		<td class="Estilo3_negrita" ><?php echo $row['id_menu'];?>&nbsp;</td>
		<td class="Estilo3_negrita"><?php echo $row['id_submenu'];?></td>
		<td class="Estilo3_negrita"><?php echo $row['nombre'];?>&nbsp;</td>
		<td class="Estilo3_negrita"><?php echo $row['link'];?>&nbsp;</td>
		<td>
		<!-- <input type="button" name="modificar" value="Modificar"  onClick="location.href='menu_modi.php?id_menu=<?php echo $row['id_menu'];?>&id_submenu=<?php echo $row['id_submenu'];?>' ">
			-->
			<? $mod=explode("submenu",$row['link']); ?>
			<input type="button" name="modificar" value="Modificar" <? //if(!empty($mod[1])) { echo "disabled"; } ?>   onClick="location.href='admin_modi_menu.php?id_menu=<?php echo $row['id_menu'];?>&id_submenu=<?php echo $row['id_submenu'];?>' "> 
	        </td>
		<td><input type="button" name="borrar" value="Borrar" <? if(!empty($mod[1])) { echo "disabled"; } ?> onClick="location.href='admin_menu.php?borra=<?php echo "1"; ?>&id_menu=<?php echo $row['id_menu'];?>&id_submenu=<?php echo $row['id_submenu'];?>&listar=<? echo $_POST['submenu']?>' ">
	      </td>
		</tr>
	  <? 
	  $row = pg_fetch_array($resulp);
	  } ?>
	  
	  
	    <tr >
	    <td colspan="6" ><?
	}
	else
	{ ?>
          <div align="center"><span class="letra_mensaje">No hay menus en el sistema!</span>
	  
	        <?
	}
	
	?>
          </div></td>
	    </tr>
		<tr>
		<td colspan="6">
		    <div align="right">
		    </div></td>
		</tr>
	  </table>
	
	 <tr>
	   <td colspan="3">
	  <tr>
		<td width="502">&nbsp;</td>
		<td width="168"><a href="menuweb_editar.php?valor=<? echo "A"?>&b=0&subt=<? echo "NUEVO MENÚ"?>" > </a>&nbsp;
	    </td>
		<td width="86">&nbsp;
	</td>
	  </tr>	   
	   
  </table>
	<?  
	}

?>

</td>
	  </tr>	   
	   
  </table></form>
</body>
</html>
