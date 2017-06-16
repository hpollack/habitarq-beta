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
						<li class="active">Cambiar Clave</li>
					</ol>
				</div>
				<div class="row">
					<div id="msg"></div>
					<form class="form-horizontal" id="fcl">
						<input type="hidden" id="nomuser" name="nomuser" class="form-control" value="<?php echo $_SESSION['rut']; ?>">
						<div class="form-group">
							<label class="col-md-4 control-label" for="cla">Contraseña Actual: </label>
							<div class="col-md-4">
								<input class="form-control" type="password" id="cla" name="cla" placeholder="Ingrese Clave Actual">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="cln">Nueva Contraseña: </label>
							<div class="col-md-4">
								<input class="form-control" type="password" id="cln" name="cln" placeholder="Ingrese Nueva Clave">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="rlv">Repita Nueva Contraseña: </label>
							<div class="col-md-4">
								<input class="form-control" type="password" id="rlv" name="rlv" placeholder="Repita Nueva Clave">
							</div>
						</div>
						<div class="col-md-6 col-md-offset-4">
							<button type="button" id="bclv" class="btn btn-primary"><i class="fa fa-edit"></i> Cambiar</button>
							<button type="button" id="cclv" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/config.js"></script>
</html>