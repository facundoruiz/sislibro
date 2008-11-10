<?
class HtmlCombo extends HtmlControl
{
	private static $cantidad=0;
	private $valoresArray;
	private $valorSel;
	private $onChange;
	
	function __construct ($p_valoresArray=NULL,$p_nombre="",$p_valorSel=NULL, $p_habilitado=true, $p_onChange=NULL) {
		$this->setValoresArray($p_valoresArray);
		if ($p_nombre!="")
			$this->setNombre($p_nombre);
		else
			$this->setNombre("combo".HtmlCombo::$cantidad);
		$this->onChange=$p_onChange;
		$this->setValor($p_valorSel);
		$this->setHabilitado($p_habilitado);
	}
	function __wakeup(){
		if(isset($_POST[$this->getNombre()])){
			$this->setValor($_POST[$this->getNombre()]);
		}
	}
	
	function addItem($p_key, $p_valor){
		$this->valoresArray[$p_key]=$p_valor;
	}
	function toString () {
		$return_string = "";
		$return_string .='<SELECT  NAME="'.$this->getNombre().'" ';
		if (isset($this->onChange)) 
			$return_string .=' OnChange="'.$this->onChange.'" ';
		if (!$this->estaHabilitado()) 
			$return_string .=' disabled="disabled" ';
		
		if (!isset($this->valorSel))
			$this->valorSel=-1;
		$return_string .= " > ";
		$v=$this->getValoresArray();
		if($v){
			foreach( $v as $key => $value ) {
				$key;
				if ($key== $this->getValor()) {
					$return_string .="<OPTION VALUE=".$key." SELECTED >";
				}
				else {
					$return_string .= "<OPTION VALUE=".$key.">";
				}
				$return_string .= $value ."</option>". "\n";
			}
		}
		$return_string .="</SELECT>";
		return($return_string);
	}
	
	function setValoresArray($p_valoresArray){
		$this->valoresArray=$p_valoresArray;
		$this->valorSel=NULL;
	}
	function getValoresArray(){
		return $this->valoresArray;
	}
	function setValor($p_valorSel){
		$this->valorSel=$p_valorSel;
	}
	function getValor(){
		return $this->valorSel;
	}
	function setOnChange($p_accion){
		$this->onChange=$p_accion;
	}
}

?>
