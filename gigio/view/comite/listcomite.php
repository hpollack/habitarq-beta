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
</head>
<body>
	<div class="container-fluid">
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
				<div class="col-md-9" id="cuerpo">
					<div class="row">
						<ol class="breadcrumb">
							<li ><a href="<?php echo $url; ?>">Inicio</a></li>
							<li><a href="<?php echo $url; ?>view/comite/">Comite</a></li>
							<li class="active">Listado</li>
						</ol>
						<div class="row">
							<div id="info"></div>
							<div class="col-md-12" id="fmgp">
								<h3 class="page-header">Agregar Miembro</h3>
								<form class="form-horizontal" id="mgp">
									<div class="form-group">
										<label class="col-md-4 control-label" for="mbusc">Buscar: </label>
										<div class="col-md-6">
											<div class="input-group">
												<input type="text" id="mrp" name="rp" class="form-control" placeholder="Ingrese Rut y presione buscar">
												<span class="input-group-btn"><button class="btn btn-success" id="mbusc" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button></span>			
											</div>
											<div id="sug"></div>
										</div>										
										<div id="mrg"></div>	
									</div>
									<hr>
									<div id="malerta"></div>
									<div id="mdpersona"></div>
									<div class="row">
										<div class="form-group">
											<input type="hidden" name="cmt" id="cmt" class="form-control">
											<label class="col-md-4 control-label">Comite: </label>
											<div class="col-md-6">
												<p id="nomb" class="form-control-static"></p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Cargo: </label>
											<div class="col-md-5">
												<select id="crg" name="crg" class="form-control" disabled>
													<option value="0">Escoja cargo</option>
													<?php 													
														cargaCombo("select * from comite_cargo");
													 ?>
												</select>
											</div>											
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="es">Estado: </label>
											<div class="col-md-5">
												<select id="es" name="es" class="form-control">
													<option value="Postulante">Postulante</option>
													<option value="No Postulante">No Postulante</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6 col-md-offset-4">
												<button type="button" class="btn btn-info" id="lsc2">
													<span class="fa fa-list"></span>
													 Ver Lista de Comités	
												</button>
												<button type="button" class="btn btn-info" id="lsc">
													<span class="fa fa-list"></span>
													 Ver lista de socios
												</button>
												<button type="button" class="btn btn-primary" id="mag" disabled>
												<span class="fa fa-check-circle"></span>
												  Asignar
												</button>												
												<button type="button" class="btn btn-danger" id="cn">
													<span class="fa fa-times"></span>
													 Cancelar
												</button>												
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="col-md-12">							
								<div id="lcomite"></div>
							</div>
							<div class="modal fade" id="myModal" role="dialog" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog" id="msize">
									<div class="modal-content">								
									</div>
								</div>
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
	<script type="text/javascript" src="<?php echo $url;?>lib/js/control/comite.js"></script>
</body>
</html>