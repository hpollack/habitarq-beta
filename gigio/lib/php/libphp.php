<?php
/*
===============================================
Funciones Generales del Sistema
===============================================
*/


/**
 *Funcion que devuelve la url del sitio, traída desde la configuracion
 *definida en config.php
 *@return la url configurada
 *
**/
 
function url(){
	include 'config.php';
	
	$url = $url;
	return $url;
}

/*
Funcion para conectar a la base de datos, basado en los parámetros de configuracion
traidos del archivo config.php
*/
function conectar(){
	include 'config.php';
	
	$host = $host;
	$user = $user;
	$pass = $pas;
	$db   = $bd;
	
	$conndb = mysqli_connect($host, $user, $pass, $db);
	if(!$conndb){
		echo "Error al conectar a la base de datos";
	}
	return $conndb;
}

/**
*Crear listas combo dinámicas a partir de una consulta a la base de datos
*@param: string $consulta
*@return: html con las opciones de la etiqueta select
**/
function cargaCombo($consulta){	
	$conn = conectar();

	$mostrar1 = "<option value=\"";
	$mostrar2 = "\">";
	$mostrar3 ="</option>";

	$stringLista = $consulta;
	$n = 0;
	$result = mysqli_query($conn, $stringLista);
	if(!$result){		
		echo "No es posible obtener datos";
	}else{
		while ($row = mysqli_fetch_array($result)) {
			$option = $mostrar1.$row[0].$mostrar2.$row[1].$mostrar3;
			echo $option;
			$n++;
		}
	}
	mysqli_free_result($result);
	mysqli_close($conn);
}

/*
Funcion que destruye la sesion. 
*/
function salidasistema(){
	$url = url();
	session_destroy();
	header("location: ".$url."login.php");
	exit();
}

/**
*Opciones de menu del usuario
*@param int $perfil: identificador del tipo de perfil de usuario
*@param string nombre: Nombre del usuario

**/
function get_nav($perfil,$nombre){
	$p = $perfil;
	$n = $nombre;	
	if($p==1){
		?>		
		<ul class="nav navbar-nav">	
			<li><a href="<?php echo url(); ?>view/config/cambiaclave.php"><i class="fa fa-key"></i>  Cambiar Clave</a></li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-gear"></i>  Configuracion</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo url(); ?>view/config/"><i class="fa fa-gears"></i> General</a></li>
					<li><a href="<?php echo url(); ?>view/config/usuario.php"><i class="fa fa-users"></i>  Gestion de Usuarios</a></li>
					<li><a href="#"><i class="fa fa-certificate"></i>   Gestion de Egis</a></li>					
				</ul>
			</li>			
		</ul>
		<?php
	}else if($p==2){
		?>
		<ul class="nav navbar-nav">	
			<li><a href="<?php echo url(); ?>view/config/cambiaclave.php">Cambiar Clave</a></li>										
		</ul>	
		<?php
	}
	?>
	<ul class="nav navbar-nav pull-right">
		<li><p class="navbar-text "><?php echo "Bienvenido ".$n; ?></p></li>		
		<li><a href=""><i class="fa fa-bell"></i></a></li>		
		<li><a href="<?php echo url(); ?>model/out.php"><i class="fa fa-sign-out"></i> Salir</a></li>
	</ul>	
	<?php
}

/**
*Crear checkbox dinámicos a partir de una consulta a la base de datos.
*Es similar a la funcion de combos.
*@param: string $consulta
*@return: html con los checkbox generados.
**/
function cargaCheckbox($consulta, $nombre){
	$conn = conectar();
	$label1 = "<label class=\"checkbox\">";
	$label2 = "</label>";
	$stringCheckbox = $consulta;
	$n = 0;
	$sql = mysqli_query($conn, $stringCheckbox);
	if(!$sql){
		echo "No se pudo generar el conjunto de checkbox";
	}else{
		while ($row = mysqli_fetch_array($sql)) {
			$chk = $label1."<input type=\"checkbox\" id=".$nombre.$row[0]." name='".$nombre."[]' value=".$row[0]." />".ucfirst($row[1]).$label2;
			echo $chk;
			$n++;
		}
	}
	mysqli_free_result($sql);
	mysqli_close($conn);
}

