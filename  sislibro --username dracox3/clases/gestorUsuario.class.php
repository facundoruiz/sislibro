<?php
class gestorUsuario extends usuario{
	private $c;
	private $menu;
	

	function __construct($p_user,$p_pass,gestorConexion $p_c) {
		if(isset($p_user)){
			$this->setUser($p_user);
			$this->setPass($p_pass);
			$this->setConexion($p_c);	
			$this->menu=new HtmlMenu(); 	
			
		}
	}
	function __wakeup(){
		$this->c->conectar();
	}	
	function setConexion(gestorConexion $p_c){
		$this->c = $p_c->getMiConexion();
	}
		
	function getConexion(){
		return $this->c;
	}
						
	function login() { //valida el login
		$user = $this->getUser();
		$this->getConexion();

		$qUsu="select pass from t_usuarios where habilitado=1 and  usuario = '$user'";
		$result = pg_query($qUsu);
		if (pg_num_rows($result)>0){
			$pass = pg_fetch_array($result);
			$p=trim($pass['pass']);
			$temp=$this->encrypt($this->getPass());
			//echo "base de datos: @".$p."@ - clase: @".$temp."@";	
			if(strcmp($p,$temp)==0)
			{
				$auth="";
				$this->setid();
				$this->setNombre();	
				$this->setApellido();
				$this->setFuncion();
				//$this->setIdArea();
				//$this->setPerfil();
				//	$this->setArea();
				$this->setSesion(true);
			}
			else
			{
				$auth="CLAVE INCORRECTA";
			}
			
		}
		else
		{
			$auth="USUARIO INEXISTENTE O INHABILITADO";
		}
	
	return $auth;
	}
	
	function encrypt($string) {//hash then encrypt a string
		$crypted = crypt(md5($string), md5($string));
		return $crypted;
	}
	
	function inf(){
		 $volver= new HtmlBoton("MENU","Volver",true,"button");
   $volver->setfull(true);
   $volver->setClassEstilo('CLASS=button');
   $volver->setScript("onclick=javascript:location.href='menu.php'");

	  	
   $exit= new HtmlBoton("SALIR","Salir",true,"button");
   $exit->setfull(true);
   $exit->setClassEstilo('CLASS=button');
   $exit->setScript("onclick=javascript:location.href='index.php'");
 	$inf=$this->getApellido().",".$this->getNombre();
	$inf.="<tr ><td colspan='3'>".$volver->toString()." ".$exit->toString()."</td></tr>";
		return $inf;
	}
	
	function cargarMenu(){
		$this->getConexion();	  
		$qMenu =" select nombre,link,descripcion from t_funcion_menu f inner join t_menu m on (f.id_menu = m.id_menu and f.id_submenu=m.id_submenu ) 
		 		  where f.id_funcion=".$this->getFuncion()." and m.id_submenu=0 order by nombre ";
		$rMenu=pg_query($qMenu);
		while($aMenu=pg_fetch_assoc($rMenu)){
			if(!empty($aMenu['img'])){
				$aMenu['img']; 
			} 
$this->menu->addItem($aMenu['link'],$aMenu['nombre'],$aMenu['target'],'class="button" ',$aMenu['descripcion']);
			
		
		}
	}
		
	function Menu(){
		$this->cargarMenu();
		return $this->menu->toString();
	}
	
	function add_user($username,$password,$nombre,$apellido,$funcion){
		$userLog=$this->getUser();
		$qtemp="select funcion from t_usuarios where usuario='$userLog'";
		$rtemp=pg_query($qtemp);
		$atemp=pg_fetch_row($rtemp);
		if ($atemp[0]==1)
		{
			//convertir todo a mayusculas	
			$username=trim(strtr(strtoupper($username), 'áéíóúñ', 'AEIOUÑ'));
			$password=trim(strtr(strtoupper($password), 'áéíóúñ', 'AEIOUÑ'));
			$password =$this->encrypt($password);
			$nombre=trim(strtr(strtoupper($nombre), 'áéíóúñ', 'AEIOUÑ'));	
			$apellido=trim(strtr(strtoupper($apellido), 'áéíóúñ', 'AEIOUÑ'));
	
			$cad = " insert into t_usuarios (usuario,pass,nombre,apellido,funcion,fecha_aud,hora_aud,usuario_aud) values (";
			$cad.= " '$username', '$password','$nombre','$apellido','$funcion',(select fecha()),(select hora()),'$userLog')";
	//		echo $cad;
			$aaa=pg_query($cad);
		}
		else 
		{
			echo "<script javascript>alert('No tiene un perfil autorizado para agregar un usuario')</script>";
			echo "<script javascript>parent.window.location.href='menu.php' </script>";
		}
	}
  /************************************ submenu ************************************/
  function cargarSubmenu($menu){
		$this->getConexion();	  
		$qSubmenu =" select img,nombre,link,descripcion from t_funcion_menu f inner join t_menu m on (f.id_menu = m.id_menu and f.id_submenu=m.id_submenu) 
		 			 where f.id_funcion=".$this->getFuncion()." and m.id_submenu<>0 and f.id_menu=$menu order by nombre";
		$rSubmenu=pg_query($qSubmenu);
		
		while($aSubmenu=pg_fetch_assoc($rSubmenu)){
			if(!empty($aSubmenu['img'])){
				$aSubmenu['img']; 
			} 
$this->menu->addItem($aSubmenu['link'],$aSubmenu['nombre'],$aSubmenu['target'],'class= "button"',$aSubmenu['descripcion']);
		}
	}
	
	function Submenu($menu){
		$this->cargarSubmenu($menu);
		return $this->menu->toString();
	}
  
  
  /**********************************************************************************/
  
}
?>