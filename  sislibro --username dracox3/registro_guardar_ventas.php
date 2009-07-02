<?php
include("cabecera.php");
include("funcionesGrales.php");
require('valida.php');	

/**
 * Registracio de ventas aqui se realiza la guarda de los datos de 
 * -libros vendidos
 * -quien vendio
 * -quien compro
 * -quien cobra
 * -y las comisiones del vendedor
 *  */
						$form=$_POST['formu'];	
						//$id_venta=$_POST['id_chequera'];
						$tipocobranza=$_POST['formadecobro'];
						if($tipocobranza==2){
							$imp_cuota=$_POST['total'];
							$dia_cuota=0;
						}elseif($tipocobranza==1){
							$dia_cuota=$_POST['dia_cada'];
							$imp_cuota=$_POST['precio_cuota'];
							
						}
						$fecha=$_POST['fecha'];
						$cant_cuotas=$_POST['cant_cuotas'];
						$num_chequera=$_POST['n_chequera'];
						$cobrado=$_POST['cobrado'];	
						$vto_fecha=$_POST['vto_fecha'];
						$importe=$_POST['total'];
						$oficio=$_POST['oficio'];
						$adelanto=$_POST['adelanto'];
						$recibo=EMPTY($_POST['recibo'])?0:$_POST['recibo'];
						
				
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
						$altdomicilio=strtoupper ($_POST['altdomicilio']);
						
						$trabajodomicilio=strtoupper ($_POST['trabajodomicilio']);
						$trabajotelefono=$_POST['trabajotelefono'];
						$trabajobarrio=strtoupper ($_POST['trabajobarrio']);
						$trabajoprov=$_POST['trabprov'];
						$trabajoLoc=$_POST['trabLoc'];
						
$error1=valida_clientes($dni,$apellido,$nombre,$domicilio,$telefono,$prov,$Loc,$barrio,$obs,$cel);
				}

	  $cmd='select f_next_idchequera() as dato';
     $result=pg_query($cmd); 
	 $rows=pg_fetch_array($result);
	
          $id_venta=empty($rows[0])?1:$rows[0];
	
$error2=valida_venta($fecha,$vto_fecha,$imp_cuota,$cant_cuotas,$num_chequera,$cobrado,$dia_cuota,$importe,$adelanto);
//if(){}
$id_jefegrupo=($_POST['jefegrupo']==0)?$error2[]="No se Selecciono <B>Jefe de Grupo</B>":$_POST['jefegrupo'];
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
						
									//$sql="INSERT INTO t_clientes (id_clientes,nombre,apellido,dni,domicilio,barrio,id_localidad,id_provincia,tel,obs,cel,moroso,estado,fecha_aud,hora_aud,usuario_aud ) VALUES ($Max,'$nombre','$apellido',$dni,'$domicilio','$barrio',$Loc,$prov,$telefono,'$obs',$cel,$moroso,0,(select fecha()),(select hora()),'".$r->getUser()."')";
									$sql="INSERT INTO t_clientes (id_clientes,nombre,apellido,dni,domicilio,barrio,id_localidad,id_provincia,tel,obs,cel,moroso,estado,fecha_aud,hora_aud,usuario_aud,altura, trabajo_domicilio, trabajo_barrio , trabajo_id_localidad, trabajo_id_provincia, trabajo_tel) VALUES ($Max,'$nombre','$apellido',$dni,'$domicilio','$barrio',$Loc,$prov,'$telefono','$obs',$cel,$moroso,0,(select fecha()),(select hora()),'".$r->getUser()."','$altdomicilio','$trabajodomicilio','$trabajobarrio',$trabajoprov,$trabajoLoc,'$trabajotelefono')";
									$rcliente=pg_query($sql);
									
											if($rcliente){
												  echo "Cliente Guardado";$id_clientes=$Max;
											}else{ 
												echo"<FONT SIZE='3' COLOR='red' >Ocurrio un error con la insercion de <B>clientes</B> a la base de datos --></FONT>".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";$b=1;
												}
									}
					}else{
						$id_clientes=$_POST['id_clientes'];
					}
									
				if($b!=1){
					
					$sqlChequera=" INSERT INTO  t_chequeras (idchequera,id_cliente,idvendedor,cant_cuotas,importe_cuota,monto_total,num_chequera,fecha,cobrado,vto_cuota,dia_cobrar,fecha_aud,hora_aud,usuario_aud,tipocobranza) VALUES ($id_venta,$id_clientes,$id_vendedor,$cant_cuotas,$imp_cuota,$importe,$num_chequera,'$fecha',$cobrado,'$vto_fecha',$dia_cuota,(select fecha()),(select hora()),'".$r->getUser()."',$tipocobranza); ";
					 $sqlChequera.=" INSERT INTO  t_ventagrupos (idchequera,idjefe) VALUES ($id_venta,$id_jefegrupo); ";
					if($tipocobranza==1){
						$sqlChequera.=" INSERT INTO  t_chequera_cobrador (idchequera,idcobrador,estado) VALUES ($id_venta,$id_cobrador,1); ";
						}
				//$sqldetalle.=" END";
				
				$sqlChequera.=$sqldetalle;
				$rventa=pg_query($sqlChequera);
				
				if($rventa){
						//si el vendedor cobro la cuota va la fecha de vencimiento cargada sino la fecha de la venta
					if($cobrado==2){
							$sqlCuotas="select f_generar_cuotas($id_venta,$cant_cuotas,'$fecha',$dia_cuota,$imp_cuota)";
					}else{
							$sqlCuotas="select f_generar_cuotas($id_venta,$cant_cuotas,'$vto_fecha',$dia_cuota,$imp_cuota)";
					}	
						$id_cuota_pri=pg_fila($sqlCuotas);
						
						if($id_cuota_pri==0){	
							$error3[]="Error al generar cuotas".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";;
						}
						if(sizeof($error3)>0){
							error($error3); 
					 		echo "<CENTER><P> No Cargue de nuevo la venta; Ya esta registrada &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver></CENTER>";
					 	}else{
								 	if($cobrado==2){
											 //$sqlPago.="select f_registrar_pago($id_cuota_pri[0],$adelanto,'$fecha',1,$id_vendedor,'".$r->getUser()."',$recibo);";
									$sqlPago.="select f_registra_cuota($id_venta, $adelanto, '$fecha',1,$id_vendedor,'".$r->getUser()."',$recibo);";
								 	}
									
									$sqlPago.="select f_registrar_comision_vendedor($id_vendedor,$id_venta,0,(select f_dame_porcentaje($id_vendedor,1)));";
									$sqlPago.="select f_registrar_comision_jefegrupo($id_jefegrupo,$id_venta,0,(select f_dame_porcentaje($id_jefegrupo,4)));";
								$rows_pago=pg_fila($sqlPago);	
									if($rows_pago==0){	
									$error4[]="Error al registrar Comisiones ".pg_last_error()." <BR>De aviso a su ADMINISTRADOR";;
										}
									
									
								if(sizeof($error4)>0)
							 		{
					     			error($error4); 
						 			echo "<CENTER><P><H1> No Cargue de nuevo la venta; Ya esta registrada &nbsp;<BR><INPUT TYPE=Button onclick='history.back(-1)' value=Volver><H1></CENTER>";
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