/* Validar digito verificador */
function validaDV($rut){
	$digito=1;
	for($i=0;$rut!=0;$rut/=10):
		$digito=($digito+$rut%10*(9-$i++%6))%11;
	endfor;	
	return chr($digito? $digito+47:75);
}

/* Devuelve formato de fecha para interfaz */
function fechanormal($fecha){
	$nfecha = date("d/m/Y", strtotime($fecha));
	return $nfecha;
}

/* Devuelve formato de fecha de MySQL */
function fechamy($fecha){
	$dia = substr($fecha,0,2);
	$mes = substr($fecha,3,2);
	$anio = substr($fecha,6,4);

	$myfecha = $anio."-".$mes."-".$dia;
	return $myfecha;
}

/*Funcion que trae me sy año solamente. Se utiliza de preferecia en el calendario */
function mesmy($fecha) {
	$mes = substr($fecha,0,2);
	$anio = substr($fecha, 3, 4);

	$myMes = $anio."-".$mes;
	return $myMes;
}

/**
* Obtener id de forma autoincremental, escaneando si existe alguna.
* Funciona solo en caso de id de tipo entero 
* @param: string $tabla: nombre de la tabla
* @param: int campo: nombre del campo
* @return: id siguiente a la generada
**/
function obtenerid($tabla, $campo){
	$conn = conectar();	
	
	$string = "select max(".$campo.") from ".$tabla."";

	$sql = mysqli_query($conn, $string);

	if(!$sql){		
		
		echo "Error al obtener ultimo identificador";
		exit();
	}
	if($f = mysqli_fetch_row($sql)){
		$max = $f[0];
	}

	mysqli_free_result($sql);
	return ($max + 1);
}

/**
*Calcular edad de la persona. 
*Se basa en la fecha real
*@param fecha de nacimiento (string)
*@return edad (entero)
**/
function esAdultoMayor1($fecha){
	//Se separan tanto el año como el mes y el día
	list($Y,$m,$d) = explode("-",$fecha);

	//Se restanto, tanto el año como el mes y el día actual
	//con los de la fecha pasada por parámetro
	$anio_dif = date("Y") - $Y;//Año de diferencia
	$mes_dif  = date("m") - $m; // Mes de diferencia	
	$dia_dif  = date("d") - $d; //dia de diferencia

	/*
	Si la diferencia del dia o el mes de diferencia son menores a los
	de la fecha de nacimiento, se descuenta los años entre ambas fechas.
	*/
	if ($dia_dif < 0 || $mes_dif < 0) {		
		$anio_dif--;
	}

	return 	$anio_dif;
}

function esAdultoMayor($fecha) {

	list($Y,$m,$d) = explode("-",$fecha);

	$anio_dif = date("Y") - $Y;

	return $anio_dif;
}

/**
*Trae el sexo de la persona ingresado en la base de datos mediante el rut
*@param rut (string)
*@return sexo (string)
**/
function traerSexoPersona($rut) {
	$conn = conectar();
	$string = "select sexo from persona where rut = '".$rut."'";
	$sql = mysqli_query($conn, $string);

	$sexo = mysqli_fetch_row($sql);

	mysqli_free_result($sql);
	mysqli_close($conn);
	
	return $sexo[0];
}

