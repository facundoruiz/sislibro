<?php
include("cabecera.php");
include("funcionesGrales.php");
require('valida.php');	
						$form=$_POST['form'];	
						$dni=$_POST['dni'];	
						$apellido=strtoupper ($_POST['apellido']);
						$nombre=strtoupper ($_POST['nombre']);
						$domicilio=strtoupper ($_POST['domicilio']);
						$telefono=$_POST['telefono'];
						$cel=$_POST['cel'];
						$prov=$_POST['prov'];
						$Loc=$_POST['Loc'];
						$moroso=$_POST['moroso'];
						$barrio=strtoupper ($_POST['barrio']);
						$obs=strtoupper ($_POST['obs']);
						$altdomicilio=strtoupper ($_POST['altdomicilio']);
						
						$trabajodomicilio=strtoupper ($_POST['trabajodomicilio']);
						$trabajotelefono=$_POST['trabajotelefono'];
						$trabajobarrio=strtoupper ($_POST['trabajobarrio']);
						$trabajoprov=$_POST['trabprov'];
						$trabajoLoc=$_POST['trabLoc'];
						
$error=valida_clientes($dni,$apellido,$nombre,$domicilio,$telefono,$prov,$Loc,$barrio,$obs,$cel);

 if(sizeof($error)>0)
	 {
     error($error); 
	 echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='javascript:history.back(-1)' value=Volver></CENTER>";
	 }else{
	 	$c->getMiconexion();
		 $cmd= "select Max(id_clientes)+1 from t_clientes";
          $rows=pg_fila($cmd);
          $Max=empty($rows[0])?1:$rows[0];
       
$sql="INSERT INTO t_clientes (id_clientes,nombre,apellido,dni,domicilio,barrio,id_localidad,id_provincia,tel,obs,cel,moroso,estado,fecha_aud,hora_aud,usuario_aud,altura, trabajo_domicilio, trabajo_barrio , trabajo_id_localidad, trabajo_id_provincia, trabajo_tel) VALUES ($Max,'$nombre','$apellido',$dni,'$domicilio','$barrio',$Loc,$prov,'$telefono','$obs',$cel,$moroso,0,(select fecha()),(select hora()),'".$r->getUser()."','$altdomicilio','$trabajodomicilio','$trabajobarrio',$trabajoprov,$trabajoLoc,'$trabajotelefono'')";

$r=pg_query($sql);
if($r){

	  echo "<SCRIPT >
		              <!--
                      alert('Datos Cargados con Exito');
		   		      //-->
		              </SCRIPT>";		
	            echo"<head><META HTTP-EQUIV='Refresh' CONTENT='1; URL=".$form.".php'></head>";
}	
else{ echo"<FONT SIZE='3' COLOR='red' >Ocurrio un error con la insercion a la base de datos --></FONT>".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";
}
}
?>