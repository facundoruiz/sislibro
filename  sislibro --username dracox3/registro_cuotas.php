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

<div class="t_datos"><div class="titulos">SISTEMAS</div></div>
<div class="descripcion">


<?PHP 
$conex=new gestorConexion();
$conex->getMiconexion();
$datos=$_GET['idchequera']; 
$sqlCmd="select * from f_desc_cuota($datos) ";
$rs=pg_fila($sqlCmd);
 $rs['monto_cuota'];
  $rs['idcuota'];
   
  
   $rs['fecha_pago'];
   
   $gc=new gestorCliente($conex);
   $cliente=$gc->get_clienteId($rs['id_cliente']);
   
?>

<table class="caja" >
<tr><td class="rotulo" colspan="2">Informacion de la cuenta</td></tr>
<tr><td class="rotulo">Nº de chequera</td><td class="datos"><?PHP echo $rs['num_chequera'];?></td></tr>
<tr><td class="rotulo">cliente: </td><td class="datos"><?PHP echo $cliente->get_Nombre().";".$cliente->get_Apellido();?> </td></tr>
<tr><td class="rotulo">Plan :</td><td class="datos"><?PHP echo $rs['cant_cuota']." X $".$rs['importe_cuota']; ?> </td></tr>
<tr><td class="rotulo">Nº de cuota </td><td class="datos"><?PHP echo "<b>".$rs['num_cuota']."</b> pago:".$rs['fecha_pago'];?> </td></tr>
<tr><td class="rotulo" colspan="2"> <?PHP echo$rs['saldo']!='t'?$rs['num_cuota']:'Saldo :'.$rs['monto_cuota'];?> </td></tr>
<tr><td class="datos">monto <input type="text" name="enviar" value="" onKeyPress="return soloNum(event)" size="4"> fecha<input type="text" name="fecha" value="dd/mm/aaaa" size="11"> </td><td class="datos"><input type="submit" name="enviar" value="registrar Nueva cuota"> </td></tr>
</table>
<p>
<p>
</div></td>
</tr>
</table>
</div>

</body></html>