/**
*Trae el valor del parámetro de configuración, de acuerdo a la clave
*@param clave (string)
*@return valor (integer)
**/
function traerValorConfig($clave) {
	$conn = conectar();

	$string = "select valor from configuracion where clave = '".$clave."'";
	$sql = mysqli_query($conn, $string);

	$valor = mysqli_fetch_row($sql);

	mysqli_free_result($sql);
	mysqli_close($conn);

	return $valor[0];
}
/**
*Traer valor de la uf diaria. Este valor deberá
*calcularse con los parámetros de configuracion
*@return uf -> valor de uf al dia.
*/
function traeUF(){
	$apiURL = 'http://mindicador.cl/api';

	if(ini_get('allow_url_fopen')){
		$json = file_get_contents($apiURL);
	}else{
		$curl = curl_init($apiURL);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($curl);
		curl_close($curl);
	}

	$indicador = json_decode($json);
	$uf = $indicador->uf->valor;
	
	return $uf;
}

/**
*Funcion que quita los días sábados y domingos de los días hábiles
*generados desde la fecha de inicio + la cantidad de días de duración
*de una obra en particular.
*A futuro se deben incluir los días festivos.
*@param $fecha -> fecha de inicio (date).
*@param $dias  -> dias (integer).
*@return $fecha_final -> fecha_final (date).
**/

function quitaSabadoyDomingo($fecha, $dias) {
	$conn = conectar();

	for ($i=0; $i < $dias ; $i++) { 
	//Segundos de un dia
		$seg = $seg + 86400;		

		//Variable que almacena el día traído desde la fecha ingresada
		$ffinal = date('D',strtotime($fecha)+$seg);

		if ($ffinal == "Sat") {
			//Si es sábado, se resta ese día
			$i--;
		}else if ($ffinal == "Sun") {
			//Si es domingo se resta ese día
			$i--;			
		}else {
			//Si el día es feriado -(visto en la configuración)
			$feriado = mysqli_fetch_row(mysqli_query($conn, "select dia from feriados where dia = ".strtotime($fecha).""));
			if($feriado[0]) {
				$i--;
			}

			$fecha_final = date("Y-m-d",strtotime($fecha)+$seg);
		}
	}

	return $fecha_final;
}
/**
*Funcion que busca la fecha final a partir de una fecha de inicio y los dias precedentes
*@param fecha (date) -> Fecha de inicio
*@param dias  (integer) -> cantidad de días desde el inicio
*@return fecha_final (date) -> fecha final que nace del valor total de días.
**/
function fechaFinal($fecha, $dias) {
	for ($i=0; $i < $dias ; $i++) { 
		//Dia en segundos 
		$dia = $dia + 86400;
		//Fecha que se generará en cada iteración. La última será entregada una vez se llegue al último día de los agregados
		$fecha_final = date("Y-m-d", strtotime($fecha)+($dia-1));
	}

	return $fecha_final;
}
/**
*Funcion que valida un rut concatenado sin puntos.
*Válido solo para nombres de usuario (esto hasta que se defina el estándar)
*@param $user (rut, varchar);
*@return $dv (digito verificador real)
**/
function validaRutUsuario($user) {
	
	//Se separan los digitos del rut
	$rut = explode('-', $user);

	//Se procede a obtener el dígito verificador real
	$dv = validaDV($rut[0]);

	return $dv;
}
/**
*Funcion que muestra una fecha en formato: %dia de %mes del %anio
*@param fecha (unix timestamp)
*@return fecha en el formato indicado
**/
function fechaAl($timestamp){
	$fecha = date('d-m-Y H:i:s', $timestamp);
	setlocale(LC_ALL, "es_ES.UTF-8","esp");
	$formato = strftime("%d de %B del %Y",strtotime($fecha));
	
	return $formato;
}
/**
*Funcion que limita las palabras desde un texto mas largo
*Sirve en caso de que se necesite limitar una frase o artículo extenso
*@param texto (string): el texto a formatear
*@param palabra(integer): el numero de palabras que se mostrarán. Por defecto son 20
*@param puntos(string): puntos suspensivos que se colocan a continuacion del limite.
*@return unarray con el texto limitado; en caso contrario el texto integro.
**/

function limitar_palabras($texto, $palabras=20, $puntos="...") {
	$txt = explode(' ',$texto);
	if (count($txt)>$palabras) {
		# code...
		return implode(' ', array_slice($txt,0,$palabra));
	}else{
		return $texto;
	}
}

