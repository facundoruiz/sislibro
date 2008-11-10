<?
class HtmlFieldset extends HtmlContenedor {
	// Para generar FieldSET Html
	private static  $num_forms=0;
	private $legend;


	
	// Constructor
	function __construct($p_legend="",$p_estilo="") {
		if($p_legend!="")
			$this->setNombre($p_legend);
		else
			$this->setNombre("Fieldset".HtmlFieldset::$num_forms);
			$this->setLegend($p_legend);
		HtmlFieldset::$num_forms++;
	}
	/*function __wakeup(){
	if($_POST){
		foreach($_POST as $clave=>$valor){
			    $c=$this->getControl($clave); 
				if(isset($c)){
					$c->setValor($valor);
				}
			}
	   }
	}*/
	// Metodos Publicos
	function getHeader(){
		$return_string ='<FIELDSET > <legend> '. $this->getlegend() .'</legend>'."\n";
		return $return_string;		
	}

	function getPie(){
		$return_string ='</FIELDSET>' ."\n";
		return $return_string;		
	}
	
	function toString () {
		if(isset($this->layout)){
			$return_string=$this->layout->organizar($this);
		}
		else
		{
			$return_string = $this->getHeader();
			if($this->controles){
				foreach($this->controles as $nombre => $control){
					$return_string .= $control->toString();
				}
			}
			$return_string .= "</FIELDSET>";
		}
		if(isset($this->estilo))
			return($this->estilo->format($return_string));
		else
			return($return_string);
	}

	function setLegend($p_legend){
		$this->legend=$p_legend;
	}

	function getLegend(){
		return	$this->legend;
	}
	
}

?>



