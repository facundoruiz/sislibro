<?PHP
class Libro{
 
 private $codigo;
 private $nombre;
 private $genero;
 private $editorial;

 private $idnombre;
 private $idgenero;
 private $ideditorial;
 
 
public function Libro($p_codigo, $p_nombre, $p_genero, $p_editorial, $p_idnombre, $p_idgenero, $p_ideditorial){
	$this->setCodigo($p_codigo);
	$this->setNombre($p_nombre);
	$this->setGenero($p_genero);
	$this->setEditorial($p_editorial);
	$this->setIdnombre($p_idnombre);
	$this->setIdgenero($p_idgenero);
	$this->setIdeditorial($p_ideditorial);
}

/**
 * Establece la propiedad codigo del objeto
 *
 * @param string $p_codigo
 * @access public
 * @return void
 */
public function setCodigo($p_codigo){
	$this->codigo=$p_codigo;
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
 * Establece la propiedad genero del objeto
 *
 * @param string $p_genero
 * @access public
 * @return void
 */
public function setGenero($p_genero){
	$this->genero=$p_genero;
}

/**
 * Establece la propiedad editorial del objeto
 *
 * @param string $p_editorial
 * @access public
 * @return void
 */
public function setEditorial($p_editorial){
	$this->editorial=$p_editorial;
}

/**
 * Establece la propiedad idnombre del objeto
 *
 * @param string $p_idnombre
 * @access public
 * @return void
 */
public function setIdnombre($p_idnombre){
	$this->idnombre=$p_idnombre;
}

/**
 * Establece la propiedad idgenero del objeto
 *
 * @param string $p_idgenero
 * @access public
 * @return void
 */
public function setIdgenero($p_idgenero){
	$this->idgenero=$p_idgenero;
}

/**
 * Establece la propiedad ideditorial del objeto
 *
 * @param string $p_ideditorial
 * @access public
 * @return void
 */
public function setIdeditorial($p_ideditorial){
	$this->ideditorial=$p_ideditorial;
}

/**
 * Devuelve el valor de la propiedad codigo del objeto
 *
 * @access public
 * @return string
 */
public function getCodigo(){
	return $this->codigo;
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
 * Devuelve el valor de la propiedad genero del objeto
 *
 * @access public
 * @return string
 */
public function getGenero(){
	return $this->genero;
}

/**
 * Devuelve el valor de la propiedad editorial del objeto
 *
 * @access public
 * @return string
 */
public function getEditorial(){
	return $this->editorial;
}

/**
 * Devuelve el valor de la propiedad idnombre del objeto
 *
 * @access public
 * @return string
 */
public function getIdnombre(){
	return $this->idnombre;
}

/**
 * Devuelve el valor de la propiedad idgenero del objeto
 *
 * @access public
 * @return string
 */
public function getIdgenero(){
	return $this->idgenero;
}

/**
 * Devuelve el valor de la propiedad ideditorial del objeto
 *
 * @access public
 * @return string
 */
public function getIdeditorial(){
	return $this->ideditorial;
}

}

?>