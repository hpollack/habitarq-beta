<?php
session_start();
include_once '../lib/php/libphp.php';
unset($_SESSION['rut']);
$fin = salidasistema();
?>