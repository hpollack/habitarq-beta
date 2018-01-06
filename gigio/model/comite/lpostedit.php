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

$ruk = $_GET['ruk'];

//Variable que almacena el texto de busqueda
$busc = mysqli_real_escape_string($conn, $_GET['rut']);

$pag = false; //Cantidad de paginas. Comienza con un valor falso

// la variable $criterio muestra una porcion de la consulta en la cual se evaluan que las condiciones sean las que entrega la variable $busc. Si no se ingresa nada, la variable se mantiene vacia

if(!empty($busc)){
	$criterio = "and concat(p.rut,'-',p.dv) like '%".$busc."%' or concat(p.nombres,' ',p.paterno,' ',p.materno) LIKE '%".$busc."%'";
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
$string = "select DISTINCT
concat(p.rut,'-',p.dv) AS rut, 
concat(p.nombres,' ',p.paterno,' ',p.materno) AS nombre, 
concat(d.calle,' N° ',d.numero) as direccion, 
v.rol, 
(select p1.metros from mts p1 where p1.rol = v.rol and p1.idpiso = 1 and idestado_vivienda = 1) AS p1, 
(select p2.metros from mts p2 where p2.rol = v.rol and p2.idpiso = 2 and idestado_vivienda = 1) AS p2,
(select mts.metros from mts where mts.idestado_vivienda = 2 and mts.rol = v.rol) as amp,
(select mts.idpiso from mts where mts.idestado_vivienda = 2 and mts.rol = v.rol) as piso
FROM
vivienda AS v
INNER JOIN persona_vivienda AS pv ON pv.rol = v.rol
INNER JOIN persona AS p ON pv.rut = p.rut
INNER JOIN direccion as d ON p.rut = d.rutpersona
INNER JOIN lista_postulantes lp ON p.rut = lp.rutpostulante
INNER JOIN mts AS mv ON mv.rol = v.rol
INNER JOIN piso AS pm ON mv.idpiso = pm.idpiso
INNER JOIN conservador AS cv ON v.conservador = cv.idconservador
INNER JOIN persona_comite AS pg ON p.rut = pg.rutpersona
INNER JOIN grupo AS g ON pg.idgrupo = g.idgrupo
WHERE g.numero = ".$ruk." and lp.estado like '%ostulado' $criterio";

$string2 = "select tp.nombre
FROM grupo AS g
INNER JOIN postulaciones AS p ON g.idgrupo = p.idgrupo
INNER JOIN item_postulacion AS ip ON p.item_postulacion = ip.iditem_postulacion
INNER JOIN tipopostulacion AS tp ON ip.idtipopostulacion = tp.idtipopostulacion
WHERE g.numero = ".$ruk."";




$sql = mysqli_query($conn, $string);
$total = mysqli_num_rows($sql);



/*
 Se ejecuta nuevamente la consulta en otra instancia agregando el LIMIT
*/

?>
<style type="text/css" media="screen">
	/* Dentro de este div se encuentra la tabla de datos.*/
	/* Se da una altura de 400 px y el scroll aparecerá si la tabla es mayor a estos pixeles*/
	.datos {
		height: 400px;
		overflow-y: auto;
		border: 1px solid #ddd;		
	}	
</style>
<div class="container">
	<div class="row">
		<div class="col-md-11 col-md-offset-0">			
				
			<?php							
				if(mysqli_num_rows($sql)>0){
					$n = 1;
					$tpost = mysqli_fetch_row(mysqli_query($conn, $string2));

					echo "<h3 class='page-header'>Listado de Comités</h3>";					
					echo "<div class='table-responsive datos'>";
					echo "<table id='lper' class='table table-bordered table-hover table-condensed table-striped'><thead><tr>";
					echo "<th>N&deg;</th>";
					echo "<th>Rut</th>";
					echo "<th>Nombre</th>";
					echo "<th>Dirección</th>";
					echo "<th>Rol-Avaluo</th>";					
					echo "<th>M2 Existente</th>";
					if ($tpost[0] == "Ampliacion") {
						# code...
						echo "<th>Ampliación M2</th>";
						echo "<th>Total Vivienda</th>";
						echo "<th>Tipo de Ampliación</th>";
						echo "<th width='5%'>Actualizar</th>";
					}
					echo "</tr></thead><tbody>";

					while ($row = mysqli_fetch_array($sql)) {
						echo "<tr>";
						echo "<td>".$n."</td>";
						echo "<td>".$row[0]."</td>";
						echo "<td>".$row[1]."</td>";
						echo "<td>".$row[2]."</td>";
						echo "<td>".$row[3]."</td>";
						echo "<td>".($row[4] + $row[5])."</td>";
						if ($tpost[0] == "Ampliacion") {
							# code...
							echo "<td>";						
							echo $amp = ($row[6] > 0) ? $row[6] : 0.00;
							echo "</td>";
							echo "<td class='text-success'><b>".(($row[4] + $row[5]) + $amp)."</b></td>";
							echo "<td>";
							
							if ($row[7] == 1) {
							 	
								echo "<p class='label label-info'>1er Piso</p>";
							} else if ($row[7] == 2) {
							 	
							 	echo "<p class='label label-info'>2do Piso</p>";
							} else {

							 	echo "<p class='label label-danger'>No ingresado</p>";
							}
							
							echo "</td>";
							echo "<td class='text-center'>";						
							echo "<a href='".url()."model/comite/modalbulk.php' data-target='#modal-id' class='open-modal btn btn-primary btn-sm' data-toggle='modal' data-id='".$row[0]."'><i class='fa fa-edit'></i></a>";
							echo "</td>";	

						}					
						
						echo "</tr>";

						$n++;
					}					
					echo "</tbody></table></div>"; 
					?>
					<br>
					 <form action="<?php echo url(); ?>model/comite/nominametros.php" method="post" class="form-horizontal" role="form">
				 		<div class="form-group">				 			
				 			<div class="col-sm-10 col-sm-offset-2">
				 				<input type="hidden" name="ruk" value="<?php echo $ruk; ?>">
				 				<button type="submit" class="btn btn-success pull-right"><i class="fa fa-download"></i> Descargar Plantilla</button> 
				 			</div>
				 		</div>
					 </form>
					<?php 
					
				}else{
					
					echo '<br><div class="col-md-10"><div class="alert alert-warning">							 
							 <strong>El comité no contiene postulantes activos </strong>
							 <a class="alert alert-link" href="javascript:history.back(1)">Volver</a>
						  </div></div>';
					
				}
			?>
		
		</div>
	</div>	
</div>

