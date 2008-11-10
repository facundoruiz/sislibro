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
		$cmd="select * from t_empleados  where dni=".$p_dni."";
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
		$empleado->set_id_zona($r['id_zona']);
		$empleado->set_id_oficio($r['id_oficio']);
		$empleado->set_estado($r['estado']);
		
		  return $empleado;
	}
	public function  get_EmpleadoId($p_id){
		$this->getConexion();
		$cmd="select * from t_empleados  where id_empleados=".$p_id."";
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
		$empleado->set_id_zona($r['id_zona']);
		$empleado->set_id_oficio($r['id_oficio']);
		$empleado->set_estado($r['estado']);
		  
		return $empleado;
		}else{
			return 0;
		}
	}
	
}

?>