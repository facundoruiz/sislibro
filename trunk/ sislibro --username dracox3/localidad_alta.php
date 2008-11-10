<?php 
include('cabecera.php');
include("funcionesGrales.php");
?>
<html>

<head>
<title>::---Carga Localidad---::</title>
<style>
a:link, a:active, a:visited {
color: #330099;
font-size: 12; 
text-decoration: none;
font-family: Arial, Helvetica, sans-serif;}

a:hover {
color: #999999;
font-size: 11;
text-decoration: none;
font-family: Arial, Helvetica, sans-serif;}
</style>
</head>

<body>

<table border="0" width="528" cellspacing="0" cellpadding="0" align="center">

  <tr>
    <td width="100%"><img border="0" src="images/hr_top.gif" width="528" height="58"></td>
  </tr>
  <tr>
    <td width="100%" valign="top">
     <A HREF="cargas.php">VOLVER</A>
 <blockquote>
        <p align="center"><font color="#000000" face="Arial" size="3"><strong><img border="0" src="images/ballet_lg.gif" width="19" height="18">
        Carga Localidades <img border="0" src="images/ballet_lg.gif" width="19" height="18"></strong></font></p>
      </blockquote>
<form  method="post" action="" name="form">
 
  <table width="434" border="1">          
   

<tr>
      <th scope="row" bgcolor=#66CCFF >Provincia</th>
      <td width="319">  	   
	  <select name="Tipo" onChange="document.form.submit()">
	  		 <option value="-1">---Seleccione Provincia</option>
			<?php 
			$qtipo="select item,descrip from diccionario where codigo=4 order by(descrip)";
			$rtipo=pg_query($qtipo);
			while ($atipo=pg_fetch_array($rtipo)){
			?>
            <option value="<?php echo $atipo['item'];?>" <?php echo ($_POST['Tipo']==$atipo['item'])?'selected':'';?>
			><?php echo $atipo['descrip'];?>
			<?php }?>
          </select> 

</tr>

    <tr>
      <th scope="row" bgcolor=#66CCFF>Localidad</th>
      <td width="319">	 
 <?php $Loc=strtoupper ($_POST['Loc']); ?>
	             <input type="text" name="Loc" title="Ingrese un Localidad" onBlur="document.form.submit()" value="<?php echo $Loc?>">	
       	
  </td> </tr>
 
  
      
 <?php if(!empty($Loc)){?>
  <tr>
      <th colspan="2"  bgcolor=#66CCFF>Localidades</th></tr><tr>
  <td colspan="2" width="319">	
 <?php 
$q= pg_query(" Select * from tlocalidades where descrip ilike'%$Loc%' and codigo=".$_POST['Tipo']." order by descrip");
 while ($r=pg_fetch_array($q)){
 echo "<FONT SIZE=2>".$r['descrip']."</FONT><br>";
 }} ?>
   	
  </td> </tr>


 </table>
<?php if(!empty($_POST['Loc'])){ ?>
<INPUT TYPE="image" SRC="images/guardar.gif" onclick="document.form.action='glocalidad.php'"  ALT="Guardar Formulario"> 

<?php }?>
  <A HREF="javascript:document.location.href='a_localidad.php'"><IMG SRC="images/limpiar.gif" WIDTH="100" HEIGHT="40" BORDER="0" ALT="Limpiar Formulario"></A>

  <INPUT TYPE="hidden" NAME="form" value="a_localidad">
  </form>
    </td>
  </tr>
  <tr>
    <td width="100%"><img border="0" src="images/hr_bot.gif" width="528" height="44"></td>
  </tr>
</table>
<br>

</body>

</html>
