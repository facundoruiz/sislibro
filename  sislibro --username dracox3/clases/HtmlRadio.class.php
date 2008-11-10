<?php  
/*function __autoload($clase){
	$PATH_CLASS='./';
	require_once($PATH_CLASS.$clase. '.class.php');
} */
class HtmlRadio extends HtmlControl{
	private static $cantidad=0; //Es la cantidad de botones instanciados
	private $valor;
		private $v;
	private $tildado;
	protected $onClick;


	function __construct($p_v="",$p_nombre="",$p_valor=NULL, $p_onChange=NULL,$p_habilitado=true){
		if($p_nombre!="")
			$this->setNombre($p_nombre);
		else
			$this->setNombre("radio".HtmlCheck::$cantidad);
		HtmlRadio::$cantidad ++;
		$this->v=$p_v;
		$this->onChange=$p_onChange;
		$this->setValor($p_valor);
		$this->setHabilitado($p_habilitado);
	}



	function toString(){

		$return_string='  <input name="'.$this->getNombre_v().'" type="radio" value="'.$this->getValor().'" ';
		if($this->getTildado())
			$return_string.='checked';
		if (isset($this->onClick)) 
			$return_string .=' OnClick="'.$this->onClick.'" ';
		if(!$this->estaHabilitado())
			$return_string.='disabled="'. $this->getHabilitado() . '" ';
		$return_string.=">\n";
		return $return_string;
	}

	function setValor($p_valor){
		$this->valor=$p_valor;
	}
	function getValor(){
		return $this->valor;
	}
	
	function setNombre_v($p_v){
		$this->v=$p_v;
	}
	function getNombre_v(){
		return $this->v;
	}
	

	function setTildado($p_tildado){
		$this->tildado=$p_tildado;
	}
	function getTildado(){
		return $this->tildado;
	}
	
	function setOnClick($p_accion){
		$this->onClick=$p_accion;
	}
	

	
}
/*$e=new HtmlRadio('sexo',1,'femenino');
$d=new HtmlRadio('sexo',2,'masculino');

$e->setOnClick('javascript:alert(\'hola\')');

$e->setTildado(true);

function ver(HtmlRadio $r){
echo $r->toString();
}
ver($e);
ver($d);
*/
?>
