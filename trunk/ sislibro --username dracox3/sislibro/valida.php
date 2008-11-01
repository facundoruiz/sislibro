
<?php
/**//*----VALIDA Movil-----*/
function validarmovil($NMovil,$tipo,$marca,$modelo,$nchasis,$nmotor,$patente,$anio,$km,
$observacion)
{
	if(empty($NMovil)||(ereg("[a-zA-Z]",$NMovil)))
				{
			$error[]="Hay un error en el dato cargado <B>Nº Movil</B>";
			}/*else{
				@$cmdMo="select * from tmovil where tmovil.nmovil='$NMovil'and baja='0' ";
				$q=pg_query($cmdMo);
				$r=pg_fetch_array($q);
		     if($r!=0){
				$error[]="Nº Movil '$NMovil' <B>Existente</B>";
				}
			}*/


		if(empty($nchasis))
				{
			$error[]="Hay un error en el dato cargado <B>Nº Chasis</B>";
			}
			
//			if(empty($nmotor)||(ereg("[a-zA-Z]",$nmotor)))
if(empty($nmotor))
				{
			$error[]="Hay un error en el dato cargado <B>Nº Motor</B>";
			}

             if(($_POST['Tipo']&&$_POST['marca']&&$_POST['modelo'])==0 )
	         {
		     $error[]="Descripcion de Vehiculo <B>Incompleta</B>";
  	         }           

			if(empty($patente))
            {
			$error[]="Hay un error en el dato cargado <B>Patente</B>";
                           
			}                                                                                                           
			if(empty($anio))
            {
			$error[]="Hay un error en el dato cargado <B>Año</B>";
			}
		
                      

	return $error;	

}
/**** Funcion que valida para dar de baja****/
function validarbaja($NMovil,$fecha,$Hora,$comisario,$Secundado,$verificador)
{
	        if(empty($NMovil)||(ereg("[a-zA-Z]",$NMovil)))
				{
			$error[]="Hay un SI error en el dato cargado <B>Nº Movil</B>";
			}/*else{
				@$cmdMo="select * from tmovil where tmovil.nmovil='$NMovil'and baja='0' ";
				$q=pg_query($cmdMo);
				$r=pg_fetch_array($q);
		     if($r!=0){
				$error[]="Nº Movil '$NMovil' <B>Existente</B>";
				}
			}*/
		

         if(!ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$fecha))
				{
			 $error[]="Hay un error SIIII en el dato cargado <B>Fecha</B>";                           
			}
         if(!ereg("([0-9]{1,2}):([0-9]{1,2})",$Hora))
				{
			 $error[]="Hay un error en el dato cargado <B>Hora</B>";
			}		
		 if($comisario==0 )
	         {
		     $error[]="Hay un error en el dato cargado <B>Comisario</B>";
  	         }         
		 if(empty($verificador))
            {
			 $error[]="Hay un error en el dato cargado <B>Verificador</B>";
			}
		/* if($mecanico==0 ) 
	         {
		     $error[]="Hay un error en el dato cargado <B>Mecanico</B>";
  	         }         		            */
	return $error;	

}




/**//*----Muestra ERROR -----*/
function error($error){ 
echo"<BODY background='img/Fondo.jpg'>
	
</BODY><CENTER><TABLE border=1>
<TR>
	<TD bgcolor='#99CC99'><FONT SIZE=4 COLOR=>Error en la Carga</FONT></TD>
</TR>";
	for($i=0;$i<sizeof($error);$i++){

echo"<TR>
	<TD align='center' valign='top' ><FONT COLOR='#FF0000' size=3 face='Book Antiqua'>".$error[$i]."</FONT></TD>
</TR>";

}echo"
</TABLE></CENTER>";

}
/**//*----VALIDA ACTA-----*/
function validarActa($fecha,$fecha_vto,$Tipo_act,$HORA,$t_n,$NMovil,$km,$Obser,$id_comisario,$id_chofer,$id_mecanico,$id_secundado){

if(!ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$fecha) )
				{
			$error[]=" <B>Fecha</B>";
			}
if(!ereg("([0-9]{1,2}):([0-9]{1,2})",$HORA) )
				{
			$error[]="<B>Hora</B>";
			}
if(!ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$fecha_vto))
				{
			$error[]="Fecha de <B>Vencimiento de Carnet</B>";
			}


if(empty($km))
				{
			$error[]="Hay un error en <b>KM</b>";
			}

if($Tipo_act!=1&&$Tipo_act!=2)
				{
			$error[]="No se Eligio <B>Tipo de Acta</B>";

			}
			
			else{
			if($Tipo_act==1){
		$cmdSQL="select * from tacta where id_movil=(select id_movil from tmovil where nmovil='$NMovil' )  order by nacta desc,tipo_acta desc,fecha desc,hora desc limit 1";
	     
			$rows=pg_fila($cmdSQL);

				if($rows>0){
					if($rows['tipo_acta']==$Tipo_act){
				$error[]="Existe Una <B><I>Acta Fuera de Servicio</I> con numero ".$rows['nacta']."</B> ";
						}
					}
				}else{
				
			$cmdSQL="select * from tacta where id_movil=(select id_movil from tmovil where nmovil='$NMovil' ) and id_servicio=0 and tipo_acta=2  order by nacta desc,tipo_acta desc,fecha desc,hora desc limit 1";
	   $rows=pg_fila($cmdSQL);

				if($rows>0){
					if($rows['tipo_acta']==$Tipo_act&&$rows['nacta']==$t_n){
				$error[]="Existe Una <B><I>Acta en Reparación</I> con número ".$rows['nacta']."</B>";
						}
					}
			
				
				}
			}


