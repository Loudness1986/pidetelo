<?php

//---iniciar la session
session_start();
//--------------------------------------------
date_default_timezone_set('America/Caracas'); //zona horaria por defecto
// capturar para la pagina que queremos abrir

$pagina = strtolower(filter_input(INPUT_GET, 'pg'));
//comprobamos si es el inicio para abrir la pagina por defecto
if ($pagina=='') {
    $pagina = 'pub_inicio';
}
//variables globales
$exten = '.php';
$directorio = 'vis/';
require_once 'vis/modulo/header.html';//todas las librerias estan cargadas en el header

if (!isset($_SESSION['nivel'])) {
    include $directorio . 'menu_inicio' . $exten; 
} else {
    if ($_SESSION['nivel'] == 1) {
        include $directorio . 'menu_admin' . $exten;
    } else if ($_SESSION['nivel'] == 2) {
        include $directorio . 'menu_usuario' . $exten;
    }
}
$link= $directorio . $pagina . $exten;
if (file_exists($link)) {
    require_once $link;
} else {
   require_once $directorio .'modulo/directorio_no_valido'.$exten;
}
require_once 'vis/modulo/footer.html'; // fragmento de html que contiene el pie de pagina de nuestra web