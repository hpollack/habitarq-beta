<?php

session_start();
include_once '../../lib/php/libphp.php';

date_default_timezone_set("America/Santiago");
setlocale(LC_TIME, 'spanish');

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
    echo "No puede ver esta pagina";
    header("location: ".url()."login.php");
    exit();
}

 
?>