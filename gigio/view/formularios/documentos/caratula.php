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
						<li class="active">Carátula de Postulación Colectiva</li>
					</ol>
					<div class="row">
						<div id="info"></div>
						<h3 class="page-header">Carátula de Postulación Colectiva</h3>
						<form class="form-horizontal" id="fcar" action="<?php echo $url; ?>model/formularios/caratula.php" method="post">
							<div class="form-group">
								<label class="col-md-4 control-label" for="ruk">Código Rukam: </label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="ruk" name="ruk" placeholder="Ingrese Código">									
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="lmd">Llamado: </label>
								<div class="col-md-6">
									<select id="lmd" name="lmd" class="form-control">
										<option value="0">Escoja Llamado</option>
										<?php cargaCombo("select * from llamados"); ?>
									</select>
								</div>								
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="canio">Año: </label>
								<div class="col-md-6">
									<select class="form-control" id="canio" name="canio">
										<option value="0">Escoga Año</option>
										<?php cargaCombo("select distinct anio as idanio, anio from llamado_postulacion"); ?>
									</select>
								</div>		
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="button" class="btn btn-success" id="seek"><i class="fa fa-search"></i> Buscar</button>
								</div>
								<div class="col-md-2">
									<span id="bgr"></span>
								</div>
							</div>
							<div id="dgr">
								<h4 class="page-header">Resumen de Información.</h4>
								<div class="form-group">
									<label class="col-md-4 control-label">Nombre Comité: </label>
									<div class="col-md-6">
										<p id="nom" class="form-control-static"></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="tit">Título: </label>
									<div class="col-md-6">
										<p id="tit" class="form-control-static"></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="pj">Personalidad Jurídica: </label>
									<div class="col-md-6">
										<p id="pj" class="form-control-static"></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="rl">Representante Legal: </label>
									<div class="col-md-6">
										<p id="rl" class="form-control-static"></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="at">Asistente Técnico: </label>
									<div class="col-md-6">
										<p id="at" class="form-control-static"></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="ctr">Contratista: </label>
									<div class="col-md-6">
										<p id="ctr" class="form-control-static"></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="np">N° Postulantes: </label>
									<div class="col-md-6">
										<p id="np" class="form-control-static"></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="tf">Total Financiamiento UF: </label>
									<div class="col-md-6">
										<p id="tf" class="form-control-static"></p>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label class="col-md-4 control-label" for="org">Grupo Organizado: </label>
								<div class="col-md-6">
									<label><input type="checkbox" class="form-control-static" id="org" name="org" value="1" disabled></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="cnv">Convenio: </label>
								<div class="col-md-6">
									<label><input type="checkbox" class="form-control-static" id="cnv" name="cnv" value="1" disabled></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="cnt">Contrato: </label>
								<div class="col-md-6">
									<label><input type="checkbox" class="form-control-static" id="cnt" name="cnt" value="1" disabled></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="reg">Inscrito en Registro: </label>
								<div class="col-md-6">
									<label><input type="checkbox" class="form-control-static" id="reg" name="reg" value="1" disabled></label>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button class="btn btn-primary" type="submit" id="gcar" formtarget="_self" disabled><i class="fa fa-download"></i> Generar</button>
									<button type="reset" class="btn btn-warning" id="rcar"><i class="fa fa-refresh"></i> Limpiar</button>
									<button type="button" class="btn btn-danger" id="cnr"><i class="fa fa-times"></i> Cancelar</button>
								</div>								
							</div>
							<div id="resp"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/formularios.js"></script>
</body>
</html>
