<?php 
session_start();
include_once '../../lib/php/libphp.php';

date_default_timezone_set("America/Santiago");
set_time_limit(60);

$rutus = $_SESSION['rut'];
if(!$rutus) {
	echo "No puede ver esta página";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$rut = $_POST['rpers'];
$nom = $_POST['npers'];

$rt = $_POST['rt'];
$nt = $_POST['nom'];
$prt = $_POST['prt'];


?>