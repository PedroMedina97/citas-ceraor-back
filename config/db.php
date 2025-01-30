<?php

setlocale(LC_TIME, 'es_ES');

 $usuario = 'ceraordc_adminsystem';
 $base = 'ceraordc_ceraor';
 $contrasena = 'X#*r&D@iEnI!';
 $dbhost = '162.241.62.131';
 
global $db;
$db = new mysqli($dbhost, $usuario, $contrasena, $base) or die("Error al conectar con la base de datos");
mysqli_set_charset($db, 'utf8');
date_default_timezone_set("America/Mexico_City");