function DB_Backup($tablas='*') {
	
	$conn = conectar();

	//Si se traen todas las tablas
	if ($tablas == '*') {
		//Se crea un arreglo con el nombre de las tablas
		$tablas = array();
		//Se trae la consulta con todas las tablas
		$sqlTabla = mysqli_query($conn, "SHOW TABLES");

		 while ($tab = mysqli_fetch_array($sqlTabla)) {
		 	$tabla = $tab[0];
		 }
	}else {
		$tablas = (is_array($tablas)) ? $tablas : explode(',', $tablas);
	}

	foreach ($tablas as $tabla) {
		$sqlTabla2 = mysqli_query($conn, "select * from ".$tabla);
		$numfilas = mysqli_num_fields($sqlTabla2);

		$return .= 'DROP TABLE '.$tabla;
		$row = mysqli_fetch_row(mysqli_query($conn, 'SHOW CREATE TABLE '.$tabla));
		$return .= "\n\n".$row[0].";\n\n";

		for ($i=0; $i < $numfilas; $i++) { 
			# code...
			while ($f = mysqli_fetch_row($sqlTabla2)) {
				# code...
				$return .= "insert into ".$tabla." values(";

				for ($j=0; $j < $numfilas ; $j++) { 
					# code...
					$fila[$j] = addslashes($fila[$j]);
					$fila = ereg_replace("\n","\\n",$fila[$j]);

					if (isset($fila[$j])) {
						# code...
						$return.= '"'.$fila[$j].'"';
					}else {
						$return .= '""';
					}

					if ($j < ($numfilas-1)) {
						$return .= ',';
					}
				}
			}

			$return .= ");\n";
		}
	}

	$return .= "\n\n\n";

	include 'config.php';
	date_default_timezone_set("America/Santiago");

	$handle = fopen($bd.'_'.date("Y-m-d", time()).".sql","w+");
	fwrite($handle,$return);
	fclose($handle);
}

function get_footer() {
	?>
		<footer>
			<p>Sistema creado por Hermann Pollack Vega</p>
			<p>Ingeniero de Ejec. En Comp y Desarrollador Web</p>	
		</footer>
	<?php
}

/*
  ===================================================================
   Funciones de consulta a la BD para ser mostradas en el calendario
  ===================================================================   
 */

/**
* Funcion que trae la información del inicio y final de las obras por grupo
* Se genera a través de una emulacion de un dataset
*@param No incluye
*@return un array de nombre fechas que almacena el resultado de la consulta
**/
function cargaFechaObras() {
	$conn = conectar();
	$fechas = array();

	$str = "select g.nombre, p.fecha_inicio, p.fecha_final from postulaciones as p ".
	       "inner join grupo as g on p.idgrupo = g.idgrupo";

	$sql = mysqli_query($conn, $str);

	while ($f = mysqli_fetch_array($sql)) {
		array_push($fechas, $f);
	}

	mysqli_free_result($sql);
	mysqli_close($conn);
	
	return $fechas;
}
/**
* Funcion que trae la información de los eventos que se van creando. 
* @param No incluye
* @return un array con los datos de los eventos.
**/

function cargarEventos() {
	$conn = conectar();
	$fechas = array();

	$str = "select * from eventos_calendario";

	$sql = mysqli_query($conn, $str);

	while ($f = mysqli_fetch_array($sql)) {
		# code...
		array_push($fechas, $f);
	}

	mysqli_free_result($sql);
	mysqli_close($conn);

	return $fechas;
}

function cargarFeriados() {
	$conn = conectar();
	$fechas = array();

	$str = "select * from feriados order by dia asc";

	$sql = mysqli_query($conn, $str);

	if (!$sql) {
		# code...
		echo "Falló la transacción";
		exit();
	}

	while ($f = mysqli_fetch_array($sql)) {
		# code...
		array_push($fechas, $f);
	}

	mysqli_free_result($sql);
	mysqli_close($conn);

	return $fechas;
}

