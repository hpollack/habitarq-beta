<?php
/*
===============================================================================
Actualiza informacion de ficha
===============================================================================


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
$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$ec  = mysqli_real_escape_string($conn, $_POST['ec']);
$fnac = mysqli_real_escape_string($conn, $_POST['fnac']);
$tmo = mysqli_real_escape_string($conn, $_POST['tmo']);
$dh  = mysqli_real_escape_string($conn, $_POST['dh']);
$gfm = mysqli_real_escape_string($conn, $_POST['gfm']);
$adm = (isset($_POST['adm']))? 1 : 0;
$ds =  (isset($_POST['ds']))? 1 : 0;
$fch = $_POST['fch'];
$ch = $_POST['ch'];

$pnt = 0;

$fecha = fechamy($fnac);

$edad = esAdultoMayor($fecha);
$sexo = traerSexoPersona($rut);



if ($sexo == "M") {
	$mEdad = traerValorConfig("AdultoMayorVaron");
}else {
	$mEdad = traerValorConfig("AdultoMayorMujer");
}

if(($edad < $mEdad) && ($adm == 1)){
	echo "no";
	exit();
}

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



$string = "update frh set tramo = ".$tmo.", puntaje = ".$pnt.", nucleo_familiar = ".$gfm.", deficit = ".$dh.", 
		   fecha_nacimiento = ".strtotime($fecha).", idestadocivil = ".$ec.", adultomayor = ".$adm.", 
		   discapacidad = ".$ds." where nficha = ".$fch."";
$sf = "select ff.factor, ff.valor
		FROM ficha_factores AS ff
		INNER JOIN frh AS f ON ff.nficha = f.nficha
		INNER JOIN persona_ficha AS pf ON pf.nficha = f.nficha
		WHERE ff.nficha = ".$fch."";
$sql = mysqli_query($conn,$string);
if(!$sql){
	echo "Ocurrió un error";
	exit();
}
/*
Actualiza los valores de los checkbox creados
*/

//setea los valores marcados
if(isset($ch)){	

	//Si es un array
	if(is_array($ch)){
		//Se recorre el array generado y se obtienen los valores		
		for($i=0;$i<count($ch);$i++){		
			$ff = mysqli_query($conn, $sf." and ff.factor = ".$ch[$i]."");
			/*
			Se obtienen los valores de acuerdo al factor marcado.
			Si los existentes en la base de datos coinciden con las claves traídas desde la vista y no estan marcados,
			se les agrega el valor 1. 
			Por otra parte si no vienen marcados desde la vista pero si lo estan en la base de datos,
			se les da valor 0 a los que sean distinto a los índices traídos			
			*/
			
			if($f=mysqli_fetch_row($ff)){				
				if($f[1]==0){
					$actualizaFactores = "update ficha_factores set valor = 1 where factor = ".$ch[$i]." and nficha = ".$fch.";";
				}else{					
					$actualizaFactores =  "update ficha_factores set valor = 0 where factor <> ".$ch[$i]." and nficha = ".$fch.";";
				}

				mysqli_query($conn, $actualizaFactores);
			}					
		}
	}
}

echo "<strong>Datos actualizados</strong>";


mysqli_commit($conn);

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/ficha.php', 'update', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);

?>