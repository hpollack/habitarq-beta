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
			<div class="col-md-9" id="cuerpo">
				<div class="row">
					<ol class="breadcrumb">
						<li><a href="<?php echo $url; ?>">Inicio</a></li>
						<li><a href="<?php echo $url; ?>/view/config/" >General</a></li>
						<li><a href="<?php echo $url; ?>view/config/dataconfig.php" title="">Registros y Base de Datos</a></li>
						<li class="active">Ver Registros</li>
					</ol>	
				</div>
				<div class="row">
						<br>
						<div id="ralerta"></div>
					<fieldset>
						<legend>Filtros</legend>
						<form class="form-horizontal" id="freg">
							<div class="form-group">
								<label class="col-md-4 control-label" for="fi">Fecha Inicio: </label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="fi" name="fi" placeholder="Ingrese Fecha de Inicio (dd/mm/yyyy)">	
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="ft">Fecha Final: </label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="ft" name="ft" placeholder="Ingrese Fecha Final (dd/mm/yyyy)">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="us">Usuario: </label>
								<div class="col-md-4">
									<select class="form-control" id="us" name="us">
										<option value="0">Escoga Usuario</option>
										<?php cargaCombo("select idusuario, concat(nombre,' ', apellidos) from usuarios"); ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="act">Accion: </label>
								<div class="col-md-4">
									<select class="form-control" id="act" name="act">
										<option value="no">Escoja Item</option>
										<option value="add"> Agregar</option>
										<option value="update"> Modificar</option>
										<option value="del">Eliminar</option>
										<option value="error"> Errores</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button class="btn btn-success" type="button" id="flt"><i class="fa fa-filter"></i> Filtrar</button>
								</div>
								<div class="col-md-2" id="fil"></div>
							</div>
						</form>						
					</fieldset>
				</div>
				<div class="row">
					<div id="lreg"></div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/config.js"></script>
</body>
</html>