/**
* Funcion que muestra los feriados en rojo.
*@param dia, mes
*@return dia feriado
*/

function mostrarFeriados($dia, $mes) {

	$feriados = cargarFeriados();

	foreach ($feriados as $f) {
	# Se transforma el mes que viene desde la base de datos
		$mes_feriado = date('Y-m', $f[1]);

		if ($mes == $mes_feriado) {
			# Si el mes coincide con el seleccionado, se obtiene el dia.
			$dia_feriado = date('j', $f[1]);
			
			if ($dia == $dia_feriado) {

				$valor = $dia_feriado;
			}
		}

	}

	return $valor;
}

/**
* Funcion mostrarEventos
* Extrae el total de eventos y asigna la marca correspondiente
* dependiendo del día y del mes pasados por valor
*@param dia 
*@param mes
*@return enlace con la marca.
**/

function mostrarEventos($dia, $mes) {

	$eventos = cargarEventos();

	foreach ($eventos as $ev) {
		# Se recorre el arreglo

		// Se extrae el identificador
		$idevento = $ev[0];	

		//Se extraen los meses de las fechas.
		$mes_ev_inicio = date('Y-m', $ev[2]);
		$mes_ev_final  = date('Y-m', $ev[3]);

		//Se obtiene 
		if (($mes == $mes_ev_inicio) && ($mes == $mes_ev_final)) {
			
			#Id del evento. Esto se usará para el modal de edicion.
			
			# Si es en el mismo mes, se extraen los días 
			$dia_ev_inicio = date('j', $ev[2]);

			$dia_ev_final = date('j', $ev[3]);

			# Si el inicio y el final son el mismo día,
			# solo mostrará el primero
			if ($dia_ev_inicio == $dia_ev_final) {
				# code...
				$dia_evento = date('j', $ev[2]);
				

				if ($dia == $dia_evento) {
					# code...
					$evento = strtoupper($ev[1]);
					$valor = "<a class='evento badge' href=\"javascript:editarEvento('".$idevento.
					"')\" data-toggle='tooltip' title='".$evento."'><i class='fa fa-bookmark' ></i></a>";
				}
			}else {
				if ($dia == $dia_ev_inicio) {
					
					$evento = strtoupper("Inicio ".$ev[1]);
					$valor = "<a class='evento badge' href=\"javascript:editarEvento('".$idevento.
					"')\" data-toggle='tooltip' title='".$evento."'><i class='fa fa-bookmark' ></i></a>";
				}

				if ($dia == $dia_ev_final) {
					# code...
					$evento = strtoupper("Fin ".$ev[1]);
					$valor = "<a class='evento badge' href=\"javascript:editarEvento('".$idevento.
					"')\" data-toggle='tooltip' title='".$evento."'><i class='fa fa-bookmark' ></i></a>";
				}
			}				
			
		}else {
			if ($mes == $mes_ev_inicio) {
				# Si ambos meses son el mismo
				# Se formatea la fecha para que coincida con el calendario
				$dia_ev_inicio = date('j', $ev[2]);
				$inicio_evento = strtoupper("Inicio ".$ev[1]);

				if ($dia == $dia_ev_inicio) {
					# code...
					$valor = "<a class='evento badge'  href=\"javascript:editarEvento('".$idevento.
					"')\"  data-toggle='tooltip' title='".$inicio_evento."'><i class='fa fa-bookmark' ></i></a>";
				}
			}

			if ($mes == $mes_ev_final) {
				# Si ambos meses son el mismo
				# Se formatea la fecha para que coincida con el calendario
				$idevento = $ev[0];
				$dia_ev_final = date('j', $ev[3]);
				$final_evento = strtoupper("Final ".$ev[1]);

				if ($dia == $dia_ev_final) {
					# code...
					$valor = "<a class='evento badge' href=\"javascript:editarEvento('".$idevento.
					"')\"  data-toogle='tooltip' title='".$final_evento."'><i class='fa fa-bookmark' ></i></a>";
				}
			}
		}
		
	}

	return $valor;
}

