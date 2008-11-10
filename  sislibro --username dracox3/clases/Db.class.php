<? 	
	class DB  {
		private $host;
		private $port;
		private $dbName;
		private $user;
		private $passWord;
		protected $conexion;
		
		/**Setea los las propiedades y llama al metodo conectar()*/
		function __construct($p_host,$p_dbName,$p_user,$p_passWord,$p_port){
			$this->host=$p_host;
			$this->port=$p_port;
			$this->dbName=$p_dbName;
			$this->user=$p_user;
			$this->passWord=$p_passWord;
		}
			/**Cierra la conexion*/
		function __destruct(){
		
			if($this->conexion)
				@pg_close($this->conexion);
		}
		/**Realiza una conecion a la DB y la guarda en la propiedad conexion*/		
		function conectar(){
			$cadena="host='" . $this->host . "' port='" . $this->port . "' dbname='" . $this->dbName . "' user='" . $this->user . "' password='" . $this->passWord . "'";
			$this->conexion=@pg_connect($cadena);
			pg_query("SET STATEMENT_timeout to 120000;");//lo puse yo facu
			pg_query("SET DATESTYLE TO sql,dmy;");
			
			//@pg_set_client_encoding($this->conexion,"UNICODE");
		}
		
		/**Dvulve el nombre de Usuario*/		
		function getUserName(){
			return $this->user;
		}
		
		function isMemberOf($p_group){
			$sql="SELECT groname as g ";
			$sql.="FROM pg_group ";
			$sql.="WHERE ";
     		$sql.="(SELECT usesysid FROM pg_user WHERE usename='";
			$sql.=$this->getUserName();
			$sql.="')=ANY(grolist)";
			//echo $sql;
			$rs=pg_query($this->conexion,$sql);
			while($row=pg_fetch_array($rs)){
				if ($p_group==$row['g']){
					return true;
				}
			}
			return false;
		}

		/**Devulve una cadena de caracter con el grupo al que pertenece 
		el usuario con la cual esta hecha la conexion a la DB.
		Si el Usuario pertenece a mas de un grupo devuelve -1. 
		Si el Usuario no tiene Grupo devuelve 0(cero).*/ 
		function getUserGroup(){
			$sql="SELECT groname as g ";
			$sql.="FROM pg_group ";
			$sql.="WHERE ";
     		$sql.="(SELECT usesysid FROM pg_user WHERE usename='";
			$sql.=$this->getUserName();
			$sql.="')=ANY(grolist)";
			//echo $sql;
			$rs=pg_query($this->conexion,$sql);
			switch(pg_num_rows($rs)){
				case 0:
						return 0;
						break;
				case 1:
						$row = pg_fetch_array($rs);
						return $row['g'];
						break;
				default:
						return -1;
						break;
			}
		}

		/**Devulve TRUE si esta conectado a la DB.Sino devuelve FALSE*/
		function estaConectado(){
			if($this->conexion)
				return TRUE;
			else
				return FALSE;
		}

	
	 function getHandle(){
 			return $this->conexion;
 	}
	}
	
?>