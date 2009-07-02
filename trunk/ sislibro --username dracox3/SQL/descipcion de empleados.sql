select e.id_empleados,(apellido||','||nombre) from t_empleados e
--inner join t_oficios o on (o.id_empleados=e.id_empleados)


select *,(select id_oficio from t_oficios where id_empleados=2 limit 1) as id_oficio, (select descoficio(1,o.id_oficio) limit 1) as oficio from t_empleados e 
inner join t_oficios o on o.id_empleados=e.id_empleados 
where e.id_empleados=2 limit 1