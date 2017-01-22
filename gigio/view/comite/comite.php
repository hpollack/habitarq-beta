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
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top""" role="navigation">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
							</button> <a class="navbar-brand" href="#">Logo</a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<?php get_nav($perfil, $nombre); ?>
						</div>
					</nav>
				</div>
				<div class="col-md-9" id="cuerpo">
					<div class="row">
						<ol class="breadcrumb">
							<li ><a href="<?php echo $url; ?>">Inicio</a></li>
							<li ><a href="<?php echo $url; ?>view/comite/">Comité</a></li>
							<li class="active">Datos Comite</li>
						</ol>
						<ul id="tab" class="nav nav-tabs">
							<li class="active"><a id="uno" href="#datos" id="ficha" data-toggle="tab">Datos Comite</a></li>
							<li><a href="#directiva" id="dos" data-toggle="tab">Inscritos</a></li>							
						</ul>
						<div id="TabContent" class="nav nav-tabs">							
							<div id="Tab" class="tab-content">
								<div class="tab-pane in active" id="datos">
									<br>
									<div id="res"></div>
									<form class="form-horizontal" id="dcom">
										<div class="form-group">
											<label class="col-md-4 control-label">Numero: </label>
											<div class="col-md-4">
												<input type="hidden" name="idg" id="idg">
												<input type="text" name="num" id="num" class="form-control" placeholder="Ingrese Numero">
											</div>
											<div class="col-md-2">
												<button type="button" class="btn btn-success" id="seek">
													<span class="fa fa-search"></span> Buscar
												</button>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Fecha: </label>
											<div class="col-md-6">
												<input type="text" name="fec" id="fec" class="form-control" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Nombre Comité: </label>
											<div class="col-md-6">
												<input type="text" name="nc" id="nc" class="form-control" disabled>
											</div> 																			
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Personalidad: </label>
											<div class="col-md-6">
												<p id="nper" class="form-control-static"></p>
												<input type="hidden" name="per" id="per">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Dirección: </label>
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
													<option value="0">Escoja provincia</option>
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
													<option value="0">Escoga comuna</option>
													<?php
													 cargaCombo("Select cm.COMUNA_ID, cm.COMUNA_NOMBRE FROM comuna AS cm");
													?>
												</select>
											</div>											
										</div>										
										<div class="form-group">
											<label class="col-md-4 control-label">Egis: </label>
											<div class="col-md-6">
												<select id="egis" name="egis" class="form-control" disabled>
													<option value="0">Escoga Egis</option>
													<?php 
													cargaCombo("select idegis, nombre from egis");
													 ?>			
												</select>
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
								<div class="tab-pane" id="directiva">
									<br>
									<form class="form-horizontal" id="gp">
										<div class="form-group">
											<label class="col-md-4 control-label" for="busc">Buscar: </label>
											<div class="col-md-4">
												<input type="text" id="rp" name="rp" class="form-control" placeholder="Ingrese Rut">						
											</div>											
											<div class="col-md-2">
												<button type="button" class="btn btn-success" id="busc">
													<i class="fa fa-search fa-1x"></i> Buscar
												</button>
											</div>
											<div class="col-md-2">
												<span id="rg"></span>
											</div>
										</div>
										<hr>
										<div id="alerta"></div>
										<div id="dpersona"></div>
										<div class="row">
											<div class="form-group">
												<label class="col-md-4 control-label">Comité: </label>
												<div class="col-md-5">
													<select id="cmt" name="cmt" class="form-control" disabled>
														<option value="0">Seleccione Comité</option>
														<?php cargaCombo("select idgrupo, nombre from grupo"); ?>
													</select>
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
												<div class="col-md-2">
													<button type="button" class="btn btn-primary" id="ag" disabled>
														<span class="fa fa-check-circle"></span>
														  Asignar
													</button>
												</div>
											</div>
											<div class="col-md-8 col-md-offest-2" id="lista">										
											</div>
										</div>
									</form>
								</div>								
							</div>								
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/comite.js"></script>
</html>
