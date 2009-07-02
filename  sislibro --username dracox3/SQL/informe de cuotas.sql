select * from( select ch.num_chequera,ch.vto_cuota,tmp_cuo_pagadas.f_cuoV_pag as fecha_Vto,tmp_cuo_impagas.f_cuoV_imp as fecha_Ult_Adelanto,tmp_pag.f_pag as fecha_Pago,tmp_pag2.cuot, 
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

where  detalle.cant_de_dia >'1 days'::interval
order by detalle.num_chequera 

/*

inner join ( select * from t_chequera_cobrador tco 
	left join t_empleados Ea on (Ea.id_empleados=tco.idcobrador) ) tmp_co on tmp_co.idchequera=ch.idchequera 
left join (select sum(tp.monto) as Monto_cobrado,idchequera,tp.fecha_pago, tc.fecha_venc from t_cuotas tc 
		inner join t_pago tp on tp.idcuota=tc.idcuota group by idchequera,tp.fecha_pago,tc.fecha_venc) sm on sm.idchequera=ch.idchequera 


where  (ch.fecha>='01/04/2009' or ch.fecha<='16/06/2009') 
order by ch.num_chequera 
*/