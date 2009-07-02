<?php 
include("cabecera.php");


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="es"><head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<title>Informe</title>
<link rel="stylesheet" type="text/css" href="css/impresion.css">
<?php include("funcionesGrales.php");?>

<script type="text/javascript" src="js/tablesorter/jquery-latest.js"></script>
	<script type="text/javascript" src="js/tablesorter/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
		
	 

<script type="text/javascript">$(function() {
		$("table")
			.tablesorter({widthFixed: true, widgets: ['zebra']})
		
	});
    </script>
</head>

    <body>

    <?php
 $cmdSQL="select * from( select ch.num_chequera,ch.vto_cuota,tmp_cuo_pagadas.f_cuoV_pag as fecha_Vto,tmp_cuo_impagas.f_cuoV_imp as fecha_Ult_Adelanto,tmp_pag.f_pag as fecha_Pago,tmp_pag2.cuot, 
CASE  
      
      WHEN tmp_cuo_pagadas.f_cuoV_pag is not null and  tmp_cuo_impagas.f_cuoV_imp is null THEN  tmp_cuo_pagadas.f_cuoV_pag 
      WHEN tmp_cuo_pagadas.f_cuoV_pag is  null and  tmp_cuo_impagas.f_cuoV_imp is not null THEN  tmp_cuo_impagas.f_cuoV_imp
     ELSE 
	ch.vto_cuota
     END as Fecha,
CASE  
      WHEN tmp_pag.f_pag is not null and  tmp_cuo_impagas.f_cuoV_imp is null THEN   age(tmp_cuo_pagadas.f_cuoV_pag)::interval 
      WHEN tmp_pag.f_pag is not null and  tmp_cuo_impagas.f_cuoV_imp is not null THEN   age(tmp_cuo_impagas.f_cuoV_imp)::interval 
     ELSE 
	age(ch.vto_cuota)::interval
     END as cant_de_dia
,tchc.idcobrador
from t_chequeras ch 
--inner join t_clientes C on (C.id_clientes=ch.id_cliente) 
inner join t_chequera_cobrador tchc using (idchequera)
inner join t_empleados E on (E.id_empleados=ch.idvendedor) 
left join (
		select max(fecha_venc)::date as f_cuoV_pag,idchequera from t_cuotas tc
		inner join t_pago tp using(idcuota)
		where tc.estado=1 group by idchequera
) tmp_cuo_pagadas using(idchequera)
left join (
		select max(fecha_venc)::date as f_cuoV_imp,idchequera from t_cuotas tc
		inner join t_pago tp using(idcuota)
		where tc.estado=0 group by idchequera
) tmp_cuo_impagas using(idchequera)
left join (
		select max(fecha_pago)::date as f_pag,idchequera from t_cuotas tc
		inner join t_pago tp using(idcuota)
		group by idchequera
) tmp_pag using(idchequera)
left join (
		select 'cuota '||max(num_cuota) as cuot, idchequera from t_cuotas tc
		inner join t_pago tp using(idcuota)
		group by idchequera
) tmp_pag2 using(idchequera)
where ch.estado!=1
) detalle

where  detalle.cant_de_dia >'1 days'::interval and detalle.idcobrador=".$_POST['cobrador']."
order by detalle.num_chequera ";



  $cmdSQL;


		$imp= new HtmlBoton("Imprimir","imp",true,"button");	
		$imp->setfull(true);
	    $imp->setClassEstilo('CLASS=input');
		$imp->setScript("onclick=javascript:imprime()");
        echo'<div class="noVer">';
		echo $imp->toString();
		echo"</div>";
?>
Cobrador: <?   $gEmpleado=new gestorEmpleado($c);
 			
				$E=$gEmpleado->get_EmpleadoId($_POST['cobrador'] );
				echo $E->get_apellido();
				echo ', '.$E->get_nombre();?>
<div id="overlay">
		Por Favor espere...
		</div>
<table cellspacing="1" class="tablesorter"  >
<thead> 
<TR >
	
	<th >N&deg; CHEQUERA</th>
	<th >FECHA VTO</th>
	<th >N&deg; CUOTA</th>
		<th >ULT. PAGO</th>
	<th >VENCIDAS</th>
	
</TR>
</thead> 
<tfoot> 
<TR >
	
	<th >N&deg; CHEQUERA</th>
	<th >FECHA VTO</th>
	<th >N&deg; CUOTA</th>
		<th >ULT. PAGO</th>
	<th >VENCIDAS</th>
	
</TR>
</tfoot>
<tbody>
<?php  
$q=pg_query($cmdSQL);
while($r=pg_fetch_array($q)){
	//$ri=pg_fila("select * from stock where cod_libro=".$r[0]."");
	
	?>
<TR  >
	
	<TD align="center"><?PHP echo$r['num_chequera']?></TD>
		<TD  ><?PHP echo$r['fecha']?></TD>
	<TD align="center"  ><?PHP echo$r['cuot']?></TD>
		<TD align="center"  ><?PHP echo$r['fecha_pago']?></TD>
	<TD><?PHP $dias=explode('@',$r['cant_de_dia']); echo $dias[1] ?></TD>
  
</TR>
<?php }	
		?>
</tbody>


</table>
    </body>
    
</html>