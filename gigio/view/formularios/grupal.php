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
						<li><a href="<?php echo $url; ?>view/formularios/" title="">Formularios</a></li>
						<li class="active">Colectivo</li>
					</ol>
					<!-- <div class="alert alert-info alert-dismissable">
						<strong>Este apartado está en construcción</strong>
					</div> -->
					<h2 class="page-header">Panel de Control Formularios.</h2>
					<div class="row">
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/formularios/documentos/caratula.php" class="btn btn-warning btn-block"><i class="fa fa-file-excel-o fa-3x"></i><p>Carátula de Postulación Colectiva</p></a>
						</div>
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/formularios/documentos/nompostulantes.php" class="btn btn-warning btn-block"><i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i><p>Nómina de Postulantes</p></a>
						</div>
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/formularios/documentos/nompuntaje.php" class="btn btn-warning btn-block"><i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i><p>Nómina por puntaje y antigüedad</p></a>
						</div>							
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/formularios/documentos/nomfinanciera.php" class="btn btn-warning btn-block"><i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i><p>Nómina Financiera</p></a>
						</div>
						<div class="col-md-4">
							<a href="javascript:void(0);" class="btn btn-warning btn-block" disabled><i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i><p>Planilla Focalización</p></a>
						</div>
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/formularios/documentos/tipodeobra.php" class="btn btn-warning btn-block"><i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i><p>Planilla Tipo de Obra</p></a>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/formularios/documentos/nominaampliacion.php" class="btn btn-warning btn-block"><i class="fa fa-file-excel-o fa-3x"></i><p>Nómina con Direccion y Rol</p></a>
						</div>
						<div class="col-md-4">
							<a href="javascript:void(0);" class="btn btn-warning btn-block" disabled><i class="fa fa-file-excel-o fa-3x"></i><p>Nómina Tipo de Ampliación</p></a>
						</div>
						<div class="col-md-4">
							<a href="<?php echo $url ?>view/formularios/documentos/nomfinanciera2.php" class="btn btn-warning btn-block"><i class="fa fa-file-word-o fa-3x"></i><p>Nómina Financiera 2017</p></a>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>
</body>