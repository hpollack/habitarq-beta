<?php 
/**
 * =================================================
 * RESPALDO AUTOMATICO DE LA BASE DE DATOS.
 * =================================================
 * 
 * Script que realiza el proceso automático de respaldo de la base de datos.
 * El script se ejecutará desde el cliente shell de php, el cual está programado
 * en el cron y realiza las comparaciones cada 3 horas.
 * Cuando coinciden las fechas, ejecuta un respaldo y actualiza el valor 
 * de la variable de configuración.
 * 
 * 
 **/
include_once 'libphp.php';

# Se trae la fecha de hoy y la que existe en la base de datos.
# Ambas se transforman al formato Y/m/d (año/mes/dia) y se comparan.
$fecha = time();
$fecha_respaldo = traerValorConfig("fecharespaldodb");

echo "Respaldo programado: fecha ".date("Y/m/d",$fecha)."\n";
echo "Verificando fecha en la base de datos...\n";
echo "Fecha de respaldo: ".date("Y/m/d", $fecha_respaldo)."\n\n\n";

if (date("Y/m/d", $fecha_respaldo) == date("Y/m/d", $fecha)) {
	# Si son iguales.
	echo "Iniciando respaldo...\n";
	# Ejecuta el respaldo automático.
	$bckp = respaldoDB();
	
	if ($bckp == 1) {
		# Se traen los días configurados en la base de datos
		$dias = traerValorConfig("RegDB");
		#Se actualiza la nueva fecha
		$update = configRespaldo($dias);

		if ($update == 1) {
			# Si se trae
			echo "Nueva fecha de respaldo: ".date("Y/m/d", traerValorConfig("fecharespaldodb"))."\n";
		}else {
			# Mensaje de error en caso de que falle la actualización
			echo "No se pudo actualizar la fecha\n";
		}
	} else {
		# Si falla el respaldo
		echo "No se pudo pudo respaldar la base de datos\n";
	}
} else {
	
	echo "No se realizo el respaldo porque las fechas no coinciden\n";

}
echo "Fin de ejecución del script\n";
exit();
?>