<?php 
include("cabecera.php");

$user=$_SESSION['miuser'];
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
<?php echo $r->Submenu(3); ?>
      </div>
<td  class="centro">


<div class="descripcion">

<?php
$b=0;


if(isset($_POST['baction'])){
	
	if(!empty($_POST['dni'])||!empty($_POST['NoA'])){
		if($_POST['option']==1){
			$dni=$_POST['dni'];
			$sql0.=" where  tc.dni=$dni  ";
			$b=1;
		}else{
			$nombre=strtoupper ($_POST['nombre']);$apellido=strtoupper ($_POST['apellido']);
			$sql0=" where  tc.apellido ilike'%$apellido%' and  tc.nombre ilike'%$nombre%' ";$b=1;
			}
	}else{ 
	echo"<SCRIPT >alert('El Campo esta vacio ')</SCRIPT>";
	}
}

//&&($_GET['d']==1)

if($b!=0){/*
$sql="select distinct (tc.apellido||', '||tc.nombre )as apynom,c.num_chequera,c.id_venta,(c.cant_cuota||' X $'||c.importe_cuota) as plan,tc.id_clientes,c.fecha,descempleado(c.id_vendedor) as vendedor,descempleado(c.id_cobrador) as cobrador,c.cobrado,coalesce(c.cant_cuota = tcuo.cuota) as debe,
coalesce((c.cant_cuota - tcuo1.M_cuota),'0') as queda,tc.dni
 from compras c 
left join tcuotas  tcuo on (tcuo.id_venta=c.id_venta and (c.cant_cuota = tcuo.cuota))
left join (select Max(cuota) as M_cuota,id_venta from tcuotas group by id_venta)  tcuo1 on ( tcuo1.id_venta=c.id_venta and (c.cant_cuota > tcuo1.M_cuota))
inner join tclientes tc on (tc.id_clientes=c.id_clientes) ".$sql0;*/
$sql=" select c.num_chequera,c.id_venta,(tc.apellido||', '||tc.nombre )as apynom,tc.dni,descempleado(c.id_vendedor) as vendedor,c.id_vendedor,descempleado(c.id_cobrador) as cobrador,c.id_cobrador,(c.cant_cuota||' X $'||c.importe_cuota) as plan,tcuo3.fecha as ultfecha,age((select fecha()), tcuo3.fecha) as mes,(select fecha() - tcuo3.fecha) as mes1,tcuo2.M_cuota";
$sql.=",c.cobrado,coalesce(c.cant_cuota = tcuo.cuota) as debe,coalesce((c.cant_cuota - tcuo2.M_cuota),'0') as queda,coalesce(c.importe_cuota = tcuo.importe) as quedaimport,tc.id_clientes,coalesce(age((select fecha()),c.fecha))as sincuota,c.fecha";
$sql.=" from compras c ";
$sql.="left join tcuotas  tcuo on (tcuo.id_venta=c.id_venta and (c.cant_cuota = tcuo.cuota))";
$sql.="left join (select Max(cuota) as M_cuota,id_venta from tcuotas group by id_venta) tcuo1 on ( tcuo1.id_venta=c.id_venta and (c.cant_cuota > tcuo1.M_cuota))";
$sql.="left join  (select Max(cuota) as M_cuota, id_venta from tcuotas  group by id_venta ) tcuo2 on (c.id_venta=tcuo2.id_venta ) ";
$sql.="left join  (select id_venta, Max(fecha) as fecha from tcuotas group by id_venta ) tcuo3 on (tcuo2.id_venta=tcuo3.id_venta ) inner join tclientes tc on (tc.id_clientes=c.id_clientes) ";
$sql.=$sql0;

	 if(pg_fila($sql)>0){

	?><CENTER><H1>Estados de Cuenta de Clientes</H1></CENTER>
<TABLE class='ta' border="1" cellspacing="1" cellpadding="1" align="center">
<TR class='tt' bgcolor=#6699FF  align="center">

	
		
	<TD  >Nº Cheq.</TD>
	<TD >Nº Sist</TD>
		<TD >DNI</TD>
	<TD >Cliente Apellido y Nombre</TD>
	<TD >ultFecha</TD>
	<TD >Plan</TD>
	<TD >Cuotas Impagas</TD>
	<!-- 
		<TD >Vendedor</TD>
		<TD >Cobrador</TD> -->
	<TD >Estado</TD>	
	<TD >Libros</TD>
</TR>

<?php $banfondo=true;
	$q=pg_query($sql);
while($r=pg_fetch_array($q)){

	?>
<TR onMouseOver="uno(this,'yellow');" onMouseOut="dos(this,'<?php echo ($banfondo)?'':'#CCFFFF';?>');"  bgcolor="<?php echo ($banfondo)?'':'#CCFFFF';$banfondo=!$banfondo;?>" class="ta">

	<TD><B><?PHP echo$r['num_chequera']?></B></TD>
	<TD><?PHP echo$r['id_venta']?></TD>
	<TD><?PHP echo$r['dni']?></TD>
	<TD ><A onClick="javascript:v_abrir2('a_clientes.php?dato=<?PHP echo$r['id_clientes']?>')">[<?PHP echo$r['apynom']?>]</A></TD>
	<TD><?PHP if(empty($r['ultfecha'])){
	$mes=explode (' ',$r['sincuota']);
	echo($r['debe']!='t'||$r['quedaimport']!='t')?"<FONT  COLOR='red'>".$mes[1]." ".$mes[2]." ".$mes[3]." ".$mes[4]." </FONT>":"---";}else{echo$r['ultfecha'];}?>
	
	</TD>
	
	<TD><?PHP echo$r['plan']?></TD>
	<TD align="center"><?PHP 
/*	$j= ($r['queda']!='0')?"".$r['queda']."":"Falta 1ª cuota";	
	$mes=explode (' ',$r['mes']);
	$mon=($r['debe']!='t'||$r['quedaimport']!='t')?"<FONT  COLOR='red'>".$mes[1]." ".$mes[2]." ".$mes[3]." ".$mes[4]." </FONT>":"---";

	echo ($r['debe']!='t')?''.$j.'/'.$mon:'No';
*/		
	$j= ($r['queda']!='0')?"".$r['queda']." ":"Falta 1ª cuota";	
	if($r['mes1']>59){
		$mes=explode (' ',$r['mes']);
	$mon=($r['debe']!='t'||$r['quedaimport']!='t')?"/<FONT  COLOR='red'>".$mes[1]." ".$mes[2]." ".$mes[3]." ".$mes[4]." </FONT>":"---";
	}

	echo ($r['debe']!='t')?''.$j.' '.$mon:'No';
	?></TD>
		
	<!-- <TD><A onclick="javascript:v_abrir2('a_empleados.php?dato=<?PHP echo$r['id_vendedor']?>')">[<?PHP echo$r['vendedor']?>]</A></TD>
	<TD><A onclick="javascript:v_abrir2('a_empleados.php?dato=<?PHP echo$r['id_cobrador']?>')">[<?PHP echo$r['cobrador']?>]</A></TD> -->
	<TD width="100"><?echo ($r['debe']!='t')?'<A HREF="javascript:v_abrir(\'m_cuotas.php?dato='.$r['num_chequera'].'&&dato2='.$r['id_venta'].'&&from=m_s_cliente\')"">Pagos</A>':'<FONT SIZE="" COLOR="red">PAGADO</FONT>';?></TD>
		<TD ><?php echo'<A HREF="javascript:v_abrir(\'libros.php?dato='.$r['num_chequera'].'&&dato2='.$r['id_venta'].'&&from=m_s_cliente\')"">libros</A>';?></TD>
</TR>
<?php }?>
</TABLE>
<?php }else{ echo"<CENTER><H3>No hay datos para mostrar </H3></CENTER>";}}?>
<div class="t_datos"><div class="titulos">Buscar clientes</div></div> 

