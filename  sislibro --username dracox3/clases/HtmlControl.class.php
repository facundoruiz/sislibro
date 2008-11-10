<?
abstract class HtmlControl {
	private $nombre;
	private $habilitado;
	public $estilo;
	
	abstract function toString();
	

		
	function setNombre($p_nombre){
		$this->nombre=$p_nombre;
	}
	function getNombre(){
		return $this->nombre;
	}
	function setHabilitado($p_habilitado){
		$this->habilitado=$p_habilitado;
	}
	function setValor(){}
	function getHabilitado(){
		if ($this->habilitado)
			return 'enabled';
		else
			return 'disabled';
	}
	function estaHabilitado(){
		return $this->habilitado;
	}
	function setEstilo(HtmlEstilo $p_e){
		$this->estilo=$p_e;
	}
}