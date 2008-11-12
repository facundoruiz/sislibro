<?php
include("cabecera.php");
include("funcionesGrales.php");
require('valida.php');	
$form=$_POST['form'];	

if( $_POST['Tipo']!=-1 ){
    $tipo=$_POST['Tipo'];
}else  {$error[]="No Selecciono <B>Provincia</B>";}
		if(!empty($_POST['Loc'])){
		$Loc=$_POST['Loc'];
		}else {$error[]="No se Cargo <B>Localidad</B>";}
		

  if(sizeof($error)>0)
	 {
     error($error); 
	 echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver></CENTER>";
	 }else{
		  $cmd= "select Max(item)+1 from t_localidades where idprovincia='$tipo'";
          $rows=pg_fila($cmd);
          $Max=empty($rows[0])?1:$rows[0];
		  $cmdSQL="INSERT INTO t_localidades (idprovincia,idlocalidad,descrip) values ($tipo,$Max,'$Loc')"; 
		  $mo=pg_query($cmdSQL);
	 if($mo){

	  echo "<SCRIPT >
		              <!--
                      alert('Datos Cargados con Exito');
		   		      //-->
		              </SCRIPT>";		
		              echo"<head><META HTTP-EQUIV='Refresh' CONTENT='1; URL=".$form.".php'></head>";
	 }else{
	 echo"<FONT SIZE='3' COLOR='red' >Ocurrio un error con la insercion a la base de datos --></FONT>".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";
	 	 }
	 
	 
	 
	 }
   
			 
 ?>
    