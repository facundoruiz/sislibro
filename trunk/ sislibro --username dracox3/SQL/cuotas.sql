select tp.numrecibo,tp.monto,fecha_pago,fecha_venc,num_chequera,idchequera from t_chequeras ch
inner join t_chequera_cobrador tcc using(idchequera)
inner join t_cuotas tc using(idchequera)
inner join t_pago tp using(idcuota)

where  tp.idcobrador=13
--group by ch.idchequera,num_chequera