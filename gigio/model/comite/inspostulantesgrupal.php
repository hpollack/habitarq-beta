<?php 
/*
=========================================
Ingreso de postulantes por llamado.
=========================================

- Algoritmo que ingresa los usuarios postulantes a una nomina.
- Por mientras esta solo para un llamado. Se debe optimizar para más 
  ya que pueden ser hasta 3 o 4 llamados de una misma postulación

*/

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

$pos = $_POST['cmt']; //Id del grupo/comite
$lmd = $_POST['lm']; //Id del llamado
$ps = $_POST['ps']; //Valores del array traído del controlador jquery


//Primera validación: Si existe la postulación del grupo.
$idpos = mysqli_fetch_row(mysqli_query($conn, "select idpostulacion from postulaciones where idgrupo = ".$pos.""));

if(!$idpos[0]) {

	//Si no existe, devuelve el mensaje a jquery y termina el proceso
	echo "2";
	exit();
}

//Segunda validación: Buscar el último llamado. Si existe al menos uno será guardado en la variable.
if ($lmd == 0) {

	//Si no existe devuelve el mensaje y termina el proceso
	echo "3";
	exit();
}

//Si se ha seteado algo desde la vista en el array
if (isset($ps)) {

	//Si la variable es un arreglo
	if (is_array($ps)) {		

		$postulantes = "";
		//Se recorre el arreglo y se verifica si trae datos
		foreach ($ps as $k) {
			
			//Se separa el rut de su dígito verificador
			$rut = explode("-", $k);

			//Se obtiene la última id ingresada en la tabla de lista_postulantes. En cada iteración traerá el último ingresado
			$id = obtenerid("lista_postulantes", "idpostulante");

			//Se consulta si ya tiene postulaciones y se trae el valor
			$lp = mysqli_fetch_row(mysqli_query($conn, "select count(idllamado_postulacion) from lista_postulantes where rutpostulante = '".$rut[0]."'"));

			//Se consulta si el rut existe en algun llamado
			$rp = mysqli_fetch_row(mysqli_query($conn, "select rutpostulante from lista_postulantes where idllamado_postulacion = '".$lmd."'"));

			

			//Si ya existe una, su estado será repostulado. En caso contrario se postulará por primera vez
			if ($lp[0] > 0) {
				
				//Si el rut se repite, continuará sin ingresarlo de nuevo
				if ($rut[0] == $rp[0]) {
					continue;
				}else {
					$estado = "Repostulado";
				}				
			}else {
				$estado = "Postulado";
			}
			
			//Se envía la transacción SQL del primer valor, se itera hasta el último			
			$postulantes = "insert into lista_postulantes(idpostulante, rutpostulante, idpostulacion, idllamado_postulacion, estado) ".
						   "values(".$id.", '".$rut[0]."', ".$idpos[0].", ".$lmd.", '".$estado."')";
			
			$sql = mysqli_query($conn, $postulantes);
			
		}
	}
	

	echo "1";


	$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/grupal.php', 'add members', ".time().");";

	mysqli_query($conn, $log);	   

}else {
	//Devuelve el mensaje de error
	echo "0";


	$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/comite.php', 'error add members', ".time().");";
	mysqli_query($conn, $log);	   	   
			   
}


mysqli_close($conn);
?>