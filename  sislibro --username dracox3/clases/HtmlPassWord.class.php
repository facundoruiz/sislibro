
<?
	class HtmlPassWord extends HtmlTextBox{
	
	function toString () {
		
		$return_string = "";
		$return_string .= '<INPUT NAME="'.$this->getNombre().'" ';
		$return_string .= 'TYPE="password" ';
		$return_string .= 'VALUE="'.$this->getValor().'" SIZE="'.$this->getSize().'" ';
		if(!$this->estaHabilitado()) 
			$return_string .='DISABLED="disabled" ';
			$return_string .='TITLE=" '.$this->getTitulo().'"';
		$return_string .= " > \n";
		return($return_string);
	}
		
		
	}


?>