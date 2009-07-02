<?php
class gestorEmpleado extends Empleado{
	private $conex;
	
	function __construct(gestorConexion $p_c) {
			$this->setConexion($p_c);	
	}

	function setConexion(gestorConexion $p_c){
		$this->conex = $p_c->getMiConexion();
	}
		
	function getConexion(){
		return $this->conex;
	}
	
	function __wakeup(){
		$this->c->conectar();
	}
	public function  get_EmpleadoDni($p_dni){
		$this->getConexion();
		$cmd="select *,(select id_oficio from t_oficios where id_empleados=e.id_empleados limit 1) as id_oficio from t_empleados e where dni=".$p_dni."";
		$query=pg_query($cmd);
		$r=pg_fetch_array($query);
		
		$empleado=new Empleado();
		
		$empleado->set_dni($r['dni']);
		$empleado->set_id_empleado($r['id_empleados']);
		$empleado->set_num_empleado($r['num_empleados']);
		$empleado->set_apellido($r['apellido']);
		$empleado->set_nombre($r['nombre']);
	    $empleado->set_domicilio($r['domicilio']);
		$empleado->set_telefono($r['tel']);
		$empleado->set_celular($r['cel']);
		$empleado->set_localidad($r['id_localidad']);
		$empleado->set_provincia($r['id_provincia']);
		$empleado->set_barrio($r['barrio']);
		$empleado->set_obs($r['obs']);
		$empleado->set_porcentaje($r['porcentaje']);
		$empleado->set_id_oficio($r['id_oficio']);
		$empleado->set_estado($r['estado']);
		
		  return $empleado;
	}
	public function  get_EmpleadoId($p_id){
		$this->getConexion();
		 $cmd="select *,(select id_oficio from t_oficios where id_empleados=".$p_id." limit 1) as id_oficio, (select descoficio(1,o.id_oficio) limit 1) as oficio from t_empleados e 
inner join t_oficios o on o.id_empleados=e.id_empleados 
where e.id_empleados=".$p_id."  limit 1";
		$query=pg_query($cmd);
		$r=pg_fetch_array($query);
		if($r>0){
		$empleado=new Empleado();
		
		$empleado->set_dni($r['dni']);
		$empleado->set_id_empleado($r['id_empleados']);
		$empleado->set_num_empleado($r['num_empleados']);
		$empleado->set_apellido($r['apellido']);
		$empleado->set_nombre($r['nombre']);
	    $empleado->set_domicilio($r['domicilio']);
		$empleado->set_telefono($r['tel']);
		$empleado->set_celular($r['cel']);
		$empleado->set_localidad($r['id_localidad']);
		$empleado->set_provincia($r['id_provincia']);
		$empleado->set_barrio($r['barrio']);
		$empleado->set_obs($r['obs']);
		$empleado->set_porcentaje($r['_porcentaje']);
		$empleado->set_id_oficio($r['id_oficio']);
		$empleado->set_oficio($r['oficio']);
		$empleado->set_estado($r['estado']);
		  
		return $empleado;
		}else{
			return 0;
		}
	}
	public function existe_NumEmpleado($p_num){
		$cmd="select existe_numempleado(".$p_num.")";
		$query=pg_query($cmd);
		$r=pg_fetch_array($query);
		if($r>0){
			return $r[0];
		}else{
		return 0;
		}
	}
	public function ComboVendedor(){
		
		$combov=new HtmlCombo('','vendedor',20,true);
					$qo=pg_query("select e.id_empleados,(apellido||','||nombre) from t_empleados e
inner join t_oficios o on (o.id_empleados=e.id_empleados)
where o.id_oficio=1 or o.id_oficio=3");
					
					$combov->addItem(0,'--Vendedor-');
					while($ro=pg_fetch_array($qo)){
						$combov->addItem($ro[0],$ro[1]);
						};
		return $combov;
	}
	public function ComboCobrador(){
		
		$comboc=new HtmlCombo('','cobrador',20,true);
					$qo=pg_query("select e.id_empleados,(apellido||','||nombre) from t_empleados e
inner join t_oficios o on (o.id_empleados=e.id_empleados)
where o.id_oficio=2 or o.id_oficio=3 ");
					
					$comboc->addItem(0,'--Cobrador-');
					while($ro=pg_fetch_array($qo)){
						$comboc->addItem($ro[0],$ro[1]);
						};
		return $comboc;
	}
	public function ComboVC(){
		
		$combovc=new HtmlCombo('','vende_cobra',20,true);
					$qo=pg_query("select e.id_empleados,(apellido||','||nombre) from t_empleados e
inner join t_oficios o on (o.id_empleados=e.id_empleados)
where o.id_oficio=3 ");
					
					$combovc->addItem(0,'--Cobrador-');
					while($ro=pg_fetch_array($qo)){
						$combovc->addItem($ro[0],$ro[1]);
						};
		return $combovc;
	}
	
	public function ComboEmpleado($idOficio=NULL){
		
		$comboe=new HtmlCombo('','empleado',20,true);
				if($idOficio!=NULL){	
					$query=pg_query("select descdic(1,$idOficio)  ");
					$rows=pg_fetch_array($query);
					$comboe->addItem(0,'Seleccione '.$rows[0].'-');
					$qo=pg_query("select e.id_empleados,(apellido||','||nombre) from t_empleados e
inner join t_oficios o on (o.id_empleados=e.id_empleados)
where o.id_oficio=$idOficio ");
					while($ro=pg_fetch_array($qo)){
						$comboe->addItem($ro[0],$ro[1]);
						};
				}else{
					$comboe->addItem(0,'--Empleados-');
					$qo=pg_query("select e.id_empleados,(apellido||','||nombre) from t_empleados e
--inner join t_oficios o on (o.id_empleados=e.id_empleados)  ");
					while($ro=pg_fetch_array($qo)){
						$comboe->addItem($ro[0],$ro[1]);
						};
					
				}
				
		return $comboe;
	}
/*	public function ComboOficios(){
		
		$comboo=new HtmlCombo('','oficio',20,true);
					$qo=pg_query("select item,descrip from diccionario where codigo=1 ");
				    $comboo->setOnChange("javascript:document.form1.submit()");	
					$comboo->addItem(0,'--Empleado-');
					while($ro=pg_fetch_array($qo)){
						$comboo->addItem($ro[0],$ro[1]);
						};
		return $comboo;
	}*/
	public function ComboOficios($valor=false){
		//if(!$valor){
		$comboo=new HtmlCombo('','oficio',20,true);
					$qo=pg_query("select item,descrip from diccionario where codigo=1 ");
				    $comboo->setOnChange("javascript:document.form1.submit()");	
					$comboo->addItem(0,'--PERFIL-');
					while($ro=pg_fetch_array($qo)){
						$comboo->addItem($ro[0],$ro[1]);
						};
		return $comboo;
	/*	}else{
			$comboo=new HtmlCombo('','oficio',20,true);
					$qo=pg_query("select item,descrip from diccionario where (codigo=1 and item=2) or (codigo=1 and item>4)");
				    $comboo->setOnChange("javascript:document.form1.submit()");	
					$comboo->addItem(0,'--Modo de Pago -');
					while($ro=pg_fetch_array($qo)){
						$comboo->addItem($ro[0],$ro[1]);
						};
		return $comboo;
			
		}*/
	}
	public function ComboJefeGrupo(){
		
		$comboc=new HtmlCombo('','jefegrupo',20,true);
					$qo=pg_query("select e.id_empleados,(apellido||','||nombre) from t_empleados e
inner join t_oficios o on (o.id_empleados=e.id_empleados)
where o.id_oficio=4 ");
					
					$comboc->addItem(0,'--Jefe de Grupo-');
					while($ro=pg_fetch_array($qo)){
						$comboc->addItem($ro[0],$ro[1]);
						};
		return $comboc;
	}
	
	
}

?>