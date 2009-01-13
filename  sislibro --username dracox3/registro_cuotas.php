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

<div class="t_datos"><div class="titulos">Registro de Cuotas</div></div>
<div class="descripcion">


<?PHP 
	$conex=new gestorConexion();
	$conex->getMiconexion();
	
	$datos=$_GET['idchequera']?$_GET['idchequera']:$_POST['idchequera'];

	
	
	$sqlCmd="select * from f_desc_cuota($datos) ";
	$rs=pg_fila($sqlCmd);
	$cobrador=$rs['idcobrador'];

	$gc=new gestorCliente($conex);
    
	$cliente=$gc->get_clienteId($rs['id_cliente']);
	
	if(isset($_POST['enviar']))
	{
	$monto=$_POST['monto'];
	$fecha=$_POST['fecha'];
	echo $sqlCmd="select f_registra_cuota($datos,$monto,'$fecha',2,$cobrador ) ";
	$rows=pg_fila($sqlCmd);
	
	} 
 
	
	
	
	$sqlCmd="select * from f_desc_cuota($datos) ";
	$rs=pg_fila($sqlCmd);
	$cobrador=$rs['idcobrador'];
?>
<form name="form1" action="" method="POST">
<input type="hidden" name="idchequera" value="<?PHP echo $_GET['idchequera']?>"  >
<table class="caja" >
<tr><td class="rotulo" colspan="2">Informacion de la cuenta</td></tr>
<tr><td class="rotulo">Nº de chequera</td><td class="datos"><?PHP echo $rs['num_chequera'];?></td></tr>
<tr><td class="rotulo">cliente: </td><td class="datos"><?PHP echo $cliente->get_Nombre().";".$cliente->get_Apellido();?> </td></tr>
<tr><td class="rotulo">Plan :</td><td class="datos"><?PHP echo $rs['cant_cuota']." X $".$rs['importe_cuota']; ?> </td></tr>
<tr><td class="rotulo">Nº de cuota </td><td class="datos"><?PHP echo "<b>".$rs['num_cuota']."</b> pago:".$rs['fecha_pago'];?> </td></tr>
<tr><td class="rotulo" colspan="2"> <?PHP echo$rs['saldo']!='t'?$rs['num_cuota']:'Saldo :'.$rs['monto_cuota'];?> </td></tr>
<tr><td class="datos">monto <input type="text" name="monto" value="" onKeyPress="return soloNum(event)" size="4"> fecha<input type="text" name="fecha" value="<?php echo (isset($_POST['fecha']))?$fecha=$_POST['fecha']:'dd/mm/aaaa';?>" onBlur="valFecha(this)" size="11"> </td><td class="datos"><input type="submit" name="enviar" value="registrar Nueva cuota"> </td></tr>
<tr><td class="datos"><?PHP echo isset($rows[0])?$rows[0]:'Saldo ';?></td></tr>
</table>
<p>
<p></form>
</div></td>
</tr>
</table>
</div>

</body></html>