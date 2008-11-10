<?
//include ('HtmlLayout.class.php');
class HtmlLayoutGrid extends HtmlLayout{
	private $rows;
	private $cols;
	private $borde;
	private $width="100%";
	private $ocultos;
	private $estiloFila;
	private $widthCol;
	private $fieldset;
	private $destino;
	private $color_out;
	private $color_in='blue';
	private $color_down;
	private $borderColor;
	
	function organizar($f){
	/*
		if (is_resource($f)){
			OrganizarRecodset($f);
		}
		if (is_subclass_of($f,'HtmlForm')){*/
			return $this->OrganizarForm($f);
		//}
/*		if (is_subclass_of($f,HtmlListado)){
			OrganizarListado($f);
		}*/
	}
	
	function OrganizarForm($f){
		$controles=$f->getControls();
		$cadena=$f->getHeader();
		
		if($f->getEstilo())
			$e=$f->getEstilo();
		else
			$e=new HtmlEstilo();
		$cadena.='<table style="margin:0px" width="'. $this->getWidth() .'" border="'.$this->getBorde() .'"';
		if($this->getBorde()) 
			$cadena.=' cellspacing="0" bordercolor="'.$this->getBordeColor() .'"';
		$cadena.=' align="'. $this->getAlign() .'">' ."\n" ;
		if(isset($this->fieldset)){
		$cadena.="<tr><td><FIELDSET > <legend>".$this->fieldset."</legend><table>";
		}
		if(isset($this->cols)){
			$columnas=$this->cols;
			if(isset($this->rows)) 
				$filas=$this->rows;
			else
				$filas=$f->getNumControls()/$columnas;
		}
		else{
			if(isset($this->rows)){
				$filas=$this->rows;
				$columnas=$f->getNumControls()/$filas;
			}
			else{
				$columnas=2;
				$filas=$f->getNumControls()/$columnas;
			}
			
		}
	

		/*echo "COLS=".$columnas;
		echo "ROWS=".$filas;
*/
		

		for($i=0;$i<$filas;$i++){
		
				 if($this->destino!=NULL){	
						if(isset($this->destino[$i])){
							$cadena.="<tr  onclick=\"document.location.href='".$this->destino[$i]."';\" onMouseOver=\"tres(this,'".$this->color_in."');\" onMouseOut=\"dos(this,'".$this->color_out."');\" bgcolor='".$e->getBackColor()."'>"."\n";
						}else{
							if($i==0){
								$cadena.="<tr  bgcolor='WHITE'>"."\n";
				        		}
							else{
							$cadena.="<tr  bgcolor=".$this->color_in.">"."\n";
								}
							}
					}else{
				$cadena.="<tr  bgcolor=".$e->getBackColor().">"."\n";
				}
			
			
			$j=0;
			$control=current($controles);
			while($j<$columnas){
				if(!isset($this->ocultos[$j]) || $this->ocultos[$j]==false){
					if(isset($this->widthCol[$j]))
						$w=' WIDTH="'.$this->widthCol[$j].'" ';
					else
						$w='';
					if($control){
						$cadena.="<td". $w .">". $control->toString() ."</td>" ."\n";
					}
					else
						$cadena.="<td>&nbsp;</td>" ."\n";
				}
				$j++;
				$control=next($controles);
			}
			$cadena.="</tr>"."\n";
			
		}
		
		if(isset($this->fieldset)){
			$cadena.="</table></FIELDSET></td></tr>";
		}
		$cadena.="</table>"."\n";
		
		$cadena.=$f->getPie();
		
		
		return $cadena;


	}
	
	function getWidth(){
		return $this->width;
	}
	function setWidth($p_width){
		$this->width=$p_width;
	}
	function getBorde(){
		if($this->borde) return 1;
		else return 0;
	}
	function getBordeColor(){
		if($this->borderColor) return $this->borderColor;
		else return "#000000";
	}
	function setBordeColor($p_bordecolor){
		$this->borderColor=$p_bordecolor;
	}
	function setBorde($p_borde){
		$this->borde=$p_borde;
	}

	
	function setRows($p_rows){
		$this->rows=$p_rows;
	}
	function setCols($p_cols){
		$this->cols=$p_cols;
	}
	function ocultarCol($p_columna){
		$this->ocultos[$p_columna]=true;
	}
	function addCol(HtmlControl $p_control){
		static $i=0;
		
		$this->agregados[$i]=$p_control;
		$i++;
	}
	function setWidthCol($p_col,$p_width){
		$this->widthCol[$p_col]=$p_width;
	}
	function setFieldset($p_fieldset){
		$this->fieldset=$p_fieldset;
	}
	function setDestino($p_destino,$c_out=NULL,$c_in=NULL,$c_down=NULL){
		$this->destino=$p_destino;
		$this->color_out=$c_out;
		$this->color_in=$c_in;
		$this->color_down=$c_down;
		
		
	}

}


?>
