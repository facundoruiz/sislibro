<?php 
include("cabecera.php");


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Informe</title>
<link rel="stylesheet" type="text/css" href="css/impresion.css">
</head>

    <body>

    <?php
 $cmdSQL="select num_chequera as \"N Sol.\",ch.monto_total as \"Monto\",ch.cant_cuotas||' X $'||ch.importe_cuota as \"PLAN\",E.num_empleados as \"Vend.\",  
CASE WHEN cobrado=2 THEN 'si -> $'||(select f_trae_monto_cuota(f_dame_idcuota_pri(ch.idchequera))) --Si cobro adelanto
     ELSE 'no' -- No cobro adelanto
       END as \"Adelanto\"
,tmp_co.num_empleados as \"Cobrador\", sm.Monto_cobrado as Tcobrado

from t_chequeras ch 
inner join t_clientes C on (C.id_clientes=ch.id_cliente) 
inner join t_empleados E on (E.id_empleados=ch.idvendedor) 
inner join ( select * from t_chequera_cobrador tco 
		left join t_empleados Ea on (Ea.id_empleados=tco.idcobrador) ) tmp_co on tmp_co.idchequera=ch.idchequera 
left join (select sum(tp.monto) as Monto_cobrado,idchequera from t_cuotas tc
inner join t_pago tp on tp.idcuota=tc.idcuota
  group by idchequera) sm on sm.idchequera=ch.idchequera

";
//where ch.idvendedor=7 and (ch.fecha>='01/04/2009' or ch.fecha<='03/06/2009')";
 
 
 /* "select num_chequera as \"Solicitud N\",C.nombre as \"Cliente\",C.domicilio as \"Domicilio\",E.nombre as \"Vendedor\",tmp_co.nombre as \"Cobrador\" from t_chequeras ch
inner join t_clientes C on (C.id_clientes=ch.id_cliente)
inner join t_empleados E on (E.id_empleados=ch.idvendedor)
left join (
select * from t_chequera_cobrador tco
inner join t_empleados Ea on (Ea.id_empleados=tco.idcobrador)
) tmp_co on tmp_co.idchequera=ch.idchequera
";*/
 if($_POST['oficio']==1){
$cmdSQL.=" where ch.idvendedor=".$_POST['vendedor']." and ( ch.fecha>='".$_POST['fecha_desde']."' or ch.fecha<='".$_POST['fecha_hasta']."') "; 	
 
 }
 if($_POST['oficio']==2){
$cmdSQL.=" where E.id_empleados=".$_POST['cobrador']." and ( ch.fecha>='".$_POST['fecha_desde']."' or ch.fecha<='".$_POST['fecha_hasta']."') "; 	
 
 }
$_POST['oficio'];


 $cmdSQL;
$query=pg_query($cmdSQL);

	
		$listadot=new HtmlInformeListado($query);
		$listadot->encabezado->setValor("PRODUCCION DESDE ". $_POST['fecha_desde']. " HASTA : ".$_POST['fecha_hasta']); 
		$listadot->encabezado->estilo->setSize(3);
		
		$listadot->encabezado->estilo->setFontColor('0,0,128');  	   
		
		$imp= new HtmlBoton("Imprimir","imp",true,"button");	
		$imp->setfull(true);
	    $imp->setClassEstilo('CLASS=input');
		$imp->setScript("onclick=javascript:imprime()");
        echo'<div class="noVer">';
		echo $imp->toString();
		echo"</div>";
		$listadot->setMargenIz(1);
	 
		
		 $listadot->toString();	
	?>
    </body>
    
</html>