/**
* Funcion mostrarObras
* Extrae el total de obrass y asigna la marca correspondiente
* dependiendo del día y del mes pasados por valor
*@param dia 
*@param mes
*@return enlace con la marca.
**/

function mostrarObras ($dia, $mes) {
	$obras = cargaFechaObras();

	foreach ($obras as $k) {
	
	    # Se recorren el array y se extraen los meses.
		$mes_inicio = date('Y-m', $k[1]);
		$mes_final  = date('Y-m', $k[2]);

		if ($mes == $mes_inicio) {
			
			# Si el mes ingresado corresponde, se extrae el día
			$dia_inicio = date('j', $k[1]);

			# Se setea el nombre del comite y el inicio el cual será mostrado en un tooltip
			$inicio_obra = strtoupper("Inicio obras ".$k[0]);

			if($dia == $dia_inicio) {

				$valor = "<a class='inicio-obras badge' href='#' data-toggle='tooltip' title='".$inicio_obra.
				"'><i class='fa fa-bookmark'></i></a>";
			}

					
		}

		if ($mes == $mes_final) {
			
			# Si el mes ingresado corresponde, se extrae el día
			$dia_final = date('j', $k[2]);

			# Se setea el nombre del comite y el inicio el cual será mostrado en un tooltip
			$final_obra = strtoupper("Fin obras ".$k[0]);

			if ($dia == $dia_final) {
				# code...
				$valor = "<a class='final-obras badge' href='#' data-toggle='tooltip' title='".$final_obra.
				"'><i class='fa fa-bookmark'></i></a>";
			}
		}
	}

	return $valor;
}

/**
* Funcion que calcula los dias faltantesa del evento mas cercano.
* Despliega una alerta con el nombre del evento y los días faltantes
* Se obtiene el valor del día de inicio mas cercano a la fecha actual y se muestra una alerta
* Esta alerta, solo se actualiza refrescando la página completa.
*@param void
*@return La alerta con el nombre del evento mas cercaos y los días faltantes.
**/

function alertaEvento() {

	$conn = conectar();	

	# Se extrae el evento mas cercano.
	# Los valores extraidos, son la fecha de inicio y el titulo del evento.
	$str = "select inicio, titulo from eventos_calendario order by inicio asc limit 0,1";

	$sql = mysqli_query($conn, $str);

	if($f = mysqli_fetch_row($sql)) {		

		//Si la fecha de hoy es menor al valor de la columna extraida. 
		if (time() < $f[0]) {

			/* 
			    - Se extraen los días, totales entre ambas fechas  y se redondean 
			    - Los datos de tiempo (dia/mes/año) son guardados en la BD como unix timestamp.
				- Se resta el tiempo actual al de la base de datos, dividiéndose por los segundos de un dia (86400)
				- Finalmente el resultado se redondea.
				- Se toma como parametro el tiempo unix de sistema y el valor de la base de datos.
	
			*/
			
			$dias = round(($f[0] - time())/86400);

			/* 
			   - Cuando falte menos de un día, el valor de la variable será 1 
			   - En caso contrario, se colocarán los días faltantes.
			*/  
			
			$faltantes = ($dias < 1) ? 1 : $dias;
			
			# Se genera el div de la alerta.
			$alerta =  '<div class="alert alert-warning alert-dismissable">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						   Próximo Evento Calendario: <strong> '.$f[1].'</strong>.  Dias Faltantes: <strong>'.$faltantes.'</strong>
						</div>';
		} else {
			
			# Devuelve la variable vacía	
			$alerta = '';
		}
		
	} else {
		
		# Devuelve la variable vacía
		$alerta = '';
	}

	echo $alerta;
	
}

function notificaEvento() {

	$conn = conectar();

	$str = "select * from eventos_calendario";

	$sql = mysqli_query($conn, $str);

	while ($f = mysqli_fetch_array($sql)) {
		
	}
}