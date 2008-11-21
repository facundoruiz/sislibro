
<?php
//**** VALIDA PERSONA *******

function valida_clientes($dni,$apellido,$nombre,$domicilio,$telefono,$prov,$Loc,$barrio,$obs,$cel)
{
	if(empty($dni))
				{
			$error[]="No se cargo<B> DNI</B>";
			}else{
			   $row=pg_fila("select dni from t_clientes where dni=$dni");
				if($row>0){
				$error[]="<B> DNI</B> Repetido";
				}
			}
	
	if(empty($apellido))
				{
			$error[]="No se cargo <B>Apellido</B>";
			}else{
			if(ereg("[0-9]",$apellido))
				$error[]="<I>Hay un error en el dato cargado Apellido</I>";
			}

			if(empty($nombre))
				{
			$error[]="No se cargo <B>Nombre</B>";
			}else{
			if(ereg("[0-9]",$nombre))
				$error[]="<I>Hay un error en el dato cargado Nombre</I>";
			}
				if(empty($domicilio))
				{
			$error[]="No se cargo <B>Domicilio</B>";
			}

			if(empty($telefono))
				{
			$error[]="No se cargo <B>telefono</B>";
			}
			if(empty($cel))
				{
			$error[]="No se cargo <B>cel</B>";
			}
			if($prov=='-1')
				{
			$error[]="No se Selecciono <B>Provincia</B>";
			}
			if($Loc=='-1')
				{
			$error[]="No se Selecciono <B>Localidad</B>";
			}
if(empty($barrio))
				{
			$error[]="No se cargo <B>Barrio</B>";
			}
	return $error;	
}

function valida_m_clientes($apellido,$nombre,$domicilio,$telefono,$prov,$Loc,$barrio,$obs,$cel)
{
	
	if(empty($apellido))
				{
			$error[]="No se cargo <B>Apellido</B>";
			}else{
			if(ereg("[0-9]",$apellido))
				$error[]="<I>Hay un error en el dato cargado Apellido</I>";
			}

			if(empty($nombre))
				{
			$error[]="No se cargo <B>Nombre</B>";
			}else{
			if(ereg("[0-9]",$nombre))
				$error[]="<I>Hay un error en el dato cargado Nombre</I>";
			}
				if(empty($domicilio))
				{
			$error[]="No se cargo <B>Domicilio</B>";
			}

			if(empty($telefono))
				{
			$error[]="No se cargo <B>telefono</B>";
			}
				if(empty($cel))
				{
			$error[]="No se cargo <B>Celular</B>";
			}
			if($prov=='-1')
				{
			$error[]="No se Selecciono <B>Provincia</B>";
			}
			if($Loc=='-1')
				{
			$error[]="No se Selecciono <B>Localidad</B>";
			}
if(empty($barrio))
				{
			$error[]="No se cargo <B>Barrio</B>";
			}
	return $error;	
}

/*-PERSONALLLLLLLLLLLLLLLLLLL*/
function valida_empleado($dni,$apellido,$nombre,$domicilio,$telefono,$prov,$Loc,$barrio,$oficio,$cel,$num)
{
	if(empty($dni))
				{
			$error[]="No se cargo<B> DNI</B>";
			}else{
			   $row=pg_fila("select dni from t_empleados where dni=$dni");
				if($row>0){
				$error[]="<B> DNI</B> Repetido";
				}
			}
	
	if(empty($apellido))
				{
			$error[]="No se cargo <B>Apellido</B>";
			}else{
			if(ereg("[0-9]",$apellido))
				$error[]="<I>Hay un error en el dato cargado Apellido</I>";
			}

			if(empty($nombre))
				{
			$error[]="No se cargo <B>Nombre</B>";
			}else{
			if(ereg("[0-9]",$nombre))
				$error[]="<I>Hay un error en el dato cargado Nombre</I>";
			}
				if(empty($domicilio))
				{
			$error[]="No se cargo <B>Domicilio</B>";
			}

			if(empty($telefono))
				{
			$error[]="No se cargo <B>telefono</B>";
			}
				if(empty($cel))
				{
			$error[]="No se cargo <B>telefono</B>";
			}
			if($prov=='-1')
				{
			$error[]="No se Selecciono <B>Provincia</B>";
			}
			if($Loc=='-1')
				{
			$error[]="No se Selecciono <B>Localidad</B>";
			}
			if(empty($barrio))
				{
			$error[]="No se cargo <B>Barrio</B>";
			}
			if($oficio=='-1')
				{
			$error[]="No se Selecciono <B>Oficio</B>";
			}else{
			
			
			
			}
	return $error;	
}

function valida_m_empleado($apellido,$nombre,$domicilio,$telefono,$prov,$Loc,$barrio,$oficio,$cel,$num)
{

	if(empty($apellido))
				{
			$error[]="No se cargo <B>Apellido</B>";
			}else{
			if(ereg("[0-9]",$apellido))
				$error[]="<I>Hay un error en el dato cargado Apellido</I>";
			}

			if(empty($nombre))
				{
			$error[]="No se cargo <B>Nombre</B>";
			}else{
			if(ereg("[0-9]",$nombre))
				$error[]="<I>Hay un error en el dato cargado Nombre</I>";
			}
				if(empty($domicilio))
				{
			$error[]="No se cargo <B>Domicilio</B>";
			}

			if(empty($telefono))
				{
			$error[]="No se cargo <B>telefono</B>";
			}
				if(empty($cel))
				{
			$error[]="No se cargo <B>telefono</B>";
			}
			if($prov=='-1')
				{
			$error[]="No se Selecciono <B>Provincia</B>";
			}
			if($Loc=='-1')
				{
			$error[]="No se Selecciono <B>Localidad</B>";
			}
			if(empty($barrio))
				{
			$error[]="No se cargo <B>Barrio</B>";
			}
			if($oficio=='-1')
				{
			$error[]="No se Selecciono <B>Oficio</B>";
			}else{
			
			
			
			}
			if(empty($num))
				{
			$error[]="No se cargo <B>NUMERO DE EMPLEADO</B>";
			}
	return $error;	
}


function valida_venta($fecha,$vto_fecha,$imp_cuota,$cant_cuotas,$num_chequera,$cobrado,$dia_cuota,$importe)
{
	
	
			/*/ if(!ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$fecha))
				{
			 $error[]="Hay un error en  <B>Fecha</B>";                           
			}
			if(!ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$vto_fecha))
				{
			 $error[]="Hay un error en  <B>Vto 1º cuota</B>";                           
			}*/

	if(empty($imp_cuota))
				{
			$error[]="No se cargo <B>Monto de la cuota</B>";
			}
if(empty($num_chequera))
				{
			$error[]="No se cargo <B>Num de Chequera</B>";
			}
	if(empty($cant_cuotas))
				{
			$error[]="No se cargo <B>Cantidad de cuota</B>";
			}

			if(empty($dia_cuota))
				{
			$error[]="No se cargo <B>cada cuanto se cobra la cuota</B>";
			}
				if(empty($importe))
				{
			$error[]="No se cargo <B>Monto TOTAL de la venta</B>";
			}
			if($cobrado=='-1')
				{
			$error[]="No se Selecciono <B>Si se Cobro la cuota</B>";
			}



	return $error;	
}
?>