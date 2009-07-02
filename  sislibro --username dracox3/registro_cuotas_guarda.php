<?php
include("cabecera.php");
include("funcionesGrales.php");

$dato=$_POST['idchequera'];
if(isset($_POST['enviar']) && !empty($_POST['monto']) && !empty($_POST['fecha']))
	{
	$monto=$_POST['monto'];
	$fecha=$_POST['fecha'];
	$num_cobrador=$_POST['num_cobrador'];	
	$recibo=$_POST['recibo'];
	$sqlCmd="select f_registra_cuota(".$_POST['idchequera'].",$monto,'$fecha',2,$num_cobrador,'".$r->getUser()."',$recibo) ";
	$rows=pg_fila($sqlCmd);

	 echo"<head><META HTTP-EQUIV='Refresh' CONTENT='1; URL=registro_cuotas.php?idchequera=$dato'></head>";
	} else{
		echo"<script>alert('campos vacios');</script>";
		
	}
?>