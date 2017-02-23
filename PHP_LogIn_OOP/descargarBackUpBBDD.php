<?php

////// Descargar Base de datos desde la web

// Nombre del archivo de con el cual queremos que se guarde la base de datos
$date = date("Y-m-d");
$filename = "projectasix" . $date . ".sql";
// Cabezeras para forzar al navegador a guardar el archivo
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Transfer-Encoding: binary");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=$filename");

$usuario="root";  // Usuario de la base de datos, un ejemplo podria ser 'root'
$passwd="Gonzalo12345";  // Contraseña asignada al usuario
$bd="projectasix";  // Nombre de la Base de Datos a exportar

// Funciones para exportar la base de datos desde Windows
//$executa = "c:\\xampp\\mysql\\bin\\mysqldump.exe -u $usuario --password=$passwd --opt $bd";
//system($executa, $resultado);

// Funciones para exportar la base de datos desde Linux
$executa2 = "/mysql/bin/mysqldump -u $usuario --password=$passwd --opt $bd";
system($executa2, $resultado2);

// Comprobar si se a realizado bien, si no es asi, mostrará un mensaje de error
//if ($resultado) { echo "<H1>Error ejecutando comando: $executa</H1>\n"; }
if ($resultado2) { echo "<H1>Error ejecutando comando: $executa2</H1>\n"; }

///// Fin Descargar Base de datos desde la web

?>

<script type="text/javascript">
    history.go(-1);
</script>
<?php
exit();
?>
