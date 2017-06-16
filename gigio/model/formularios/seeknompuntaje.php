<?php 
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

$ruk = mysqli_real_escape_string($conn, $_POST['ruk']);
$lmd = $_POST['lmd'];
$anio = $_POST['anio'];

$string = "select g.numero, g.nombre, count(lp.rutpostulante) as postulantes, ".
		  "round(avg(f.puntaje)) as prompuntaje, ".
		  "round(avg(v.anio_recepcion)) as promanio ".
		  "from frh as f ".
		  "inner join persona_ficha as pf on pf.nficha = f.nficha ".
		  "inner join persona as p on p.rut = pf.rutpersona ".
		  "inner join lista_postulantes as lp on lp.rutpostulante = pf.rutpersona ".
		  "inner join llamado_postulacion as ll on ll.idllamado_postulacion = lp.idllamado_postulacion ".
          "inner join llamados as l on l.idllamados = ll.idllamado ".
          "inner join postulaciones as ps on ps.idpostulacion = ll.idpostulacion ".
          "inner join grupo as g on g.idgrupo = ps.idgrupo ".
          "inner join persona_vivienda as pv on pv.rut = lp.rutpostulante ".
          "inner join vivienda as v on v.rol = pv.rol ".
          "where g.numero = ".$ruk." and ll.idllamado = ".$lmd." and ll.anio = ".$anio."";


$sql = mysqli_query($conn, $string);



if ($f = mysqli_fetch_array($sql)) {
	$pruk = $f[0];
	$pnom = $f[1];
	$ppos = $f[2];
	$pppr = ($f[3] != null) ? $f[3] : 0;
	$papr = ($f[4] != null) ? $f[4] : 0;
}else {
	$pruk = null;
	$pnom = null;
	$ppos = null;
	$pppr = null;
	$papr = null;
}

if ($sql) {
	
	$datos = array('pruk' => $pruk, 'anom' => $pnom, 'apos' => $ppos, 'ppr' => $pppr, 'apr' => $papr );
	echo json_encode($datos);
}else {
	echo "Error";
	exit();
}

mysqli_free_result($sql);
mysqli_close($conn);
?>