var nav4 = window.Event ? true : false;

//<!---------------DEja typear si es Numero ----------------------->
function soloNum(evt){ 
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
var key = nav4 ? evt.which : evt.keyCode; 
return (key <= 13 || (key >= 48 && key <= 57));
}

//<!---------------DEja typear si es Numero y tiene Pto----------------------->
function soloNumPto(evt){ 
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
var key = nav4 ? evt.which : evt.keyCode; 
return (key <= 13 ||key <= 44||key <= 46 || (key >= 48 && key <= 57));
}


//<!---------------Valida Fecha----------------------->
function esDigito(sChr){
	var sCod = sChr.charCodeAt(0);
	return ((sCod > 47) && (sCod < 58));
}
function valSep(oTxt){
	var bOk = false;
	<!--bOk = bOk || ((oTxt.value.charAt(2) == "-") && (oTxt.value.charAt(5) == "-"));-->
	bOk = bOk || ((oTxt.value.charAt(2) == "/") && (oTxt.value.charAt(5) == "/"));
	return bOk;
}
function finMes(oTxt){
	var nMes = parseInt(oTxt.value.substr(3, 2), 10);
	var nAnio = parseInt(oTxt.value.substr(6, 4), 10);
	var nRes = 0;
	switch (nMes){
		case 1: nRes = 31; break;
		case 2: if (nAnio%4==0) 
					nRes = 29;
				else
					nRes = 28; 
				break;
		case 3: nRes = 31; break;
		case 4: nRes = 30; break;
		case 5: nRes = 31; break;
		case 6: nRes = 30; break;
		case 7: nRes = 31; break;
		case 8: nRes = 31; break;
		case 9: nRes = 30; break;
		case 10: nRes = 31; break;
		case 11: nRes = 30; break;
		case 12: nRes = 31; break;
	}
	return nRes;
}
function valDia(oTxt){
	var bOk = false;
	var nDia = parseInt(oTxt.value.substr(0, 2), 10);
	bOk = bOk || ((nDia >= 1) && (nDia <= finMes(oTxt)));
	return bOk;
}
function valMes(oTxt){
	var bOk = false;
	var nMes = parseInt(oTxt.value.substr(3, 2), 10);
	bOk = bOk || ((nMes >= 1) && (nMes <= 12));
	return bOk;
}
function valAno(oTxt){
	var bOk = true;
	var nAno = oTxt.value.substr(6);
	bOk = bOk && ((nAno.length == 2) || (nAno.length == 4));
	if (bOk){
		for (var i = 0; i < nAno.length; i++){
			bOk = bOk && esDigito(nAno.charAt(i));
		}
	}
	return bOk;
}
function valFecha(oTxt){
	var bOk = true;
	if (oTxt.value != ""){
		bOk = bOk && (valAno(oTxt));
		bOk = bOk && (valMes(oTxt));
		bOk = bOk && (valDia(oTxt));
		bOk = bOk && (valSep(oTxt));
		if (!bOk){
			alert("Fecha inválida");
			
                          oTxt.value='';
                        oTxt.select();
                        oTxt.focus();
			
		}
	}
}
//<!---------------Fin Valida Fecha----------------------->

//<!---------------Valida Hora ----------------------->
function valMin(oTxt){
	var bOk = false;
	var nMin = parseInt(oTxt.value.substr(3, 2), 10);
	bOk = bOk || ((nMin >= 0) && (nMin <= 59));
	
	return bOk;
}

function valHor(oTxt){
	var bOk = false;
	var nHor = parseInt(oTxt.value.substr(0, 2), 10);
	bOk = bOk || ((nHor >= 0) && (nHor <= 24));
	
	return bOk;
}
function valSepa(oTxt){
	var bOk = false;
	bOk = bOk || ((oTxt.value.charAt(2) == ":") );
	return bOk;
}
	
function valHora(oTxt){

	var bOk = true;

	if (oTxt.value != ""){

		bOk = bOk && (valHor(oTxt));
		bOk = bOk && (valMin(oTxt));
		bOk = bOk && (valSepa(oTxt));
		if (!bOk){
			alert("Hora inválida");
			
                          oTxt.value='';
			oTxt.select();
			oTxt.focus();
		}
	}
}


