select num_chequera as "Solicitud N",C.nombre as "Cliente",C.domicilio as "Domicilio",E.nombre as "Vendedor",tmp_co.nombre as "Cobrador",tmp_jf.nombre as "Jefe Grupo" 
from t_chequeras ch inner join t_clientes C on (C.id_clientes=ch.id_cliente) 
inner join t_empleados E on (E.id_empleados=ch.idvendedor) 
left join (
	select * from t_chequera_cobrador tco 
	inner join t_empleados Ea on (Ea.id_empleados=tco.idcobrador) 
	) tmp_co on tmp_co.idchequera=ch.idchequera 
left join (
	select * from t_ventagrupos tv 
	inner join t_empleados Ea on (Ea.id_empleados=tv.idjefe) 
	) tmp_jf on tmp_jf.idchequera=ch.idchequera 

where tmp_co.id_empleados=10 and ( ch.fecha>='01/03/2009' or ch.fecha<='09/06/2009') 

