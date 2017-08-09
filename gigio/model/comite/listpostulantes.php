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
		  "g.nombre AS `comité`, c.cargo, pc.estado, cn.total as `total ahorro` ".		  
		  "FROM persona_comite AS pc INNER JOIN persona AS p ON pc.rutpersona = p.rut ".
		  "INNER JOIN grupo AS g ON pc.idgrupo = g.idgrupo ".
		  "INNER JOIN comite_cargo AS c ON pc.idcargo = c.idcargo ".
		  "INNER JOIN persona_ficha AS pf ON pf.rutpersona = p.rut ".
		  "INNER JOIN persona_vivienda AS pv ON pv.rut = p.rut ".
		  "INNER JOIN cuenta_persona AS cp ON cp.rut_titular = p.rut ".
		  "INNER JOIN cuenta AS cn ON cn.ncuenta = cp.ncuenta ".
		  "WHERE g.idgrupo = ".$id." AND p.estado = 1 AND pc.estado = 'Postulante'";

$sql = mysqli_query($conn, $string);

//Total de filas traídas
$total = mysqli_num_rows($sql);

//Se divide el total de filas por la cantidad de registros
//Se redondea el resultado.
$total_pag = ceil($total/$reg);

/*El mismo string de consulta es usado ahora con un LIMIT donde los parámetros
son la variablie inicio y la cantidad de registros
*/
$pagina = $string." LIMIT ".$inicio.", ".$reg;
$sql2 = mysqli_query($conn, $pagina);
$cols = mysqli_num_fields($sql2);
?>
<div class="container">
	<div class="row">
		<div class="col-md-9 col-md-offset-0">
			<form class="form-horizontal" id="tcomite">
				<input type="hidden" id="cmt" name="cmt" value="<?php echo $id; ?>">
				<div class="form-group">
					<label class="col-md-4 control-label" for="lm">Llamado: </label>
					<div class="col-md-4">
						<select id="lm" name="lm" class="form-control">
							<option value="0">Escoja llamado </option>
							<?php
							  $str = "select lp.idllamado_postulacion, concat(l.llamados,' de ', anio) as llamado ".
							            "from llamado_postulacion lp ".
							            "inner join llamados l on lp.idllamado = l.idllamados ".
							            "inner join postulaciones p on p.idpostulacion = lp.idpostulacion ".
							            "where p.idgrupo = ".$id."";
							 cargaCombo($str); 
							 ?>
						</select>
					</div>
				</div>				
			<?php
				//echo $pagina;			
				if(mysqli_num_rows($sql2)>0){					
					$col = mysqli_fetch_fields($sql2);
					echo "<div class='table-responsive'>";
					echo "<h3 class='page-header'>Listado de Postulantes</h3>";
					echo "<table id='lper' class='table table-bordered table-hover table-condensed table-striped'><thead><tr>";
					foreach ($col as $name) {
						echo "<th>".ucfirst($name->name)."</th>";
					}										
					echo "<th>Postular</th>";
					echo "</tr></thead></tbody>";
					
					while ($row = mysqli_fetch_array($sql2)) {
						/*
						Se separa el rut del dígito verificador y se compara con el ya existente
						en la tabla postulante.
						*/
						$rut = explode('-', $row[0]);
						$post = mysqli_fetch_array(mysqli_query($conn, "select rutpostulante from lista_postulantes where rutpostulante = '".$rut[0]."'"));

						echo "<tr>";
						echo "<td>".$row[0]."</td>";
						echo "<td>".ucwords($row[1])."</td>";
						echo "<td>".ucwords($row[2])."</td>";
						echo "<td>".$row[3]."</td>";
						echo "<td>".$row[4]."</td>";						
						echo "<td>".$row[5]."</td>";
						echo "<td>".$row[6]." UF</td>";
						
						if ($rut[0] == $post[0]) {
							echo "<td><input type='checkbox' id='ps".$row[0]."' name='ps[]' value='".$row[0]."' checked></td>";
						}else {
							echo "<td><input type='checkbox' id='ps".$row[0]."' name='ps[]' value='".$row[0]."'></td>";
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
				 			echo "<li><a href=\"javascript:paginar2(".($j)."', '".$id."')\" aria-hidden='true'>Siguiente &raquo;</a></li>";
				 		}
				 		
				 	}
				 	echo "</ul></nav>";
				}else{
					echo "<h4 class='text-center text-danger'>No existe o aun no se han ingresado datos<h4>";
				}
				?>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-0">
						<button type="button" class="btn btn-primary" id="pst"><i class="fa fa-paper-plane"></i> Enviar</button>
						<button type="button" class="btn btn-danger" id="cnl"><i class="fa fa-times"></i> Cancelar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
