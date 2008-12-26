<?php
include("cabecera.php");
include("funcionesGrales.php");
require('valida.php');	
						$form=$_POST['form'];	
						$id_venta=$_POST['id_chequera'];
						$fecha=$_POST['fecha'];
						$vto_fecha=$_POST['vto_fecha'];
						$imp_cuota=$_POST['precio_cuota'];
						$cant_cuotas=$_POST['cant_cuotas'];
						$num_chequera=$_POST['n_chequera'];
						$cobrado=$_POST['cobrado'];
						$dia_cuota=$_POST['dia_cada'];
						$importe=$_POST['total'];
						$oficio=$_POST['oficio'];
						$adelanto=$_POST['adelanto'];
				
				if($_POST['existe']!=1){
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
$error1=valida_clientes($dni,$apellido,$nombre,$domicilio,$telefono,$prov,$Loc,$barrio,$obs,$cel);
				}

$error2=valida_venta($fecha,$vto_fecha,$imp_cuota,$cant_cuotas,$num_chequera,$cobrado,$dia_cuota,$importe,$adelanto);
//if(){}
$id_vendedor=($_POST['vendedor']==0)?$error2[]="No se Selecciono <B>Vendedor</B>":$_POST['vendedor'];
$id_cobrador=($_POST['empleado']==0)?$error2[]="No se Selecciono <B>Cobrador</B>":$_POST['empleado'];
$c=1; 
//$sqldetalle="BEGIN ";
while ($_POST['codigo'.$c]){

		if($_POST['estado'.$c]){
			$sqldetalle.=" INSERT INTO detalle_chequera (idchequera,cant,precio,codigo_ejemplar,fecha_aud,hora_aud,usuario_aud)";
			$sqldetalle.=" VALUES($id_venta,";
			$sqldetalle.=$_POST['cant'.$c].",";
			$sqldetalle.=empty($_POST['precio'.$c])?0:$_POST['precio'.$c];
			$sqldetalle.=",";
			$sqldetalle.=$_POST['codigo'.$c].",(select fecha()),(select hora()),'".$r->getUser()."'); ";
		
		}

$c++; 
 }	

$conexion=new gestorConexion();

$conexion->getMiconexion();
 if(sizeof($error2)>0)
	 {
     	error($error2); 
	 	echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver></CENTER>";
	 }else{$b=0;
				if($_POST['existe']!=1){	
							if(sizeof($error1)>0)
							 {
					     			error($error1); 
						 			echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver></CENTER>";
							 }else{
							 	//$c->getMiconexion();
									 $cmd= "select Max(id_clientes)+1 from t_clientes";
							          $rows=pg_fila($cmd);
							          $Max=empty($rows[0])?1:$rows[0];
						
									$sql="INSERT INTO t_clientes (id_clientes,nombre,apellido,dni,domicilio,barrio,id_localidad,id_provincia,tel,obs,cel,moroso,estado,fecha_aud,hora_aud,usuario_aud ) VALUES ($Max,'$nombre','$apellido',$dni,'$domicilio','$barrio',$Loc,$prov,$telefono,'$obs',$cel,$moroso,0,(select fecha()),(select hora()),'".$r->getUser()."')";
									
									$rcliente=pg_query($sql);
									
											if($rcliente){
												  echo "Cliente Guardado";$id_clientes=$Max;
														   }	
											else{ echo"<FONT SIZE='3' COLOR='red' >Ocurrio un error con la insercion de <B>clientes</B> a la base de datos --></FONT>".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";$b=1;
												}
									}
					}else{	$id_clientes=$_POST['id_clientes'];		}
									
				if($b!=1){
				
				$sqlChequera=" INSERT INTO  t_chequeras (idchequera,id_cliente,idvendedor,cant_cuotas,importe_cuota,monto_total,num_chequera,fecha,cobrado,vto_cuota,dia_cobrar,fecha_aud,hora_aud,usuario_aud,idcobrador) VALUES ($id_venta,$id_clientes,$id_vendedor,$cant_cuotas,$imp_cuota,$importe,$num_chequera,'$fecha',$cobrado,'$vto_fecha',$dia_cuota,(select fecha()),(select hora()),'".$r->getUser()."',$id_cobrador); ";
				//$sqldetalle.=" END";
				
				echo$sqlChequera.=$sqldetalle;
					$rventa=pg_query($sqlChequera);
				
				if($rventa){
						echo $sqlCuotas="select f_generar_cuotas($id_venta,$cant_cuotas,'$vto_fecha',$dia_cuota,$imp_cuota)";
						$id_cuota_pri=pg_fila($sqlCuotas);
						if($id_cuota_pri==0){	
							$error3[]="Error al registrar cuota intente manualmente";
						}
						if(sizeof($error3)>0){
							error($error3); 
					 		echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver></CENTER>";
					 	}else{
								 	if($cobrado==2){
											    $sqlPago.="select f_registrar_pago($id_cuota_pri[0],$importe,'$fecha',$oficio,$id_cobrador,'".$r->getUser()."');";
										}
								 	if($cobrado==3){
											    $sqlPago.="select f_registrar_pago($id_cuota_pri[0],$adelanto,'$fecha',$oficio,$id_cobrador,'".$r->getUser()."');";
										}	
									$sqlPago.="select f_registrar_comision($id_vendedor,$id_cuota_pri[0],0,(select porcentaje from t_empleados where id_empleados=$id_vendedor))";
								$rows_pago=pg_fila($sqlPago);	
									if($rows_pago==0){	
									$error4[]="Error al registrar Pago de vendedor intente manualmente";
										}
									
									
								if(sizeof($error4)>0)
							 		{
					     			error($erro4); 
						 			echo "<CENTER><P> Debe volver para corregir la carga &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver></CENTER>";
									 }else{				
								
					 			
				/*stock	
				$c=1; 
				while ($_POST['codigo'.$c]){
				if($_POST['estado'.$c]){
				$sqlstock.="update stock SET cant=coalesce(cant-".$_POST['cant'.$c].",0),costo=";
				$sqlstock.=empty($_POST['precio'.$c])?0:$_POST['precio'.$c];
				$sqlstock.=" where cod_libro=".$_POST['codigo'.$c].";";
				
				}
				
				$c++; 
				 }	
				pg_fila($sqlstock);
				*/						
										
					  echo "<SCRIPT >
						              <!--
				                      alert('Datos Cargados con Exito');
						   		      //-->
						              </SCRIPT>";		
					            echo"<head><META HTTP-EQUIV='Refresh' CONTENT='1; URL=".$form.".php'></head>";
					
									 }
					 	} 
									 
				}else{ echo"<FONT SIZE='3' COLOR='red' >Ocurrio un error con la insercion a la base de datos --></FONT>".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";
						}
				}
	 }
?>