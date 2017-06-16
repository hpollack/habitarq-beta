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

if ($perfil != 1) {
	echo "Este apartado es solo para el administrador";
	header("location: login.php");
}
include '../../lib/php/libphp.php';
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
			</div>
			<div class="col-md-9" id="cuerpo">
				<div class="row">
					<ol class="breadcrumb">
						<li><a href="<?php echo $url; ?>">Inicio</a></li>												
						<li class="active">Gestion de Usuarios</li>
					</ol>
				</div>
				<div class="row">
					<form class="form-horizontal" id="fus">
						<br>
						<div id="msg"></div>
						<fieldset>
							<legend>Formulario de Gestión de Usuario</legend>
							<div class="form-group">
								<label class="col-md-4 control-label" for="us">Nombre de Usuario: </label>
								<div class="col-md-6">
									<div class="input-group">
										<input type="text" id="us" name="us" class="form-control" placeholder="Ingrese Usuario y presione buscar">
										<span class="input-group-btn"><button class="btn btn-success" id="seek" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button></span>				
									</div>
									<span class="bsc"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="nom">Nombres: </label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="nom" name="nom" placeholder="Ingrese Nombres" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="ap">Apellidos: </label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="ap" name="ap" placeholder="Ingrese Apellidos" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="mail">Correo Electrónico: </label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="mail" name="mail" placeholder="Ingrese Correo Electrónico" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="clv">Contraseña: </label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="clv" name="clv" placeholder="Ingrese Contraseña" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="pfl">Perfil: </label>
								<div class="col-md-6">
									<select id="pfl" name="pfl" class="form-control" disabled>
										<option value="0">Escoja Perfil de Usuario</option>
										<?php cargaCombo("select * from perfil"); ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="est">Estado</label>
								<div class="col-md-6">
									<label><input type="checkbox" id="est" name="est" value="1"> ¿Vigente?</label>								
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="button" class="btn btn-primary" id="grb" disabled><i class="fa fa-plus"></i> Grabar</button>
									<button type="button" class="btn btn-primary" id="edt" disabled><i class="fa fa-edit"></i> Editar</button>
									<button type="reset" class="btn btn-warning" id="rst"><i class="fa fa-refresh"></i> Limpiar</button>
									<button type="button" class="btn btn-danger" id="cnl"><i class="fa fa-times"></i> Cancelar</button>
								</div>
							</div>
						</fieldset>						
					</form>
				</div>
				<div class="row">
					<div id="lusuarios"></div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/config.js"></script>
</body>
</html>