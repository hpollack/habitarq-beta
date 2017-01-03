<?php
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
$conn = conectar();
$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$ec  = mysqli_real_escape_string($conn, $_POST['ec']);
$fnac = mysqli_real_escape_string($conn, $_POST['fnac']);
$tmo = mysqli_real_escape_string($conn, $_POST['tmo']);
$pnt = mysqli_real_escape_string($conn, $_POST['pnt']);
$dh  = mysqli_real_escape_string($conn, $_POST['dh']);
$gfm = mysqli_real_escape_string($conn, $_POST['gfm']);
$adm = (isset($_POST['adm']))? 1 : 0;
$ds =  (isset($_POST['ds']))? 1 : 0;
$fch = $_POST['fch'];
$ch = $_POST['ch'];

$fecha = fechamy($fnac);

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



if(isset($ch)){	
	if(is_array($ch)){
		for($i=0;$i<count($ch);$i++){		
			$ff = mysqli_query($conn, $sf." and ff.factor = ".$ch[$i]."");			
			if($f=mysqli_fetch_array($ff)){					
				if($f[1]==0){
					// echo "update ficha_factores set valor = 1 where factor = ".$ch[$i]." and nficha = ".$fch.";<br>";
					mysqli_query($conn, "update ficha_factores set valor = 1 where factor = ".$ch[$i]." and nficha = ".$fch.";");
				}else{
					//echo "update ficha_factores set valor = 0 where factor <> ".$ch[$i]." and nficha = ".$fch.";<br>";
					mysqli_query($conn, "update ficha_factores set valor = 0 where factor <> ".$ch[$i]." and nficha = ".$fch.";");
				}
			}			
		}
	}
}
echo "Datos actualizados";

mysqli_commit($conn);
mysqli_close($conn);

?>