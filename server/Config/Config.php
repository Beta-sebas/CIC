<?php 

header('Access-Control-Allow-Origin: *');
/*header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Max-Age: 172800');
header('Content-Length: 0');
header('Content-Type: text/plain');
header('content-type: application/json; charset=utf-8');*/

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}





const Base_url = "http://localhost/CIC/server/Rutas";

//Datos de conexión a base de datos
const DB_HOST = "localhost"; //servidor de la DB
const DB_NAME = "db_cursos"; //nombre DB
const DB_USER = "root"; //usuario DB
const DB_PASSWORD = ""; //cantraseña DB
const DB_CHARSET = "charset=utf8"; //codificación


?>