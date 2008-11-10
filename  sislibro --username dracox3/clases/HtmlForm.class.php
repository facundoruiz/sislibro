<?
class HtmlForm extends HtmlContenedor {
	// Para generar Formularios Html
	private static  $num_forms=0;
	private $method;
	private $action; // Direccion  la que apunta el sumit
	private $target;
	//private $numControls=0;
	
	// Constructor
	function __construct($p_accion,$p_nombre="",$p_method="post",$p_target="") {
		if($p_nombre!="")
			$this->setNombre($p_nombre);
		else
			$this->setNombre("form".HtmlForm::$num_forms);
		$this->setMethod($p_method);
		$this->setAction($p_accion);
		$this->setTarget($p_target);
		HtmlForm::$num_forms++;
	}
	function __wakeup(){
	if($_POST){
		foreach($_POST as $clave=>$valor){
			    $c=$this->getControl($clave); 
				if(isset($c)){
					$c->setValor($valor);
				}
			}
	   }
	}
	// Metodos Publicos
	function getHeader(){
		$return_string ='<FORM style="margin:0px" NAME="'. $this->getNombre() . '" METHOD="'.$this->getMethod().'" ACTION="'.$this->getAction() .'" TARGET="'.$this->getTarget().'">' ."\n";
		return $return_string;		
	}

	function getPie(){
		$return_string ='</FORM>' ."\n";
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
			$return_string .= "</FORM>";
		}
		if(isset($this->estilo))
			return($this->estilo->format($return_string));
		else
			return($return_string);
	}

	function setMethod($p_method){
		if(strtoupper($p_method)=='GET' or strtoupper($p_method)=='POST'){
			$this->method=$p_method;
		}
	}
	function getMethod(){
		return $this->method;
	}
	
	function setAction($p_action){
		$this->action=$p_action;
	}
	function getAction(){
		return $this->action;
	}
	function setTarget($p_target){
		/*if(strtoupper($p_method)=='_BLANK' || 
			strtoupper($p_method)=='_PARENT' || 
			strtoupper($p_method)=='_SELF' || 
			strtoupper($p_method)=='_TOP'){
			*/
			$this->target=$p_target;
		
	}
	function getTarget(){
		return $this->target;
	}

	
}

?>



