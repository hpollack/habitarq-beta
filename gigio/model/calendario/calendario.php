<?php 
/*
Calendario de eventos. Engloba todo los eventos creados para ser visualizados como una agenda.*/


date_default_timezone_set("America/Santiago");
setlocale(LC_TIME, 'spanish');


include_once '../../lib/php/libphp.php';

//Variable que controla el mes a mostrar. Si no viene nada muestra el mes actual
$mes = isset($_GET['mes']) ? mesmy($_GET['mes']) : date('Y-m');


$semana = 1;

for ($i=1; $i <= date('t', strtotime($mes)); $i++) { 
	
	$dia_semana = date('N', strtotime($mes.'-'.$i));

	$calendario[$semana][$dia_semana] = $i;

	if ($dia_semana == 7) {
		
		# Pasa a la siguiente semana
		$semana++;
	}
}

/* Marcar las fechas de inicio y final de obras por comite.*/

$obras = cargaFechaObras();  //Se obtienen lo datos de las obras.
$eventos = cargarEventos(); //Se obtienen los datos de los eventos

foreach ($obras as $k) {
	
	//Se recorren el array y se extraen los meses.
	$mes_inicio = date('Y-m', $k[1]);
	$mes_final  = date('Y-m', $k[2]);

	if ($mes == $mes_inicio) {
		
		# Si el mes ingresado corresponde, se extrae el día
		$dia_inicio = date('j', $k[1]);

		# Se setea el nombre del comite y el inicio el cual será mostrado en un tooltip
		$inicio_obra = strtoupper("Inicio obras ".$k[0]);

		//echo $inicio_obra;		
	}

	if ($mes == $mes_final) {
		
		# Si el mes ingresado corresponde, se extrae el día
		$dia_final = date('j', $k[2]);

		# Se setea el nombre del comite y el inicio el cual será mostrado en un tooltip
		$final_obra = strtoupper("Fin obras ".$k[0]);
	}

}

foreach ($eventos as $ev) {
	# Se recorre el arreglo

	//Se extraen los meses de las fechas.
	$mes_ev_inicio = date('Y-m', $ev[2]);
	$mes_ev_final  = date('Y-m', $ev[3]);

	//Se obtiene 
	if ($mes_ev_inicio == $mes_ev_final) {
		# Si es en el mismo mes, se extraen los días 
		$dia_ev_inicio = date('j', $ev[2]);

		$dia_ev_final = date('j', $ev[3]);

		if ($dia_ev_inicio == $dia_ev_final) {
			# code...
			$dia_evento = date('j', $ev[2]);
			$evento = strtoupper($ev[1]);
		}


	}

	if ($mes == $mes_ev_inicio) {
		# code...
		$dia_ev_inicio = date('j', $ev[2]);
		$inicio_evento = strtoupper("Inicio ".$ev[1]);
	}

	if ($mes == $mes_ev_final) {
		# code...
		$dia_ev_final = date('j', $ev[3]);
		$final_evento = strtoupper("Final ".$ev[1]);
	}
}



?> 
<h3 class="text-center"><?php echo strftime("%B %Y", strtotime($mes)) ?></h3>
<table id="calendar" class="table table-bordered table-condensed table-responsive">	
	<thead>				
		<tr>
			<th>Lun.</th>
			<th>Mar.</th>
			<th>Miér.</th>
			<th>Jue.</th>
			<th>Vier.</th>
			<th>Sáb.</th>
			<th>Dom.</th>
		</tr>
	</thead>
	<tbody>
		<?php 

		foreach ($calendario as $dias) {
			
			# Se genera el calendario de acuerdo al mes.
			# Dentro de este se irán colocando los eventos marcados e ingresados			
			echo "<tr>";

			# Este bucle genera los días del mes por semana, dibujando las filas y columnas de la tabla
			for ($i=1; $i <=7; $i++) { 							

				# Se agregan las marcas.
				if ($dias[$i] == date('j')) {
					echo "<td class='marca'>";
					echo isset($dias[$i]) ? '<span class="dias"><b>'.$dias[$i].'</b></span>' : '';
					echo "<br>";
					if ($dias[$i] == $dia_inicio) {
						# code...					
						echo isset($inicio_obra) ? "<a class='inicio-obras badge' href='#' data-toggle='tooltip' title='".$inicio_obra."'><i class='fa fa-bookmark'></i></a>" : '';
					}

					if ($dias[$i] == $dia_final) {
						# code...
						echo isset($inicio_obra) ? "<a class='inicio-obras badge' href='#' data-toggle='tooltip' title='".$inicio_obra."'><i class='fa fa-bookmark'></i></a>" : '';
					}

					if($dias[$i] == $dia_evento) {
						echo isset($evento) ? "<a class='evento badge' href='#' data-toggle='tooltip' title='".$evento."'><i class='fa fa-bookmark'></i></a>" : '';
					}else if ($dias[$i] == $dia_ev_inicio) {
						# code...
						echo isset($inicio_evento) ? "<a class='evento badge' href='#' data-toggle='tooltip' title='".$inicio_evento."'><i class='fa fa-bookmark'></i></a>" : '';
					}else if ($dias[$i] == $dia_ev_final) {
						# code...
						echo isset($final_evento) ? "<a class='evento badge' href='#' data-toggle='tooltip' title='".$final_evento."'><i class='fa fa-bookmark'></i></a>" : '';
					}

					echo "</td>";				
				}else {
					echo "<td>";
					echo isset($dias[$i]) ? '<span>'.$dias[$i].'</span>' : '';
					echo "<br>";
					if ($dias[$i]) {
						# code...
						if ($dias[$i] == $dia_inicio) {
						# code...					
						echo isset($inicio_obra) ? "<a class='inicio-obras badge' href='#' data-toggle='tooltip' title='".$inicio_obra."'><i class='fa fa-bookmark'></i></a>" : '';
						}

						if ($dias[$i] == $dia_final) {
							# code...
							echo isset($inicio_obra) ? "<a class='inicio-obras badge' href='#' data-toggle='tooltip' title='".$inicio_obra."'><i class='fa fa-bookmark'></i></a>" : '';
						}

						if($dias[$i] == $dia_evento) {
							echo isset($evento) ? "<a class='evento badge' href='#' data-toggle='tooltip' title='".$evento."'><i class='fa fa-bookmark'></i></a>" : '';
						}else if ($dias[$i] == $dia_ev_inicio) {
							# code...
							echo isset($inicio_evento) ? "<a class='evento badge' href='#' data-toggle='tooltip' title='".$inicio_evento."'><i class='fa fa-bookmark'></i></a>" : '';
						}else if ($dias[$i] == $dia_ev_final) {
							# code...
							echo isset($final_evento) ? "<a class='evento badge' href='#' data-toggle='tooltip' title='".$final_evento."'><i class='fa fa-bookmark'></i></a>" : '';
						}
					}
					echo "<br>";
					
					echo "</td>";
				}					

				
			}
			
			echo "</tr>";
		}

		?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function() {
		$("[data-toggle='tooltip']").tooltip();
	});
</script>		