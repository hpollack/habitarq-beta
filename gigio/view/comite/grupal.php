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
						<li><a href="<?php echo $url; ?>view/comite/">Comité</a></li>
						<li><a href="<?php echo $url; ?>view/comite/postulaciones.php">Postulaciones</a></li>
						<li class="active">Por grupo</li>
					</ol>
					<ul id="tab" class="nav nav-tabs">
						<li class="active"><a id="uno" href="#datosPostulacion" data-toggle="tab">Datos Postulación</a></li>
						<li><a id="dos" href="#postulantes" data-toggle="tab" >Postulantes</a></li>
					</ul>
					<div id="TabContent" class="nav nav-tabs">
						<div id="Tab" class="tab-content">
							<div class="tab-pane in active" id="datosPostulacion">
								<div id="res"></div>
								<form class="form-horizontal" id="fpos">
									<br>
									<div class="form-group">								
										<label class="col-md-4 control-label" for="num">Código Rukam: </label>
										<div class="col-md-6">
											<div class="input-group">
												<input type="text" id="num" name="num" class="form-control" placeholder="Ingrese Código y presione buscar">
												<span class="input-group-btn"><button class="btn btn-success" id="seek" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button></span>	
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">Nombre Comite: </label>
										<div class="col-md-6">
											<input type="hidden" id="idg" name="idg">
											<input type="hidden" id="pos" name="pos">
											<p class="form-control-static" id="nom"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="tit">Título: </label>
										<div class="col-md-6">
											<select id="tit" name="tit" class="form-control" disabled>
												<option value="0">Escoja título</option>
												<?php cargaCombo("select idtitulo_postulacion, titulo from titulo_postulacion"); ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="tip">Tipo Postulacion: </label>
										<div class="col-md-6">
											<select id="tip" name="tip" class="form-control" disabled>
												<option value="0">Escoja Tipo de Postulación</option>
												<?php cargaCombo("select idtipopostulacion, nombre from tipopostulacion"); ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="item">Item Postulacion: </label>
										<div class="col-md-6">
											<select id="item" name="item" class="form-control" disabled>
												<option value="0">Escoja Item</option>
												<?php cargaCombo("select iditem_postulacion, item_postulacion from item_postulacion"); ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="con">Contratista: </label>
										<div class="col-md-6">
											<select id="con" name="con" class="form-control" disabled>
												<option value="0">Escoja contratista</option>
												<?php cargaCombo("select rutprof, CONCAT(nombres,' ', apellidos) as nombre from profesionales"); ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="fi">Fecha Inicio: </label>
										<div class="col-md-6">
											<input class="form-control" type="text" id="fi" name="fi" placeholder="Ingrese Fecha (dd/mm/yyyy)" disabled>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="ds">Días de Duración de la Obra: </label>
										<div class="col-md-3">
											<input class="form-control" type="text" name="ds" id="ds" maxlength="3" placeholder="Ingrese Número de días" disabled>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-md-offset-4">
											<button id="grab" type="button" class="btn btn-primary" disabled><i class="fa fa-plus"></i> Grabar</button>
											<button id="edit" type="button" class="btn btn-primary" disabled><i class="fa fa-edit"></i> Editar</button>
											<button id="rs" type="reset" class="btn btn-warning"><i class="fa fa-refresh"></i> Limpiar</button>
											<button id="can" type="button" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</button>
										</div>
									</div>
								</form>
							</div>
							<div class="tab-pane" id="postulantes">
								<div id="resp"></div>
								<div id="lcomite"></div>
							</div>
							<div class="modal fade" id="EliminaSocio" role="dialog" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog modal-sm" id="msize">
									<div class="modal-content">								
									</div>
								</div>
							</div>	
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/postulacion.js"></script>
</body>
</html>