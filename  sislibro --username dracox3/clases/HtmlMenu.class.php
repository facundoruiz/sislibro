<?
class HtmlMenu extends HtmlGrupo{
	
	protected $titulo;
	protected $maxlen=0;
	function __construct($p_layout=NULL){
		if (!isset($p_layout)){
			$this->layout=new HtmlLayoutGrid();
			$this->layout->setCols(1);
		}

	}
	function addItem( $p_action,$p_caption, $p_target="",$p_class_estilo=NULL,$p_descripcion=NULL){
		$f=new HtmlForm($p_action ,"","post", $p_target);//
		/*
		if(strlen($p_caption)>$this->maxlen){
			$this->maxlen=strlen($p_caption);
		}
			if($this->controles){
				//echo "ee";
				foreach($this->controles as $id=>$formulario){
					$cs=$formulario->getControls();
					//echo $b->getCaption();
					foreach($cs as $key=>$btn){
						//if(get_class($b)=='HtmlBoton'){
							//print_r($b);
							$cantsp=($this->maxlen- strlen(trim($btn->getCaption())))/2;
							$newCaption=str_repeat(' ', $cantsp).trim($btn->getCaption()).str_repeat(' ', $cantsp);
							$btn->setCaption($newCaption);
						}
				}
			}
		*/
		$bt=new HtmlBoton($p_caption);
		$bt->setClassEstilo($p_class_estilo);		
		if($p_descripcion!=NULL){
		$bt->setScript(' onmouseover="change(\''.$p_descripcion.'\')" onmouseout="change(\'\')"');
		}
		$f->addControl($bt);
		$this->addControl($f);
	}
	function setTitulo($p_titulo){
		$this->titulo=$p_titulo;
	}
	
	function toString(){
		return $this->layout->organizar($this);
	}
	


}



?>
