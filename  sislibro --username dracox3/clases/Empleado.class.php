<?PHP
class Empleado{
 
  private $id_empleado; 
  private $num_empleado;
  private $nombre; 
  private $apellido;
  private $dni;
  private $domicilio;
  private $barrio;
  private $id_localidad; 
  private $id_provincia; 
  private $telefono; 
  private $celular;
  private $id_oficio;
  private $porcentaje;
  private $oficio;
  private $obs;
  private $estado;
   
  
	/**
	 * Set_ metodos para ingresar valor en las variables
	 */
	public function set_id_empleado($p_id_empleado){
		$this->id_empleado=$p_id_empleado;
	}
	public function set_num_empleado($p_num_empleado){
		$this->num_empleado=$p_num_empleado;
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
	public function set_telefono($p_tel){
		$this->telefono=$p_tel;
	}
	public function set_obs($p_obs){
		$this->obs=$p_obs;
	}
	
	public function set_id_oficio($p_id_oficio){
		$this->id_oficio=$p_id_oficio;
	}
	public function set_oficio($p_oficio){
		$this->oficio=$p_oficio;
	}
	public function set_porcentaje($p_porcentaje){
		$this->porcentaje=$p_porcentaje;
	}
	public function set_estado($p_estado){
		$this->estado=$p_estado;
	}
	/**
	 * Get_ metodos para recuperar valor en las variables
	 */
	
	public function get_id_empleado(){
	 	return	$this->id_empleado;
	}
	public function get_num_empleado(){
	 	return	$this->num_empleado;
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
	public function get_id_oficio(){
		return $this->id_oficio;
	}
	public function get_oficio(){
		return $this->oficio;
	}
	public function get_porcentaje(){
		return $this->porcentaje;
	}
	public function get_estado(){
		return $this->estado;
	}
}
?>