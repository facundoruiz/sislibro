
CREATE OR REPLACE FUNCTION f_registra_cuota(pid_chequera integer, pmonto double precision, pfecha_pago date, ptipo_pago integer, pidcobrador integer, p_usuario character varying,num_recibo integer)
  RETURNS double precision AS
$BODY$
DECLARE 
cantidad_cuotas integer;
num_cuota double precision;
idcuotay integer;
idcuota_impaga integer;
idcuota_sin_pagar integer;
j integer;
i integer;
cont integer;
resto integer;
saldo boolean;
monto_cuota double precision;--monto de la cuota
monto_idcuota double precision;--monto de la segun el id cuota 
monto_saldo double precision;--monto que hay en pagos
monto_resto double precision;--varible para pasar el pmonto
f boolean;
BEGIN
select cant_cuotas, f_num_cuota(ch.idchequera,ch.cant_cuotas) ,f_trae_cuota(ch.idchequera) ,s.idcuota ,COALESCE(s.sal_valor ,false),s.s_monto,tc.monto,ch.idchequera
 into cantidad_cuotas,num_cuota,idcuota_sin_pagar,idcuota_impaga,saldo,monto_saldo,monto_cuota
 from t_chequeras ch 
left join (
		select  a.s_monto>=c.monto as sal_valor ,a.s_monto||' >= '||c.monto as calc,idcuota,c.idchequera,s_monto
		from t_cuotas c
		inner join (
			select sum(monto) as s_monto,idcuota from t_pago 
			group by idcuota
			) a using( idcuota )
		where (a.s_monto>=c.monto)!='t'
--limit 1
) s  on s.idchequera=pid_chequera
left join t_cuotas tc on tc.idcuota=f_trae_cuota(ch.idchequera) 
where ch.idchequera=pid_chequera
limit 1;

raise notice '0 cantidad: %  | Cuota Monto % | ID s/p % | ID cuo saldo % | Num Cuota % | saldo %  ',cantidad_cuotas,monto_cuota,idcuota_sin_pagar,idcuota_impaga,num_cuota,saldo;
--controlo q si hay saldo

if  (idcuota_impaga is  NULL) and (idcuota_sin_pagar is  NULL) then
return -999;
end if;


  if num_cuota >=0 then

		if (idcuota_impaga is NULL) then
			raise notice 'idcuota_impaga';
			monto_resto=pmonto;
		else --sumo el saldo de la cuota
			monto_resto=pmonto+monto_saldo;
		end if;
	raise notice ' 1 cantidad: %  | Cuota Monto % | id_cuota % | Num Cuota % | saldo %  $% ',cantidad_cuotas,monto_cuota,idcuota_sin_pagar,num_cuota,saldo,monto_saldo;

	
	cont=1;
	
	if  (idcuota_impaga is not NULL)then 
		idcuotay=idcuota_impaga;
	else
		idcuotay=idcuota_sin_pagar;
	end if; 



	--if monto_resto>monto_cuota then
	-- calculo la cant de cuota que puedo pagar con el monto ingresado sin que supere la cantidad de cuotas de la chequera
		while monto_resto>=monto_cuota loop 
			raise notice ' id : %',idcuotay;
			monto_idcuota=f_trae_monto_idcuota(idcuotay);
			idcuotay=idcuotay+1;	
			monto_resto=monto_resto-monto_idcuota;
			if (cont+num_cuota)>cantidad_cuotas then 
				raise notice 'La cantidad es mayor a las cuotas';
				 EXIT;
			end if; 
			cont=cont+1;	
		end loop;

		if (num_cuota+cont)<=cantidad_cuotas then   --si la cuota +cant de elemtos es menor a cant de cuota total
			for i in 0..(cont-1) loop

				idcuota_impaga= f_dame_idcuota_impaga(pid_chequera);--da el id de la cuota pagada a media
				idcuota_sin_pagar=f_trae_cuota(pid_chequera);--trae el id de la cuota sin pagar
