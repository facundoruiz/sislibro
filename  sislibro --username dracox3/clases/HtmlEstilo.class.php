<?

class HtmlEstilo{
	private $negrita;
	private $cursiva;
	private $font;
	private $fontColor;
	private $tamanio;
	private $backColor;
	private $align;
	
	function __construct($p_negrita="",$p_cursiva="", $p_tamanio="",$p_font="", $p_fontColor="", $p_backColor=""){
		$this->negrita=$p_negrita;
		$this->cursiva=$p_cursiva;
		$this->font=$p_font;
		$this->fontColor=$p_fontColor;
		$this->tamanio=$p_tamanio;
		$this->backColor=$p_backColor;	
	}
	
	function format($p_cadena){
		$cadena="";
		if(isset($this->align)){
			$cadena='<div align="'.$this->align.'">';
		}
if($this->tamanio!="" or $this->fontColor or $this->font){
		$cadena.="<font ";
		if($this->tamanio!="")
			$cadena.='size='.$this->tamanio ." ";
		if($this->fontColor)
			$cadena.='color="'.$this->fontColor.'"';
		if($this->font)
			$cadena.='face="'.$this->font.'"';
		$cadena.='>';
}
		if($this->negrita)
			$cadena.="<strong>";
		if($this->cursiva)
			$cadena.="<em>";
		$cadena.=$p_cadena;
		if($this->cursiva)
			$cadena.="</em>";
		if($this->negrita)
			$cadena.="</strong>";
if($this->tamanio!="" or $this->fontColor or $this->font){
		$cadena.="</font>";
		}
		if(isset($this->align)){
			$cadena.='</div>';
		}
		return $cadena;			
	}
	
	function getBackColor(){
		return $this->backColor;
	}
	function setBackColor($p_color){
		$this->backColor=$p_color;
	}
	function setFont($p_font){
		$this->font=$p_font;
	}
	function setSize($p_tam){
		$this->tamanio=$p_tam;
	}
	function setNegrita($p_negrita){
		$this->negrita=$p_negrita;
	}
	function setCursiva($p_cursiva){
		$this->cursiva=$p_cursiva;
	}
	function setAlign($p_align){
		$this->align=$p_align;
	}
	//lo agregue yo Ivanchus es para el color de la fuente
	function setFontColor($p_fontColor){
		$this->fontColor=$p_fontColor;
	}
	
}

?>