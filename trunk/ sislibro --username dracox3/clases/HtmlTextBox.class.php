<?
/*include ('../clases/HtmlControl.class.php');
include ('../clases/HtmlForm.class.php');
include ('../clases/HtmlBoton.class.php');
include ('../clases/HtmlLayout.class.php');
include ('../clases/HtmlLayoutGrid.class.php');*/
class HtmlTextBox extends HtmlControl{
	private static $cantidad=0;
	private $valor;
	private $size;
	private $title;
	private $script;
	private $maxlength;
	
	

	function __construct ($p_valorInicial="",$p_nombre="",$p_size=20,$p_habilitado=true,$p_title="Ingresa...",$p_maxlength="20")
	{
		// Initialization of member vars
		if ($p_nombre!="")
			$this->setNombre($p_nombre);
		else
			$this->setNombre("textbox".HtmlTextBox::$cantidad);
			
		$this->setTitulo($p_title);
		$this->setValor($p_valorInicial);
		$this->setSize($p_size);
		$this->setHabilitado($p_habilitado);
		$this->setMaxlength($p_maxlength);
		HtmlTextBox::$cantidad++;
	}
	
	function __wakeup(){
		if(isset($_POST[$this->getNombre()])){
			$this->setValor($_POST[$this->getNombre()]);
		}
	}
				
	function toString () {
		
		$return_string = "";
		$return_string .= '<INPUT NAME="'.$this->getNombre().'" ';
		$return_string .= 'TYPE="TEXT" ';
		$return_string .= 'VALUE="'.$this->getValor().'" SIZE="'.$this->getSize().'" ';
		if(!$this->estaHabilitado()) 
			$return_string .='DISABLED="disabled" ';
						$return_string .='TITLE=" '.$this->getTitulo().'"';
			$return_string .= $this->script;
		if($this->maxlength)
		$return_string .=' maxlength="'.$this->getMaxlength().'" ';
		
					
		$return_string .= " > \n";
		return($return_string);
	}
	
	function setValor($p_valor){
		$this->valor=$p_valor;
	}
	function getValor(){
		return $this->valor;
	}
	function setMaxlength($p_valor){
		$this->maxlength=$p_valor;
	}
	function getMaxlength(){
		return $this->maxlength;
	}
	function setSize($p_size){
		$this->size=$p_size;
	}
	function getSize(){
		return $this->size;
	}
	function setTitulo($p_title){
		$this->title=$p_title;
	}
	function getTitulo(){
		return $this->title;
	}
	function setScript($p_script=""){
	$this->script=$p_script;	
	}
	/*function setJS($p_metodo,$p_funcion){
		$this->metodo=$p_metodo;
		$this->funcion=$p_funcion;
		
	}
	
	function getJS(){
		return ' '.$this->metodo.'="'. $this->funcion.'"';
		
	}*/
}
?>

