<?PHP


exec("d:/Servidor/www/e_b.bat"); 
echo "Se realizo copia de la base de datos";
//le decimos la carpeta
$path = "./backups";

//abrimos la carpeta
$dir = opendir($path);

//Mostramos los archivos
while ($elemento = readdir($dir))
{
  echo $elemento."<br>";
}

//Cerramos la carpeta
closedir($dir);



?>