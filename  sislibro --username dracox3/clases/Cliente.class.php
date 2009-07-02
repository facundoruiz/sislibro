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
  private $idlocalidad;
  private $idprovincia;
  private $celular;
  private $obs;
  private $telefono;
  private $moroso;
  private $esmoroso;
  private $estado;
  private $fecha_aud;
  private $hora_aud;
  private $usuario_aud;
  private $altdomicilio;
  
  private $trabajodomicilio;
  private $trabajobarrio;
  private $trabajolocalidad;
  private $trabajoprovincia;
  private $trabajoidlocalidad;
  private $trabajoidprovincia;
  private $trabajotelefono;
  
  
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
	public function set_idlocalidad($p_localidad){
		$this->idlocalidad=$p_localidad;
	}
	public function set_idprovincia($p_provincia){
		$this->idprovincia=$p_provincia;
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
public function set_esmoroso($p_moroso){
		$this->esmoroso=$p_moroso;
	}
	public function set_estado($p_estado){
		$this->estado=$p_estado;
	}
public function set_altdomicilio($p_altdomicilio){
		$this->altdomicilio=$p_altdomicilio;
	}
public function set_trabajodomicilio($p_domicilio){
		$this->trabajodomicilio=$p_domicilio;
	}
	public function set_trabajobarrio($p_barrio){
		$this->trabajobarrio=$p_barrio;
	}
	public function set_trabajolocalidad($p_localidad){
		$this->trabajolocalidad=$p_localidad;
	}
	public function set_trabajoprovincia($p_provincia){
		$this->trabajoprovincia=$p_provincia;
	}
	public function set_trabajoidlocalidad($p_localidad){
		$this->trabajoidlocalidad=$p_localidad;
	}
	public function set_trabajoidprovincia($p_provincia){
		$this->trabajoidprovincia=$p_provincia;
	}

	public function set_trabajotelefono($p_tel){
		$this->trabajotelefono=$p_tel;
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
	public function get_idlocalidad(){
		return $this->idlocalidad;
	}
	public function get_idprovincia(){
		return $this->idprovincia;
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
public function get_esmoroso(){
		return $this->esmoroso;
	}
	public function get_estado(){
		return $this->estado;
	}
public function get_altdomicilio(){
	return	$this->altdomicilio;
	}
public function get_trabajodomicilio(){
		 return $this->trabajodomicilio;
	}
	public function get_trabajobarrio(){
		 return $this->trabajobarrio;
	}
	public function get_trabajolocalidad(){
		return $this->trabajolocalidad;
	}
	public function get_trabajoprovincia(){
		return $this->trabajoprovincia;
	}
	public function get_trabajoidlocalidad(){
		return $this->trabajoidlocalidad;
	}
	public function get_trabajoidprovincia(){
		return $this->trabajoidprovincia;
	}
	public function get_trabajotelefono(){
		return $this->trabajotelefono;
	}
}
?>