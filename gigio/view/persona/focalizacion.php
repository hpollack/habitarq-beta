<?php
session_start();
include_once '../../lib/php/libphp.php';
$url = url();
$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
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
							</button> <a class="navbar-brand" href="#">Logo</a>
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
							<li><a href="<?php echo $url; ?>view/persona/">Datos Persona</a></li>
							<li>Focalizacion</li>
						</ol>
						<ul class="nav nav-tabs">
							<li class="active"><a id="#focalizacion" href="#" data-toggle = "tab">Datos Focalización</a></li>
						</ul>
					</div>
					<div id="tabContent" class="nav nav-tabs">
						<form class="form-horizontal" id="focal">
							<div class="tab tab-pane fade in active" id="focal">
							<br>
							<div id="resp"></div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="rut">RUT: </label>
									<div class="col-md-6">
										<div class="input-group">
											<input type="text" id="rut" name="rut" class="form-control" maxlength="8" placeholder="Ingrese Rut y presione buscar">
											<span class="input-group-btn"><button class="btn btn-success" id="busc" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button></span>			
										</div>
										<span id="b"></span>
										<div id="sug"></div>
										<input type="hidden" id="idg" name="idg">										
									</div>
								</div>								
								<div id="alerta"></div>
								<h4 class="page-header">Datos Personales</h4>
								<div id="dp">
									<div class="form-group">
										<label class="col-md-4 control-label">RUT: </label>
										<div class="col-md-6">
											<p class="form-control-static" id="r"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">Nombre: </label>
										<div class="col-md-6">
											<p class="form-control-static" id="nom"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">N° Ficha: </label>
										<div class="col-md-6">
											<p class="form-control-static" id="fic"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">Comité: </label>
										<div class="col-md-6">
											<p class="form-control-static" id="ng"></p>
										</div>
									</div>				
								</div>
								<h4 class="page-header">1° - Requerimientos por familia</h4>							
								<div class="form-group">
									<label class="col-md-4 control-label" for="ed">Edad: </label>
									<div class="col-md-2">
										<p class="form-control-static" id="ed"></p>
									</div>
									<div class="col-md-2">
										<input type="checkbox" id="fed" name="fed" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="dis">Discapacidad: </label>
									<div class="col-md-2">
										<p class="form-control-static" id="dis"></p>
									</div>
									<div class="col-md-2">
										<input type="checkbox" id="fdis" name="fdis" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="hac">Hacinamiento: </label>
									<div class="col-md-2">
										<p class="form-control-static" id="hac"></p>
									</div>
									<div class="col-md-2">
										<input type="checkbox" id="fhac" name="fhac" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label">Metros Casa Original: </label>
									<div class="col-md-2">
										<p class="form-control-static" id="mts"></p>
									</div>
									<div class="col-md-2">
										<input type="checkbox" id=fmts name="fmts" disabled>
									</div>
								</div>
								<h4 class="page-header">2° - Territorio</h4>
								<div class="form-group">
									<label class="col-md-4 control-label" for="at">Acondicionamiento térmico: </label>
									<div class="col-md-4">
										<input type="checkbox" id="at" name="at" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="soc">Afectados por Socavones: </label>
									<div class="col-md-4">
										<input type="checkbox" id="soc" name="soc" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="xil">Afectados por Xilófagos: </label>
									<div class="col-md-4">
										<input type="checkbox" id="xil" name="xil" disabled>
									</div>
								</div>								
								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="button" class="btn btn-primary" id="grab"><i class="fa fa-plus"></i> Grabar</button>
										<button type="button" class="btn btn-primary" id="edit"><i class="fa fa-edit"></i> Editar</button>
										<button type="reset" class="btn btn-warning" id="rst"><i class="fa fa-refresh"></i> Limpiar</button>
										<button type="button" class="btn btn-danger" id="can"><i class="fa fa-times"></i> Cancelar</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/focalizacion.js"></script>
</body>
</html>