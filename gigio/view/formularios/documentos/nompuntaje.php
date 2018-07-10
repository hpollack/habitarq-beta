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
include '../../../lib/php/libphp.php';
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
						<li><a href="<?php echo $url; ?>view/formularios/grupal.php" title="">Colectivo</a></li>
						<li class="active">Nómina Puntaje y Antigüedad</li>
					</ol>
				</div>
				<div class="row">
					<div id="info"></div>					
					<h3 class="page-header">Nómina por Puntaje y Antigüedad.</h3>
					<form class="form-horizontal" action="<?php echo $url; ?>model/formularios/nompuntaje.php" method="post">
						<div class="form-group">
							<label class="col-md-4 control-label">Código Rukam: </label>
							<div class="col-md-6">
								<input class="form-control" type="text" id="ruk3" name="ruk3" placeholder="Ingrese Código Rukam">
								<div id="sug"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Llamado: </label>
							<div class="col-md-6">
								<select class="form-control" id="llmd3" name="llmd3" >
									<option value="0">Escoga Llamado</option>
									<?php cargaCombo("select * from llamados"); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="nanio">Año: </label>
							<div class="col-md-6">
								<select class="form-control" id="nanio" name="nanio">
									<option value="0">Escoga Año</option>
									<?php cargaCombo("select distinct anio as idanio, anio from llamado_postulacion"); ?>
								</select>
							</div>		
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button class="btn btn-success" type="button" id="seek3"><i class="fa fa-search"></i> Buscar</button>
							</div>
							<div class="col-md-2">
								<div id="gbr"></div>
							</div>
						</div>
						<div id="bnom">
							<h4 class="page-header">Resumen.</h4>
							<div class="form-group">
								<label class="col-md-4 control-label" for="anom">Nombre: </label>
								<div class="col-md-6">
									<p class="form-control-static" id="anom"></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="apos">N° Postulantes: </label>
								<div class="col-md-6">
									<p class="form-control-static" id="apos"></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="ppr">Promedio Puntaje: </label>
								<div class="col-md-6">
									<p class="form-control-static" id="ppr"></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="apr">Promedio Año: </label>
								<div class="col-md-6">
									<p class="form-control-static" id="apr"></p>
								</div>
							</div>							
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button class="btn btn-primary" id="asub" type="submit" formtarget="_self" disabled><i class="fa fa-download"></i> Generar</button>
								<button class="btn btn-warning" id="ars" type="reset"><i class="fa fa-refresh"></i> Limpiar</button>
								<button  class="btn btn-danger" type="button" id="acnl"><i class="fa fa-times"></i> Cancelar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?php echo $url ?>lib/js/control/formularios.js"></script>
<script type="text/javascript">
	$("#ruk3").blur(function() {
		$("#sug").fadeOut('fast');
	});
</script>
</html>