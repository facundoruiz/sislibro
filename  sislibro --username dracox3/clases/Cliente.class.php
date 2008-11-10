<?PHP
class Cliente{
  private $id_cliente;
  private $nombre;
  private $apellido;
  private $dni;
  private $domicilio;
  private $barrio;
  private $localidad;
  private $provincia;
  private $celular;
  private $obs;
  private $telefono;
  private $moroso;
  private $estado;
  private $fecha_aud;
  private $hora_aud;
  private $usuario_aud;
	/**
	 * Set_ metodos para ingresar valor en las variables
	 */
	public function set_id_cliente($p_id_clientes){
		$this->id_cliente=$p_id_clientes;
	}
	public function set_nombre($p_nombre){
		$this->nombre=$p_nombre;
	}
	public function set_apellido($p_apellido){
		$this->apellido=$p_apellido;
	}
	public function set_dni($p_dni){
		$this->dni=$p_dni;
	}
	public function set_domicilio($p_domicilio){
		$this->domicilio=$p_domicilio;
	}
	public function set_barrio($p_barrio){
		$this->barrio=$p_barrio;
	}
	public function set_localidad($p_localidad){
		$this->localidad=$p_localidad;
	}
	public function set_provincia($p_provincia){
		$this->provincia=$p_provincia;
	}
	public function set_celular($p_cel){
		$this->celular=$p_cel;
	}
	public function set_obs($p_obs){
		$this->obs=$p_obs;
	}
	public function set_telefono($p_tel){
		$this->telefono=$p_tel;
	}
	public function set_moroso($p_moroso){
		$this->moroso=$p_moroso;
	}
	public function set_estado($p_estado){
		$this->estado=$p_estado;
	}
	/**
	 * Get_ metodos para recuperar valor en las variables
	 */
	
	public function get_id_cliente(){
	 	return	$this->id_cliente;
	}
	public function get_nombre(){
		 return $this->nombre;
	}
	public function get_apellido(){
		 return $this->apellido;
	}
	public function get_dni(){
		 return $this->dni;
	}
	public function get_domicilio(){
		 return $this->domicilio;
	}
	public function get_barrio(){
		 return $this->barrio;
	}
	public function get_localidad(){
		return $this->localidad;
	}
	public function get_provincia(){
		return $this->provincia;
	}
	public function get_celular(){
		return $this->celular;
	}
	public function get_obs(){
		return $this->obs;
	}
	public function get_telefono(){
		return $this->telefono;
	}
	public function get_moroso(){
		return $this->moroso;
	}
	
	public function get_estado(){
		return $this->estado;
	}
}
?>