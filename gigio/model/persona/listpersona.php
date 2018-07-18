<?php
/**
 * =========================================================
 *  Lista de personas inscritas con paginacion
 * =========================================================
 * 
 * Lista de datos personas, desplegadas en una tabla paginada de 5 en 5, 
 * con 10 registros por página (constante que se puede cambiar en la variable integer $reg)
 * 
 * El paginado en la vista se realiza mediante una funcion ajax con JQuery, además de eso
 * tiene un buscador, el cual, permite, mediate ingreso por teclado, hacer un filtrado rapido
 * por nombre y apellido. 
 * 
 * @author Hermann Pollack.
 * @version 1.1: se actualizó el criterio, para que no muestre ls registros eliminados.
 * @param string $busc: parámetro opcional que busca por rut, nombre o apellidos
 * @return la lista completa, en caso de que el parámetro, venga vacío.
**/
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();
/*
Listado que trae registros de personas con paginador en ajax. Este paginador funciona con una funcion escrita en javascript que recibe los parámetros
de el numero de pagina y un valor a buscar.

- Se actualizó el criterio para que no muestre los eliminados.
*/

//Variable que almacena el texto de busqueda
$busc = mysqli_real_escape_string($conn, $_POST['busc']); //Texto a buscar
$reg = 50; //Numero de registros por pagina
$pag = false; //Cantidad de paginas. Comienza con un valor falso

// la variable $criterio muestra una porcion de la consulta en la cual se evaluan que las condiciones sean las que entrega la variable $busc. Si no se ingresa nada, la variable se mantiene vacia. Se han puesto paréntesis para que sea tomada como una sola condición.
if (!empty($busc)) {

	$criterio = "and (concat(rut,'-',dv) like '%".$busc."%' or concat(nombres,' ',paterno,' ',materno) LIKE '%".$busc."%')";
} else {

	$criterio = "";
}

if (isset($pag)) {
	# Si se ha seteado un valor en $pag, se genera un valor get.
	$pag = $_GET['pag'];
}

//Se comprueba si existe la variable. Si existe toma el valor 1

if(!$pag){
	# Si no existe la variable, se dan los valores por defecto
	$inicio = 0;
	$pag = 1;
}else{
	$inicio = ($pag-1)*$reg;
}

//Consulta SQL concatenada con el valor de la variable criterio
$string = "select concat(rut,'-',dv) as rut, nombres, concat(paterno,' ',materno) as apellidos, correo from persona WHERE estado = 1 $criterio";

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
		<div class="col-lg-11 col-lg-offset-0">
			<?php							
				if(mysqli_num_rows($sql2)>0){

					$col = mysqli_fetch_fields($sql2);
					echo "<div class='table-responsive'>";					
					echo "<h3 class='page-header'>Listado de Personas Inscritas</h3>";
					echo "<table id='lper' class='table table-bordered table-hover table-condensed table-striped'><thead><tr>";
					echo "<th>N&deg;</th>";

					//Se obtiene el nombre de las columnas. La funcion ucfirst() devuelve los nombres con la primera letra en mayuscula
					foreach ($col as $name) {

						echo "<th>".ucfirst($name->name)."</th>";
					}					

					//Columnas de las acciones a realizar en la tabla
					echo "<th>Ver</th>";
					echo "<th>Quitar</th>";
					echo "</tr></thead></tbody>";

					$n = 1;
					while ($row = mysqli_fetch_array($sql2)) {
						
						echo "<tr>";
						echo "<td>".$n."</td>";
						echo "<td>".$row[0]."</td>";
						echo "<td>".$row[1]."</td>";
						echo "<td>".$row[2]."</td>";
						echo "<td>".$row[3]."</td>";

						# En esta acción, se puede ver un modal con los datos principales de la fila						
						echo "<td class='text-center'><a href='#myModal' class='open-modal btn btn-info btn-sm' data-toggle='modal' data-id='".$row[0]."'><i class='fa fa-eye'></i></a></td>";

						# Esta acción permite "borrar" -desactivar- la fila. 
						# Cuando esto ocurre, previa confirmación, la fila desaparece de la lista.
						echo "<td class='text-center'><a class='btn btn-danger btn-sm' href=\"javascript:deleteLista('".$row[0]."')\"><i class='fa fa-trash'></i></td>";
						echo "</tr>";

						$n++;

						
					}
					echo "</tbody></table></div>";

					$regs = ($total == 1) ? "registro" : "registros";
					$pages = ($total_pag == 1) ? "página" : "páginas";
					echo "<h5><b>Total de registros:</b> ".$total." ".$regs." en ".$total_pag." ".$pages."</h5></br>";
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
					
					if ($start > $pag) {
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
				 			echo "<li><a href=\"javascript:paginar2('1')\">Primera</a></li>";
				 			echo "<li><a href=\"javascript:paginar2('".($start-1)."')\">&laquo; Anterior</a></li>";				 			
				 		}
				 		
				 		for ($j=$start; $j <= $end; $j++) {
				 			if($pag==$j){
				 				echo "<li class='active'><span>".$pag."</span></li>";
				 			}else{
				 				echo "<li><a href=\"javascript:paginar2('".$j."')\">".$j."</a></li>";
				 			}		 			
				 		}
						/*
						- la variable de control j, toma el último valor de la iteración, después del ciclo.
						- Si el valor de j es mayor a 5 y menor al total de la página crea un enlace nuevo al siguiente grupo de paginas;
						*/
				 		if($j<=$total_pag){
				 			# Mientras no llegue al total de paginas construidas, aparecerá este enlace.
				 			echo "<li><a href=\"javascript:paginar2('".($j)."')\" aria-hidden='true'>Siguiente &raquo;</a></li>";
				 			echo "<li><a href=\"javascript:paginar2('".$total_pag."')\" aria-hidden='true'>Última</a></li>";
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