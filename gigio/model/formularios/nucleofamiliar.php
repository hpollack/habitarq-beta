<?php 
/*
===================================================================================
 DOCUMENTO DE DECLARACION DE NUCLEO FAMILIAR
===================================================================================

El número de miembros del núcleo familiar se extrae del valor agregado en el modulo ficha
Esto generará la cantidad de campos a agregar dentro del documento.
Por el momento no se guardan en la base de datos.
*/
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

//Valores del postulante
$rut = $_POST['rpers'];
$nom = $_POST['npers'];

/*
Variables que encierran los array de campos generados por el valor.
*/
$rt = $_POST['rt'];
$nt = $_POST['nom'];
$prt = $_POST['prt'];

$fecha = time(); //Fecha en formato Unix
$filas = count($rt); //Cantidad de filas generadas para los campos.



require_once '../../lib/php/phpword/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

$word = new \PhpOffice\PhpWord\TemplateProcessor('plantillas/declaracion.docx');

//Asignamos los valores a la plantilla
$word->setValue('rutpersona', $rut);
$word->setValue('nombre', $nom);
$word->setValue('fecha', fechaAl($fecha));

//Se clonan las filas en la tabla del documento donde irán los miembros del núcleo familiar
$word->cloneRow('tabpar', $filas);

//Valores del parentesco
foreach($prt as $p => $v) {
	$i = ($p+1);
	$word->setValue('tabpar#'.$i, $v);			
}

//Valores del rut de cada miembro
foreach ($rt as $r => $v) {
	$i = ($r+1);
	$word->setValue('tabrut#'.$i, $v);
}

//Valores del nombre de cada miembro
foreach($nt as $n => $v) {
	$i = ($n+1);
	$word->setValue('tabnom#'.$i, $v);
}	

$word->saveAs("plantillas/results/Declaracion ".$nom.".docx");

header("Content-Disposition: attachment; filename=Declaracion ".$nom.".docx; charset=iso-8859-1");

echo file_get_contents("plantillas/results/Declaracion ".$nom.".docx");
?>
