select num_chequera as "Solicitud N",C.nombre as "Cliente",C.domicilio as "Domicilio",ch.monto_total as "Monto",ch.cant_cuotas||' X $'||ch.importe_cuota as"PLAN",E.nombre||' '||E.apellido as "Vendedor",  
CASE WHEN cobrado=2 THEN 'si -> $'||(select f_trae_monto_cuota(f_dame_idcuota_pri(ch.idchequera))) --Si cobro adelanto
     ELSE 'no' -- No cobro adelanto
       END as "Cobro Adelanto"
,tmp_co.nombre||' '||E.apellido as "Cobrador", sm.Monto_cobrado

from t_chequeras ch 
inner join t_clientes C on (C.id_clientes=ch.id_cliente) 
inner join t_empleados E on (E.id_empleados=ch.idvendedor) 
inner join ( select * from t_chequera_cobrador tco 
		left join t_empleados Ea on (Ea.id_empleados=tco.idcobrador) ) tmp_co on tmp_co.idchequera=ch.idchequera 
left join (select sum(tp.monto) as Monto_cobrado,idchequera from t_cuotas tc
inner join t_pago tp on tp.idcuota=tc.idcuota
  group by idchequera) sm on sm.idchequera=ch.idchequera

order by num_chequera
--where ch.idvendedor=7 and (ch.fecha>='01/04/2009' or ch.fecha<='03/06/2009')

--select * from t_chequeras where num_chequera=4001

select  ch.num_chequera as "Solicitud N",C.nombre as "Cliente",C.domicilio as "Domicilio",ch.monto_total as "Monto",ch.cant_cuotas||' X $'||ch.importe_cuota as "PLAN",E.nombre||' '||E.apellido as "Vendedor", CASE WHEN cobrado=2 THEN 'si -> $'||(select f_trae_monto_cuota(f_dame_idcuota_pri(ch.idchequera)))  ELSE 'no'  END as "Cobro Adelanto" ,tmp_co.nombre||' '||tmp_co.apellido as "Cobrador", sm.Monto_cobrado 
, now()::date-sm.fecha_pago ,sm.fecha_pago ,sm.fecha_venc
from t_chequeras ch 
inner join t_clientes C on (C.id_clientes=ch.id_cliente) 
inner join t_empleados E on (E.id_empleados=ch.idvendedor) 
inner join ( select * from t_chequera_cobrador tco 
	left join t_empleados Ea on (Ea.id_empleados=tco.idcobrador) ) tmp_co on tmp_co.idchequera=ch.idchequera 
left join (select sum(tp.monto) as Monto_cobrado,idchequera,tp.fecha_pago, tc.fecha_venc from t_cuotas tc 
		inner join t_pago tp on tp.idcuota=tc.idcuota group by idchequera,tp.fecha_pago,tc.fecha_venc) sm on sm.idchequera=ch.idchequera 
inner join (
select tp.monto,fecha_pago,fecha_venc,num_chequera,idchequera from t_chequeras ch
inner join t_chequera_cobrador tcc using(idchequera)
inner join t_cuotas tc using(idchequera)
inner join t_pago tp using(idcuota)
) tmp_cuotas on tmp_cuotas.idchequera=ch.idchequera
where  ( ch.fecha>='01/04/2009' or ch.fecha<='16/06/2009') 
order by ch.num_chequera 
