<?php
class DBestatic extends DB {
	


 function __construct($p_host='localhost',$p_db='desarrollo_sislibro',$p_port='5432',$p_user='postgres',$p_pass='1234') {
  	parent::__construct($p_host,$p_db,$p_user,$p_pass,$p_port);
  	parent::conectar();
 }
 /*
 function dameHand(){	
 	$thisgetHandle();
 }
*/
 function dimeHand(){	
  	return $this->conexion;
 }
}
?>