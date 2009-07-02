select num_chequera as "Solicitud N",E.nombre as "Vendedor",C.nombre as "Cliente",tmp_co.nombre as "Cobrador" from t_chequeras ch
inner join t_clientes C on (C.id_clientes=ch.id_cliente)
inner join t_empleados E on (E.id_empleados=ch.idvendedor)
left join (
select * from t_chequera_cobrador tco
inner join t_empleados Ea on (Ea.id_empleados=tco.idcobrador)
) tmp_co on tmp_co.idchequera=ch.idchequera



select cant_cuotas,importe_cuota ,(select f_trae_idcuota(ch.idchequera))as idcuota,(select f_num_cuota(ch.idchequera,ch.cant_cuotas)), COALESCE(s.sal_valor ,false),(select f_trae_monto_cuota((select f_trae_idcuota(ch.idchequera)))) 
 from t_chequeras ch 
left join (
	select (importe_cuota > (select f_trae_monto_cuota((select f_trae_idcuota(ch.idchequera))))) as sal_valor,idchequera    from t_chequeras ch 
	inner join t_pago p on p.idcuota=(select f_trae_idcuota(ch.idchequera))
	--where ch.idchequera=2 limit 1;
) s  on s.idchequera=2
where ch.idchequera=2;


-- segun chequera suma de Pago y el total de cuotas
select sum(sumap) as "Pago",sumaC as "Monto Total",c.idchequera from t_cuotas c
inner join (
select sum(monto)as sumaC,idchequera from t_cuotas group by idchequera
 ) S_cuota on S_cuota.idchequera=c.idchequera
--inner join t_pago p on p.idcuota=c.idcuota
inner join (
select sum(monto) as sumaP,idcuota from t_pago group by idcuota
 ) S_pago on S_pago.idcuota=c.idcuota
where c.idchequera=3
group by c.idchequera,sumaC