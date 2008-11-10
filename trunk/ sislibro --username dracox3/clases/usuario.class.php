<?
class usuario{
	private $nombre;
	private $apellido;
	private $user;
	private $pass;
	private $perfil;
	private $funcion;
	private $id_area;
	private $area;
	private $turno;	
	private $sesion; 	
	private $id;
		
	function usuario(){
		
	} 
	function setUser($p_user){
		$this->user=trim(strtr(strtoupper($p_user), 'áéíóúñ', 'AEIOUÑ'));
	}

	function setPass($p_pass){
		$this->pass=trim(strtr(strtoupper($p_pass), 'áéíóúñ', 'AEIOUÑ'));
	}
	
	function setNombre($p_nom=""){
		if (!$p_nom){
			$qCons="select nombre from t_usuarios where habilitado=1 and  usuario = '".$this->getUser()."'";
			$rCons=pg_query($qCons);
			$aCons=pg_fetch_assoc($rCons);
			$p_nom=$aCons['nombre'];
		}
		$this->nombre=$p_nom;
	}

	function setApellido($p_ap=""){
		if (!$p_ap){
			$qCons="select apellido from t_usuarios where habilitado=1 and  usuario = '".$this->getUser()."'";
			$rCons=pg_query($qCons);
			$aCons=pg_fetch_assoc($rCons);
			$p_ap=$aCons['apellido'];
		}
		$this->apellido=$p_ap;
	}

	function setId($p_id=""){
		if (!$p_id){
			$qCons="select id_usuario from t_usuarios where habilitado=1 and  usuario = '".$this->getUser()."'";
			$rCons=pg_query($qCons);
			$aCons=pg_fetch_assoc($rCons);
			$p_id=$aCons['id_usuario'];
		}
		$this->id=$p_id;
	}

	function setFuncion($p_f=""){
		if (!$p_f){
			$qCons="select funcion from t_usuarios where habilitado=1 and  usuario = '".$this->getUser()."'";
			$rCons=pg_query($qCons);
			$aCons=pg_fetch_assoc($rCons);
			$p_f=$aCons['funcion'];
		}
		$this->funcion=$p_f;
	}

/*	function setPerfil($p_perfil=""){
		if (!$p_perfil){
//			$qCons="select nombre,apellido,descdic(3,funcion)as perfil,funcion,pass,id_usuario from tusuarios where habilitado=1 and  usuario = '".$this->getUser."'";
			$qCons="select descdic(5,funcion)as perfil from tusuarios where habilitado=1 and  usuario = '".$this->getUser()."'";
			$rCons=pg_query($qCons);
			$aCons=pg_fetch_assoc($rCons);
			$p_perfil=$aCons['perfil'];
		}
		$this->perfil=$p_perfil;
	}
	function setArea($p_area=""){
		if(!$p_area){
			$qCons="select descdic(7,id_area)as area from ubicacion_funcion where id_funcion = '".$this->getFuncion()."'";
			$rCons=pg_query($qCons);
			$aCons=pg_fetch_assoc($rCons);
			$p_area=$aCons['area'];
		
		}
		$this->area=$p_area;
	}

	function setIdArea($p_idarea=0){
		if(!$p_idarea){
			$qCons="select id_area from ubicacion_funcion where id_funcion = '".$this->getFuncion()."'";
			$rCons=pg_query($qCons);
			$aCons=pg_fetch_assoc($rCons);
			$p_idarea=$aCons['id_area'];
		
		}
		$this->id_area=$p_idarea;
	}
	
	function setTurno($p_turno){
		$this->turno=$p_turno;
	}*/
	function setSesion($p_sesion){
		$this->sesion=$p_sesion;
	}
	function getNombre(){
		return $this->nombre;
	}
	
	function getApellido(){
		return $this->apellido;
	}

	function getid(){
		return $this->id;
	}		

	function getFuncion(){
		return $this->funcion;
	}		

	function getUser(){
		return $this->user;
	}

	function getPass(){
		return $this->pass;
	}

/*	function getPerfil(){
		return $this->perfil;
	}
	function getArea(){
		return $this->area;
	}
	function getTurno(){
		return $this->turno;
	}
	function getDescTurno(){
		$qDesc="select descdic(9,".$this->getTurno().")";
		@$rDesc=pg_query($qDesc);
		@$aDesc=pg_fetch_row($rDesc);
		if ($aDesc)	
			return $aDesc[0];
		else
			return "";
		
	}
	
	function getIdArea(){
		return $this->id_area;
	}*/
	function getSesion(){
		return $this->sesion;
	}
}



		

 ?>
