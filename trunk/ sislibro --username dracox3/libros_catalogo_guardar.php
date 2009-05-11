<?php
include("cabecera.php");
include("funcionesGrales.php");
require('valida.php');	
						
				
				
						$form=$_POST['formu'];	
						$nombre=strtoupper ($_POST['Nombre']);
						
if(empty($nombre)){
	$error[]="Debe poner un nombre al Catalogo";
}






 if(sizeof($error)>0)
	 {
     	error($error); 
	 	echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver></CENTER>";
	 }else{
				
				
	 	 $idcatalogo=pg_fila("select f_catalogo_insert('".$nombre."','".$r->getUser()."')");
		$c=1;		
	 	 while ($_POST['codigo'.$c]){

					if($_POST['estado'.$c]){
						$sqldetalle.=" INSERT INTO detalle_catalogo (idcatalogo,cant,precio,codigo_ejemplar,fecha_aud,hora_aud,usuario_aud)";
						$sqldetalle.=" VALUES($idcatalogo[0],";
						$sqldetalle.=$_POST['cant'.$c].",";
						$sqldetalle.=empty($_POST['precio'.$c])?0:$_POST['precio'.$c];
						$sqldetalle.=",";
						$sqldetalle.=$_POST['codigo'.$c].",(select fecha()),(select hora()),'".$r->getUser()."'); ";
					
					}
						$c++; 
 								}	
 								echo $sqldetalle;
 								$conexion=new gestorConexion();
			$conexion->getMiconexion();	
 					$rcatalogo=pg_query($sqldetalle);
 								
				if($rcatalogo){
																
					  echo "<SCRIPT >
						              <!--
				                      alert('Catalogo ".$nombre."  Cargados con Exito');
						   		      //-->
						              </SCRIPT>";		
					            echo"<head><META HTTP-EQUIV='Refresh' CONTENT='1; URL=".$form.".php'></head>";
					
						
					 									 
				}else{ echo"<FONT SIZE='3' COLOR='red' >Ocurrio un error con la insercion a la base de datos --></FONT>".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";
					}
				
	 }
?>