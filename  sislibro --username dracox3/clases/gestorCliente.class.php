<?php
class gestorCliente extends Cliente{
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
	public function  get_clienteDni($p_dni){
		$this-> getConexion();
		$cmd="select *,descdic(4,moroso) as esmoroso,(select descrip from t_localidades where idprovincia=id_provincia and idlocalidad=id_localidad ) as localidad,(select descrip from t_provincias where idprovincia=id_provincia) as provincia from t_clientes  where dni=".$p_dni."";
		$query=pg_query($cmd);
		$r=pg_fetch_array($query);
			if($r>0){
		$cliente=new Cliente();
	
		$cliente->set_nombre($r['nombre']);
		$cliente->set_dni($r['dni']);
		$cliente->set_id_cliente($r['id_clientes']);
		$cliente->set_apellido($r['apellido']);
		$cliente->set_nombre($r['nombre']);
	    $cliente->set_domicilio($r['domicilio']);
		$cliente->set_telefono($r['tel']);
		$cliente->set_celular($r['cel']);
		$cliente->set_idlocalidad($r['id_localidad']);
		$cliente->set_localidad($r['localidad']);
		$cliente->set_provincia($r['provincia']);
		$cliente->set_idprovincia($r['id_provincia']);
		$cliente->set_barrio($r['barrio']);
		$cliente->set_obs($r['obs']);
		$cliente->set_moroso($r['moroso']);
		$cliente->set_esmoroso($r['esmoroso']);
		$cliente->set_estado($r['estado']);
			return $cliente;
		}else{
			return 0;
		} 
	}
	public function  get_clienteId($p_id){
		$this-> getConexion();
		$cmd="select *, descdic(4,moroso) as esmoroso,(select descrip from t_localidades where idprovincia=id_provincia and idlocalidad=id_localidad ) as localidad,(select descrip from t_provincias where idprovincia=id_provincia) as provincia from t_clientes   where id_clientes=".$p_id."";
		$query=pg_query($cmd);
		$r=pg_fetch_array($query);
		$cliente=new Cliente();
		$cliente->set_nombre($r['nombre']);
		$cliente->set_dni($r['dni']);
		$cliente->set_id_cliente($r['id_clientes']);
		$cliente->set_apellido($r['apellido']);
		$cliente->set_nombre($r['nombre']);
	    $cliente->set_domicilio($r['domicilio']);
		$cliente->set_telefono($r['tel']);
		$cliente->set_celular($r['cel']);
		$cliente->set_idlocalidad($r['id_localidad']);
		$cliente->set_localidad($r['localidad']);
		$cliente->set_provincia($r['provincia']);
		$cliente->set_idprovincia($r['id_provincia']);
		$cliente->set_barrio($r['barrio']);
		$cliente->set_obs($r['obs']);
		$cliente->set_moroso($r['moroso']);
		$cliente->set_esmoroso($r['esmoroso']);
		$cliente->set_estado($r['estado']);
		  return $cliente;
	}
	
}

?>