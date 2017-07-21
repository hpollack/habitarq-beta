<?php 
/*
Calendario de eventos. Engloba todo los eventos creados para ser visualizados como una agenda.


*/


date_default_timezone_set("America/Santiago");
setlocale(LC_TIME, 'spanish');


include_once '../../lib/php/libphp.php';

//Variable que controla el mes a mostrar. Si no viene nada muestra el mes actual
$mes = isset($_GET['mes']) ? mesmy($_GET['mes']) : date('Y-n');


$semana = 1;

for ($i=1; $i <= date('t', strtotime($mes)); $i++) { 
	
	$dia_semana = date('N', strtotime($mes.'-'.$i));

	$calendario[$semana][$dia_semana] = $i;

	if ($dia_semana == 7) {
		# code...
		$semana++;
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
			# code...
			echo "<tr>";

			for ($i=1; $i <=7 ; $i++) { 							

				if ($dias[$i] == date('j')) {
					
					echo "<td class='marca'>";
					echo isset($dias[$i]) ? '<span><b>'.$dias[$i].'</b></span>' : '';
					echo "</td>";					
				}else {

					echo "<td>";
					echo isset($dias[$i]) ? '<span>'.$dias[$i].'</span>' : '';
					echo "</td>";
				}
				
			}

			echo "</tr>";
		}

		?>
	</tbody>
</table>		