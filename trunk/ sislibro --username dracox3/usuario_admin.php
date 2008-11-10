<?php include("cabecera.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>ADMINISTRAR USUARIOS</title>
</head>
<body>
<a href="menu.php"><IMG SRC="img/volver.gif" WIDTH="35" HEIGHT="35" BORDER="0" ALT=""><BR>
Menu Principal</a>
    
	<form name="form1" method="post" action="">
	
    <strong>
    <input name="orden" type="radio" value="usuario" onClick="submit()" <?php echo (!$_POST['orden'] or $_POST['orden'])=='usuario'?'checked':''; ?>>
      USUARIO</strong>
    <strong>
    <input name="orden" type="radio" value="nombres" onClick="submit()" <?php echo ($_POST['orden']=='nombres')?'checked':''; ?>>
      APELLIDO Y NOMBRE </strong>
    <strong>
    <input name="orden" type="radio" value="funcion" onClick="submit()" <?php echo ($_POST['orden']=='funcion')?'checked':''; ?>>
      PERFIL</strong>
        <strong>
          <input name="orden" type="radio" value="habilitado" onClick="submit()" <?php echo ($_POST['orden']=='habilitado')?'checked':''; ?>>
          HABILITADO</strong>
  
	  <?php
	  $orden_f=($_POST['orden'])?$_POST['orden']:'usuario';
	  $quser =" select u.id_usuario,u.usuario,u.apellido||', '||u.nombre as nombres,d.descrip as funcion, habilitado from t_usuarios u ";
	  $quser.=" left join diccionario d on (d.item=u.funcion and d.codigo=7 ) order by $orden_f";
	  $ruser=pg_query($quser);
	  $i=1;
	  while($auser=pg_fetch_assoc($ruser)){
	  ?>
      <tr  bgcolor="<?php echo (!$banfondo)?'':'#CCCCCC'; $banfondo=!$banfondo;?>">
	  	
        <td><?php echo $auser['usuario'];?></td>
        <td><?php echo $auser['nombres'];?></td>
        <td><?php echo $auser['funcion'];?></td>
        <td>
			<input type="checkbox" name="habil<?php echo $i;?>" value="1" <?php echo ($auser['habilitado']==1)?'checked':'';?> disabled>
	        <a href="usuario_mod.php?id_user=<?php echo $auser['id_usuario'];?>">Modificar</a>
		</td>
      </tr>
	  <?php $i++;}?>
    
	</form>
	
	
</body>
</html>
