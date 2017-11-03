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
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>	
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/calendario/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/calendario/locales/bootstrap-datepicker.es.min.js" charset="utf-8"></script>	
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/calendario/css/bootstrap-datepicker3.css" />
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
						<li class="active">Calendario</li>
					</ol>					
					<?php alertaEvento(); ?>
					<div id="alerta"></div>
					<form class="form-horizontal">
						<div class="form-group">
							<div class="col-md-4">
								<input type="text" id="mes" name="mes" class="form-control">
							</div>
							<div class="col-md-3">
								<button type="button" id="cm" class="btn btn-primary"><i class="fa fa-calendar"></i> Cambiar Mes</button>		
							</div>
							<div class="col-md-3">
								<button type="button" id="aev" class="btn btn-primary" data-toggle="modal" data-target="#agregaEventoCal" data-whatever="<?php echo $url; ?>view/calendario/evento.php">
									<i class="fa fa-bookmark"></i> Agregar Evento
								</button>
							</div>							
						</div>
						
					</form>
					<div id="calendario"></div>
					<div class="modal fade" id="agregaEventoCal" role="dialog" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-sm" id="msize">
							<div class="modal-content">
								<form class="form-horizontal" id="ev">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h3>Agregar Evento</h3>
									</div>
									<div class="modal-body">
										<div id="msg"></div>
										<div class="form-group">
											<label class="col-md-4 control-label">Fecha Inicio: </label>
											<div class="col-md-6">
												<input class="form-control f-date" type="text" id="fev" name="fev" placeholder="Ingrese Fecha (dd/mm/yyyy)">
											</div>			
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Hora Inicio: </label>
											<div class="col-md-6">
												<input class="form-control time" type="time" id="hev" name="hev" value="" placeholder="Ingrese Hora (hh:mm)">
											</div>
										</div>	
										<div class="form-group">
											<label class="col-md-4 control-label">Fecha Final: </label>
											<div class="col-md-6">
												<input class="form-control f-date" type="text" id="ffv" name="ffv" placeholder="Ingrese Fecha (dd/mm/yyyy)">
											</div>			
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Hora Final: </label>
											<div class="col-md-6">
												<input class="form-control" type="time" id="hfv" name="hfv" value="" placeholder="Ingrese Hora (hh:mm)">
											</div>
										</div>		
										<div class="form-group">
											<label class="col-md-4 control-label">Título: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="tev" name="tev" placeholder="Ingrese Titulo">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Detalles: </label>
											<div class="col-md-6">
												<textarea class="form-control" rows="10" id="cev" name="cev" placeholder="Ingrese Detalle (máximo 200 caracteres)" maxlength="200"></textarea>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<div class="form-group">
											<div class="col-md-6 col-md-offset-4">
												<button type="button" class="btn btn-primary" id="agev" ><i class="fa fa-plus"></i> Grabar</button>
												<button type="reset" class="btn btn-warning" id="rev"><i class="fa fa-reset"></i> Limpiar</button>
												<button type="button" class="btn btn-danger" id="cev" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>	
											</div>
										</div>
									</div>
								</form>								
							</div>
						</div>
					</div>
					<div class="modal fade" id="editaEventoCal" role="dialog" tabindex="-1" aria-hidden="true"></div>					
				</div>
			</div>
		</div>
	</div>	
	<script type="text/javascript" src="<?php echo $url ?>lib/js/control/calendario.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/control/evento.validate.js"></script>
</body>
</html>