<?php
/**
 * =====================================================
 * Ingreso de datos de la ficha
 * =====================================================
 * Este script escribe los datos principales de la ficha 
 * además, crea los factores de esta ficha los cuales, serán asociados
 * a esta y la persona.
 * 
 * @author Hermann Pollack
 * @version 1.0
*/
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rut']); //RUT de la persona
$ec  = mysqli_real_escape_string($conn, $_POST['ec']); //Estado Civil
$fnac = mysqli_real_escape_string($conn, $_POST['fnac']); // Fecha de Nacimiento
$tmo = mysqli_real_escape_string($conn, $_POST['tmo']); // Tramo
$dh  = mysqli_real_escape_string($conn, $_POST['dh']); //Déficit Habitacional
$gfm = mysqli_real_escape_string($conn, $_POST['gfm']);
$adm = (isset($_POST['adm']))? 1 : 0; //Adulto Mayor (Check)
$ds =  (isset($_POST['ds']))? 1 : 0; // Discapacidad (Check)
$ch = $_POST['ch']; // Carencias (array con los datos de los checkbox asociados)

# Puntaje: Por defecto Cero, Dependerá de lo escogido en el tramo.
$pnt = 0; 

# Se transforma la fecha a formato MySQL
$fecha = fechamy($fnac);

# Se trae el la edad de la persona
$edad = esAdultoMayor($fecha);

# Se trae el sexo (de estar ingresado) de la persona.
$sexo = traerSexoPersona($rut);

# Edad por defecto 0
$mEdad = 0;

# Se valida el sexo y se calcula la edad, dependiendo de los valores de configuracion
if ($sexo == "M") {

	$mEdad = traerValorConfig("AdultoMayorVaron");
} else {

	$mEdad = traerValorConfig("AdultoMayorMujer");
}
/**
 * Traido el valor, se valida que la edad sea correcta
 * A la vez se debe comprobar si la edad es correcta con el parámetro
 * de adulto mayor. Si la edad de la persona es menor y el check esta activo,
 * se envía respuesta y deja de ejecutar.
 **/ 
if (($edad < $mEdad) && ($adm == 1)) {
	
	echo "no";
	exit();
}

# Se verifica el tramo, de acuerdo al valor traído por el id del tramo
# Se asigna valor a la variable $pnt de acuerdo al valor verificado
switch ($tmo) {
	case 1:
		$pnt = 40;
		break;
	case 2:
		$pnt = 50;
	case 3:
		$pnt = 60;
		break;
	case 4;
		$pnt = 70;
		break;
	case 5:
		$pnt = 80;
		break;
	case 6:
		$pnt = 90;
		break;
	case 7 : 
		$pnt = 100;
		break;					
	default:		
		break;
}

# Se crea la sentencia.
$string = "insert into frh (idestadocivil, fecha_nacimiento, tramo, puntaje, deficit, nucleo_familiar, adultomayor, discapacidad) ".
"values(".$ec.", ".strtotime($fecha).", ".$tmo.", ".$pnt.", ".$dh.", ".$gfm.", ".$adm.", ".$ds.")";

#
$sql = mysqli_query($conn, $string);

# Se verifica que sea correcta
if(!$sql){
	//echo mysqli_error($conn);
	echo "<strong>Ocurrió un error en el ingreso de datos</strong>";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/ficha.php', 'error add', ".time().");";

	mysqli_query($conn, $log);

	exit();
}

#Se trae el id del usuario (es autoincrementable en la tabla)
$id = mysqli_insert_id($conn);

#Se ingresa la asoiación de datos en la tabla que las une.
$sql2 = mysqli_query($conn, "insert into persona_ficha(rutpersona, nficha) values('".$rut."', ".$id.")");

/**
 * Insertar factores: Estos valores deben crearse en la tabla correspondiente
 * con los parámetros clave => valor.  
**/
$traeFactores = mysqli_query($conn, "select * from factores_carencia");

if($traeFactores){

	$insertFactores = "";

	while ($f=mysqli_fetch_array($traeFactores)){
		$insertFactores = "insert into ficha_factores(nficha, factor, valor) values(".$id.", ".$f[0].", 0);";
		mysqli_query($conn, $insertFactores);
	}
	
}
/**
 * Actualiza factores checkeados: Una vez creados, se procede a escribir los valores
 * provenientes del array generado por los checkbox que han sido
 * marcados. Si vienen marcados, los valores serán uno. En caso contrario,
 * mantendrán el valor 0
**/
if(isset($ch)){

	if(is_array($ch)){		
		//$num = count($ch);
		$actualizaFactores = "";

		foreach ($ch as $k => $v) {
			$actualizaFactores = "update ficha_factores set valor = 1 where nficha = ".$id." and factor = ".$v.";";
			mysqli_query($conn, $actualizaFactores);
		}
		
	}
}

echo "<strong>Datos Agregados</strong>";
$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/ficha.php', 'add', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);


?>