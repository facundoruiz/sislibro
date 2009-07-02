<?php
class Garante{
 
  private $idgarante;
  private $idcliente;
  private $idchequera;
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
  private $usuario_aud;
  private $altdomicilio;
  private $cobrodomicilio;
  
  public function Garante($p_idgarante, $p_idcliente, $p_idchequera, $p_nombre, $p_apellido, $p_dni, $p_domicilio, $p_barrio, $p_localidad, $p_provincia, $p_idlocalidad, $p_idprovincia, $p_celular, $p_obs, $p_telefono, $p_usuario_aud, $p_altdomicilio, $p_cobrodomicilio){
	$this->setIdgarante($p_idgarante);
	$this->setIdcliente($p_idcliente);
	$this->setIdchequera($p_idchequera);
	$this->setNombre($p_nombre);
	$this->setApellido($p_apellido);
	$this->setDni($p_dni);
	$this->setDomicilio($p_domicilio);
	$this->setBarrio($p_barrio);
	$this->setLocalidad($p_localidad);
	$this->setProvincia($p_provincia);
	$this->setIdlocalidad($p_idlocalidad);
	$this->setIdprovincia($p_idprovincia);
	$this->setCelular($p_celular);
	$this->setObs($p_obs);
	$this->setTelefono($p_telefono);
	$this->setUsuario_aud($p_usuario_aud);
	$this->setAltdomicilio($p_altdomicilio);
	$this->setCobrodomicilio($p_cobrodomicilio);
}

/**
 * Establece la propiedad idgarante del objeto
 *
 * @param string $p_idgarante
 * @access public
 * @return void
 */
public function setIdgarante($p_idgarante){
	$this->idgarante=$p_idgarante;
}

/**
 * Establece la propiedad idcliente del objeto
 *
 * @param string $p_idcliente
 * @access public
 * @return void
 */
public function setIdcliente($p_idcliente){
	$this->idcliente=$p_idcliente;
}

/**
 * Establece la propiedad idchequera del objeto
 *
 * @param string $p_idchequera
 * @access public
 * @return void
 */
public function setIdchequera($p_idchequera){
	$this->idchequera=$p_idchequera;
}

/**
 * Establece la propiedad nombre del objeto
 *
 * @param string $p_nombre
 * @access public
 * @return void
 */
public function setNombre($p_nombre){
	$this->nombre=$p_nombre;
}

/**
 * Establece la propiedad apellido del objeto
 *
 * @param string $p_apellido
 * @access public
 * @return void
 */
public function setApellido($p_apellido){
	$this->apellido=$p_apellido;
}

/**
 * Establece la propiedad dni del objeto
 *
 * @param string $p_dni
 * @access public
 * @return void
 */
public function setDni($p_dni){
	$this->dni=$p_dni;
}

/**
 * Establece la propiedad domicilio del objeto
 *
 * @param string $p_domicilio
 * @access public
 * @return void
 */
public function setDomicilio($p_domicilio){
	$this->domicilio=$p_domicilio;
}

/**
 * Establece la propiedad barrio del objeto
 *
 * @param string $p_barrio
 * @access public
 * @return void
 */
public function setBarrio($p_barrio){
	$this->barrio=$p_barrio;
}

/**
 * Establece la propiedad localidad del objeto
 *
 * @param string $p_localidad
 * @access public
 * @return void
 */
public function setLocalidad($p_localidad){
	$this->localidad=$p_localidad;
}

/**
 * Establece la propiedad provincia del objeto
 *
 * @param string $p_provincia
 * @access public
 * @return void
 */
public function setProvincia($p_provincia){
	$this->provincia=$p_provincia;
}

/**
 * Establece la propiedad idlocalidad del objeto
 *
 * @param string $p_idlocalidad
 * @access public
 * @return void
 */
public function setIdlocalidad($p_idlocalidad){
	$this->idlocalidad=$p_idlocalidad;
}

/**
 * Establece la propiedad idprovincia del objeto
 *
 * @param string $p_idprovincia
 * @access public
 * @return void
 */
public function setIdprovincia($p_idprovincia){
	$this->idprovincia=$p_idprovincia;
}

/**
 * Establece la propiedad celular del objeto
 *
 * @param string $p_celular
 * @access public
 * @return void
 */
public function setCelular($p_celular){
	$this->celular=$p_celular;
}

/**
 * Establece la propiedad obs del objeto
 *
 * @param string $p_obs
 * @access public
 * @return void
 */
public function setObs($p_obs){
	$this->obs=$p_obs;
}

/**
 * Establece la propiedad telefono del objeto
 *
 * @param string $p_telefono
 * @access public
 * @return void
 */
public function setTelefono($p_telefono){
	$this->telefono=$p_telefono;
}

/**
 * Establece la propiedad usuario_aud del objeto
 *
 * @param string $p_usuario_aud
 * @access public
 * @return void
 */
public function setUsuario_aud($p_usuario_aud){
	$this->usuario_aud=$p_usuario_aud;
}

/**
 * Establece la propiedad altdomicilio del objeto
 *
 * @param string $p_altdomicilio
 * @access public
 * @return void
 */
public function setAltdomicilio($p_altdomicilio){
	$this->altdomicilio=$p_altdomicilio;
}

/**
 * Establece la propiedad cobrodomicilio del objeto
 *
 * @param string $p_cobrodomicilio
 * @access public
 * @return void
 */
public function setCobrodomicilio($p_cobrodomicilio){
	$this->cobrodomicilio=$p_cobrodomicilio;
}

/**
 * Devuelve el valor de la propiedad idgarante del objeto
 *
 * @access public
 * @return string
 */
public function getIdgarante(){
	return $this->idgarante;
}

/**
 * Devuelve el valor de la propiedad idcliente del objeto
 *
 * @access public
 * @return string
 */
public function getIdcliente(){
	return $this->idcliente;
}

/**
 * Devuelve el valor de la propiedad idchequera del objeto
 *
 * @access public
 * @return string
 */
public function getIdchequera(){
	return $this->idchequera;
}

/**
 * Devuelve el valor de la propiedad nombre del objeto
 *
 * @access public
 * @return string
 */
public function getNombre(){
	return $this->nombre;
}

/**
 * Devuelve el valor de la propiedad apellido del objeto
 *
 * @access public
 * @return string
 */
public function getApellido(){
	return $this->apellido;
}

/**
 * Devuelve el valor de la propiedad dni del objeto
 *
 * @access public
 * @return string
 */
public function getDni(){
	return $this->dni;
}

/**
 * Devuelve el valor de la propiedad domicilio del objeto
 *
 * @access public
 * @return string
 */
public function getDomicilio(){
	return $this->domicilio;
}

/**
 * Devuelve el valor de la propiedad barrio del objeto
 *
 * @access public
 * @return string
 */
public function getBarrio(){
	return $this->barrio;
}

/**
 * Devuelve el valor de la propiedad localidad del objeto
 *
 * @access public
 * @return string
 */
public function getLocalidad(){
	return $this->localidad;
}

/**
 * Devuelve el valor de la propiedad provincia del objeto
 *
 * @access public
 * @return string
 */
public function getProvincia(){
	return $this->provincia;
}

/**
 * Devuelve el valor de la propiedad idlocalidad del objeto
 *
 * @access public
 * @return string
 */
public function getIdlocalidad(){
	return $this->idlocalidad;
}

/**
 * Devuelve el valor de la propiedad idprovincia del objeto
 *
 * @access public
 * @return string
 */
public function getIdprovincia(){
	return $this->idprovincia;
}

/**
 * Devuelve el valor de la propiedad celular del objeto
 *
 * @access public
 * @return string
 */
public function getCelular(){
	return $this->celular;
}

/**
 * Devuelve el valor de la propiedad obs del objeto
 *
 * @access public
 * @return string
 */
public function getObs(){
	return $this->obs;
}

/**
 * Devuelve el valor de la propiedad telefono del objeto
 *
 * @access public
 * @return string
 */
public function getTelefono(){
	return $this->telefono;
}

/**
 * Devuelve el valor de la propiedad usuario_aud del objeto
 *
 * @access public
 * @return string
 */
public function getUsuario_aud(){
	return $this->usuario_aud;
}

/**
 * Devuelve el valor de la propiedad altdomicilio del objeto
 *
 * @access public
 * @return string
 */
public function getAltdomicilio(){
	return $this->altdomicilio;
}

/**
 * Devuelve el valor de la propiedad cobrodomicilio del objeto
 *
 * @access public
 * @return string
 */
public function getCobrodomicilio(){
	return $this->cobrodomicilio;
}

}
?>