<FORM METHOD=POST ACTION="" name="form">
<table  align="center" class="formulario">          
 
   <tr >
      
<?php if($_POST['option']==1) {?>
	  <th scope="row" class="rotulo" >DNI </th>
      <td>	 
	  <input type="text"  name="dni" maxlength="8" onKeyPress="return soloNum(event)" title="Ingrese Num de Documento" value="<?php echo $dni?>">
	  	<? }else{ ?>
	  <th scope="row" class="rotulo">Apellido del cliente </th>
      <td >	 
      <input type="text" class="ta"  name="NoA"  title="Ingrese apellido o nombre" value="<?php echo $apellido?>">  		
	  		
	  	<? } ?>
	  <select name="option" onChange="document.form.submit()">
	  <option value="1" <?php echo(1==$_POST['option'])?'selected':'';?>>DNI</option>
	  <option value="2" <?php echo(2==$_POST['option'])?'selected':'';?>>Apellido o Nombre</option>
	  </select>
	  <INPUT TYPE="submit" name="baction"  value="Buscar" title="Click para buscar DNI" onClick="document.form.submit()">      	
  		</td> 
  	</tr>
 	
 	   
</table>
<A HREF="javascript:document.location.href='clientes_buscar.php'" class="button">Limpiar Formulario</A></CENTER>

</FORM>


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