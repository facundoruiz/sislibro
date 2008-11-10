<? 
/*Esta Clase representa un boton de HTML*/

class HtmlBoton extends HtmlControl{
	private static $cantidad=0; //Es la cantidad de botones instanciados
	private $caption;//Es el texto que contendra el boton
	private $type;// tipo de boton
	private $full;
	private $script;
private $class_estilo;//estilo para el botn
	function __construct($p_caption="Enviar",$p_nombre="",$p_habilitado=true, $p_type="SUBMIT"){
		if($p_nombre!="")
			$this->setNombre($p_nombre);
		else
			$this->setNombre("boton".HtmlBoton::$cantidad);
		$this->setCaption($p_caption);
		$this->setType($p_type);
		$this->setHabilitado($p_habilitado);
		HtmlBoton::$cantidad ++;
	}

	function toString(){
	/*Devulve una cadena de texto que es el codigo html para el boton*/
		$return_string='<Input style="margin:0px;';
		if($this->full!=true){
			$return_string.='width:100%"';
		}else{ 
			$return_string.='"'; 
		}
		
		$return_string.='  NAME="'. $this->getNombre() . '" ';
		$return_string.='type="'. $this->getType() . '" ';
		$return_string.='value="'. $this->getCaption() . '" ';
		if(!$this->estaHabilitado())
			$return_string.='disabled="'. $this->getHabilitado() . '" ';
		$return_string.=' '.$this->script.' ';	
			$return_string.=' '.$this->class_estilo.' ';
		$return_string.=">\n";
		return $return_string;
	}
	
	function setCaption($p_caption){
		$this->caption=$p_caption;
	}
	function getCaption(){
		return $this->caption;
	}
	function setType($p_type){
		$this->type=$p_type;
	}
	
	function setfull($p_bool=true){
		$this->full=$p_bool;
		}
	function setScript($p_script=""){
	$this->script=$p_script;	
	}	
		function setClassEstilo($p_estilo=""){
	$this->class_estilo=$p_estilo;	
	}	
	function getType(){
		return $this->type;
	}
	
}
?>
