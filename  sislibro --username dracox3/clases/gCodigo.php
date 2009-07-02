<?php
class Garante{
 
  private $idgarante;
  private $idcliente;
  private $idchequera;
  private $nombre;
  private $apellido;
  private $dni;
  private $domicilio;
  private $barrio;
  private $localidad;
  private $provincia;
  private $idlocalidad;
  private $idprovincia;
  private $celular;
  private $obs;
  private $telefono;
  private $usuario_aud;
  private $altdomicilio;
  private $cobrodomicilio;
  
function constructor(){
	$str='public function '.get_class($this).'(';
	$class_vars = get_class_vars(get_class($this));
	foreach ($class_vars as $name => $value) {
		$str.='$p_'.$name.', ';
	}
	$str=substr($str,0,strlen($str)-2);
	$str.='){';
	foreach ($class_vars as $name => $value) {
		$str.="\n\t".'$this->set'.strtoupper($name[0]).substr($name,1).'($p_'.$name.');';
	}
	$str.="\n}\n";
	echo $str;
}

function set(){
	$class_vars = get_class_vars(get_class($this));
	foreach ($class_vars as $name => $value) {
   		$str.="\n/**\n";
	 	$str.=" * Establece la propiedad ".$name." del objeto\n";
	 	$str.=" *\n";
	 	$str.=" * @param string \$p_".$name."\n";
	 	$str.=" * @access public\n";
	 	$str.=" * @return void\n";
	 	$str.=" */\n";
		$str.='public function set'.strtoupper($name[0]).substr($name,1).'($p_'.$name.'){';
   		$str.="\n\t".'$this->'.$name.'=$p_'.$name.';';		
		$str.="\n}\n";
		echo $str;
		$str="";
	}
}

function get(){
	$class_vars = get_class_vars(get_class($this));
	
	foreach ($class_vars as $name => $value) {
		$str.="\n/**\n";
	 	$str.=" * Devuelve el valor de la propiedad ".$name." del objeto\n";
	 	$str.=" *\n";
	 	$str.=" * @access public\n";
	 	$str.=" * @return string\n";
	 	$str.=" */\n";
		$str.='public function get'.strtoupper($name[0]).substr($name,1).'(){';
		$str.="\n\t".'return $this->'.$name.';';		
		$str.="\n}\n";
		echo $str;
		$str="";
	}
}

	}


echo "<pre>";
$o=new Garante();
$o->constructor();
$o->set();
$o->get();
?>