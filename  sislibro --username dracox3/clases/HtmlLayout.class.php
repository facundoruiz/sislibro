<?

abstract class HtmlLayout{

	private $align;
	
	abstract function Organizar($f);
	
	function setAlign($p_align){
		if(strtoupper($p_align)=='' ||
		strtoupper($p_align)=='CENTER' ||
		strtoupper($p_align)=='LEFT' ||
		strtoupper($p_align)=='RIGHT' )
			$this->align=$p_align;
		else
			$this->align="";
	}
	
	function getAlign(){
		return $this->align;
	}
}

?>