return $error;
}
/*///////Valida Las actas de recepcion y Provicion*/
function validarActa_entrec($fecha,$fecha_vto,$Tipo_act,$HORA,$t_n,$NMovil,$km,$Obser,$id_comisario,$id_chofer,$id_secundado,$id_ComisarioDep,$dependencia){

if(!ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$fecha))
				{
			$error[]=" <B>Fecha</B>";
			}
if(!ereg("([0-9]{1,2}):([0-9]{1,2})",$HORA))
				{
			$error[]="<B>Hora</B>";
			}



if(empty($km))
				{
			$error[]="Hay un error en <b>KM</b>";
			}
/*if(empty($Obser))
				{
			$error[]="No se Cargo <b>Observación</b>";
			}




if($id_secundado==0)
				{
			$error[]="No se Cargo <b>Secundado</b>";
			}
if($id_comisario==0)
				{
			$error[]="No se Cargo <b>Comisario </b>";
			}

if(empty($id_ComisarioDep) )
				{
			$error[]="No se Cargo <b>Comisario de Dependencia</b>";
			}*/
if(!empty($id_chofer))
				{
	if(!ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$fecha_vto))
				{
			$error[]="Fecha de <B>Vencimiento de Carnet</B>";
			}
		//	$error[]="No se Cargo <b>Chofer</b>";
			}
if($dependencia==0)
				{
			$error[]="No se Cargo <b>Dependencia</b>";
			}			
			
			


if($Tipo_act!=4&&$Tipo_act!=3)
				{
			$error[]="No se Eligio <B>Tipo de Acta</B>";

			}
			
			else{
				$cmdSQL="select * from tacta where id_movil=(select id_movil from tmovil where nmovil='$NMovil' and baja=0)  order by nacta desc,fecha desc,hora desc limit 1";
	     
			$rows=pg_fila($cmdSQL);

			if($Tipo_act==3){
		

				if($rows>0){
					if($rows['tipo_acta']==$Tipo_act){
				$error[]="Existe Una <B><I>Acta Recepcion</I> con numero ".$rows['nacta']."</B> ";
						}
					}
				}else{
			
				if($rows>0){
					if($rows['tipo_acta']==$Tipo_act){
				$error[]="Existe Una <B><I>Acta en Provicion</I> con número ".$rows['nacta']."</B>";
						}
					}
			
				
				}
			}

return $error;
}


/**//*----VALIDA TIPO-----*/
function validartipo($Tipo,$marca,$tmarca,$tmodelo)
{
if(empty($tmarca) and empty($tmodelo))
	{
	$error[]="<B>Marca</B> Incompleta";
	$error[]="<B>Modelo</B> Incompleto";
	}	
	return $error;
}
//**** VALIDA PERSONA *******

function validarpersona($dni,$apellido,$nombre,$acargo,$oficio)
{
	if(empty($dni))
				{
			$error[]="<B>No se cargo DNI</B>";
			}/*else{
				//if(!ereg("([0-9]{8})",$dni))
				$error[]="<I>Hay un error en el dato cargado DNI</I>";
			}	*/
	
	if(empty($apellido))
				{
			$error[]="<B>No se cargo Apellido</B>";
			}else{
			if(ereg("[0-9]",$apellido))
				$error[]="<I>Hay un error en el dato cargado Apellido</I>";
			}

			if(empty($nombre))
				{
			$error[]="<B>No se cargo Nombre</B>";
			}else{
			if(ereg("[0-9]",$nombre))
				$error[]="<I>Hay un error en el dato cargado Nombre</I>";
			}
			
			if($acargo==0)
				{
			$error[]="<B>No se eligio Cargo</B>";
			    }
			if ($_POST['tipo_per'])
			   {				
                    if($oficio==0)
				    {
			        $error[]="<B>No se eligio Oficio</B>";
			        }
			   }
			
	return $error;	
}

/**//*----VALIDA ACTA-----*/
function valida_exp($fecha,$NMovil,$aniosolic,$nsolic,$id_dependencia,$procedencia,$asunto)	{

if(empty($nsolic)){
			$error[]=" <B>Nº de Solicitud/Exp </B>";

}
if(empty($aniosolic)){
				$error[]=" <B>Falta año de Solicitud</B>";
	
}
if(!ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$fecha))
				{
			$error[]=" <B>Fecha</B>";
			}
if(empty($NMovil)){
			$error[]=" <B>Nº de TUC </B>";

}
if($id_dependencia=='-1'){
		$error[]=" <B>Debe Seleccionar Dependencia </B>";
}
/*if($causante=='-1'){
		$error[]=" <B>Debe Seleccionar Causante </B>";
}*/
if(empty($procedencia)){
			$error[]=" <B>no cargo Procedencia </B>";

}
if(empty($asunto)){
			$error[]=" <B>no cargo asunto </B>";

}

return $error;
}
?>