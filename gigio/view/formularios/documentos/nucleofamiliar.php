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
						<li><a href="<?php echo $url; ?>view/formularios/" title="">Formularios</a></li>
						<li><a href="<?php echo $url; ?>view/formularios/individual.php" title="">Individual</a></li>
						<li class="active">Declaración de Núcleo Familiar</li>
					</ol>
				</div>
				<div class="row">
					<br>
					<div id="info"></div>
					<fieldset>
						<legend>Declaración por Comité</legend>
						<form class="form-horizontal" id="fnuc">
							<div class="form-group">
								<label class="col-md-4 control-label" for="nruk">Código Rukam: </label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="nruk" name="nruk" placeholder="Ingrese Código Rukam">
									<div id="sug"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="nlmd">Llamado: </label>
								<div class="col-md-6">
									<select class="form-control" id="nlmd" name="nlmd" >
										<option value="0">Escoja un llamado</option>
										<?php cargaCombo("select * from llamados"); ?>
									</select>
								</div>								
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="nnanio">Año: </label>
								<div class="col-md-6">
									<select class="form-control" id="nnanio" name="nnanio">
										<option value="0">Escoja un año</option>
										<?php cargaCombo("select distinct anio as idanio, anio from llamado_postulacion"); ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="button" class="btn btn-success" id="nbusc"><i class="fa fa-search"></i> Buscar</button>	
								</div>
								<div class="col-md-3">
									<div id="gbr"></div>
								</div>								
							</div>
						</form>
					</fieldset>
				</div>
				<div class="row">
					<div id="nlist"></div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/formularios.js"></script>
<script type="text/javascript">
	$("#nruk").blur(function() {
		$("#sug").fadeOut('fast');
	});
</script>
</html>