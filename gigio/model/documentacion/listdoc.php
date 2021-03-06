<?php
/*
=========================================================
Lista de Documentos
=========================================================
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

$id = $_GET['id'];

$conn = conectar();

//Se setea la zona horaria para las fechas.
date_default_timezone_set("America/Santiago");
/*
Listado que trae registros de comites con paginador en ajax. Este paginador funciona con una funcion escrita en 
javascript que recibe los parámetros
de el numero de pagina y un valor a buscar.
*/

$reg = 20; //Numero de registros por pagina
$pag = false; //Cantidad de paginas. Comienza con un valor falso

// la variable $criterio muestra una porcion de la consulta en la cual,
// se evaluan que las condiciones sean las que entrega la variable $busc. Si no se ingresa nada, la variable se mantiene vacia

//Si se ha seteado un valor en $pag, se genera un valor get.
if(isset($pag)){
	$pag = $_GET['pag'];
}
//Se comprueba si existe la variable. Si existe toma el valor 1

if(!$pag){
	$inicio = 0;
	$pag = 1;
}else{
	$inicio = ($pag-1)*$reg;
}

//Consulta SQL concatenada con el valor de la variable criterio
$string = "select id, nombre, enlace from documentos where directorio = ".$id."";

$sql = mysqli_query($conn, $string);
$total = mysqli_num_rows($sql);

//Total de paginas se obtiene con la division redondeada del total de filas por lo registros
$total_pag = ceil($total/$reg);

//criterio que aplica la sentencia LIMIT de MySQL para generar las paginas y se une al string anterior
$pagina = $string." LIMIT ".$inicio.", ".$reg;
/*
 Se ejecuta nuevamente la consulta en otra instancia agregando el LIMIT
*/
$sql2 = mysqli_query($conn, $pagina);
$cols = mysqli_num_fields($sql2); //cantidad de columnas que trae la sentencia
?>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-0">
			<?php							
				if(mysqli_num_rows($sql2)>0){
					
					echo "<div class='table-responsive'>";
					echo "<h3 class='page-header'>Listado de Documentos.</h3>";
					echo "<table id='lper' class='table table-bordered table-hover table-condensed table-striped'><thead><tr>";

					echo "<th>Nombre del Archivo</th>";
					echo "<th>Enlace</th>";
					if ($perfil == 1) {
						# code...
						echo "<th width='3%'>Eliminar</th>";
					}
					
					echo "</tr></thead></tbody>";
					while ($row = mysqli_fetch_array($sql2)) {

						# Crea el enlace
						$link = explode('/', $row[2]);

						# Extrae el nombre del archivo
						$nom  = explode('.', $row[1]);

						echo "<tr>";
						echo "<td>".$nom[0]."</td>";
						echo "<td><a href='".$row[2]."'>".$link[7]."</a></td>";												
						if ($perfil == 1) {
							# code...
							echo "<td width='3%'><a href=\"javascript:borrarArchivos('".$row[0]."', '".$row[2]."', '".$id."')\" class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a></td>";
						}
						echo "</tr>";
					}
					echo "</tbody></table></div>";
					echo "<nav aria-label='page navigation' class='text-center'><ul class='pagination' style='align:center;'>";

					//La siguiente operacion permite limitar la cantidad de paginas que se visualizaran en el paginador
					//Si tenemos una cantidad de paginas de 5 y registros por pagina de 10, se generaran enlaces adicionales contando
					//de 5 en 5 las páginas
					$ppag = 5; //cantidad de páginas

					/*variable de inicio: se obtiene restando el numero de pagina por el resto de la division entre el mismo
					  numero por la cantidad de paginas a desplegar mas 1
					  Si es mayor al numero de pagina que llega por get, entonces se resta por el numero de paginas
					*/
					$start = $pag - ($pag%$ppag)+1;
					if($start > $pag){
						$start = $start - $ppag;
					}
					/*
					variable de finalizacion: se obtiene si la suma del inicio por la resta del numero de paginas-1 es mayor al 
					total de paginas, entonces se deja el total de paginas. Si no se realiza la suma anteriormente mencionada
					*/
					$end = ($start + ($ppag-1) > $total_pag)? $total_pag : $start + ($ppag-1);

					//Paginacion 
					if($total_pag>1){		 		
				 		
				 		if($start!=1){
				 			
				 			echo "<li><a href=\"javascript:listdoc('".($start-1)."', '".$id."')\">&laquo; Anterior</a></li>"; 			
				 		}
				 		
				 		for ($j=$start; $j <= $end; $j++) {
				 			
				 			if($pag==$j){
				 				
				 				echo "<li class='active'><span>".$pag."</span></li>";
				 			}else{
				 				
				 				echo "<li><a href=\"javascript:listdoc('".$j."', '".$id."')\">".$j."</a></li>";
				 			}		 			
				 		}
						
						/*
						Si el valor de j es mayor a 5 y menor al total de la página crea un enlace nuevo
						al siguiente grupo de paginas;
						*/

				 		if($j<=$total_pag){
				 			
				 			echo "<li><a href=\"javascript:listdoc('".($j)."', '".$id."')\" aria-hidden='true'>Siguiente &raquo;</a></li>";
				 		}
				 		
				 	}
				 	
				 	echo "</ul></nav>";
				}else{
					
					echo '<div class="alert alert-warning">							
							<strong>Aun no se han subido archivos.</strong>
						</div>';					
				}
			?>
		</div>
	</div>	
</div>