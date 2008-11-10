<?
class HtmlTag extends HtmlControl {
	private static $cantidad=0;
	private $valor;
	
	function __construct($p_valor="",$p_nombre="",$e=NULL){
		if($p_nombre!="")
			$this->setNombre($p_nombre);
		else
			$this->setNombre("TAG".HtmlTag::$cantidad);
		$this->valor=$p_valor;
		HtmlTag::$cantidad++;
		if(isset ($e)){
			$this->estilo=$e;
		}
		else
			$this->estilo=new HtmlEstilo();
	}
	
	function toString(){
		if(trim($this->valor)=="" || $this->valor==NULL){
			$cadena="&nbsp;";
		}
		else{
			$cadena=$this->valor;
		}
		
		if(isset($this->estilo)){
			//$cadena=$this->estilo->format("<p>".$this->valor."</p>"). "\n";
			$cadena=$this->estilo->format($cadena). "\n";	
		}
		else{
//			$cadena="<p>".$this->valor."</p>". "\n";	
				$cadena=$this->valor."\n";	
		}

		return $cadena;
	}
	function setValor($p_valor){
		$this->valor=$p_valor;
	}
	function getValor(){
		return $this->valor;
	}
}

?>