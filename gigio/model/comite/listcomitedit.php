<?php
/*
=========================================================
Lista de comites
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


$conn = conectar();

//Se setea la zona horaria para las fechas.
date_default_timezone_set("America/Santiago");
/*
Listado que trae registros de comites con paginador en ajax. Este paginador funciona con una funcion escrita en javascript que recibe los parámetros
de el numero de pagina y un valor a buscar.
*/

//Variable que almacena el texto de busqueda
$busc = mysqli_real_escape_string($conn, $_POST['busc']);
$reg = 30; //Numero de registros por pagina
$pag = false; //Cantidad de paginas. Comienza con un valor falso

// la variable $criterio muestra una porcion de la consulta en la cual se evaluan que las condiciones sean las que entrega la variable $busc. Si no se ingresa nada, la variable se mantiene vacia

if(!empty($busc)){
	$criterio = "and g.numero like '%".$busc."%' or g.nombre LIKE '%".$busc."%'";
}else{
	$criterio = "";
}

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
$string = "select 
		   g.numero AS rukam,
		   g.nombre,
		   from_unixtime(g.fecha) AS creado,
		   g.personalidad,
		   (
			    select count(distinct rutpostulante) from lista_postulantes as lp
				inner join llamado_postulacion as ll on ll.idllamado_postulacion = lp.idllamado_postulacion
				inner join postulaciones as p on p.idpostulacion = lp.idpostulacion
				inner join grupo as q on q.idgrupo = p.idgrupo
				where q.idgrupo = g.idgrupo
			) as postulantes
		   FROM
		   grupo AS g
		   INNER JOIN comuna AS c ON g.idcomuna = c.COMUNA_ID
		   WHERE
		   g.estado = 1 $criterio order by g.numero asc";


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
					$col = mysqli_fetch_fields($sql2);
					echo "<div class='table-responsive'>"; // La tabla está dentro de este div de limites definidos con scroll.
					echo "<h3 class='page-header'>Listado de Comités</h3>";
					echo "<table id='lper' class='table table-bordered table-hover table-condensed table-striped'><thead><tr>";

					//Se obtiene el nombre de las columnas. La funcion ucfirst() devuelve los nombres con la primera letra en mayuscula
					foreach ($col as $name) {
						echo "<th>".ucfirst($name->name)."</th>";
					}					
					echo "<th width='5%'>Ver</th>";
					echo "</tr></thead></tbody>";
					while ($row = mysqli_fetch_array($sql2)) {
						echo "<tr>";
						echo "<td>".$row[0]."</td>";
						echo "<td>".$row[1]."</td>";
						echo "<td>".fechanormal($row[2])."</td>";
						echo "<td>".$row[3]."</td>";
						echo "<td width='3%'><span class='badge' style='font-size:14px;'>".$row[4]."</span></td>";						
						echo "<td class='text-center'><a href='".url()."view/comite/editbulkpost.php?ruk=".$row[0]."' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a></td>";
						
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
				 			echo "<li><a href=\"javascript:paginar3('".($start-1)."')\">&laquo; Anterior</a></li>";				 			
				 		}
				 		for ($j=$start; $j <= $end; $j++) {
				 			if($pag==$j){
				 				echo "<li class='active'><span>".$pag."</span></li>";
				 			}else{
				 				echo "<li><a href=\"javascript:paginar3('".$j."')\">".$j."</a></li>";
				 			}		 			
				 		}
						/*
						Si el valor de j es mayor a 5 y menor al total de la página crea un enlace nuevo
						al siguiente grupo de paginas;
						*/
						
				 		if($j<=$total_pag){
				 			
				 			echo "<li><a href=\"javascript:paginar3('".($j)."')\" aria-hidden='true'>Siguiente &raquo;</a></li>";
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