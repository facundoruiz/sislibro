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
<?php echo $r->Submenu(1); ?>
      </div>
<td  class="centro">

<div class="t_datos"><div class="titulos">ASIGNAR OPCION MENUS</div></div>
<div class="descripcion">
  
     
     	
<form name="form1" method="post" action="<?php echo $PHP_SELF;?>?SID">
  
<?php 
	$perfsel=($_POST['perfil'])?$_POST['perfil']:1;
	if ($_POST['paya']){
		$i=0;
		$dispo2=$_POST['dispo'];
		while ($i < count($_POST['dispo'])){
$sub=explode("@",$dispo2[$i]);
			echo$sqlAsig="insert into t_funcion_menu (id_funcion,id_menu,id_submenu)values($perfsel,$sub[0],$sub[1])";
			$recAs=@pg_query($sqlAsig);
			if (!$recAs)	
				echo "ERROR";
			$i++;
		}
	}
	else{
		if(isset($_POST['paca'])){
			$i=0;
			$quita2=$_POST['asig'];
			while ($i < count($_POST['asig'])){
				$sub=explode("@",$quita2[$i]);
				$sqlquita="delete from t_funcion_menu where id_funcion=$perfsel and id_menu=$sub[0] and id_submenu=$sub[1]";
				$recDi=@pg_query($sqlquita);
				if (!$recDi)	
					echo "ERROR";
				$i++;
			}
		}
	}
	$sqlbus="select descrip from diccionario where item=$perfsel and cod=7";
	$resu=@pg_query($sqlbus);
	if ($resu>0)
		$datbus=pg_fetch_array($resu);
?> 
Opciones de men&uacute;es asignados a cada perfil <BR> 
   		<select name="perfil" size="1" id="perfil" onChange="javascrip:submit()">
		   <?php	
			$sqlgrup="select item,descrip from diccionario where codigo=3 order by descrip";
			if ($rperfil=@pg_query($sqlgrup))
				while($aperfil = pg_fetch_array($rperfil)){ ?>
					  <option value="<?php echo $aperfil['item'];?>"<?php echo ($aperfil['item']==$perfsel)?" selected":""?>>
						   <?php echo $aperfil['descrip'];?> 
		    </option>
		  <?php }   ?>
        </select>      
      <?php // echo $perfsel;?>Perfil Seleccionado:
	      <?php echo $aperfil['descrip']?><BR>
	      <TABLE ALIGN="CENTER">
	      <TR><TD>Disponibles</TD>
     <TD>Asignados</TD></TR>
     <TR><TD>
        <select name="dispo[]" size="15" multiple id="dispo[]" style="font:'Courier New'" class="letra">
          <?php	
		$sqlusulib = "select m.nombre,m.id_menu,m.id_submenu from t_menu m left join t_funcion_menu fm on (fm.id_menu=m.id_menu and  fm.id_submenu=m.id_submenu) where (fm.id_funcion<>$perfsel and (fm.id_menu not in(select id_menu from t_funcion_menu fm2 	where id_funcion=$perfsel  )or fm.id_submenu not in(select id_submenu from t_funcion_menu fm2 	where id_funcion=$perfsel  ))) or fm.id_menu is null group by m.nombre,m.id_menu,m.id_submenu order by id_menu asc , id_submenu asc";
		 $sqlusulib;
		if ($recusulib=@pg_query($sqlusulib))
			if(pg_num_rows($recusulib)>0)
			{
				while($datusulib = pg_fetch_array($recusulib))
				{ ?>
          <option value="<?php echo $datusulib['id_menu']."@".$datusulib['id_submenu'];?>"> 
		  <?php //echo $datusulib['nombre'].str_repeat("&nbsp;",50-strlen($datusulib['nombre']));
		echo($datusulib['id_submenu']>0)?"&nbsp;&nbsp;|_".$datusulib['nombre']:$datusulib['nombre'];		
				?></option>

		  <?php } 
		}
		else
		{?>
          <option value="0"><?php echo str_repeat("&nbsp;",25);?></option>
          <?php 
		}?>
        </select>
        <input name="paya" type="submit" id="paya" value="Agregar -&gt;" class="button">
   </TD> <TD>
    <select name="asig[]" size="15" multiple id="asig[]" class="letra">
        <?php	
		
		$sqlusuocu = "select m.nombre,m.id_menu,m.id_submenu  ";
		$sqlusuocu.= " from t_funcion_menu fm inner join t_menu m on (fm.id_menu=m.id_menu and fm.id_submenu=m.id_submenu) ";
		$sqlusuocu.= " where fm.id_funcion=$perfsel ";
		$sqlusuocu.= " group by m.nombre,m.id_menu,m.id_submenu  ";
		$sqlusuocu.= " order by id_menu asc , id_submenu asc";
		
		echo "<br>$sqlusuocu ";
		if ($recusuocu=@pg_query($sqlusuocu))
			if (pg_num_rows($recusuocu)>0)
			{
				while($datusuocu = pg_fetch_array($recusuocu))
				{ ?>
			<option value="<?php echo $datusuocu['id_menu']."@".$datusuocu['id_submenu'];?>">
			<?php //echo $datusuocu['nombre'].str_repeat("&nbsp;",50-strlen($datusuocu['nombre']));
					echo($datusuocu['id_submenu']>0)?"&nbsp;&nbsp;|_".$datusuocu['nombre']:$datusuocu['nombre'];	
			?></option>

			<?			 }
				}
			else 
				{?>
				<option value="0"><?php echo str_repeat("&nbsp;",25);?></option>
				<?php } ?>
      </select>
        <input name="paca" type="submit" id="paca" value="&lt;- Eliminar" class="button">
     </TD></TR>
     </TABLE>
</form>

</div></td>
</tr>
</table>
</div>
<div class="pie">

<div class="letracapital">Action2</div>
<p class="copy">Desarrollo de sistemas</p>
</div></div>
</div>
</body></html>