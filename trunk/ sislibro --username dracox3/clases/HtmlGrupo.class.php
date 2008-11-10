<?
class HtmlGrupo extends HtmlContenedor{
	//protected $controles;
	private static $cantidad=0;

	function __construct($p_pg_rs=NULL,$p_campo="",$p_accion="",$p_nombre=""){
		
		if($p_nombre!="")
			$this->setNombre($p_nombre);
		else
			$this->setNombre("group".HtmlGrupo::$cantidad);
		HtmlGrupo::$cantidad++;
		
		if ($p_pg_rs){
			while($row=pg_fetch_array($p_pg_rs)){
				foreach($row as $key => $campo)
					$this->addControl(new HtmlTag($campo));
			}
		}
	}
	
	function toString(){
		if(isset($this->layout)){
			$return_string= $this->layout->organizar($this);
		}
		else
		{
			$return_string = $this->getHeader();
			if($this->controles){
				foreach($this->controles as $nombre => $control){
					$return_string .= $control->toString(). "<br>";
				}
			}
		}
		
		if(isset($this->estilo)){
			return($this->estilo->format($return_string));
		}
		else
			return($return_string);
		
	}

	function getHeader(){
		return "";
	}
	function getPie(){
		return "";
	}

}

?>