//<!-------------------FUNCION IMPRIMIR----------------------->
//si se aprieta en boton imprimir imprime y no aparece el boton
function imprime(){

//desaparece el boton
 if (window.print){
document.getElementById("btnImprimir").style.display='none';
//se imprime la pagina
factory.printing.header = "";
  factory.printing.footer = "";
  //imprime los dos metodos
 //factory.printing.Print(true);//si true va a setup false va de una a imprimir
window.print();
factory.printing.header = "";
factory.printing.footer = "Si.Trans.";

//reaparece el boton
document.getElementById("btnImprimir").style.display='inline';
 }  else{
    alert("Lo siento, pero a tu navegador no se le puede ordenar imprimir" +
      " desde la web. Actualizate o hazlo desde los menús");
 }

 
}

//<!-- -----------------Funcion PARA MAXIMIZAR VENTANA-------------------------- -->



// Maximizar Ventana por Nick Lowe (nicklowe@ukonline.co.uk)
function  MaxVent(){
window.moveTo(0,0);
if (document.all) {
top.window.resizeTo(screen.availWidth,screen.availHeight);
}
else if (document.layers||document.getElementById) {
if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
top.window.outerHeight = screen.availHeight;
top.window.outerWidth = screen.availWidth; 

}
}
}

//<!-- -----------------Funcion Ocultar div-------------------------- -->

function mostrar(nombreCapa){
//document.getElementById(nombreCapa).style.visibility="visible";
document.getElementById(nombreCapa).style.display='';
}
function ocultar(nombreCapa){
//document.getElementById(nombreCapa).style.visibility="hidden";
document.getElementById(nombreCapa).style.display='none';
}

//<!-- -----------------Funcion Ocultar filas o columnas-------------------------- -->
function ocultarFila(num,ver) {
  dis= ver ? '' : 'none';
  tab=document.getElementById('tabla');
  tab.getElementsByTagName('tr')[num].style.display=dis;
}
function ocultarColumna(num,ver) {
  dis= ver ? '' : 'none';
  fila=document.getElementById('tabla').getElementsByTagName('tr');
  for(i=0;i<fila.length;i++)
    fila[i].getElementsByTagName('td')[num].style.display=dis;
}


//<!-- ----------FUNCION ILUNINA CELDAS O COLUMNAS simple------------ -->

function uno(src,color_entrada) { 
    src.bgColor=color_entrada;src.style.cursor="hand"; 
} 
function dos(src,color_default) { 
    src.bgColor=color_default;src.style.cursor="default"; 
} 

//<!-- ABRIR VENTANA -->
function v_abrir (URL){ 
   window.open(URL,"ventana1"," top=0,left=0,width=400, height=400, scrollbars=1") 
} 
 function v_abrir2 (URL){ 
   window.open(URL,"ventana1"," top=0,left=0,width=520, height=500, scrollbars=1") 
} 
//<!-- ----------FUNCION Oculatas CELDAS O COLUMNAS simple------------ -->
function show_hide_menus(ele)    {
           if (document.getElementById('tbl_'+ele).style.display=='')
           {
               document.getElementById('tbl_'+ele).style.display='none';
               //setCookie( ele, "none", 1);
             //  var imgsource = plus_minus_img + ele + '.gif';
             //  document.getElementById('img_'+ele).src=imgsource;
           }    else    {
               document.getElementById('tbl_'+ele).style.display='';
             //  setCookie( ele, "", 1);
             //  var imgsource = plus_minus_img + ele + '_m.gif';
             //  document.getElementById('img_'+ele).src=imgsource;
           }
       }
function show_hide_menus2(ele)    {
          
                   document.getElementById('tbl_'+ele).style.display='none';     
          
       }
function imgtoggle(obj){

	if(obj.className=="open"){
		obj.style.display='';
		obj.className="close";
		obj.src="img/pin_up.gif";
	}else{
		obj.className="open";
		obj.src="img/pin_down.gif";
	}
}
//<!--------------------FUNCION DE DESCRIPCION DE MENU ------------------->
function change(html){
  description.innerHTML=html
}

