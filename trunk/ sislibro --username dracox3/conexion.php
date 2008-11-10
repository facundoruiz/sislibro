<?php 

function abrir_conexion() {
	include("config.php");
		$idcon=pg_connect("host='$server' port='$puerto' dbname='$database' user='$usuario' password='$clave'") or die("No pudo Conectarse al servidor".pg_last_error());
		pg_query("SET STATEMENT_timeout to 120000;");
		pg_query("SET DATESTYLE TO sql,dmy;");
	
return $idcon;
}

function cerrar_conexion($idcon) {
pg_close($idcon);
}

?>