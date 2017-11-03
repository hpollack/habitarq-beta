<?php 
session_start();
include_once '../../lib/php/libphp.php';
$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

# Codigo RUKAM
$ruk = $_POST['ruk'];
$lmd = $_POST['llmd'];
$anio = $_POST['anio'];

# Datos del grupo
$datosGrupo = "select g.nombre, g.numero, c.COMUNA_NOMBRE, r.REGION_ID from grupo as g ".
			  "inner join comuna as c on c.COMUNA_ID = g.idcomuna ".
			  "inner join provincia as p on p.PROVINCIA_ID = c.COMUNA_PROVINCIA_ID ".
			  "inner join region as r on r.REGION_ID = p.PROVINCIA_REGION_ID ".
			  "where g.numero = ".$ruk."";
$programa = "select concat(tt.titulo,' (',ip.item_postulacion,')'), tp.idtipopostulacion as programa ".
    		"from postulaciones as p ".
    		"inner join grupo as g on p.idgrupo = g.idgrupo ".
    		"inner join profesional_postulacion as pp on pp.idpostulacion = p.idpostulacion ".
    		"inner join item_postulacion as ip on p.item_postulacion = ip.iditem_postulacion ".
    		"inner join tipopostulacion as tp on ip.idtipopostulacion = tp.idtipopostulacion ".
    		"inner join titulo_postulacion as tt on tt.idtitulo_postulacion = tp.idtitulo ".
    		"inner join llamado_postulacion lp on lp.idpostulacion = p.idpostulacion ".
    		"where g.numero = ".$ruk." and lp.idllamado = ".$lmd." and lp.anio = ".$anio."";

$postulantes = "select concat(p.nombres,' ', p.paterno,' ', p.materno) as postulante,cp.ncuenta, cn.ahorro, ".
			"cn.subsidio, cn.total, p.rut, p.dv ".	
			"from persona_comite AS pc ".
			"INNER JOIN persona AS p ON pc.rutpersona = p.rut ".
			"INNER JOIN grupo AS g ON pc.idgrupo = g.idgrupo ".
			"INNER JOIN comite_cargo AS c ON pc.idcargo = c.idcargo ".
			"INNER JOIN persona_ficha AS pf ON pf.rutpersona = p.rut ".
			"INNER JOIN persona_vivienda AS pv ON pv.rut = p.rut ".
			"INNER JOIN cuenta_persona AS cp ON cp.rut_titular = p.rut ".
			"INNER JOIN cuenta AS cn ON cn.ncuenta = cp.ncuenta ".
			"INNER JOIN lista_postulantes AS lp ON lp.rutpostulante = pc.rutpersona ".
			"INNER JOIN llamado_postulacion AS llp ON llp.idllamado_postulacion = lp.idllamado_postulacion ".
			"INNER JOIN postulaciones AS ps ON ps.idgrupo = g.idgrupo AND llp.idpostulacion = ps.idpostulacion ".
			"WHERE g.numero = ".$ruk." AND p.estado = 1 AND llp.idllamado = ".$lmd." and llp.anio = ".$anio." ".
			"AND pc.estado = 'Postulante' order by p.paterno asc"; 


?>