<?
abstract class  HtmlInforme extends HtmlControl {
	private $margenIz=2;
	private $margenDe=2.0;
	static private $ESCALA=0.0264;
	public $titulo;
	public $encabezado;
	protected $numHojas;
		
	static function toPixel($p_medida){
		return round($p_medida/HtmlInforme::$ESCALA);
	}
	function __construct(){
		
	}

	function toString(){
		
		
	
	}
		
	
	function getMargenIz(){
		return $this->margenIz;
	}
	function setMargenIz($p_mi){
		$this->margenIz=$p_mi;
	}
	function getMargenDe(){
		return $this->margenDe;
	}
	function setMargenDe($p_md){
		$this->margenDe=$p_md;
	}
	
	function getNumHojas(){
		return $this->numHojas;
	}
	function getEncabezado(){
		return $this->encabezado->toString();
	}
	function setEncabezado($p_encabezado){
		$this->encabezado=$p_encabezado;
	}	
	function getTitulo(){
		return $this->titulo->toString();
	}
	function setTitulo($p_titulo){
		$this->titulo=$p_titulo;
	}
	function getCuerpo(){}
}
?>