raise notice 'impaga I % |Monto_resto % |impaga %',i,monto_resto,idcuota_impaga;
				if i=(cont-1) then
					if monto_resto<=0 then 
					   raise notice 'No hay saldo';
					else
						
						if  (idcuota_impaga is not NULL) then
							raise notice 'el monto_resto impag';
							if  monto_resto>f_suma_monto_cuota(idcuota_impaga) then
								raise notice 'el monto_resto > s_cuo';
								f= f_registrar_pago(idcuota_impaga ,monto_resto-f_suma_monto_cuota(idcuota_impaga),pfecha_pago, ptipo_pago , pidcobrador,p_usuario ,numrecibo );
							else
								f= f_registrar_pago(idcuota_impaga ,monto_resto,pfecha_pago, ptipo_pago , pidcobrador,p_usuario ,numrecibo );
							end if;
							
						else
							raise notice 'el monto_resto sin pag';
							f= f_registrar_pago( idcuota_sin_pagar ,monto_resto, pfecha_pago, ptipo_pago , pidcobrador ,p_usuario,numrecibo);
						end if;
					end if;
				else
					if  i=0 and (idcuota_impaga is not NULL)  then
						raise notice 'Si es la impaga : %',num_cuota+i;	
					     --  f= f_update_pago(( f_trae_idcuota(pid_chequera)) ,monto_cuota, pfecha_pago, ptipo_pago , pidcobrador );
						monto_idcuota=f_trae_monto_idcuota(idcuota_impaga);
						f= f_registrar_pago((idcuota_impaga) ,monto_idcuota-monto_saldo,pfecha_pago, ptipo_pago , pidcobrador,p_usuario ,numrecibo );
					else 
						raise notice 'Inserto cuota z%',num_cuota+i;
						f= f_registrar_pago(idcuota_sin_pagar ,f_trae_monto_idcuota(idcuota_sin_pagar), pfecha_pago, ptipo_pago , pidcobrador ,p_usuario,numrecibo);
						
					end if;

					
				end if;
			end loop;
		else
			resto=(num_cuota+cont)-cantidad_cuotas;
			for j in 0..(cont-resto) loop
				idcuota_impaga= f_dame_idcuota_impaga(pid_chequera);--da el id de la cuota pagada a media
				idcuota_sin_pagar=f_trae_cuota(pid_chequera);--trae el id de la cuota sin pagar


				if j=((cont-resto)) then
					if monto_resto<=0 then 
					   raise notice 'No hay saldo';
					else
						   raise notice 'monto_resto _cuando cuo pasa';
							if  (idcuota_impaga is not NULL) then
								raise notice 'impaga';
								if  monto_resto>f_suma_monto_cuota(idcuota_impaga) then
									raise notice 'el monto_resto > s_cuo';
									f= f_registrar_pago(idcuota_impaga ,monto_resto-f_suma_monto_cuota(idcuota_impaga),pfecha_pago, ptipo_pago , pidcobrador,p_usuario ,numrecibo );
								else
									f= f_registrar_pago(idcuota_impaga ,monto_resto,pfecha_pago, ptipo_pago , pidcobrador,p_usuario ,numrecibo );
								end if;
							else
								raise notice 'sin pagar';
								f= f_registrar_pago(idcuota_sin_pagar ,monto_resto, pfecha_pago, ptipo_pago , pidcobrador ,p_usuario,numrecibo);
							end if;
						--f= f_registrar_pago(( f_dame_idcuota_impaga(pid_chequera)) ,monto_resto,pfecha_pago, ptipo_pago , pidcobrador,p_usuario  );
						
					end if;
				else		
						if j=0 and (idcuota_impaga is not NULL) then
							raise notice 'Update con saldo %',num_cuota;	
						f= f_registrar_pago(idcuota_impaga ,f_trae_monto_idcuota(idcuota_impaga)-monto_saldo, pfecha_pago, ptipo_pago , pidcobrador ,p_usuario,numrecibo);
						else 
							raise notice 'in sert cuota%',num_cuota;	
							f= f_registrar_pago(idcuota_sin_pagar ,f_trae_monto_idcuota(idcuota_sin_pagar), pfecha_pago, ptipo_pago , pidcobrador,p_usuario,numrecibo );
						end if;
				end if;
			end loop;
		end if;
	/*else --Cuando el Monto de la cuota es inferior al de la cuota pasa por aqui
		if (idcuota_impaga is not NULL) then
			raise notice 'existe saldo  %',num_cuota;
			if monto_resto<monto_cuota then
				raise notice 'Inserto el lo que falta  %',num_cuota;
				monto_resto=monto_resto-(monto_cuota-monto_saldo);
				f= f_registrar_pago(( f_dame_idcuota_impaga(pid_chequera)) ,monto_cuota-monto_saldo, pfecha_pago, ptipo_pago , pidcobrador ,p_usuario);
				
				if monto_resto >0 then 
					f= f_registrar_pago((f_trae_cuota(pid_chequera)) ,monto_resto, pfecha_pago, ptipo_pago , pidcobrador ,p_usuario);
				end if;	
			
			else 	
				monto_resto=monto_resto-(monto_cuota-monto_saldo);
				raise notice 'existe saldo  y lo inserto con el monto%',monto_resto;
				f= f_registrar_pago(( f_dame_idcuota_impaga(pid_chequera)) ,monto_resto-monto_saldo, pfecha_pago, ptipo_pago , pidcobrador ,p_usuario);
			end if;
		else
			if (idcuota_sin_pagar is not null) then
				raise notice 'insert con el monto correcto%', num_cuota;
				f=f_registrar_pago((f_trae_cuota(pid_chequera)) ,pmonto, pfecha_pago, ptipo_pago , pidcobrador ,p_usuario);
			end if;
		end if;*/
	end if;

return monto_resto;
--end if;

return 0;


END;
$BODY$
  LANGUAGE 'plpgsql' VOLATILE SECURITY DEFINER;




CREATE OR REPLACE FUNCTION f_registrar_pago(pid_cuota integer, pmonto double precision, pfecha_pago date, ptipo_pago integer, pidcobrador integer, p_usuario character varying,p_numrecibo integer)
  RETURNS boolean AS
$BODY$Begin

insert into t_pago (idcuota,monto,fecha_pago,tipo_pago,idcobrador,fecha_aud,hora_aud,usuario_aud,numrecibo)
values(pid_cuota,pmonto,pfecha_pago,ptipo_pago,pidcobrador,(select fecha()),(select hora()),p_usuario,p_numrecibo);
	if NOT FOUND then
		ROLLBACK;
		return false;
	else	
		return true;
	end if;
end;$BODY$
  LANGUAGE 'plpgsql' VOLATILE SECURITY DEFINER;

