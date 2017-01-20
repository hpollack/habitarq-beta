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
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/fa/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/hoja.css">
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/calendario/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/calendario/locales/bootstrap-datepicker.es.min.js" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/calendario/css/bootstrap-datepicker3.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top""">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
							</button> <a class="navbar-brand" href="#">Logo</a>
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
						<li><a href="<?php echo $url; ?>view/comite/postulaciones.php">Postulaciones</a></li>
						<li class="active">Individual</li>
					</ol>
					<div class="alert alert-info alert-dismissable">
						<strong>Este apartado está en construcción</strong>						
					</div>
					<ul id="tab" class="nav nav-tabs">
						<li class="active"><a id="uno" href="#datos" data-toggle="tab" >Datos Postulación</a></li>
					</ul>
					<div id="Tab" class="tab-content">
						<div id="datos" class="tab-pane in active">
							<br>
							<div id="res"></div>
							<form class="form-horizontal" id="pin">
								<div class="form-group">
									<label class="col-md-4 control-label">Rut: </label>
									<div class="col-md-4">
										<input type="text" name="rut" id="rut" class="form-control">
									</div>
									<div class="col-md-2" id="seek">
										<button class="btn btn-success">
											<i class="fa fa-search"></i>
											  Buscar
										</button>
									</div>
								</div>
								<div id="dpos">
									<h5 class="page-header">Datos Postulante</h5>
									<div class="form-group">
										<label class="col-md-4 control-label" >Nombre: </label>
										<div class="col-md-6">
											<p id="nom" class="form-control-static"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">Direccion: </label>
										<div class="col-md-6">
											<p id="dir" class="form-control-static"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">Comuna:</label>
										<div class="col-md-6">
											<p id="dir" class="form-control-static"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">Tramo: </label>
										<div class="col-md-6">
											<p id="trm" class="form-control-static"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">Déficit: </label>
										<div class="col-md-6">
											<p id="def" class="form-control-static"></p>
										</div>
									</div>
								</div>
								<h5 class="page-header">Formulario Postulación</h5>
								<div class="form-group">
									<label class="col-md-4 control-label">DS10</label>
									<div class="col-md-6">
										<select id="ds10" class="form-control">
											<option value="0">Escoga una opción</option>
											<?php cargaCombo("select * from ds10"); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label">Tipo de Vivienda:</label>
									<div class="col-md-6">
										<select id="trs" name="trs" class="form-control" disabled>
											<option value="0">Escoja tipo de residencia</option>
											<?php cargaCombo("select * from tipo_residencia"); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label">Items: </label>
									<div class="col-md-6">
										<?php cargaCheckbox("select * from item_postulacion", "itm"); ?>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>