<?php
session_start();
include_once '../../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

date_default_timezone_set("America/Santiago");

$fi = mysqli_real_escape_string($conn, $_POST['fi']);
$ff = mysqli_real_escape_string($conn, $_POST['ft']);
$us = mysqli_real_escape_string($conn, $_POST['us']);
$ac = mysqli_real_escape_string($conn, $_POST['act']);

if (!empty($fi)) {
	$inicio = strtotime(fechamy($fi));
}

if (!empty($ff)) {
	$final  = strtotime(fechamy($ff));
}



$criterio = "";

//Validaciones.
//El criterio se irá llenando de acuerdo a la condición.
if ((!empty($fi)) && (!empty($ff))) {
	if ($final < $inicio) {
		echo "0";
		exit();
	}

	$criterio = "where l.fecha between ".$inicio." and ".$final."";

}elseif ((!empty($fi)) && (!empty($ff)) && ($us != 0) && ($ac != "no")) {
	if ($final < $inicio) {
		echo "0";
		exit();
	}

	$criterio = "where l.fecha between ".$inicio." and ".$final." and l.usuario = '".$us."' and l.accion like '".$ac."%'";

}elseif ((!empty($fi)) && (!empty($ff)) && ($ac != "no")) {
	if ($final < $inicio) {
		echo "0";
		exit();
	}
	
	$criterio = "where l.fecha between ".$inicio." and ".$final." and l.action like '".$ac."%'";

}elseif ((!empty($fi)) && (!empty($ff)) && ($us != 0)) {
	if ($final < $inicio) {
		echo "0";
		exit();
	}
	
	$criterio = "where l.fecha between ".$inicio." and ".$final." and l.usuario = '".$us."'";

}elseif ((!empty($fi)) && ($us != 0) && ($ac != "no")) {
	$criterio = "where l.fecha >=  ".$inicio." and l.usuario = '".$us."' and l.accion like '".$ac."%'";

}elseif ((!empty($fi)) && ($us != 0)) {
	$criterio = "where l.fecha >=  ".$inicio." and l.usuario = '".$us."'";

}elseif ((!empty($fi)) && ($ac != "no")) {
	$criterio = "where l.fecha >=  ".$inicio." and l.accion like '".$ac."%'";		

}elseif ((!empty($ff)) && ($us != 0) && ($ac != "no")) {
	$criterio = "where l.fecha <=  ".$final." and l.usuario = '".$us."' and l.accion like '".$ac."%'";

}elseif ((!empty($ff)) && ($us != 0)) {
	$criterio = "where l.fecha <=  ".$final." and l.usuario = '".$us."'";

}elseif ((!empty($ff)) && ($ac != "no")) {
	$criterio = "where l.fecha <=  ".$final." and l.accion like '".$ac."%'";		

}elseif (($us != 0) && ($ac != "no")) {
	$criterio = "where l.usuario = '".$us."' and l.accion like '".$ac."%'";

}elseif($us!=0) {
	$criterio = "where l.usuario = '".$us."'";

}elseif ($ac != "no") {
	$criterio = "where l.accion like '".$ac."%'";

}elseif (!empty($fi)) {
	$criterio = "where l.fecha >= ".$inicio."";

}elseif (!empty($ff)) {
	$criterio = "where l.fecha <= ".$final."";

}else {
	$criterio = "";
}






$reg = 10;
$pag = false;
if(isset($pag)){
	$pag = $_GET['pag'];
}
if(!$pag){
	$inicio = 0;
	$pag = 1;
}else{
	$inicio = ($pag-1)*$reg;
}
$string = "select concat(u.nombre,' ',u.apellidos) as usuario, ".
		  "l.ip as IP, l.url as URL, l.accion, l.fecha ".
		  "from log as l ".
		  "inner join usuarios as u on u.idusuario = l.usuario $criterio order by l.fecha desc";

$sql = mysqli_query($conn, $string);
$total = mysqli_num_rows($sql);
$total_pag = ceil($total/$reg);
$pagina = $string." LIMIT ".$inicio.", ".$reg;

$sql2 = mysqli_query($conn, $pagina);
$cols = mysqli_num_fields($sql2);
?>
<div class="container">
	<div class="row">
		<div class="col-md-9 col-md-offset-0">
			<form class="form-horizontal" id="tcomite">
			<?php
				//echo $pagina;			
				if(mysqli_num_rows($sql2)>0){					
					$col = mysqli_fetch_fields($sql2);
					echo "<div class='table-responsive'>";
					echo "<h3 class='page-header'>Registros del Sistema</h3>";
					echo "<table id='lper' class='table table-bordered table-hover table-condensed table-striped'><thead><tr>";
					foreach ($col as $name) {
						echo "<th>".ucfirst($name->name)."</th>";
					}										
					//echo "<th>Quitar</th>";
					echo "</tr></thead></tbody>";
					
					while ($row = mysqli_fetch_array($sql2)) {
						echo "<tr>";
						echo "<td>".$row[0]."</td>";
						echo "<td>".$row[1]."</td>";
						echo "<td>".$row[2]."</td>";
						echo "<td>".$row[3]."</td>";
						echo "<td>".date("d/m/Y H:i:s", $row[4])."</td>";
						echo "</tr>";
					}

					echo "</tbody></table></div>";
					echo "<nav aria-label='page navigation' class='text-center'><ul class='pagination' style='align:center;'>";
					
					$ppag = 5; //cantidad de páginas
					$start = $pag - ($pag%$ppag)+1;
					
					if($start > $pag){
						$start = $start - $ppag;
					}
					
					$end = ($start + ($ppag-1) > $total_pag)? $total_pag : $start + ($ppag-1);

					if($total_pag>1){		 		
				 		if($start!=1){
				 			echo "<li><a href=\"javascript:paginarReg('".($start-1)."')\">&laquo; Anterior</a></li>";				 			
				 		}
				 		for ($j=$start; $j <= $end; $j++) {
				 			if($pag==$j){
				 				echo "<li class='active'><span>".$pag."</span></li>";
				 			}else{
				 				echo "<li><a href=\"javascript:paginarReg('".$j."')\">".$j."</a></li>";
				 			}		 			
				 		}
				 		if($j<=$total_pag){
				 			echo "<li><a href=\"javascript:paginarReg('".($j)."')\" aria-hidden='true'>Siguiente &raquo;</a></li>";
				 		}				 		
				 		
				 	}
				 	echo "</ul></nav>";
				}else{
					echo "<h4 class='text-center text-danger'>No existe o aun no se han ingresado datos<h4>";
				}
			?>
			</form>
		</div>
	</div>
</div>
