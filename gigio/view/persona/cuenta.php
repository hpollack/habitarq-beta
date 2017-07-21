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
<!doctype>
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
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/bootstrap.min.js"></script>
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
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
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
				<div class="col-md-11" id="cuerpo">
					<div class="row">
						<ol class="breadcrumb">
							<li ><a href="<?php echo $url; ?>">Inicio</a></li>
							<li><a href="<?php echo $url; ?>view/persona/">Persona</a></li>
							<li>Datos Cuenta</li>
						</ol>
						<ul id="Tab" class="nav nav-tabs">
							<li class="active"><a id="#vivienda" href="#" data-toggle = "tab">Datos Cuenta</a></li>
						</ul>
						<div id="TabContent" class="nav nav-tabs">
							<form class="form-horizontal" id="cuen">
								<div class="tab-pane fade in active" id="cuenta">
										<br>
										<div id="resp"></div>
										<div class="form-group">
											<label class="col-md-4 control-label">RUT Persona: </label>
											<div class="col-md-6">
												<div class="input-group">
													<input type="text" id="rut" name="rut" class="form-control" placeholder="Ingrese Rut y presione buscar">
													<span class="input-group-btn"><button class="btn btn-success" id="busc" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button></span>				
												</div>
												<div id="sug"></div>
												<span id="b"></span>											
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Nombre Titular: </label>
											<div class="col-md-6">
												<p class="form-control" id="nom"></p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="nc">N° Cuenta</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="nc" name="nc" placeholder="Ingrese Numero de Cuenta" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="fap">Fecha de Apertura: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="fap" name="fap" placeholder="Ingrese fecha de Apertura (dd/mm/yyyy)" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Ahorro/Subsidio: </label>
											<div class="col-md-3">
												<label><input type="checkbox" id="ahc" name="ahc" value="1" disabled> Ahorro.</label>
											</div>
											<div class="col-md-3">
												<label><input type="checkbox" id="suc" name="suc" value="1" disabled> Subsidio.</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="ah">Ahorro: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="ah" name="ah" placeholder="Ingrese Cantidad de UF" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="sb">Subsidio: </label>
											<div class="col-md-6">
												<select class="form-control" name="sb" id="sb" disabled>
													<option value="0">Escoja un subsidio</option>
													<?php cargaCombo("select valor, concat(clave,' (',valor,')') from configuracion where idconfig between 3 and 6"); ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="td">Total en UF: </label>
											<div class="col-md-6">
												<input type="hidden" class="form-control" id="td" name="td" placeholder="Total">
												<p class="text text-success form-control-static" id="vtd"></p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="tp">Total en pesos: </label>
											<div class="col-md-6">												
												<p class="text text-success form-control-static" id="tp"></p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" id="accion">Acciones: </label>
											<div class="col-md-6">
												<button class="btn btn-primary" id="grab" type="button" disabled><i class="fa fa-plus fa-1x"></i> Grabar</button>
												<button class="btn btn-primary" id="edit" type="button" disabled ><i class="fa fa-edit fa-1x"></i> Editar</button>
												<button class="btn btn-warning" type="reset" id="rs"><i class="fa fa-refresh"></i> Limpiar</button>
												<button class="btn btn-danger" id="del" type="button" ><i class="fa fa-times fa-1x"></i> Cancelar</button>
											</div>
										</div>
									</div>
							</form>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/cuenta.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/control/cuenta.validate.js"></script>
</body>
</html>