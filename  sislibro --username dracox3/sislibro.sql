--
-- PostgreSQL database dump
--

-- Started on 2008-12-29 20:03:50

SET client_encoding = 'LATIN1';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 1 (class 2615 OID 22972)
-- Name: auditoria; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA auditoria;


ALTER SCHEMA auditoria OWNER TO postgres;

--
-- TOC entry 1644 (class 0 OID 0)
-- Dependencies: 5
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'Standard public schema';


--
-- TOC entry 306 (class 2612 OID 16386)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


SET search_path = public, pg_catalog;

--
-- TOC entry 293 (class 1247 OID 32591)
-- Dependencies: 1258
-- Name: d_editorial; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE d_editorial AS (
	ideditorial integer,
	descrip character varying
);


ALTER TYPE public.d_editorial OWNER TO postgres;

--
-- TOC entry 294 (class 1247 OID 32613)
-- Dependencies: 1259
-- Name: d_ejemplares; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE d_ejemplares AS (
	codigo integer,
	t_genero character varying,
	t_editorial character varying,
	t_titulos character varying
);


ALTER TYPE public.d_ejemplares OWNER TO postgres;

--
-- TOC entry 303 (class 1247 OID 49991)
-- Dependencies: 1268
-- Name: info_cuota; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE info_cuota AS (
	idchequera integer,
	cant_cuota integer,
	importe_cuota double precision,
	idcuota integer,
	num_cuota integer,
	saldo boolean,
	monto_cuota double precision,
	num_chequera integer,
	id_cliente integer,
	fecha_vto date,
	fecha_pago date,
	idcobrador integer,
	idvendedor integer
);


ALTER TYPE public.info_cuota OWNER TO postgres;

