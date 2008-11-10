<?
class HtmlHidden extends HtmlControl{
	private static $cantidad=0;
	private $valor;

	function __construct ($p_valorInicial="",$p_nombre="")
	{
		// Initialization of member vars
		if ($p_nombre!="")
			$this->setNombre($p_nombre);
		else
			$this->setNombre("hidden".HtmlHidden::$cantidad);
		$this->setValor($p_valorInicial);
		HtmlHidden::$cantidad++;
	}
	
	function toString () {
		
		$return_string = "";
		$return_string .= '<INPUT NAME="'.$this->getNombre().'" ';
		$return_string .= 'TYPE="hidden" ';
		$return_string .= 'VALUE="'.$this->getValor().'" ';
		$return_string .= " > \n";
		return($return_string);
	}
	
	function setValor($p_valor){
		$this->valor=$p_valor;
	}
	function getValor(){
		return $this->valor;
	}
}
?>