<?php 
session_start();

include_once '../../lib/php/libphp.php';

$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rp']);
$idg = $_POST['cmt'];
$crg = $_POST['crg'];

//Validaciones


//Si la persona ya fue asignada
$sqlexist = mysqli_query($conn, "select rutpersona from persona_comite where rutpersona = '".$rut."'");
$exist = mysqli_fetch_row($sqlexist);
if($exist[0]){
	echo "2";
	exit();
}

//Si los roles de presidente y secretario ya estan asignados
$rolexist = mysqli_query($conn, "select distinct idcargo from persona_comite where idgrupo = ".$idg." and idcargo = ".$crg."");
$rol = mysqli_fetch_row($rolexist);

if(($rol[0] == 2) || ($rol[0] == 3)){
	echo "2";
	exit();
}

/*
Existe un grupo llamado individual donde entran los beneficiarios que postulan por su cuenta
Solo ingresan los usuarios miembros, descartando los otros roles
*/
$indiv = mysqli_query($conn, "select nombre from grupo where idgrupo = ".$idg."");
$nombre = mysqli_fetch_row($indiv);

if($nombre[0] == "Individual"){
	if(($crg == 2) || ($crg == 3)){
		echo "3";
		exit();
	}
}


$string = "insert into persona_comite(rutpersona, idgrupo, idcargo) values('".$rut."', ".$idg.", ".$crg.")";

$sql = mysqli_query($conn, $string);


if($sql){
	
	echo "1";
		
}else{
	echo "0";
	exit();
}

mysqli_close($conn);

?>