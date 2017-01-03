<?php
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();
$rut = $_POST['rut'];
$datos = array();
$chk = 'ch';
$stringf = "select
				ff.factor, ff.valor
			FROM
				ficha_factores AS ff
			INNER JOIN frh AS f ON ff.nficha = f.nficha
			INNER JOIN persona_ficha AS pf ON pf.nficha = f.nficha
			WHERE
				pf.rutpersona = '".$rut."'";
$sqlf = mysqli_query($conn,$stringf);
$n = mysqli_num_rows($sqlf);
if($n > 0){
	for($i=0;$i<$n;$i++){		
		if($f=mysqli_fetch_array($sqlf)){
			if($f[1]==1){
				$k[$i]=$chk.$f[0];
				$datos[$k[$i]]=$f[0];
			}
		}
	}
	echo json_encode($datos);
}
mysqli_free_result($sqlf);
mysqli_close($conn);

?>