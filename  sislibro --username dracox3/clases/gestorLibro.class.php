<?php
class gestorLibro extends Libro{
	private $conex;
	
	function __construct(gestorConexion $p_c) {
			$this->setConexion($p_c);	
	}

	function setConexion(gestorConexion $p_c){
		$this->conex = $p_c->getMiConexion();
	}
		
	function getConexion(){
		return $this->conex;
	}
	
	function __wakeup(){
		$this->c->conectar();
	}
	public function  get_libroCodigo($p_codigo){
		$this-> getConexion();
	$sql="select codigo,f_desc_genero(idgenero),f_desc_editorial(ideditorial),f_desc_titulo(idtitulo),idtitulo,ideditorial,idgenero from t_ejemplares where codigo=". $p_codigo."";
		$query=pg_query($sql);
		$r=pg_fetch_array($query);
			if($r>0){
		$libro=new Libro($r['codigo'],$r[3],$r[2],$r[1],$r['idtitulo'],$r['idgenero'],$r['idetirorial']);
			return $libro;
		}else{
			return 0;
		} 
	}
	public function show_libro(Libro $p_libro){
		$cad= '<tr>';
    	$cad.= '<td>'. $p_libro->getNombre() .'</td>';
    	$cad.= '<td>'. $p_libro->getGenero() .'</td>';
    	$cad.= '<td>'. $p_libro->getEditorial().'</td>';
  		$cad.= '</tr>';		
		return $cad;
	}
	
	
}

?>