--
-- TOC entry 21 (class 1255 OID 32585)
-- Dependencies: 306 5
-- Name: descdic(numeric, numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION descdic(ptabla numeric, pitem numeric) RETURNS character varying
    AS $$begin
return (select descrip from diccionario where codigo=ptabla and item=pitem);
end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.descdic(ptabla numeric, pitem numeric) OWNER TO postgres;

--
-- TOC entry 22 (class 1255 OID 32587)
-- Dependencies: 306 5
-- Name: descoficio(numeric, numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION descoficio(ptabla numeric, pid_oficio numeric) RETURNS character varying
    AS $$begin
return (select descrip from diccionario where codigo=ptabla and item=(select id_oficio from t_oficios where id_empleados=pid_oficio));
end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.descoficio(ptabla numeric, pid_oficio numeric) OWNER TO postgres;

--
-- TOC entry 20 (class 1255 OID 24203)
-- Dependencies: 306 5
-- Name: existe_numempleado(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION existe_numempleado(p_num integer) RETURNS integer
    AS $$
begin return(select num_empleados from t_empleados
where num_empleados=p_num); end;
$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.existe_numempleado(p_num integer) OWNER TO postgres;

--
-- TOC entry 38 (class 1255 OID 49909)
-- Dependencies: 5 306
-- Name: f_asig_menu_insert(integer, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_asig_menu_insert(p_idfuncion integer, p_idmenu integer, p_idsubmenu integer, p_quees integer) RETURNS void
    AS $$
begin
	if p_quees=1 then
	/*INSERTA UN MENU A UNA DETERMINADA FUNCION*/
		insert into t_funcion_menu (id_funcion,id_menu,id_submenu)values(p_idfuncion,p_idmenu,p_idsubmenu);
	else
	/*ELIMINA UN MENU A UNA DETERMINADA FUNCION*/
		delete from t_funcion_menu where id_funcion=p_idfuncion and id_menu=p_idmenu and id_submenu=p_idsubmenu;
	end if;
		
	
end;
$$
    LANGUAGE plpgsql SECURITY DEFINER;


ALTER FUNCTION public.f_asig_menu_insert(p_idfuncion integer, p_idmenu integer, p_idsubmenu integer, p_quees integer) OWNER TO postgres;

--
-- TOC entry 42 (class 1255 OID 58188)
-- Dependencies: 306 5 293
-- Name: f_dame_editorial_genero(numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_dame_editorial_genero(pid_genero numeric) RETURNS SETOF d_editorial
    AS $$
Declare
d d_editorial;
begin
--funcion devuelve las editoriales segun la relacion de libros existentes
for d in
	execute 'select e.ideditorial,e.descrip  from t_editoriales e
	inner join t_ejemplares j on(e.ideditorial=j.ideditorial)
	inner join t_libros t on(t.idlibro=j.idtitulo)
	where j.idgenero='||pid_genero||' ' 
loop
	return  NEXT d;
end loop;

end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_dame_editorial_genero(pid_genero numeric) OWNER TO postgres;

--
-- TOC entry 39 (class 1255 OID 49992)
-- Dependencies: 5 306 303
-- Name: f_desc_cuota(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_desc_cuota(p_idch integer) RETURNS info_cuota
    AS $$
declare 
rs info_cuota ;
begin
-- funcion que devuelve informacion de la cuota
select ch.idchequera,cant_cuotas ,importe_cuota ,coalesce((select f_trae_idcuota(ch.idchequera)),0)as idcuota,(select f_num_cuota(ch.idchequera,ch.cant_cuotas)) as numero_cuota, COALESCE(s.sal_valor ,false)as saldo,(select f_trae_monto_cuota((select f_trae_idcuota(ch.idchequera)))) as monto_cuota,num_chequera,id_cliente, f_fecha_vto_cuota((select f_trae_idcuota(ch.idchequera))),s.fecha_pago,ch.idcobrador,ch.idvendedor
into rs 
 from t_chequeras ch 
left join (
	select (importe_cuota > (select f_trae_monto_cuota((select f_trae_idcuota(ch.idchequera))))) as sal_valor,idchequera,p.fecha_pago    from t_chequeras ch 
	inner join t_pago p on p.idcuota=(select f_trae_idcuota(ch.idchequera))
	--where ch.idchequera=2 limit 1;
) s  on s.idchequera=p_idch 
where ch.idchequera=p_idch ;

return rs ;
end;
$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_desc_cuota(p_idch integer) OWNER TO postgres;

--
-- TOC entry 23 (class 1255 OID 32600)
-- Dependencies: 306 5
-- Name: f_desc_editorial(numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_desc_editorial(pitem numeric) RETURNS character varying
    AS $$begin
return (select descrip from t_editoriales where ideditorial=pitem);
end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_desc_editorial(pitem numeric) OWNER TO postgres;

--
-- TOC entry 32 (class 1255 OID 32614)
-- Dependencies: 294 306 5
-- Name: f_desc_ejemplares(numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_desc_ejemplares(pitem numeric) RETURNS d_ejemplares
    AS $$
declare 
descripcion d_ejemplares;
begin
-- FUNCION QUE INGRESANDO EL ID DEL libro titulo MUESTRA LA DESCRIPCION DEL MISMO
select codigo,f_desc_genero(idgenero),f_desc_editorial(ideditorial),f_desc_titulo(idtitulo) into descripcion from t_ejemplares where codigo=pitem;
return descripcion;

end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_desc_ejemplares(pitem numeric) OWNER TO postgres;

--
-- TOC entry 24 (class 1255 OID 32601)
-- Dependencies: 306 5
-- Name: f_desc_genero(numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_desc_genero(pitem numeric) RETURNS character varying
    AS $$begin
-- FUNCION QUE INGRESANDO EL ID DEL TIPO DE GENERO MUESTRA LA DESCRIPCION DEL MISMO
return (select descrip from t_generos where idgenero=pitem);
end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_desc_genero(pitem numeric) OWNER TO postgres;

--
-- TOC entry 25 (class 1255 OID 32602)
-- Dependencies: 5 306
-- Name: f_desc_titulo(numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_desc_titulo(pitem numeric) RETURNS character varying
    AS $$begin
-- FUNCION QUE INGRESANDO EL ID DEL libro titulo MUESTRA LA DESCRIPCION DEL MISMO
return (select descrip from t_libros where idlibro=pitem);
end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_desc_titulo(pitem numeric) OWNER TO postgres;

--
-- TOC entry 29 (class 1255 OID 49891)
-- Dependencies: 5 306
-- Name: f_fecha_vto_cuota(numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_fecha_vto_cuota(p_idcuota numeric) RETURNS date
    AS $$begin
-- 
return (select fecha_venc from t_cuotas where idcuota=p_idcuota);
end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_fecha_vto_cuota(p_idcuota numeric) OWNER TO postgres;

--
-- TOC entry 26 (class 1255 OID 33499)
-- Dependencies: 306 5
-- Name: f_generar_cuotas(integer, numeric, date, integer, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_generar_cuotas(p_idchequera integer, p_cant numeric, p_fecha_vto date, dia_cant integer, p_monto double precision) RETURNS integer
    AS $$
declare 
descripcion d_ejemplares;
fecha_vto date;
begin
fecha_vto=p_fecha_vto;
-- genera un registro de cada cuota
	for i in 1..p_cant loop
		insert into t_cuotas(idchequera,fecha_venc,monto)
		values(p_idchequera,fecha_vto,p_monto);
			
		if NOT FOUND then
			ROLLBACK;
			return 0;
		end if;
	    select fecha_vto + dia_cant into fecha_vto;

	end loop;
return (select min(idcuota) from t_cuotas where idchequera=p_idchequera); 

end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_generar_cuotas(p_idchequera integer, p_cant numeric, p_fecha_vto date, dia_cant integer, p_monto double precision) OWNER TO postgres;

--
-- TOC entry 34 (class 1255 OID 49905)
-- Dependencies: 5 306
-- Name: f_menu_delete(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_menu_delete(p_idmenu integer, p_idsubmenu integer) RETURNS integer
    AS $$
declare
  v_cont integer;
begin
	select into v_cont (select count(*) from t_menu where id_menu=p_idmenu);
	if v_cont=2 then
		delete from t_menu where id_menu=p_idmenu;
		if found=true then
			delete from tfuncion_menu where id_menu=p_idmenu ; 
			return 2; 
		else 	
			return 0; 
		end if;		
		
        else
		delete from t_menu where id_menu=p_idmenu and id_submenu=p_idsubmenu;	
		if found=true then
			delete from tfuncion_menu where id_menu=p_idmenu and id_submenu=p_idsubmenu;
			return 3; 
		else 	
			return 0; 
		end if;
	end if;
end;
$$
    LANGUAGE plpgsql SECURITY DEFINER;


ALTER FUNCTION public.f_menu_delete(p_idmenu integer, p_idsubmenu integer) OWNER TO postgres;

--
-- TOC entry 35 (class 1255 OID 49906)
-- Dependencies: 306 5
-- Name: f_menu_insert(integer, integer, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_menu_insert(p_idmenu integer, p_idsubmenu integer, p_nombre character varying, p_link character varying, p_descrip character varying) RETURNS integer
    AS $$
begin
	
	insert into t_menu (id_menu, id_submenu, nombre, link,descripcion) values (p_idmenu, p_idsubmenu, p_nombre, p_link,p_descrip);
	return 1;	
	
end;
$$
    LANGUAGE plpgsql SECURITY DEFINER;


ALTER FUNCTION public.f_menu_insert(p_idmenu integer, p_idsubmenu integer, p_nombre character varying, p_link character varying, p_descrip character varying) OWNER TO postgres;

--
-- TOC entry 36 (class 1255 OID 49907)
-- Dependencies: 306 5
-- Name: f_menu_update(integer, integer, integer, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_menu_update(p_idmenu integer, p_idsubmenu integer, p_idmenu2 integer, p_nombre character varying, p_link character varying) RETURNS integer
    AS $$
begin
	
	UPDATE t_menu SET id_menu=p_idmenu2, nombre=p_nombre, link=p_link WHERE id_menu=p_idmenu and id_submenu=p_idsubmenu;		
	return 1;
end;
$$
    LANGUAGE plpgsql SECURITY DEFINER;


ALTER FUNCTION public.f_menu_update(p_idmenu integer, p_idsubmenu integer, p_idmenu2 integer, p_nombre character varying, p_link character varying) OWNER TO postgres;

--
-- TOC entry 37 (class 1255 OID 49908)
-- Dependencies: 306 5
-- Name: f_menu_update(integer, integer, integer, integer, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_menu_update(p_idmenu integer, p_idsubmenu integer, p_idmenu2 integer, p_idsubmenu2 integer, p_nombre character varying, p_link character varying, p_descrip character varying) RETURNS integer
    AS $$
begin
	
	UPDATE t_menu SET id_menu=p_idmenu2,id_submenu=p_idsubmenu2, nombre=p_nombre, link=p_link, descripcion=p_descrip WHERE id_menu=p_idmenu and id_submenu=p_idsubmenu;		
	return 1;
end;
$$
    LANGUAGE plpgsql SECURITY DEFINER;


ALTER FUNCTION public.f_menu_update(p_idmenu integer, p_idsubmenu integer, p_idmenu2 integer, p_idsubmenu2 integer, p_nombre character varying, p_link character varying, p_descrip character varying) OWNER TO postgres;

--
-- TOC entry 31 (class 1255 OID 49894)
-- Dependencies: 306 5
-- Name: f_num_cuota(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_num_cuota(p_idchequera integer, p_cant integer) RETURNS integer
    AS $$
begin
--Trae el Numero de cuota pagada se deveria sumar 1 para sacar la prox cuota a pagar
return  (select (p_cant - count(idcuota)) from (
	select idcuota from t_cuotas c where idchequera=p_idchequera
	 EXCEPT  
	select idcuota from t_pago p
) cuota_pago);
end;
$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_num_cuota(p_idchequera integer, p_cant integer) OWNER TO postgres;

--
-- TOC entry 41 (class 1255 OID 49895)
-- Dependencies: 306 5
-- Name: f_registra_cuota(integer, double precision, date, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_registra_cuota(pid_chequera integer, pmonto double precision, pfecha_pago date, ptipo_pago integer, pidcobrador integer) RETURNS integer
    AS $_$
DECLARE 
cantidad integer;
monto_resto double precision;
id_cuota integer;
num_cuota integer;
j integer;
i integer;
cont integer;
resto integer;
saldo boolean;
monto_cuota double precision;
monto_saldo double precision;
f boolean;
BEGIN

select cant_cuotas ,importe_cuota ,(select f_trae_idcuota(ch.idchequera))as idcuota,(select f_num_cuota(ch.idchequera,ch.cant_cuotas)), COALESCE(s.sal_valor ,false),(select f_trae_monto_cuota((select f_trae_idcuota(ch.idchequera)))) into  cantidad,monto_cuota,id_cuota,num_cuota,saldo,monto_saldo
 from t_chequeras ch 
left join (
	select (importe_cuota > (select f_trae_monto_cuota((select f_trae_idcuota(ch.idchequera))))) as sal_valor,idchequera    from t_chequeras ch 
	inner join t_pago p on p.idcuota=(select f_trae_idcuota(ch.idchequera))
	--where ch.idchequera=2 limit 1;
) s  on s.idchequera=pid_chequera
where ch.idchequera=pid_chequera;

raise notice '0 cantidad: %  | Cuota Monto % | id_cuota % | Num Cuota % | saldo %  ',cantidad,monto_cuota,id_cuota,num_cuota,saldo;

if num_cuota >=0 then

	if saldo=false then
	
       select (select f_trae_cuota(ch.idchequera))as idcuota,(select f_num_cuota(ch.idchequera,ch.cant_cuotas)+1) into  id_cuota,num_cuota
	from t_chequeras ch where ch.idchequera=pid_chequera;

	monto_resto=pmonto;
	else --sumo el saldo de la cuota
	monto_resto=pmonto+monto_saldo;
	end if;
raise notice ' 1 cantidad: %  | Cuota Monto % | id_cuota % | Num Cuota % | saldo %  $% ',cantidad,monto_cuota,id_cuota,num_cuota,saldo,monto_saldo;

	
	cont=1;
	


	if pmonto>monto_cuota then
	-- calculo la cant de cuota que puedo pagar con el monto ingresado sin que supere la cantidad de cuotas de la chequera
		while monto_resto>=monto_cuota loop 
			monto_resto=monto_resto-monto_cuota;
			if (cont+num_cuota)>cantidad then 
				raise notice 'La cantidad es mayor a las cuotas';
				 EXIT;
			end if; 
			cont=cont+1;	
		end loop;

		if (num_cuota+cont)<=cantidad then   --si la cuota +cant de elemtos es menor a cant de cuota total
			for i in 0..(cont-1) loop
				
				if i=(cont-1) then
					if monto_resto<=0 then 
					   raise notice 'No hay saldo';
					else
						raise notice 'Inserto cuota saldo % ... $%',num_cuota+i,monto_resto;
						f= f_registrar_pago(( f_trae_cuota(pid_chequera)) ,monto_resto,pfecha_pago, ptipo_pago , pidcobrador );
						f=f_registrar_comision(pidcobrador,(f_trae_idcuota(pid_chequera)),0,(select porcentaje from t_empleados where id_empleados=pidcobrador));
					end if;
				else
					if  i=0 and saldo=true  then
						raise notice 'Update saldo %',num_cuota+i;	
					       f= f_update_pago(( f_trae_idcuota(pid_chequera)) ,monto_cuota, pfecha_pago, ptipo_pago , pidcobrador );
					else 
						raise notice 'Inserto cuota z%',num_cuota+i;
						f= f_registrar_pago(( f_trae_cuota(pid_chequera)) ,monto_cuota, pfecha_pago, ptipo_pago , pidcobrador );
						f=f_registrar_comision(pidcobrador,(f_trae_idcuota(pid_chequera)),0,(select porcentaje from t_empleados where id_empleados=pidcobrador));
					end if;

					
				end if;
			end loop;
		else
			resto=(num_cuota+cont)-cantidad;
			for j in 0..(cont-resto) loop
				if j=0 and saldo=true then
					raise notice 'Update con saldo %',num_cuota;	
					f= f_update_pago(( f_trae_idcuota(pid_chequera)) ,monto_cuota, pfecha_pago, ptipo_pago , pidcobrador );
				else 
					raise notice 'Inserto cuota Nº %',num_cuota+j;
					f= f_registrar_pago(( f_trae_cuota(pid_chequera)) ,monto_cuota, pfecha_pago, ptipo_pago , pidcobrador );
					f=f_registrar_comision(pidcobrador,(f_trae_idcuota(pid_chequera)),0,(select porcentaje from t_empleados where id_empleados=pidcobrador));
				end if;
				
			end loop;
		end if;
	else 
		if saldo=true then
			raise notice 'Update  %',num_cuota;
			if monto_resto>monto_cuota then
			f= f_update_pago((f_trae_idcuota(pid_chequera)) ,monto_cuota, pfecha_pago, ptipo_pago , pidcobrador );
			f=f_registrar_pago((f_trae_cuota(pid_chequera)) ,monto_resto-monto_cuota, pfecha_pago, ptipo_pago , pidcobrador );
			f=f_registrar_comision(pidcobrador,(f_trae_idcuota(pid_chequera)),0,(select porcentaje from t_empleados where id_empleados=pidcobrador));	
			else 	
			f= f_update_pago((f_trae_idcuota(pid_chequera)) ,monto_resto, pfecha_pago, ptipo_pago , pidcobrador );
			end if;
		else
			raise notice 'insert %', num_cuota;
			 f=f_registrar_pago((f_trae_cuota(pid_chequera)) ,pmonto, pfecha_pago, ptipo_pago , pidcobrador );
			 f=f_registrar_comision(pidcobrador,(f_trae_idcuota(pid_chequera)),0,(select porcentaje from t_empleados where id_empleados=pidcobrador));
		end if;
	end if;

return monto_resto;
end if;

return 0;

END;
$_$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_registra_cuota(pid_chequera integer, pmonto double precision, pfecha_pago date, ptipo_pago integer, pidcobrador integer) OWNER TO postgres;

--
-- TOC entry 27 (class 1255 OID 33512)
-- Dependencies: 5 306
-- Name: f_registrar_comision(integer, integer, integer, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_registrar_comision(pidempleado integer, pid_cuota integer, pestado integer, pporcentaje double precision) RETURNS boolean
    AS $$Begin

insert into t_comisiones (idempleado,idcuota,porcentaje,estado)values(pidempleado,pid_cuota,pporcentaje,pestado);
	if NOT FOUND then
		ROLLBACK;
		return false;
	else	
		return true;
	end if;
end;$$
    LANGUAGE plpgsql SECURITY DEFINER;


ALTER FUNCTION public.f_registrar_comision(pidempleado integer, pid_cuota integer, pestado integer, pporcentaje double precision) OWNER TO postgres;

--
-- TOC entry 43 (class 1255 OID 58220)
-- Dependencies: 5 306
-- Name: f_registrar_pago(integer, double precision, date, integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_registrar_pago(pid_cuota integer, pmonto double precision, pfecha_pago date, ptipo_pago integer, pidcobrador integer, p_usuario character varying) RETURNS boolean
    AS $$Begin

insert into t_pago (idcuota,monto,fecha_pago,tipo_pago,idcobrador,fecha_aud,hora_aud,usuario_aud)
values(pid_cuota,pmonto,pfecha_pago,ptipo_pago,pidcobrador,(select fecha()),(select hora()),p_usuario);
	if NOT FOUND then
		ROLLBACK;
		return false;
	else	
		return true;
	end if;
end;$$
    LANGUAGE plpgsql SECURITY DEFINER;


ALTER FUNCTION public.f_registrar_pago(pid_cuota integer, pmonto double precision, pfecha_pago date, ptipo_pago integer, pidcobrador integer, p_usuario character varying) OWNER TO postgres;

--
-- TOC entry 28 (class 1255 OID 49889)
-- Dependencies: 306 5
-- Name: f_trae_cuota(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_trae_cuota(p_idchequera integer) RETURNS integer
    AS $$
begin
--Trae la cuota siguiente
return  (select min(idcuota) as cuota from (
	select idcuota from t_cuotas c where idchequera=p_idchequera
	 EXCEPT  
	select idcuota from t_pago p
) cuota_pago);
end;
$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_trae_cuota(p_idchequera integer) OWNER TO postgres;

--
-- TOC entry 33 (class 1255 OID 49900)
-- Dependencies: 306 5
-- Name: f_trae_idcuota(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_trae_idcuota(p_idchequera integer) RETURNS integer
    AS $$
begin
--Trae idcuota de cuota pagada
return  (select max(idcuota) as cuota from (
	select idcuota from t_pago p
	INTERSECT  
	select idcuota from t_cuotas c where idchequera=p_idchequera
) cuota_pago);
end;
$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_trae_idcuota(p_idchequera integer) OWNER TO postgres;

--
-- TOC entry 30 (class 1255 OID 49890)
-- Dependencies: 306 5
-- Name: f_trae_monto_cuota(numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_trae_monto_cuota(p_idcuota numeric) RETURNS double precision
    AS $$begin
-- 
return (select monto from t_pago where idcuota=p_idcuota);
end;$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.f_trae_monto_cuota(p_idcuota numeric) OWNER TO postgres;

--
-- TOC entry 40 (class 1255 OID 49993)
-- Dependencies: 5 306
-- Name: f_update_pago(integer, double precision, date, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION f_update_pago(pid_cuota integer, pmonto double precision, pfecha_pago date, ptipo_pago integer, pidcobrador integer) RETURNS boolean
    AS $$Begin

update t_pago SET monto=pmonto,fecha_pago=pfecha_pago,tipo_pago=ptipo_pago,idcobrador=pidcobrador 
where idcuota=pid_cuota;

	if NOT FOUND then
		ROLLBACK;
		return false;
	else	
		return true;
	end if;
end;$$
    LANGUAGE plpgsql SECURITY DEFINER;


ALTER FUNCTION public.f_update_pago(pid_cuota integer, pmonto double precision, pfecha_pago date, ptipo_pago integer, pidcobrador integer) OWNER TO postgres;

--
-- TOC entry 14 (class 1255 OID 23048)
-- Dependencies: 5 306
-- Name: fecha(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION fecha() RETURNS date
    AS $$
begin return(current_date); end;
$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.fecha() OWNER TO postgres;

--
-- TOC entry 15 (class 1255 OID 23049)
-- Dependencies: 5 306
-- Name: hora(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION hora() RETURNS character varying
    AS $$
DECLARE ls_hora VARCHAR;
BEGIN
ls_hora := to_char(current_timestamp,'HH24:MI');
return (ls_hora);
END;
$$
    LANGUAGE plpgsql;


ALTER FUNCTION public.hora() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1266 (class 1259 OID 32657)
-- Dependencies: 5
-- Name: detalle_chequera; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE detalle_chequera (
    idchequera integer,
    iddetalle integer NOT NULL,
    codigo_ejemplar integer,
    cant integer,
    precio double precision,
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20)
);


ALTER TABLE public.detalle_chequera OWNER TO postgres;

--
-- TOC entry 1265 (class 1259 OID 32655)
-- Dependencies: 5 1266
-- Name: detalle_chequera_iddetalle_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE detalle_chequera_iddetalle_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.detalle_chequera_iddetalle_seq OWNER TO postgres;

--
-- TOC entry 1646 (class 0 OID 0)
-- Dependencies: 1265
-- Name: detalle_chequera_iddetalle_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE detalle_chequera_iddetalle_seq OWNED BY detalle_chequera.iddetalle;


SET default_with_oids = true;

--
-- TOC entry 1240 (class 1259 OID 22973)
-- Dependencies: 5
-- Name: diccionario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diccionario (
    codigo numeric(4,0),
    item numeric(4,0),
    descrip character varying(100)
);


ALTER TABLE public.diccionario OWNER TO postgres;

SET default_with_oids = false;

--
-- TOC entry 1257 (class 1259 OID 24388)
-- Dependencies: 5
-- Name: t_chequeras; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_chequeras (
    idchequera integer NOT NULL,
    vto_cuota date,
    dia_cobrar integer,
    cant_cuotas integer,
    importe_cuota double precision,
    monto_total double precision,
    num_chequera integer,
    id_cliente integer,
    fecha date,
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20),
    financiado double precision,
    idvendedor integer,
    cobrado integer,
    idcobrador integer
);


ALTER TABLE public.t_chequeras OWNER TO postgres;

--
-- TOC entry 1256 (class 1259 OID 24386)
-- Dependencies: 5 1257
-- Name: t_chequeras_idchequera_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE t_chequeras_idchequera_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.t_chequeras_idchequera_seq OWNER TO postgres;

--
-- TOC entry 1647 (class 0 OID 0)
-- Dependencies: 1256
-- Name: t_chequeras_idchequera_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE t_chequeras_idchequera_seq OWNED BY t_chequeras.idchequera;


SET default_with_oids = true;

--
-- TOC entry 1247 (class 1259 OID 23256)
-- Dependencies: 5
-- Name: t_clientes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_clientes (
    id_clientes integer NOT NULL,
    nombre character varying(30),
    apellido character varying(30),
    dni numeric(8,0),
    domicilio character varying(100),
    barrio character varying(30),
    id_localidad numeric(5,0),
    id_provincia numeric(5,0),
    cel numeric(10,0),
    obs text,
    tel numeric(7,0),
    moroso numeric(1,0),
    estado numeric(1,0),
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20)
);


ALTER TABLE public.t_clientes OWNER TO postgres;

SET default_with_oids = false;

--
-- TOC entry 1264 (class 1259 OID 32646)
-- Dependencies: 5
-- Name: t_comisiones; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_comisiones (
    idempleado integer,
    idcuota integer,
    porcentaje double precision,
    estado numeric(1,0),
    idcomision integer NOT NULL
);


ALTER TABLE public.t_comisiones OWNER TO postgres;

--
-- TOC entry 1267 (class 1259 OID 33506)
-- Dependencies: 1264 5
-- Name: t_comisiones_idcomision_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE t_comisiones_idcomision_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.t_comisiones_idcomision_seq OWNER TO postgres;

--
-- TOC entry 1648 (class 0 OID 0)
-- Dependencies: 1267
-- Name: t_comisiones_idcomision_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE t_comisiones_idcomision_seq OWNED BY t_comisiones.idcomision;


--
-- TOC entry 1261 (class 1259 OID 32624)
-- Dependencies: 5
-- Name: t_cuotas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_cuotas (
    idchequera integer,
    idcuota integer NOT NULL,
    fecha_venc date,
    monto double precision
);


ALTER TABLE public.t_cuotas OWNER TO postgres;

--
-- TOC entry 1260 (class 1259 OID 32622)
-- Dependencies: 1261 5
-- Name: t_cuotas_idcuota_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE t_cuotas_idcuota_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.t_cuotas_idcuota_seq OWNER TO postgres;

--
-- TOC entry 1649 (class 0 OID 0)
-- Dependencies: 1260
-- Name: t_cuotas_idcuota_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE t_cuotas_idcuota_seq OWNED BY t_cuotas.idcuota;


--
-- TOC entry 1249 (class 1259 OID 24161)
-- Dependencies: 5
-- Name: t_editoriales; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_editoriales (
    ideditorial numeric(5,0) NOT NULL,
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20),
    descrip character varying(200)
);


ALTER TABLE public.t_editoriales OWNER TO postgres;

--
-- TOC entry 1252 (class 1259 OID 24173)
-- Dependencies: 5
-- Name: t_ejemplares; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_ejemplares (
    codigo integer NOT NULL,
    idtitulo numeric(4,0) NOT NULL,
    idgenero numeric(4,0) NOT NULL,
    ideditorial numeric(5,0) NOT NULL,
    costo integer NOT NULL,
    cant integer NOT NULL,
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20),
    estado integer NOT NULL
);


ALTER TABLE public.t_ejemplares OWNER TO postgres;

SET default_with_oids = true;

--
-- TOC entry 1248 (class 1259 OID 24106)
-- Dependencies: 5
-- Name: t_empleados; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_empleados (
    id_empleados integer NOT NULL,
    num_empleados integer,
    nombre character varying(30),
    apellido character varying(30),
    dni numeric(8,0),
    domicilio character varying(100),
    barrio character varying(30),
    id_localidad numeric(5,0),
    id_provincia numeric(5,0),
    tel numeric(7,0),
    obs text,
    estado numeric(2,0),
    cel numeric(10,0),
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20),
    porcentaje double precision
);


ALTER TABLE public.t_empleados OWNER TO postgres;

--
-- TOC entry 1650 (class 0 OID 0)
-- Dependencies: 1248
-- Name: COLUMN t_empleados.porcentaje; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN t_empleados.porcentaje IS 'valor que cobra por ventas/cobranzas realizadas';


--
-- TOC entry 1241 (class 1259 OID 22975)
-- Dependencies: 5
-- Name: t_funcion_menu; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_funcion_menu (
    id_funcion integer,
    id_menu integer,
    id_submenu integer
);


ALTER TABLE public.t_funcion_menu OWNER TO postgres;

SET default_with_oids = false;

--
-- TOC entry 1250 (class 1259 OID 24165)
-- Dependencies: 5
-- Name: t_generos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_generos (
    idgenero numeric(4,0) NOT NULL,
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20),
    descrip character varying(100)
);


ALTER TABLE public.t_generos OWNER TO postgres;

--
-- TOC entry 1251 (class 1259 OID 24169)
-- Dependencies: 5
-- Name: t_libros; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_libros (
    idlibro numeric(4,0) NOT NULL,
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20),
    descrip character varying(100)
);


ALTER TABLE public.t_libros OWNER TO postgres;

--
-- TOC entry 1253 (class 1259 OID 24204)
-- Dependencies: 5
-- Name: t_localidad_idlocalidad_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE t_localidad_idlocalidad_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.t_localidad_idlocalidad_seq OWNER TO postgres;

SET default_with_oids = true;

--
-- TOC entry 1254 (class 1259 OID 24206)
-- Dependencies: 1595 5
-- Name: t_localidades; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_localidades (
    idprovincia integer DEFAULT nextval(('public.t_localidad_idlocalidad_seq'::text)::regclass) NOT NULL,
    idlocalidad numeric(4,0) NOT NULL,
    descrip character varying(100)
);


ALTER TABLE public.t_localidades OWNER TO postgres;

--
-- TOC entry 1242 (class 1259 OID 22977)
-- Dependencies: 5
-- Name: t_menu; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_menu (
    id_menu integer,
    id_submenu integer,
    nombre character varying(50),
    link character varying(100),
    descripcion character varying(100),
    img character varying(30)
);


ALTER TABLE public.t_menu OWNER TO postgres;

SET default_with_oids = false;

--
-- TOC entry 1255 (class 1259 OID 24220)
-- Dependencies: 5
-- Name: t_oficios; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_oficios (
    id_oficio integer NOT NULL,
    id_empleados integer
);


ALTER TABLE public.t_oficios OWNER TO postgres;

--
-- TOC entry 1263 (class 1259 OID 32636)
-- Dependencies: 5
-- Name: t_pago; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_pago (
    idcuota integer,
    idpago integer NOT NULL,
    monto double precision,
    fecha_pago date,
    tipo_pago integer,
    idcobrador integer,
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20)
);


ALTER TABLE public.t_pago OWNER TO postgres;

--
-- TOC entry 1262 (class 1259 OID 32634)
-- Dependencies: 5 1263
-- Name: t_pago_idpago_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE t_pago_idpago_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.t_pago_idpago_seq OWNER TO postgres;

--
-- TOC entry 1653 (class 0 OID 0)
-- Dependencies: 1262
-- Name: t_pago_idpago_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE t_pago_idpago_seq OWNED BY t_pago.idpago;


SET default_with_oids = true;

--
-- TOC entry 1246 (class 1259 OID 23062)
-- Dependencies: 5
-- Name: t_pais; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_pais (
    codigo numeric(4,0),
    idpais numeric(4,0),
    descrip character varying(100)
);


ALTER TABLE public.t_pais OWNER TO postgres;

--
-- TOC entry 1245 (class 1259 OID 23060)
-- Dependencies: 5
-- Name: t_provincias; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_provincias (
    idpais numeric(4,0),
    idprovincia numeric(4,0) NOT NULL,
    descrip character varying(100)
);


ALTER TABLE public.t_provincias OWNER TO postgres;

--
-- TOC entry 1243 (class 1259 OID 22979)
-- Dependencies: 1592 1593 1594 5
-- Name: t_usuarios; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_usuarios (
    id_usuario integer DEFAULT nextval(('public.tusuarios_id_usuario_seq'::text)::regclass) NOT NULL,
    usuario character varying(20) NOT NULL,
    pass character varying(30) NOT NULL,
    nombre character varying(20) NOT NULL,
    apellido character varying(20) NOT NULL,
    funcion numeric(4,0) DEFAULT 1 NOT NULL,
    habilitado numeric(1,0) DEFAULT 1,
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20)
);


ALTER TABLE public.t_usuarios OWNER TO postgres;

--
-- TOC entry 1270 (class 1259 OID 58216)
-- Dependencies: 5
-- Name: t_vales; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE t_vales (
    id_empleado integer,
    idvale integer NOT NULL,
    monto double precision,
    fecha date,
    fecha_aud date,
    hora_aud character varying(5),
    usuario_aud character varying(20)
);


ALTER TABLE public.t_vales OWNER TO postgres;

--
-- TOC entry 1269 (class 1259 OID 58214)
-- Dependencies: 5 1270
-- Name: t_vales_idvale_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE t_vales_idvale_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.t_vales_idvale_seq OWNER TO postgres;

--
-- TOC entry 1655 (class 0 OID 0)
-- Dependencies: 1269
-- Name: t_vales_idvale_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE t_vales_idvale_seq OWNED BY t_vales.idvale;


--
-- TOC entry 1244 (class 1259 OID 22984)
-- Dependencies: 5
-- Name: tusuarios_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tusuarios_id_usuario_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.tusuarios_id_usuario_seq OWNER TO postgres;

--
-- TOC entry 1600 (class 2604 OID 32659)
-- Dependencies: 1266 1265 1266
-- Name: iddetalle; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE detalle_chequera ALTER COLUMN iddetalle SET DEFAULT nextval('detalle_chequera_iddetalle_seq'::regclass);


--
-- TOC entry 1596 (class 2604 OID 24390)
-- Dependencies: 1257 1256 1257
-- Name: idchequera; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE t_chequeras ALTER COLUMN idchequera SET DEFAULT nextval('t_chequeras_idchequera_seq'::regclass);


--
-- TOC entry 1599 (class 2604 OID 33508)
-- Dependencies: 1267 1264
-- Name: idcomision; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE t_comisiones ALTER COLUMN idcomision SET DEFAULT nextval('t_comisiones_idcomision_seq'::regclass);


--
-- TOC entry 1597 (class 2604 OID 32626)
-- Dependencies: 1261 1260 1261
-- Name: idcuota; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE t_cuotas ALTER COLUMN idcuota SET DEFAULT nextval('t_cuotas_idcuota_seq'::regclass);


--
-- TOC entry 1598 (class 2604 OID 32638)
-- Dependencies: 1263 1262 1263
-- Name: idpago; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE t_pago ALTER COLUMN idpago SET DEFAULT nextval('t_pago_idpago_seq'::regclass);


--
-- TOC entry 1601 (class 2604 OID 58218)
-- Dependencies: 1269 1270 1270
-- Name: idvale; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE t_vales ALTER COLUMN idvale SET DEFAULT nextval('t_vales_idvale_seq'::regclass);


--
-- TOC entry 1632 (class 2606 OID 33514)
-- Dependencies: 1266 1266
-- Name: detalle_chequera_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY detalle_chequera
    ADD CONSTRAINT detalle_chequera_pk PRIMARY KEY (iddetalle);


--
-- TOC entry 1624 (class 2606 OID 24392)
-- Dependencies: 1257 1257
-- Name: t_chequera_idchequera_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_chequeras
    ADD CONSTRAINT t_chequera_idchequera_pk PRIMARY KEY (idchequera);


--
-- TOC entry 1609 (class 2606 OID 23262)
-- Dependencies: 1247 1247
-- Name: t_clientes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_clientes
    ADD CONSTRAINT t_clientes_pkey PRIMARY KEY (id_clientes);


--
-- TOC entry 1630 (class 2606 OID 33516)
-- Dependencies: 1264 1264
-- Name: t_comisiones_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_comisiones
    ADD CONSTRAINT t_comisiones_pk PRIMARY KEY (idcomision);


--
-- TOC entry 1626 (class 2606 OID 32633)
-- Dependencies: 1261 1261
-- Name: t_cuotas_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_cuotas
    ADD CONSTRAINT t_cuotas_pk PRIMARY KEY (idcuota);


--
-- TOC entry 1613 (class 2606 OID 24164)
-- Dependencies: 1249 1249
-- Name: t_editoriales_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_editoriales
    ADD CONSTRAINT t_editoriales_pk PRIMARY KEY (ideditorial);


--
-- TOC entry 1619 (class 2606 OID 24176)
-- Dependencies: 1252 1252
-- Name: t_ejemplares_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_ejemplares
    ADD CONSTRAINT t_ejemplares_pk PRIMARY KEY (codigo);


--
-- TOC entry 1611 (class 2606 OID 24112)
-- Dependencies: 1248 1248
-- Name: t_empleados_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_empleados
    ADD CONSTRAINT t_empleados_pkey PRIMARY KEY (id_empleados);


--
-- TOC entry 1615 (class 2606 OID 24168)
-- Dependencies: 1250 1250
-- Name: t_generos_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_generos
    ADD CONSTRAINT t_generos_pk PRIMARY KEY (idgenero);


--
-- TOC entry 1617 (class 2606 OID 24172)
-- Dependencies: 1251 1251
-- Name: t_libros_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_libros
    ADD CONSTRAINT t_libros_pk PRIMARY KEY (idlibro);


--
-- TOC entry 1622 (class 2606 OID 24213)
-- Dependencies: 1254 1254
-- Name: t_localidad; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_localidades
    ADD CONSTRAINT t_localidad PRIMARY KEY (idlocalidad);


--
-- TOC entry 1628 (class 2606 OID 32640)
-- Dependencies: 1263 1263
-- Name: t_pago_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_pago
    ADD CONSTRAINT t_pago_pk PRIMARY KEY (idpago);


--
-- TOC entry 1606 (class 2606 OID 24211)
-- Dependencies: 1245 1245
-- Name: t_provincias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_provincias
    ADD CONSTRAINT t_provincias_pkey PRIMARY KEY (idprovincia);


--
-- TOC entry 1604 (class 2606 OID 23021)
-- Dependencies: 1243 1243
-- Name: tusuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY t_usuarios
    ADD CONSTRAINT tusuarios_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 1620 (class 1259 OID 24219)
-- Dependencies: 1254
-- Name: fki_idprovincas; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_idprovincas ON t_localidades USING btree (idprovincia);


--
-- TOC entry 1602 (class 1259 OID 23022)
-- Dependencies: 1240
-- Name: idx_codigo; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_codigo ON diccionario USING btree (codigo);


--
-- TOC entry 1607 (class 1259 OID 24209)
-- Dependencies: 1246
-- Name: t_pais_idpais; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX t_pais_idpais ON t_pais USING btree (idpais);


--
-- TOC entry 1636 (class 2606 OID 24214)
-- Dependencies: 1254 1245 1605
-- Name: fk_idprovincia; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY t_localidades
    ADD CONSTRAINT fk_idprovincia FOREIGN KEY (idprovincia) REFERENCES t_provincias(idprovincia);


--
-- TOC entry 1638 (class 2606 OID 24393)
-- Dependencies: 1247 1608 1257
-- Name: t_chequera_idcliente; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY t_chequeras
    ADD CONSTRAINT t_chequera_idcliente FOREIGN KEY (id_cliente) REFERENCES t_clientes(id_clientes);


--
-- TOC entry 1633 (class 2606 OID 24177)
-- Dependencies: 1249 1612 1252
-- Name: t_editoriales_new_table_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY t_ejemplares
    ADD CONSTRAINT t_editoriales_new_table_fk FOREIGN KEY (ideditorial) REFERENCES t_editoriales(ideditorial);


--
-- TOC entry 1634 (class 2606 OID 24182)
-- Dependencies: 1252 1614 1250
-- Name: t_generos_new_table_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY t_ejemplares
    ADD CONSTRAINT t_generos_new_table_fk FOREIGN KEY (idgenero) REFERENCES t_generos(idgenero);


--
-- TOC entry 1639 (class 2606 OID 32627)
-- Dependencies: 1257 1623 1261
-- Name: t_idchequera_pk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY t_cuotas
    ADD CONSTRAINT t_idchequera_pk FOREIGN KEY (idchequera) REFERENCES t_chequeras(idchequera);


--
-- TOC entry 1635 (class 2606 OID 24187)
-- Dependencies: 1251 1616 1252
-- Name: t_libros_new_table_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY t_ejemplares
    ADD CONSTRAINT t_libros_new_table_fk FOREIGN KEY (idtitulo) REFERENCES t_libros(idlibro);


--
-- TOC entry 1637 (class 2606 OID 24222)
-- Dependencies: 1610 1248 1255
-- Name: t_oficios_fk_idempleados; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY t_oficios
    ADD CONSTRAINT t_oficios_fk_idempleados FOREIGN KEY (id_empleados) REFERENCES t_empleados(id_empleados);


--
-- TOC entry 1640 (class 2606 OID 32641)
-- Dependencies: 1261 1263 1625
-- Name: t_pago_idcuota; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY t_pago
    ADD CONSTRAINT t_pago_idcuota FOREIGN KEY (idcuota) REFERENCES t_cuotas(idcuota);


--
-- TOC entry 1645 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- TOC entry 1651 (class 0 OID 0)
-- Dependencies: 1241
-- Name: t_funcion_menu; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE t_funcion_menu FROM PUBLIC;
REVOKE ALL ON TABLE t_funcion_menu FROM postgres;
GRANT ALL ON TABLE t_funcion_menu TO postgres;


--
-- TOC entry 1652 (class 0 OID 0)
-- Dependencies: 1242
-- Name: t_menu; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE t_menu FROM PUBLIC;
REVOKE ALL ON TABLE t_menu FROM postgres;
GRANT ALL ON TABLE t_menu TO postgres;


--
-- TOC entry 1654 (class 0 OID 0)
-- Dependencies: 1243
-- Name: t_usuarios; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE t_usuarios FROM PUBLIC;
REVOKE ALL ON TABLE t_usuarios FROM postgres;
GRANT ALL ON TABLE t_usuarios TO postgres;


-- Completed on 2008-12-29 20:03:51

--
-- PostgreSQL database dump complete
--

