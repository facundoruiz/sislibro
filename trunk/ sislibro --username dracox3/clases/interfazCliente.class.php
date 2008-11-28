<?php
class interfazCliente{
	
public function mostrar_cliente(Cliente $cliente){
	
$cad.='<tr>		  
      <th  scope="row" class="rotulo">DNI</th>	  
      <td >'.$cliente->get_dni().'</td>
</tr>';
$cad.='<tr>
      <th scope="row"  class="rotulo">Apellido</th>
      <td >'.$cliente->get_apellido().'</td>
</tr>';
$cad.='<tr>
     <th scope="row" class="rotulo" >Nombre</th>
     <td >'.$cliente->get_nombre().'</td>
</tr>';
$cad.='<tr>
       <th scope="row" class="rotulo" >Domicilio</th>
      <td >'.$cliente->get_domicilio().'</td>
</tr>';
$cad.='<tr>
       <th scope="row" class="rotulo">Telefono</th>
      <td >'.$cliente->get_telefono().'</td>
</tr>';	
$cad.='<tr>
   <th scope="row" class="rotulo">Celular(*)</th>
   <td >'.$cliente->get_celular().'</td>
</tr>';	
$cad.='<tr>
   <th scope="row" class="rotulo">Provincia</th>
   <td  align="left">'.$cliente->get_provincia().'</td>
</tr>';    
 
$cad.='<tr>
   <th scope="row" class="rotulo">Localidad</th>
   <td  align="left">'.$cliente->get_localidad().'</td>
</tr>';
$cad.='<tr>
    <th scope="row" class="rotulo">Barrio</th>
 	<td width="281">'.$cliente->get_barrio().'</td>
</tr>';
if($cliente->get_moroso()!=2){
$cad.='<tr>
 	<th scope="row" class="rotulo">Moroso</th>
    <td >'. $cliente->get_esmoroso().'</td>
</tr>';}else{
	$cad.='<tr>
 	<th scope="row" class="rotulo">Moroso</th>
    <td class="error">'. $cliente->get_esmoroso().'</td>
</tr>';
	}
$cad.='<tr>
    <th scope="row" class="rotulo">Observacion</th>
 	<td >'.$cliente->get_obs().'</td>
 </tr>';
		/*
		 * $cont=new HtmlGrupo(NULL,'','','cliente');
	
	$contenedor=new HtmlGrupo();
	$lau2=new HtmlLayoutGrid();
	$lau2->setCols('2');
	$lau2->setEstiloCols('rotulo');
	$contenedor->setLayout($lau2);
	
		
	$l=new HtmlLayoutGrid();
		$l->setCols('1');		
		$lau2->setEstiloClass('c_datos');
		
		$cont->setLayout($l);
$contenedor->addControl(new HtmlTag('DNI'));	  
$contenedor->addControl(new HtmlTag($cliente->get_dni()));
$contenedor->addControl(new HtmlTag('Apellido'));
$contenedor->addControl(new HtmlTag($cliente->get_apellido()));
$contenedor->addControl(new HtmlTag('Nombre'));
$contenedor->addControl(new HtmlTag( $cliente->get_nombre()));
$contenedor->addControl(new HtmlTag('Domicilio'));
$contenedor->addControl(new HtmlTag($cliente->get_domicilio()));  
$contenedor->addControl(new HtmlTag('Telefono'));
$contenedor->addControl(new HtmlTag($cliente->get_telefono()));
$contenedor->addControl(new HtmlTag('Celular(*)'));
$contenedor->addControl(new HtmlTag($cliente->get_celular()));
$contenedor->addControl(new HtmlTag('Provincia'));
$contenedor->addControl(new HtmlTag($cliente->get_provincia()));
$contenedor->addControl(new HtmlTag('Localidad'));
$contenedor->addControl(new HtmlTag($cliente->get_localidad()));
$contenedor->addControl(new HtmlTag('Barrio'));
$contenedor->addControl(new HtmlTag($cliente->get_barrio()));
$contenedor->addControl(new HtmlTag('Moroso'));
$contenedor->addControl(new HtmlTag($cliente->get_esmoroso()));
$contenedor->addControl(new HtmlTag('Observacion'));
$contenedor->addControl(new HtmlTag($cliente->get_obs()));
$cont->addControl($contenedor);

$cont->addControl(new HtmlTag('(*)se coloca el numero sin 0 y sin 15 ej: 0<B>381</B>15<B>4498244</B>')); 
return $cont->toString();
* */


		return $cad;
		
	}
	
}
?>