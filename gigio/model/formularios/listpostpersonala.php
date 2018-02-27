<?php 
/*
=========================================================
Lista de Historial de llamados
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
Listado que trae los postulantes por llamado con paginador en ajax. Este paginador funciona con una funcion escrita en javascript que recibe los parámetros
de el numero de pagina y un valor a buscar.
*/

$cmt = $_GET['cmt'];
$lmd = $_GET['lmd'];
$anio = $_GET['anio'];

$reg = 30; //Numero de registros por pagina
$pag = false; //Cantidad de paginas. Comienza con un valor falso


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
$string = "select distinct concat(p.rut,'-',p.dv) as rut, concat(p.nombres,' ',p.paterno,' ',p.materno) as nombre from persona as p ".
		  "inner join cuenta_persona as cp on cp.rut_titular = p.rut ".
		  "inner join persona_comite as pc on pc.rutpersona = p.rut ".
		  "inner join grupo as g on g.idgrupo = pc.idgrupo ".
		  "inner join persona_ficha as pf on pf.rutpersona = p.rut ".
		  "inner join frh as f on f.nficha = pf.nficha ".
		  "inner join lista_postulantes as lp on lp.rutpostulante = p.rut ".
		  "inner join llamado_postulacion ll on ll.idllamado_postulacion = lp.idllamado_postulacion ".
		  "inner join llamados as l on l.idllamados = ll.idllamado ".
		  "where g.numero = ".$cmt." and l.idllamados = ".$lmd." and ll.anio = ".$anio." and p.estado = 1 ".
		  "order by abs(p.rut) asc";

$strtitulo = "select  `ttp`.`idtitulo_postulacion` ".
			 "FROM `titulo_postulacion` `ttp` ".
			 "INNER JOIN `tipopostulacion` `tp` ON (`ttp`.`idtitulo_postulacion` = `tp`.`idtitulo`) ".
			 "INNER JOIN `item_postulacion` `ip` ON (`tp`.`idtipopostulacion` = `ip`.`idtipopostulacion`) ".
			 "INNER JOIN `postulaciones` `p` ON (`ip`.`iditem_postulacion` = `p`.`item_postulacion`) ".
			 "INNER JOIN `llamado_postulacion` `llp` ON (`p`.`idpostulacion` = `llp`.`idllamado_postulacion`) ".
			 "INNER JOIN `llamados` `ll` ON (`llp`.`idllamado` = `ll`.`idllamados`) ".
			 "INNER JOIN `grupo` `g` ON (`p`.`idgrupo` = `g`.`idgrupo`) ".
			 "where g.numero = ".$cmt." and ll.`idllamados` = ".$lmd." and llp.`anio` = ".$anio."";

			 //echo $strtitulo; exit();
			 

$titulo = mysqli_fetch_row(mysqli_query($conn, $strtitulo));

if ($titulo[0] == 1) {
	# code...
	echo "no";
	exit();
}

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
		<div class="col-md-9 col-md-offset-0">
			<?php							
				if(mysqli_num_rows($sql2)>0){
					$col = mysqli_fetch_fields($sql2);
					echo "<div class='table-responsive'>";
					echo "<h3 class='page-header'>Listado de postulados</h3>";
					echo "<table id='lper' class='table table-bordered table-hover table-condensed table-striped'><thead><tr>";

					//Se obtiene el nombre de las columnas. La funcion ucfirst() devuelve los nombres con la primera letra en mayuscula
					foreach ($col as $name) {
						echo "<th>".ucfirst($name->name)."</th>";
					}

					echo "<th>Descargar</th>";					
					echo "</tr></thead></tbody>";

					while ($row = mysqli_fetch_array($sql2)) {
						$r = explode('-',$row[0]);
						echo "<tr>";
						echo "<td>".$row[0]."</td>";
						echo "<td>".$row[1]."</td>";						
						echo "<td width='3%'><center><a href='".url()."model/formularios/postpersonala.php?r=".$r[0]."' class='btn btn-primary btn-sm' target='_self'><i class='fa fa-download'></i></a></center></td>";
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
					total de paginas, entonces se deja el total de paginas. Si no se realiza, continúa la suma anteriormente mencionada
					*/
					$end = ($start + ($ppag-1) > $total_pag)? $total_pag : $start + ($ppag-1);

					//Paginacion 
					if($total_pag>1){		 		
				 		if($start!=1){
				 			echo "<li><a href=\"javascript:paginarPostPersonala('".($start-1)."','".$cmt."', '".$lmd."', '".$anio."')\">&laquo; Anterior</a></li>";				 			
				 		}
				 		for ($j=$start; $j <= $end; $j++) {
				 			if($pag==$j){
				 				echo "<li class='active'><span>".$pag."</span></li>";
				 			}else{
				 				echo "<li><a href=\"javascript:paginarPostPersonala('".$j."','".$cmt."', '".$lmd."',  '".$anio."')\">".$j."</a></li>";
				 			}		 			
				 		}
						/*
						Si el valor de j es mayor a 5 y menor al total de la página crea un enlace nuevo
						al siguiente grupo de paginas;
						*/
				 		if($j<=$total_pag){
				 			echo "<li><a href=\"javascript:paginarPostPersonala('".($j)."','".$cmt."', '".$lmd."',  '".$anio."')\" aria-hidden='true'>Siguiente &raquo;</a></li>";
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
?>