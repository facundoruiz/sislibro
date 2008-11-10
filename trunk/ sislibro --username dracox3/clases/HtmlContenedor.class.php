<?
abstract class HtmlContenedor extends HtmlControl{
	protected $controles; // vector de HtmlControl
	public $lauyout;
	protected $numControls=0;
	
		
	function addControl($p_control, $p_estilo=NULL) {
		if (!isSet($p_control) || !is_object($p_control) || !is_subclass_of($p_control,'HtmlControl')){
			die("Parametro para HtmlForm::addInputForm ".
				"debe ser una instancia de HtmlControl.".
				" Ha Pasado un parametro de la clase " . get_class($p_control));
		}
		else {
			$this->controles[$p_control->getNombre()]=$p_control;
		}
		$this->numControls++;
		if($p_estilo)
			$this->estilo=$p_estilo;
		/*else
			$this->estilo=new HtmlEstilo();*/
	}
	function delControl($p_nombre){
		if(isset($this->controles[$p_nombre])){
			unset($this->controles[$p_nombre]);
			$this->numControls--;
		}
	}
	function delAllControl(){
		$this->controles=NULL;
		$this->numControls=0;
	}
	function getControls(){
		return $this->controles;		
	}
	function getControl($p_nombre){
		$rtn_control=NULL;
		
		if (isset($this->controles[$p_nombre])){
			$rtn_control=$this->controles[$p_nombre];		
		}
		else{
			foreach($this->controles as $id=>$control){
				
				if(is_subclass_of ($control, "HtmlContenedor")){
				
					return $control->getControl($p_nombre);
				}
			}
		}
		return $rtn_control;
	}
	function setLayout($p_layout){
		$this->layout=$p_layout;
	}
	function getNumControls(){
		return $this->numControls;
	}
	function setEstilo($p_estilo){
		$this->estilo=$p_estilo;
	}
	function getEstilo(){
		return $this->estilo;
	}
}


?>
