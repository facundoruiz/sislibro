<?	
class HtmlInformeListado extends HtmlInforme{
	private static  $num_infomesListado=0;
	protected $rs;
	private $numFilas1=60;
	private $numFilas=60;
	private $contLineas;
	private $verNumPag=true;
	protected $numHojas;
	protected $pie;
	private $numerar=true;
	private $tituloall=false;
	private $paginar=true;
	public $listado;
	
	function __construct($p_rs=NULL, $p_nombre=""){
		if($p_nombre!="")
			$this->setNombre($p_nombre);
		else
			$this->setNombre("informeListado".HtmlInformeListado::$num_infomesListado);
		
		HtmlInformeListado::$num_infomesListado++;
		
		if(isset($p_rs)){
			if(is_resource($p_rs)){
				$this->setRS($p_rs);
			}
			else{
				$this->rs=$p_rs;
				$this->filacero=new HtmlGrupo();
				$this->contLineas=count($this->rs);
				$this->numHojas= ceil((($this->contLineas - $this->numFilas1)/$this->numFilas)+1);
			}
		}	
		
		$this->titulo=new HtmlTag("");
		//$this->encabezado=new HtmlTag("");		
		$this->listado=new HtmlListado($p_rs);
	}
	
	function setRS($p_rs){
		$c=0;
		
		while($row=pg_fetch_assoc($p_rs)){
			$this->rs[$c]=$row;
			$c++;
		}
		$this->filacero=new HtmlGrupo();
		$this->contLineas=$c;
		$this->numHojas= ceil((($this->contLineas - $this->numFilas1)/$this->numFilas)+1);
	}
	
	
	function getPie($p_pagina){
			
			$pie='<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
					<tr>
					    <td width='. $this->toPixel($this->getMargenIz()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					    <td>'. $this->pie .'</td>
						<td width='. $this->toPixel($this->getMargenDe()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					</tr>
					<tr>
					    <td width='. $this->toPixel($this->getMargenIz()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>';
			if($this->paginar){
				$pie.='<td><div align="center"> Pagina '.$p_pagina.' de '. $this->getNumHojas().'</div> </td>';
			}
			else{
				$pie.='<td><div align="center">   </div> </td>';
			}
			$pie.='	<td width='. $this->toPixel($this->getMargenDe()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					</tr>
					</table>';
					/*
			
			$pie='<table width="100%" border="0" cellspacing="0" >
					<tr>
					<td width="100%"><div>'.$this->pie.'</div></td>
					<td width="100%"><div align="center">Pagina '.$p_pagina.' de '. $this->getNumHojas().'</div></td>
					</tr>
				</table>';*/
		if($p_pagina!=$this->getNumHojas()){
			//$pie.='<H1 class="SaltoDePagina"> </H1>';
			$pie.='<div style="page-break-after:always"></div>';
		}
			
		
		return $pie;
	}
	function getCuerpo($p_pagina){
		return $this->getListado();
/*		$cuerpo='
				<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
					<tr>
					    <td width='. $this->toPixel($this->getMargenIz()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					    <td align="right">'. $this->getListado($p_pagina) .'</td>
    					<td width="75" align="right" bordercolor="#FFFFFF">&nbsp;</td>
  					</tr>
				</table>';
		return $cuerpo;*/
	}
	/*function getCuerpo($p_pagina){
		return $this->getListado($p_pagina);
	}*/
	
	function getListado($p_pagina){
		if($this->rs){
			if($p_pagina==1){ 
				$n=$this->getNumFilas1();
				$offset=0;
			}
			else{
				$n=$this->getNumFilas(); 	
				$offset=($p_pagina-1)*$this->getNumFilas() - ($this->getNumFilas()-$this->getNumFilas1()) ;
			}
			$c=1;
			
			$this->listado->setDatos(array_slice($this->rs,$offset,$n,false));
			//esta linea permite poner nombre a los campos
			$this->listado->setEncabezado(true);
			//$this->listado=new HtmlListado(array_slice($this->rs,$offset,$n,false));
			if($this->numerar){
				$this->listado->setNumerar(true,$offset);
			}
			else
				$this->listado->setNumerar(false);
			return $this->listado->toString();
		}
		else
			return "";
			
	}

	function getNumFilas1(){
		return $this->numFilas1;
	}
	function setNumFilas1($p_numFilas1){
		$this->numFilas1=$p_numFilas1;
		$this->numHojas= ceil((($this->contLineas - $this->numFilas1)/$this->numFilas)+1);
	}
	function getNumFilas(){
		return $this->numFilas;
		
	}
	function setNumFilas($p_numFilas){
		$this->numFilas=$p_numFilas;
		$this->numHojas= ceil((($this->contLineas - $this->numFilas1)/$this->numFilas)+1);
	}

	function getContLineas(){
		return $this->contLineas;
	}
	function toString(){
		for($i=1;$i<=$this->numHojas;$i++){
						$informe='
				<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">';
					
						if(isset($this->encabezado)){
					    echo '<tr><td width='. $this->toPixel($this->getMargenIz()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					    <td>'. $this->encabezado->toString() .'</td>
						<td width='. $this->toPixel($this->getMargenDe()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td></tr>	';				
						}/*
						else
						{
						echo '<tr><td width='. $this->toPixel($this->getMargenIz()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					    <td>'. $this->encabezado->toString() .'</td>
						<td width='. $this->toPixel($this->getMargenDe()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td></tr>	';			}*/
					
					if($this->tituloall){
					$informe.='	<tr>
					    <td width='. $this->toPixel($this->getMargenIz()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					    <td align="right">'. $this->titulo->toString() .'</td>
    					<td width='. $this->toPixel($this->getMargenDe()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
  					</tr>';
					}
					
					$informe.='	<tr>
					    <td width='. $this->toPixel($this->getMargenIz()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					    <td align="right">'. $this->getListado($i) .'</td>
						<td width='. $this->toPixel($this->getMargenDe()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					</tr>
					<tr>
					    <td width='. $this->toPixel($this->getMargenIz()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					    <td align="right">'. $this->getPie($i) .'</td>
						<td width='. $this->toPixel($this->getMargenDe()). ' align="right" nowrap bordercolor="#FFFFFF">&nbsp;</td>
					</tr>
					
				</table>';
						echo $informe;
		}
	
	}
	
	function setNumerar($p_bool){
		$this->numerar=$p_bool;
	}
	function setTituloAll($p_bool){
		$this->tituloall=$p_bool;
	}
	function setPaginar($p_bool){
		$this->paginar=$p_bool;
	}
	
}
?>