<?php
/*
Listado que trae registros de personas con paginador en ajax. Este paginador funciona con una funcion escrita en javascript que recibe los parámetros
de el numero de pagina y un valor a buscar.
*/
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();
//Valor a busca enviado por post
$busc = $_POST['busc'];

//Cantidad de registros a aparecer. La pagina se inicia como un valor falso
$reg = 10;
$pag = false;

if(!empty($busc)){
	$criterio = "and concat(rut,'-',dv) like '%".$busc."%' or concat(nombres,' ',paterno,' ',materno) LIKE '%".$busc."%'";
}else{
	$criterio = "";
}
if(isset($pag)){
	$pag = $_GET['pag'];
}
if(!$pag){
	$inicio = 0;
	$pag = 1;
}else{
	$inicio = ($pag-1)*$reg;
}
$string = "select concat(rut,'-',dv) as rut, nombres, concat(paterno,' ',materno) as apellidos, correo from persona WHERE estado = 1 $criterio";
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
			<?php							
				if(mysqli_num_rows($sql2)>0){
					$col = mysqli_fetch_fields($sql2);
					echo "<div class='table-responsive'>";
					echo "<h3 class='page-header'>Listado de Personas Inscritas</h3>";
					echo "<table id='lper' class='table table-bordered table-hover table-condensed table-striped'><thead><tr>";
					foreach ($col as $name) {
						echo "<th>".ucfirst($name->name)."</th>";
					}
					echo "<th>Ver</th>";					
					echo "<th>Quitar</th>";
					echo "</tr></thead></tbody>";
					while ($row = mysqli_fetch_array($sql2)) {
						echo "<tr>";
						echo "<td>".$row[0]."</td>";
						echo "<td>".$row[1]."</td>";
						echo "<td>".$row[2]."</td>";
						echo "<td>".$row[3]."</td>";
						echo "<td class='text-center'><a href='#myModal' class='open-modal btn btn-primary' data-toggle='modal' data-id='".$row[0]."'><i class='fa fa-eye'></i></a></td>";
						echo "<td class='text-center'><a class='btn btn-danger' href=\"javascript:deleteLista('".$row[0]."')\"><i class='fa fa-trash'></i></td>";
						echo "</tr>";
					}
					echo "</tbody></table></div>";
					echo "<nav aria-label='page navigation' class='text-center'><ul class='pagination' style='align:center;'>";
					$ppag = 5; //cantidad de páginas
					
					//La siguiente operacion permite limitar la cantidad de paginas que se visualizaran en el paginador
					//Si tenemos una cantidad de paginas de 5 y registros por pagina de 10, se generaran enlaces adicionales contando
					//de 5 en 5 las páginas
					$start = $pag - ($pag%$ppag)+1;
					if($start > $pag){
						$start = $start - $ppag;
					}
					$end = ($start + ($ppag-1) > $total_pag)? $total_pag : $start + ($ppag-1);

					if($total_pag>1){		 		
				 		if($start!=1){
				 			echo "<li><a href=\"javascript:paginar2('".($start-1)."')\">&laquo; Anterior</a></li>";				 			
				 		}
				 		for ($j=$start; $j <= $end; $j++) {
				 			if($pag==$j){
				 				echo "<li class='active'><span>".$pag."</span></li>";
				 			}else{
				 				echo "<li><a href=\"javascript:paginar2('".$j."')\">".$j."</a></li>";
				 			}		 			
				 		}
				 		if($j<=$total_pag){
				 			echo "<li><a href=\"javascript:paginar2('".($j)."')\" aria-hidden='true'>Siguiente &raquo;</a></li>";
				 		}
				 		
				 	}
				 	echo "</ul></nav>";
				}else{
					echo "<h4 class='text-center text-danger'>No existe o aun no se han ingresado datos<h4>";
				}
			?>
		</div>
	</div>	
</div>
