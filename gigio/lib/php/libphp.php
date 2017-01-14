<?php
/**
===============================================
Funciones Generales del Sistema
===============================================
*/

//Funcion para setear url
function url(){
	$url = "http://localhost/gigio/";
	return $url;
}

//Funcion para conectar a la base de datos
function conectar(){
	$host = "localhost";
	$user = "root";
	$pass = "hermann";
	$db = "recabarius";
	$conndb = mysqli_connect($host, $user, $pass, $db);
	if(!$conndb){
		echo "Error al conectar a la base de datos";
	}
	return $conndb;
}

//Funcion para generar listas combobox
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
//Funcion que destruye la sesion
function salidasistema(){
	$url = url();
	session_destroy();
	header("location: ".$url."login.php");
	exit();
}

// Menús segun perfil de usuario
function get_nav($perfil,$nombre){
	$p = $perfil;
	$n = $nombre;	
	if($p==1){
		?>		
		<ul class="nav navbar-nav">	
			<li><a href="#"><i class="fa fa-key"></i>  Cambiar Clave</a></li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i>  Configuracion</a>
				<ul class="dropdown-menu">
					<li><a href="#"><i class="fa fa-users"></i>  Gestion de Usuarios</a></li>
					<li><a href="#"><i class="fa fa-certificate"></i>   Gestion de Egis</a></li>
				</ul>
			</li>			
		</ul>
		<?php
	}else if($p==2){
		?>
		<ul class="nav navbar-nav">	
			<li><a href="#">Cambiar Clave</a></li>										
		</ul>	
		<?php
	}
	?>
	<ul class="nav navbar-nav pull-right">
		<li><p class="navbar-text "><?php echo "Bienvenido ".$n; ?></p></li>
		<li><a href="<?php echo url(); ?>model/out.php"><i class="fa fa-sign-out"></i> Salir</a></li>
	</ul>	
	<?php
}

//Funcion que genera un conjunto de checkbox
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
			$chk = $label1."<input type=\"checkbox\" id=".$nombre.$row[0]." name='".$nombre."[]' value=".$row[0]." />".$row[1].$label2;
			echo $chk;
			$n++;
		}
	}
	mysqli_free_result($sql);
	mysqli_close($conn);
}

//Validar digito verificador
function validaDV($rut){
	$digito=1;
	for($i=0;$rut!=0;$rut/=10):
		$digito=($digito+$rut%10*(9-$i++%6))%11;
	endfor;	
	return chr($digito?$digito+47:75);
}
function fechanormal($fecha){
	$nfecha = date("d/m/Y", strtotime($fecha));
	return $nfecha;
}
function fechamy($fecha){
	$dia = substr($fecha,0,2);
	$mes = substr($fecha,3,2);
	$anio = substr($fecha,6,4);

	$myfecha = $anio."-".$mes."-".$dia;
	return $myfecha;
}

function obtenerid($tabla, $campo){
	$conn = conectar();

	if(!(integer)$campo){
		echo "El campo debe ser un número entero";
		exit();
	}
	
	$string = "select max(".$campo.") from ".$tabla."";

	$sql = mysqli_query($string);

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
/*
Calcular edad de la persona. 
Se basa en la fecha real
Parametro de entrada: fecha tipeada
Salida: entero edad.


*/
function esAdultoMayor($fecha){
	//Fechas actuales
	list($Y,$m,$d) = explode("-",$fecha);

	//Retorna el resultado de la operacion de calculo

	return (date("md") < $m.$d ? date("Y")-$Y-1 : ("Y")-$Y); 	
}