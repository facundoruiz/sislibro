<?php
include("cabecera.php");
include("funcionesGrales.php");
require('valida.php');	
						$form=$_POST['form'];	
						$dni=$_POST['dni'];	
						$num=$_POST['num'];	
						$apellido=$_POST['apellido'];
						$nombre=$_POST['nombre'];
						$domicilio=$_POST['domicilio'];
						$telefono=$_POST['telefono'];
						$cel=$_POST['cel'];
						$prov=$_POST['prov'];
						$Loc=$_POST['Loc'];
						$barrio=$_POST['barrio'];
						$oficio=$_POST['oficio'];
						$porcentaje=$_POST['porcentaje'];
					
						$obs=$_POST['obs'];




$error=valida_empleado($dni,$apellido,$nombre,$domicilio,$telefono,$prov,$Loc,$barrio,$oficio,$cel,$num,$porcentaje);

 if(sizeof($error)>0)
	 {
     error($error); 
	 echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver class=button></CENTER>";
	 }else{
		 $cmd= "select Max(id_empleados)+1 from t_empleados";
          $rows=pg_fila($cmd);
          $Max=empty($rows[0])?1:$rows[0];

$zona=($oficio==2)?$zona:0;
$sql="INSERT INTO t_empleados (id_empleados,nombre,apellido,dni,domicilio,barrio,id_localidad,id_provincia,tel,obs,cel,estado,num_empleados,fecha_aud,hora_aud,usuario_aud,porcentaje ) VALUES ($Max,'$nombre','$apellido',$dni,'$domicilio','$barrio',$Loc,$prov,$telefono,'$obs',$cel,0,$num,(select fecha()),(select hora()),'".$r->getUser()."',$porcentaje)";
$sql.="; INSERT INTO t_oficios(id_ofico,id_empleados) values($oficio,$Max)";
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