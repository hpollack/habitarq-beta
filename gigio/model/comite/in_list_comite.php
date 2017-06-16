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

$rut = mysqli_real_escape_string($conn, $_POST['rp']);
$idg = $_POST['cmt'];
$crg = $_POST['crg'];
$es  = $_POST['es'];

$string = "";

//Validaciones


//Si la persona ya fue asignada
$sqlexist = mysqli_query($conn, "select rutpersona, estado from persona_comite where rutpersona = '".$rut."'");
$exist = mysqli_fetch_row($sqlexist);

//Busca cuenta de la persona.
$sqlCuenta = mysqli_query($conn, "select ncuenta from cuenta_persona where rut_titular = '".$rut."'");
$cuenta = mysqli_fetch_row($sqlCuenta);

//Si la persona no posee cuenta, no puede postular.	
if((!$cuenta[0]) && ($es == "Postulante")) {
	echo "2";
	exit();
}

if(($exist[0]) && ($exist[1] != "Eliminado")){
	echo "3";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/listcomite.php', 'error add', ".time().");";
	mysqli_query($conn, $log);   	
	exit();	
}else if($exist[1] == "Eliminado"){
	//Si existe y fue eliminado, puede volver a ser integrado
	$string = "update persona_comite set idcargo = ".$crg.", estado = '".$es."' where rutpersona = '".$rut."' and idgrupo = ".$idg."";
}else{
	
	//Si no exite, se ingresa al listado
	$string = "insert into persona_comite(rutpersona, idgrupo, idcargo, estado) values('".$rut."', ".$idg.", ".$crg.", '".$es."')";
}

//Si los roles de presidente y secretario ya estan asignados
$rolexist = mysqli_query($conn, "select distinct idcargo from persona_comite where idgrupo = ".$idg." and idcargo = ".$crg."");
$rol = mysqli_fetch_row($rolexist);

if(($rol[0] == 2) || ($rol[0] == 3)){
	echo "4";
	exit();
}

/*
Existe un grupo llamado individual donde entran los beneficiarios que postulan por su cuenta
Solo ingresan los usuarios miembros, descartando los otros roles
Se puede definir mas adelante con el numero de idetificador como constante
*/
$indiv = mysqli_query($conn, "select nombre from grupo where idgrupo = ".$idg."");
$nombre = mysqli_fetch_row($indiv);

if($nombre[0] == "Individual"){
	if(($crg == 2) || ($crg == 3)){
		echo "5";
		exit();
	}
}
/*
Valida que el socio tenga ficha
*/
$ficha = mysqli_query($conn, "select rutpersona from persona_ficha where rutpersona = '".$rut."'");
$sqlFicha = mysqli_fetch_row($ficha);

if ((!$sqlFicha[0]) && ($es == "Postulante")) {
	echo "6";
	exit();
}

$sql = mysqli_query($conn, $string);


if($sql){
	
	echo "1";
		
}else{
	//echo mysqli_error();
	echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/listcomite.php', 'add', ".time().");";

mysqli_query($conn, $log);
mysqli_close($conn);

?>