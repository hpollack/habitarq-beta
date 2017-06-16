<?php 
session_start();
//$rutus = '1-9';
$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: login.php");
	exit();
}

if ($perfil != 1) {
	echo "Este apartado es solo para el administrador";
	header("location: login.php");
}
include '../../lib/php/libphp.php';
$url = url();
$conn = conectar();

$RegConfig = mysqli_fetch_row(mysqli_query($conn, "select valor from configuracion where idconfig = 8"));
$RegDB = mysqli_fetch_row(mysqli_query($conn, "select valor from configuracion where idconfig = 9"));
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/fa/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/hoja.css">
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="<?php echo $url; ?>lib/calendario/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/calendario/locales/bootstrap-datepicker.es.min.js" charset="utf-8"></script>	
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/calendario/css/bootstrap-datepicker3.css">
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/additional-methods.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/localization/messages_es.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/menu_ajax.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
						<div class="navbar-header">						 
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
							</button> <a class="navbar-brand" href="#">Sistema E.P. Habitarq</a>
						</div>					
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<?php get_nav($perfil, $_SESSION['usuario']); ?>
						</div>					
					</nav>
				</div>				
			</div>
			<div class="col-md-9" id="cuerpo">
				<div class="row">
					<ol class="breadcrumb">
						<li><a href="<?php echo $url; ?>">Inicio</a></li>
						<li><a href="<?php echo $url; ?>/view/config/" >General</a></li>
						<li class="active">Registros y Base de Datos</li>
					</ol>					
				</div>
				<div class="row">
					<br>
					<div id="rmsg"></div>
					<form class="form-horizontal" id="fdb">									
						<fieldset>
							<legend>Configuración</legend>
							<p class="text text-info">Configuración de todo lo referente a los registros del sistema. Estos son tomados en cada acción que se realiza por lo que suelen acumularse con el tiempo, lo que podría afectar el rendimiento del sistema</p>
							<p class="text text-warning"><span class="fa fa-exclamation-triangle"></span> <b>Los cambios que haga, afectarán al resto del sistema. Si no está seguro, deje los valores por defecto</b></p>
							<h4 class="page-header">Cantidad de Días que se mantendrán los registros</h4>
							<div class="form-group">
								<label class="col-md-4 control-label" for="lr">Limpiar Registros: </label>
								<div class="col-md-4">
									<label class="form-control-static"><input type="checkbox" id="lr" name="lr" value="1"></label>
									<span class="text text-justify"><small>Valor por defecto: no.</small></span>
									<p><small>Si activa este parámetro, podrá configurar el rango de días que se mantendrán los registros.</small></p>
								</div>								
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="dr">Cantidad de días: </label>
								<div class="col-md-4">
									<input type="text" id="dr" name="dr" class="form-control" placeholder="Días en Números" value="<?php echo $RegConfig[0]; ?>" disabled>
									<p class="text text-justify"><small>Valor por defecto: 0. Los registros que se mantendrán, serán los que estén dentro del rango de días ingresado</small></p>
								</div>
								<div class="col-md-2">
									<a class="btn btn-primary" href="<?php echo $url ?>view/config/registros.php"><i class="fa fa-eye"></i> Ver Registros</a>
								</div>
							</div>
							<h4 class="page-header">Respaldo de la Base de datos</h4>
							<p class="text text-info">Configuración del respaldo de la base de datos. El sistema generará una copia de la información, que será respaldada en el servidor</p>
							<p class="text text-warning"><span class="fa fa-exclamation-triangle"></span> <b>Si no está seguro, deje los valores por defecto.</b></p>
							<div class="form-group">
								<label class="col-md-4 control-label" for="dbd">Cantidad de días: </label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="dbd" name="dbd" value="<?php echo $RegDB[0]; ?>" placeholder="Ingrese los días">
									<p class="text text-justify"><small>Valor por defecto: 0. La base de datos se respaldará automáticamente, de acuerdo al rango de días agregado. Si se mantiene en 0, no se realizará el respaldo</small></p>
								</div>
								<div class="col-md-2">
									<button class="btn btn-primary" type="button" id="rdbm"><i class="fa fa-database"></i> Respaldar Ahora</button>
								</div>
							</div>
							<div class="col-md-6 col-md-offset-4">
								<button class="btn btn-primary" type="button" id="gdb"><i class="fa fa-plus"></i> Guardar</button>	
								<button class="btn btn-danger" type="button" id="cdb"><i class="fa fa-times"></i> Cancelar</button>
							</div>
						</fieldset>						
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/config.js"></script>
</body>
</html>