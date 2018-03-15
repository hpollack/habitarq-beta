<?php 
/**
 * ==============================================================================================
 * Calendario de eventos. Engloba todo los eventos creados para ser visualizados como una agenda.
 * ==============================================================================================
**/


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


?> 
<script type="text/javascript">	
	$("[data-toggle='tooltip']").tooltip();
</script>	
<h3 class="text-center"><?php echo strftime("%B %Y", strtotime($mes)); ?></h3>
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
		/*
		  En esta parte se dibujará los días del calendario y las marcas correspondiente a los eventos, obras etc.
		  Los días domingo (y posteriormente festivos, de ser necesario), aparecerán en rojo.
		*/
		foreach ($calendario as $dias) {
			
			# Se genera el calendario de acuerdo al mes.
			# Dentro de este se irán colocando los eventos marcados e ingresados			
			echo "<tr>";

			# Este bucle genera los días del mes por semana, dibujando las filas y columnas de la tabla
			for ($i=1; $i <=7; $i++) { 							

				# Se agregan las marcas.
				if ($dias[$i] == date('j')) {
					
					echo "<td class='marca'>";
					
					$feriado = mostrarFeriados($dias[$i], $mes);
					
					if ($i==7) {
						# code...
						echo '<span class="fer"><b>'.$dias[$i].'</b></span>';
					}else if ($dias[$i] == $feriado) {
						
						echo '<span class="fer"><b>'.$dias[$i].'</b></span>';	
					}else{
						
						echo "<span><b>".$dias[$i]."</b></span>";
					}

					echo "<br>";

					# Los eventos y fechas de obras se muestran acá.
					# De acuerdo al día se consulta y se van marcando

					$obras  = mostrarObras($dias[$i], $mes);
					$evento = mostrarEventos($dias[$i], $mes);

					echo $obras;
					echo $evento;
					
					echo "</td>";				
				} else {

					echo "<td>";
					# Si el cuadro tiene un día marcado, procede a poner las marcas donde corresponde
					# Se procede a poner las marcas correspondientes a las fechas.
					if (isset($dias[$i])) {
						# Se crean las marcas correspondientes a los días.
						$feriado = mostrarFeriados($dias[$i], $mes);
						#Si el día es domingo (mas adelante se incluirán feriados), se marcan los números en rojo
						if ($i == 7) {
							# code...
							echo '<span class="fer">'.$dias[$i].'</span>';
						} else if ($dias[$i] == $feriado) {
							
							echo '<span class="fer">'.$dias[$i].'</span>';	
						} else {
							
							echo "<span>".$dias[$i]."</span>";
						}

						echo "<br>";

						# Los eventos y fechas de obras se muestran acá.
						# De acuerdo al día se consulta y se van marcando
						
						$obras  = mostrarObras($dias[$i], $mes);
						$evento = mostrarEventos($dias[$i], $mes);

						echo $obras;
						echo $evento;
						
					}				
					
					echo "</td>";
				}					

				
			}
			
			echo "</tr>";
		}

		?>
	</tbody>
</table>	