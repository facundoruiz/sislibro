select num_chequera,c.apellido ||'; '||c.nombre as vendedor,te.apellido ||'; '||te.nombre as cliente, c.dni, c.domicilio,c.trabajo_domicilio,c.tel,c.cel,(select descrip from t_localidades where idlocalidad=c.id_localidad and idprovincia=c.id_provincia ) as localidad,tc.importe_cuota,tc.cant_cuotas,tc.fecha 

   from t_chequeras tc
inner join  t_clientes c on tc.id_cliente=c.id_clientes
inner join t_Empleados te on te.id_empleados=tc.idvendedor
inner join detalle_chequera td on td.idchequera=tc.idchequera


