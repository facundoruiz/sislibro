<?php
class FormadePago{

	
	public function ComboFormadeCobro(){
	
		$comboo=new HtmlCombo('','formadecobro',20,true);
					$qo=pg_query("select item,descrip from diccionario where codigo=5 order by item asc ");
				    $comboo->setOnChange("javascript:document.form1.submit()");	
					$comboo->addItem(0,'--Seleccione-');
					while($ro=pg_fetch_array($qo)){
						$comboo->addItem($ro[0],$ro[1]);
						};
		return $comboo;
}

public function ComboCantCuotas(){
	
		$comboo=new HtmlCombo('','cant_cuotas',20,true);
					$qo=pg_query("select item,descrip from diccionario where codigo=7 order by item asc ");
				    $comboo->setOnChange("javascript:document.form1.submit()");	
					$comboo->addItem(0,'--Seleccione-');
					while($ro=pg_fetch_array($qo)){
						$comboo->addItem($ro[0],$ro[1]);
						};
		return $comboo;
}





}
?>