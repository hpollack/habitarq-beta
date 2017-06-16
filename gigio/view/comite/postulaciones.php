<?php
session_start();
include_once '../../lib/php/libphp.php';
$url = url();
$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".$url."login.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="es">
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
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/menu_ajax.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
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
						<li ><a href="<?php echo $url; ?>">Inicio</a></li>
						<li><a href="<?php echo $url; ?>view/comite/">Comité</a></li>
						<li class="active">Postulaciones</li>
					</ol>
					<h2 class="page-header">Panel Postulaciones</h2>					
					<div class="col-md-4">
						<a href="<?php echo $url; ?>view/comite/individual.php" class="btn btn-primary btn-block"><i class="fa fa-user fa-3x"></i><p>Individual</p></a>
					</div>
					<div class="col-md-4">
						<a href="<?php echo $url; ?>view/comite/grupal.php" class="btn btn-primary btn-block"><i class="fa fa-users fa-3x"></i><p>Por grupo</p></a>
					</div>					
				</div>
			</div>
		</div>
	</div>
</body>