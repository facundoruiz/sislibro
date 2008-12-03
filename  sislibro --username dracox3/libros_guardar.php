<?php
include("cabecera.php");
include("funcionesGrales.php");
require('valida.php');	


$form=$_POST['form'];	

			if( $_POST['genero']!=-1 ){
    			$tipo=$_POST['genero'];
			}else  {$error[]="No Selecciono <B>GENERO</B>";}
		
			if($_POST['titulo']!=-1){
				$titulo=$_POST['titulo'];
				}else 
			{$error[]="No se Selecciono <B>TITULO</B>";}
								
			if($_POST['editorial']!=-1){
			$editorial=$_POST['editorial'];
			}else{
			$error[]="No Selecciono <B>Editorial</B>";
			}
		
			if(!empty($_POST['cant'])){
			$cant=$_POST['cant'];
			}else{
			$cant=0;
			}
			if(!empty($_POST['costo'])){
			$costo=$_POST['costo'];
			}else{
			$costo=0;
			}
						
echo$cmdSQL="select * from t_ejemplares where idgenero=$tipo and ideditorial=$editorial and idtitulo=$titulo";
        $rows=pg_fila($cmdSQL);
        if(!empty($rows[0])){
        	$error[]="El ejemplar ya esta cargado";
        }
        
	if(sizeof($error)>0)
	 {
     error($error); 
	 echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver></CENTER>";
	 }else{
			  
		  $cmd= "select Max(codigo)+1 from t_ejemplares";
          $rows=pg_fila($cmd);
          $Max=empty($rows[0])?1:$rows[0];

		  echo$cmdSQL="INSERT INTO t_ejemplares (codigo,idtitulo ,idgenero , ideditorial , costo ,  cant ,  fecha_aud ,  hora_aud ,  usuario_aud ,  estado ) values ($Max,$titulo,$tipo,$editorial,$costo,$cant,(select fecha()),(select hora()),'".$r->getUser()."',0)"; 
		  $mo=pg_query($cmdSQL);



	 if($mo){
/*
 $cmd2.="INSERT INTO stock (cod_libro,cant,costo) values ($Max,$cant,$costo)"; 
  $cmd2.=";INSERT INTO stock1 (cod_libro,cant,costo) values ($Max,$cant,$costo)"; 

		  $m=pg_query($cmd2);
if($m){*/
echo"<P><BR>&nbsp;<P>Codigo de Libro ".$Max."";
	  echo "<SCRIPT >
		              <!--
                      alert('Codigo de Libro ".$Max." Datos Cargados con Exito');
		   		      //-->
		              </SCRIPT>";		
		              echo"<head><META HTTP-EQUIV='Refresh' CONTENT='1; URL=".$form.".php'></head>";
//}

}else{
	 echo"<FONT SIZE='3' COLOR='red' >Ocurrio un error con la insercion a la base de datos --></FONT>".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";
	 
	 }
	 
	 
	 
	 }
   
			 
 ?>
