<?php

setlocale(LC_TIME, 'es_ES');
// BD


 $usuario = "root";
 $base = "ceraor";
 $contrasena = "";
 $dbhost = "localhost";

 
global $db;
$db = new mysqli($dbhost, $usuario, $contrasena, $base) or die("Error al conectar con la base de datos");
mysqli_set_charset($db, 'utf8');
date_default_timezone_set("America/Mexico_City");