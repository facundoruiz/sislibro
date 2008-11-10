<?
class HtmlListado extends HtmlContenedor{
	private static $cantidad=0;
	private $ocultos;
	private $numerar=true;
	private $numeroEmpieza=0;
	private $listado;
	private $accion;
	private $campoOculto;
	private $nombreCampo;
	private $captionBoton;
	private $encabezado=false;
	private $estiloEncabezado;
	private $estilosCol;
	
	function __construct($p_pg_rs=NULL,$p_accion=NULL,$p_caption="",$p_campoId="",$p_nombreCampo=NULL){
		//echo "EN EL CONSTRUCTOR";
		//print_r($p_pg_rs);
		$this->setNombre("listado".HtmlListado::$cantidad);
		HtmlListado::$cantidad++;
		  //$this->layout=new HtmlLayoutGrid();
		//$this->layout->setBorde(true);
		$this->listado=$p_pg_rs;
		$this->campoOculto=$p_campoId;
		$this->nombreCampo=$p_nombreCampo;
		$this->captionBoton=$p_caption;
		$this->accion=$p_accion;
		$this->estiloEncabezado=new HtmlEstilo(true,false,2,"ARIAL");
		$this->estiloEncabezado->setAlign("CENTER");
		
	}
	
	private function generarRS(){

		$this->controles=NULL;
		if ($this->listado){
			$n=pg_num_fields($this->listado);
			$v=$n;
			if ($this->numerar)
				$v++;			
			if(isset($this->accion))
				$v++;
			
			$c=1;
			if($this->encabezado){
				if($this->numerar){
					$this->addControl(new HtmlTag("Orden","",$this->estiloEncabezado));
					
				}
				for($i=0;$i < pg_num_fields($this->listado);$i++){
					$this->addControl(new HtmlTag(pg_field_name($this->listado,$i),"",$this->estiloEncabezado));
				}
			}
			while($row=pg_fetch_array($this->listado)){
				if($this->numerar){
					if(isset($this->estilosCol[1])){
						$this->addControl(new HtmlTag($c+$this->numeroEmpieza,"",$this->estilosCol[1]));
					}
					else{
						$this->addControl(new HtmlTag($c+$this->numeroEmpieza));
					}
				}
				for($i=0;$i<$n;$i++){
					if(isset($this->estilosCol[$i])){
						$this->addControl(new HtmlTag($row[$i],"",$this->estilosCol[$i]));
					}
					else{
						$this->addControl(new HtmlTag($row[$i]));
					}
				}
				if(isset($this->accion)){
					$f=new HtmlForm($this->accion);
					$f->addControl(new HtmlBoton($this->captionBoton));
					if(isset($this->nombreCampo))
						$f->addControl(new HtmlHidden($row[$this->campoOculto],$this->nombreCampo));
					else
						$f->addControl(new HtmlHidden($row[$this->campoOculto],$this->campoOculto));
					$this->addControl($f);
				}
				$c++;
			}
			if(!isset($this->layout)){
				$this->layout=new HtmlLayoutGrid();
				$this->layout->setCols($v);
			}			
				
		}
	}
	private function generarArray(){

		$this->controles=NULL;
		if ($this->listado){
			$n=1;
			$v=0;
			if ($this->numerar)
				$v++;
			if(isset($this->accion))
				$v++;
			$c=1;
			$t=true;
			$e=true;
			foreach($this->listado as $clave=>$valor){
				if(is_array($valor)){
					if($this->encabezado && $e){
						if($this->numerar){
							$this->addControl(new HtmlTag("Orden","",$this->estiloEncabezado));
							//lo agregue yo
							//$this->addControl(new HtmlTag("Turno Nº","",$this->estiloEncabezado));
						}
						foreach($valor as $id1=>$valor2){
							$this->addControl(new HtmlTag($id1,"",$this->estiloEncabezado));
						}
						$e=false;
					}
					if($this->numerar){
							if(isset($this->estilosCol[1])){
								$this->addControl(new HtmlTag($c+$this->numeroEmpieza,"",$this->estilosCol[1]));
							}
							else{
								$this->addControl(new HtmlTag($c+$this->numeroEmpieza));
							}
					}
					$columna=2;
					foreach($valor as $id=>$valor1){

						if(isset($this->estilosCol[$columna])){
							$this->addControl(new HtmlTag($valor1,"",$this->estilosCol[$columna]));
						}
						else{
							$this->addControl(new HtmlTag($valor1));
						}
						if($t){
							$v++;
						}
						$columna++;
				
					}
					$t=false;
				}
				else{
					if($this->encabezado && $e){
						if($this->numerar){
							$this->addControl(new HtmlTag("Orden"));
						}
						$this->addControl(new HtmlTag($clave));
						$e=false;
					}
					if($this->numerar){
						if(isset($this->estilosCol[1])){
							$this->addControl(new HtmlTag($c+$this->numeroEmpieza,"",$this->estilosCol[1]));
						}
						else{
							$this->addControl(new HtmlTag($c+$this->numeroEmpieza));
						}
					}
					if(isset($this->estilosCol[2])){
						$this->addControl(new HtmlTag($valor."www","",$this->estilosCol[2]));
					}
					else{
						$this->addControl(new HtmlTag($valor));
					}
				}
				
				//SI LLEVA BOTON
				if(isset($this->accion)){
					$f=new HtmlForm($this->accion);
					$f->addControl(new HtmlBoton($this->captionBoton));
					if(isset($this->nombreCampo))
						$f->addControl(new HtmlHidden($clave,$this->nombreCampo));
					else
						$f->addControl(new HtmlHidden($clave,$this->campoOculto));
					$this->addControl($f);
				}
				$c++;
			}
			if(!isset($this->layout)){
				$this->layout=new HtmlLayoutGrid();
				$this->layout->setBorde(true);
				$this->layout->setCols($v);
			}
		}
	}
	
	function toString(){
		
		
		if(is_resource($this->listado))
			$this->generarRS();
		if(is_array($this->listado)){
			$this->generarArray();
		}
		$return_string= $this->layout->organizar($this);
		
		
		return $return_string;
	}

	function getHeader(){
		return "";
	}
	function getPie(){
		return "";
	}

	function setNumerar($p_condic,$p_num=1){
		$this->numerar=$p_condic;
		$this->numeroEmpieza=$p_num;
	}	
	
	function setEncabezado($p_enc){
		$this->encabezado=$p_enc;
	}
	function setEstiloCol($p_col, HtmlEstilo $e){
		$this->estilosCol[$p_col]=$e;
	
	}
	function setDatos($p_rs){
		$this->listado=NULL;
		$this->delAllControl();
		
		$this->listado=$p_rs;
		
	}
	function setEstiloEncabezado(HtmlEstilo $e){
		$this->estiloEncabezado=$e;
	}
}



?>




