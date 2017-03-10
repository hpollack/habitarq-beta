<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

$pos = $_POST['cmt']; //Id del grupo/comite
$ps = $_POST['ps']; //

if (isset($ps)) {

	if (is_array($ps)) {		

		$postulantes = "";
		foreach ($ps as $k) {

			$rut = explode("-", $k);
			$id = obtenerid("lista_postulantes", "idpostulante");			
			$postulantes = "insert into lista_postulantes(idpostulante, rutpostulante, idpostulacion) ".
						   "values(".$id.", '".$rut[0]."', ".$pos.")";
			
			$sql = mysqli_query($conn, $postulantes);
			
		}
	}

	$respuesta = ($count == 1)	? "postulante" : "postulantes";

	echo "1";


}else {
	echo "0";
}

mysqli_close($conn);
?>