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

$id = $_GET['id'];

$reg = 30;
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
$string = "select concat(p.rut, '-', p.dv) AS rut, p.nombres, concat(p.paterno, ' ', p.materno) AS apellidos, ".
		  "g.nombre AS `comité`, c.cargo, pc.estado ".
		  "FROM persona_comite AS pc INNER JOIN persona AS p ON pc.rutpersona = p.rut ".
		  "INNER JOIN grupo AS g ON pc.idgrupo = g.idgrupo ".
		  "INNER JOIN comite_cargo AS c ON pc.idcargo = c.idcargo ".		  
		  "WHERE pc.idgrupo = ".$id." and p.estado = 1";
		  

$sql = mysqli_query($conn, $string);
$total = mysqli_num_rows($sql);
$total_pag = ceil($total/$reg);
$pagina = $string." LIMIT ".$inicio.", ".$reg;
$sql2 = mysqli_query($conn, $pagina);
$cols = mysqli_num_fields($sql2);
?>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form class="form-horizontal" id="tcomite">
			<?php
				//echo $pagina;			
				if(mysqli_num_rows($sql2)>0){

					$col = mysqli_fetch_fields($sql2);
					echo "<div class='table-responsive'>";
					echo "<h3 class='page-header'>Listado de Personas Inscritas</h3>";
					echo "<table id='lper' class='table table-bordered table-hover table-condensed table-striped'><thead><tr>";
					foreach ($col as $name) {
						echo "<th>".ucfirst($name->name)."</th>";
					}										
					echo "<th>Quitar</th>";
					echo "</tr></thead></tbody>";
					
					while ($row = mysqli_fetch_array($sql2)) {

						echo "<tr>";
						echo "<td>".$row[0]."</td>";
						echo "<td>".ucwords($row[1])."</td>";
						echo "<td>".ucwords($row[2])."</td>";
						echo "<td>".$row[3]."</td>";
						echo "<td>".$row[4]."</td>";						
						echo "<td>".$row[5]."</td>";

						if ($row[5] == "Eliminado") {
							
							echo "<td class='text-center'><a class='btn btn-default btn-sm' disabled><i class='fa fa-ban'></i></a></td>";
						} else {
							
							echo "<td class='text-center'><a href='".url()."view/comite/elim_socio_motivo.php' data-target='#EliminaSocio' class='open-modal btn btn-danger btn-sm' data-toggle='modal' data-id='".$row[0]."'><i class='fa fa-trash'></i></a></td>";
						}						
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
				 			echo "<li><a href=\"javascript:paginar2('".($start-1)."', '".$id."')\">&laquo; Anterior</a></li>";				 			
				 		}
				 		for ($j=$start; $j <= $end; $j++) {
				 			if($pag==$j){
				 				echo "<li class='active'><span>".$pag."</span></li>";
				 			}else{
				 				echo "<li><a href=\"javascript:paginar2('".$j."', '".$id."')\">".$j."</a></li>";
				 			}		 			
				 		}
				 		if($j<=$total_pag){
				 			echo "<li><a href=\"javascript:paginar2('".($j)."', '".$id."')\" aria-hidden='true'>Siguiente &raquo;</a></li>";
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
