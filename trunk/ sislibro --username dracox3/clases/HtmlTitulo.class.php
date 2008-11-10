<?
class HtmlTitulo{
	private $texto;

	function __construct($p_texto, $p_estilo=NULL, $p_layout=NULL){

		$this->texto=new HtmlGrupo();

		if(!$p_estilo){
			$e=new HtmlEstilo(true, false, "4", "", "","#CCCCC");
		}
		if(!$p_layout){
			$p_layout=new HtmlLayoutGrid();
			$p_layout->setCols(1);
			$p_layout->setWidth("100%");
			$p_layout->setAlign("CENTER");
		}
		$this->texto->setLayout($p_layout);
		$this->texto->addControl(new HtmlTag($p_texto,"",$e),$e);
	} 
	
	function toString(){
		return $this->texto->toString();
	}


}

?>