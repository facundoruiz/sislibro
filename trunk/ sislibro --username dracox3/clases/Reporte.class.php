<?php
/**
 * COntiene la información para la generación de un reporte. 
 * Se puede usar el metodo getReporte de la clase InterfazSistema para generarlo por pantalla.
 * 
 * @author Silvera Ricardo
 * @see InterfazSistema
 *
 */
class Reporte{
	/**
	 * Especifica la configuración del reporte
	 *
	 * @var ConfiguracionReporte
	 * @access public
	 */
	public $confReporte;
	
	/**
	 * Es un array que contiene los datos que se listaran en el reporte
	 *
	 * @var array
	 * @access public
	 */
	public $datos;
	
	/**
	 * Guarda las columnas que no se mostrarán en el reporte
	 *
	 * @var array
	 * @access private
	 */
	private $ocultos=array();
	
	/**
	 * Es un acadena de caracteres que se mostrará en el encabezado del reporte
	 *
	 * @var string
	 * @access private
	 */
	private $encabezado;
	
	/**
	 * Títutlo del reporte
	 *
	 * @var string
	 * @access private
	 */
	private $titulo;
	
	/**
	 * Cantidad de filas por hoja que tendrá el reporte
	 *
	 * @var int
	 * @access private
	 */
	private $filas;
	
	/**
	 * Margen izquierdo en pixeles
	 * valor por defecto : 50
	 * 
	 * @var unknown_type
	 * @access private 
	 */
	private $margenIz=50;
	
	/**
	 * Margen derecho en pixeles
	 * valor por defecto : 20
	 * 
	 * @var unknown_type
	 * @access private 
	 */
	
	private $margenDer=20;
	
	function __construct(){
		
	}
	
	/**
	 * Establece el valor de la propiedad encabezado
	 *
	 * @param string $p_encabezado
	 * @access public
	 */
	public function setEncabezado($p_encabezado){
		$this->encabezado=$p_encabezado;
	}
	/**
	 * Establece el valor de la propiedad titulo
	 *
	 * @param string $p_titulo
	 * @access public
	 */
	public function setTitulo($p_titulo){
		$this->titulo=$p_titulo;
	}
	
	/**
	 * Devuelve el valor de la propiedad encabezado
	 *
	 * @return string
	 */
	public function getEncabezado(){
		return $this->encabezado;
	}
	
	/**
	 * Devuelve el valor de la propiedad titulo
	 *
	 * @return unknown
	 */
	public function getTitulo(){
		return $this->titulo;
	}
	
	/**
	 * Establece como oculta un a columna.
	 * Recibe como parametro el nombre de la columna que se ocultará.
	 *
	 * @param  string $p_columna
	 */
	public function ocultar($p_columna){
		$this->ocultos[$p_columna]=1;
	}
	
	/**
	* Evalua si la columna p_columna es oculta. 
	* Devuelve verdadero si lo es, falso si no lo es
	*
	* @param string $p_columna
	* @access public
	* @return boolean
	*/
	public function esOculto($p_columna){
		if(array_key_exists($p_columna,$this->ocultos))
			return true;
		else
			return false;
	}
	
	/**
	* Establece el valor de la propiedad filas
	*
	* @param int $p_filas
	* @access public
	*/
	public function setFilas($p_filas){
		$this->filas=$p_filas;
	}
	
	/**
	 * Devuelve el valor de la propiedad filas
	 *
	 * @param int $p_margen
	 * @access public
	 */
	
	public function getFilas(){
		return $this->filas;
	}
	
	/**
	* Establece el valor de la propiedad margenIz
	*
	* @param int $p_margen
	* @access public
	*/
	
	public function setMargenIz($p_margen){
		$this->margenIz=$p_margen;
	}
	
	/**
	 * Devuelve el valor de la propiedad margenIz
	 * 
	 * @return int
	 * @access public
	 */
	public function getMargenIz(){
		return $this->margenIz;
	}
	/**
	* Establece el valor de la propiedad margenDer
	*
	* @param int $p_margen
	* @access public
	*/
	
	public function setMargenDer($p_margen){
		$this->margenDer=$p_margen;
	}
	
	/**
	 * Devuelve el valor de la propiedad margenDer
	 * 
	 * @return int
	 * @access public
	 */
	public function getMargenDer(){
		return $this->margenDer;
	}
	
}	

	

?>