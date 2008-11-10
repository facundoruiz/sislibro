<?php
include("cabecera.php");
include("funcionesGrales.php");
require('valida.php');	
						$form=$_POST['form'];	
						$dni=$_POST['dni'];	
						$id=$_POST['id'];	
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

$error=valida_m_clientes($apellido,$nombre,$domicilio,$telefono,$prov,$Loc,$barrio,$obs,$cel);

 if(sizeof($error)>0)
	 {
     error($error); 
	 echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver></CENTER>";
	 }else{

$sql="UPDATE t_clientes SET nombre='$nombre',apellido='$apellido',domicilio='$domicilio',barrio='$barrio',id_localidad=$Loc,id_provincia=$prov,tel=$telefono,obs='$obs' , cel=$cel, moroso=$moroso,fecha_aud=(select fecha()),hora_aud=(select hora()),usuario_aud='".$r->getUser()."' where id_clientes=$id"; 



$r=pg_query($sql);
if($r){
  echo "<head><SCRIPT >alert('Datos Modificados con exitos');</SCRIPT>";
	   if(isset($form)){
	   echo"<META HTTP-EQUIV='Refresh' CONTENT='1; URL=".$form.".php'></head> ";
	   }else{
	   echo "<head><SCRIPT >window.close();</SCRIPT>";
	   		   }
	
}	
else{ echo"<FONT SIZE='3' COLOR='red' >Ocurrio un error con la insercion a la base de datos --></FONT>".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";
}
}
?>