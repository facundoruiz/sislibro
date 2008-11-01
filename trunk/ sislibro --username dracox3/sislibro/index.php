<?php 
session_start();
session_destroy();
include("funcionesGrales.php");



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body onload="MaxVent()">
<form name="form1" method="post" action="menu.php">
  <p>&nbsp;</p>
  <p align="center" class="titulo Estilo3">&nbsp;</p>
  <p class="Estilo2">&nbsp;</p>
  <div align="center">
    <table width="398" height="181" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0">
      <tr valign="middle" bgcolor="#009900" class="titulo">
        <td height="15" colspan="2" align="center" class="titulogrande Estilo6">INICIO DE SESION </td>
      </tr>
      <tr class="letra">
        <td height="20" align="center" valign="middle">&nbsp;</td>
        <td height="20"align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr class="letra">
        <td width="176" height="33" align="center" valign="middle"><p align="left" class="letra"><font size="3"> &nbsp;USUARIO&nbsp;</font></p></td>
        <td width="218" height="33"align="center" valign="middle">
          <div align="left">
            <input name="user" type="text" title="Ingrese el Nombre de Usuario" class="Estilo3" id="user">
          </div></td>
      </tr>
      <tr class="letra">
        <td width="176" height="33"  align="center" valign="middle" class="letra"><div align="left"><font size="3">&nbsp;CONTRASE&Ntilde;A&nbsp;</font></div></td>
        <td width="218" height="33" align="center" valign="middle">
          <div align="left">
            <input name="pass" type="password" title="Ingrese su Password" class="Estilo3" id="pass">
          </div></td>
      </tr>
	  <tr class="titulo">
        <td height="20" align="center" valign="middle"></td>
        <td height="20" align="center" valign="middle"></td>
      </tr
      ><tr class="titulo">
        <td height="20" align="center" valign="middle"></td>
        <td height="20" align="center" valign="middle"></td>
      </tr>
      <tr class="titulo">
        <td width="176" height="20" align="center" valign="middle"> <input type="submit" name="Submit" value=" LOGUEARSE ">
        </td>
        <td width="218" height="20" align="center" valign="middle"><input type="reset" name="Submit" value="RESTABLECER"></td>
      </tr>
      <tr class="titulo">
        <td height="20" align="center" valign="middle">&nbsp;</td>
        <td height="20" align="center" valign="middle">&nbsp;</td>
      </tr>
    </table>
  </div>
  <p>&nbsp; </p>
  <p>
<div align="center">
  <center>
  <table border="1" width="32%" bordercolor="#000000" cellspacing="0" cellpadding="0">
    <tr>
      <td width="18%" bgcolor="#FFFFFF" bordercolor="#FF0000"><IMG SRC="img/action2_tm.gif" WIDTH="150" HEIGHT="85" BORDER="0" ALT="info()" onclick="javascript:window.open('action.html', 'Action2', 'top=0,left=0,width=550, height=500, scrollbars=1')"></td>
      <td width="82%" bgcolor="#FFFFFF"><CENTER>
 <BR><IMG SRC="img/Libros.JPG" WIDTH="85" HEIGHT="85" BORDER="0"  ><FONT SIZE="2" COLOR="">Sistema Libro<br>Creado y Desarrollado por:<br>Action 2&trade;</FONT></CENTER></td>
    </tr>
  </table>
  </center>
</div> </p>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>
</html>
