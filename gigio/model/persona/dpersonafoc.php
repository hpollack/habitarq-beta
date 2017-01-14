<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
$conn = conectar();


$rut = mysqli_real_escape_string($conn, $_POST['rut']);

$persona  = mysqli_query($conn, "select rut, concat(nombres,' ',paterno,' ',materno) as nombre from persona where rut = '".$rut."'");
$traeRut = mysqli_fetch_row($persona);
if(!$traeRut){
	echo "no";
	exit();
}

//Datos Persona/Ficha

$persona = "select f.nficha, concat(p.rut,'-',p.dv) AS Rut, concat(p.nombres,' ',p.paterno,' ',p.materno	) AS nombre, ".
			"FROM_UNIXTIME(f.fecha_nacimiento), e.estado, ".
			"f.adultomayor, f.discapacidad, d.deficit ".
			"FROM frh AS f ".
			"INNER JOIN persona_ficha AS pf ON pf.nficha = f.nficha ".
			"INNER JOIN persona AS p ON pf.rutpersona = p.rut ".
			"INNER JOIN estado_civil AS e ON e.idestadocivil = f.idestadocivil ".
			"INNER JOIN deficit_habitacional AS d ON d.iddeficit = f.deficit ".
			"where pf.rutpersona = '".$rut."'";
$sqlpersona = mysqli_query($conn, $persona);

//Datos factores
if(!$sqlpersona){
	
	echo "Ocurrio un error en la transacción";
	exit();
}

echo "<div class='form-group'><h3 class='page-header'>Datos personales</h3>";

if ($p = mysqli_fetch_array($sqlpersona)) {	

	echo "<label class='col-md-4 control-label'>Número de Ficha: </label><p class='col-md-5'>".$p[0]."</p>";
	echo "<label class='col-md-4 control-label'>Rut: </label><p class='col-md-5'>".$p[1]."</p>";
	echo "<label class='col-md-4 control-label'>Nombre: </label><p class='col-md-5'>".$p[2]."</p>";
	echo "<label class='col-md-4 control-label'>Fecha de Nacimiento: </label><p class='col-md-5'>".fechanormal($p[3])."</p>";
	echo "<label class='col-md-4 control-label'>Estado Civil: </label><p class='col-md-5'>".$p[4]."</p>";	

	//Chequea si es adulto mayor
	$amayor = ($p[5]==1) ? "Si" : "No";

	//Chequea si es discapacitado
	$disc = ($p[6] == 1) ? "Si" : "No";

	echo "<label class='col-md-4 control-label'>Adulto Mayor: </label><p class='col-md-5'>".$amayor."</p>";
	echo "<label class='col-md-4 control-label'>Discapacidad: </label><p class='col-md-5'>".$disc."</p>";
	echo "<label class='col-md-4 control-label'> Déficit Habitacional: </label><p class='col-md-5'>".$p[7]."</p>";
}else{
	echo "Esta persona no existe o el rut esta mal ingresado";
	exit();
}

 ?>