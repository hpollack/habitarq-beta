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
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top""" role="navigation">
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
							<li ><a href="<?php echo $url; ?>">Inicio</a></li>
							<li><a href="<?php echo $url; ?>view/config/" >General</a></li>
							<li class="active">Feriados</li>
						</ol>						
						<div id="fms"></div>
						<h3 class="page-header">Configuración de Feriados</h3>
						<p class="text text-info">Este apartado permite agregar las fechas que no serán hábiles, tales como feriados nacionales o días de celebración cristiana.</p>
						<p class="text-info">Estos días ingresados, serán incluidos en la configuración según corresponda.</p>
						<form class="form-horizontal" id="fer">
							<fieldset>
								<legend>Feriados</legend>
								<div class="form-group">
									<label class="col-md-4 control-label" for="fech">Fecha: </label>
									<div class="col-md-4">
										<input type="text" class="form-control" id="fech" name="fech" placeholder="Ingrese Fecha (dd/mm/yyyy">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="mot">Motivo: </label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="mot" name="mot" placeholder="Ingrese Motivo">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="button" class="btn btn-primary" id="bfech"><i class="fa fa-plus"></i> Grabar</button>
									</div>
								</div>
							</fieldset>
						</form>
						<div id="c"></div>
					</div>					
					<div class="row">
						<div id="lfer"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url ?>lib/js/control/config.js"></script>
</body>
</html>