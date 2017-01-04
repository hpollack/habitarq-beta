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
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
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
						<li class="active">Profesionales</li>						
					</ol>					
					<ul id="tab" class="nav nav-tabs">
						<li class="active"><a id="uno" href="#datos" data-toggle="tab" >Datos Profesional</a></li>						
					</ul>
					<div id="Tab" class="tab-content">
						<div id="datos" class="tab-pane fade in active">
							<br>
							<div id="res"></div>
							<form class="form-horizontal" id="prof">
								<div class="form-group">
									<label class="col-md-4 control-label" for="rut">Rut: </label>
									<div class="col-md-3">
										<input type="text" name="rut" id="rut" class="form-control">
									</div>
									<div class="col-md-1">
										<input type="text" name="dv" id="dv" class="form-control">
									</div>
									<div class="col-md-2">
										<button type="button" class="btn btn-success" id="seek">
											<i class="fa fa-search"></i>
											  Buscar
										</button>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="nom">Nombres: </label>
									<div class="col-md-6">
										<input type="text" id="nom" name="nom" class="form-control" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="ape">Apellidos: </label>
									<div class="col-md-6">
										<input type="text" id="ape" name="ape" class="form-control" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="dir">Direccion: </label>
									<div class="col-md-6">
										<input type="text" id="dir" name="dir" class="form-control" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label">Región: </label>
									<div class="col-md-6">
										<select id="reg" name="reg" class="form-control" disabled>
											<option value="0">Escoja region</option>
											<?php
											 cargaCombo("SELECT REGION_ID, REGION_NOMBRE FROM region");
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="pr">Provincia: </label>
									<div class="col-md-6">
										<select id="pr" name="pr" class="form-control" disabled>
											<option value="0">Seleccione una provincia</option>
											<?php
											cargaCombo("SELECT PROVINCIA_ID, PROVINCIA_NOMBRE FROM provincia");
											?>
										</select>
									</div>
								</div>										
								<div class="form-group">
									<label class="col-md-4 control-label" for="cm">Comuna: </label>
									<div class="col-md-6">
										<select id="cm" name="cm" class="form-control" disabled>
											<option value="0">Seleccione una comuna</option>
											<?php
											 cargaCombo("Select cm.COMUNA_ID, cm.COMUNA_NOMBRE FROM comuna AS cm");
											?>
										</select>
									</div>											
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="tel">Telefono: </label>
									<div class="col-md-6">
										<input type="text" id="tel" name="tel" class="form-control" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="em">Correo: </label>
									<div class="col-md-6">
										<input type="text" id="em" name="em" id="em" class="form-control" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="crg">Cargo: </label>
									<div class="col-md-6">
										<input type="text" id="crg" name="crg" class="form-control" disabled>
									</div>
								</div>								
								<div class="form-group">
									<label class="col-md-4 control-label" id="accion">Acciones: </label>
									<div class="col-md-6">																
										<button class="btn btn-primary" id="grab" type="button" disabled><i class="fa fa-plus fa-1x"></i> Grabar</button>
										<button class="btn btn-primary" id="edit" type="button" disabled><i class="fa fa-edit fa-1x"></i> Editar</button>
										<button class="btn btn-danger" id="can" type="button" disabled><i class="fa fa-ban fa-1x"></i> Cancelar</button>											
									</div>
								</div>
							</form>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/contratistas.js"></script>
</body>