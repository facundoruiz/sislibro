<?php
class gestorConexion{
	protected $miconexion; // tipo DBestatic 
	
	function __construct(){
		$this->miconexion= new DBestatic();
		$this->miconexion->conectar();
		
	}
	function getMiconexion(){
		return $this->miconexion;
	}
	function conectar(){
		$this->miconexion->conectar();
	}

}
?>