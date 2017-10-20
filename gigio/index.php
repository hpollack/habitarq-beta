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
include 'lib/php/libphp.php';
$url = url();

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/fa/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/hoja.css">
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/menu_ajax.js"></script>	
</head>
<body>
	<div class="container-fluid" style="align:center;">
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
				<div class="col-md-9 col-md-offset-1" id="cuerpo">
					<div class="row">
						<ol class="breadcrumb">
							<li class="active">Inicio</li>
						</ol>
						<?php if ($perfil != 2)  { ?>													
							<div class="col-md-4">
								<a href="<?php $url; ?>view/comite/" class="btn btn-primary btn-block"><i class="fa fa-group fa-5x" aria-hidden="true"></i><p> Comite</p></a>
							</div>
						<?php }else{ ?>
							<div class="col-md-4">
								<a href="javascript:void(0);" class="btn btn-default btn-block" disabled><i class="fa fa-group fa-5x" aria-hidden="true"></i><p> Comite</p></a>
							</div>
						<?php } ?>		
						<div class="col-md-4">
							<a href="<?php $url; ?>view/persona/" id="per" class="btn btn-success btn-block"><i class="fa fa-user fa-5x" aria-hidden="true"></i><p>Persona</p></a>
						</div>						
						<div class="col-md-4">
							<?php if ($perfil != 2)  { ?>
								<a href="<?php $url; ?>view/formularios/" class="btn btn-danger btn-block"><i class="fa fa-folder fa-5x" aria-hidden="true"></i><p>Formularios</p></a>
							<?php }else{ ?>
								<a href="javascript:void(0);" class="btn btn-default btn-block" disabled><i class="fa fa-folder fa-5x" aria-hidden="true"></i><p>Formularios</p></a>
							<?php } ?>
						</div>
					</div><br>
					<div class="row">							
						<div class="col-md-4">
							<a href="<?php $url; ?>view/contratistas/" class="btn btn-primary btn-block"><i class="fa fa-certificate fa-5x" aria-hidden="true"></i><p>Contratistas</p></a>
						</div>
						<div class="col-md-4">
							<a href="<?php $url; ?>view/calendario/" class="btn btn-success btn-block"><i class="fa fa-calendar fa-5x" aria-hidden="true"></i><p>Calendario</p></a>
						</div>
						<div class="col-md-4">
							<a href="<?php $url; ?>view/pagos/" class="btn btn-danger btn-block"><i class="fa fa-money fa-5x" aria-hidden="true"></i><p>Pagos</p></a>
						</div>
					</div><br>
					<div class="row">
						<div class="col-md-4">
							<a href="<?php $url; ?>view/obras/" class="btn btn-primary btn-block"><i class="fa fa-puzzle-piece fa-5x" aria-hidden="true"></i><p>Obras</p></a>
						</div>
						<div class="col-md-4">
							<a href="<?php $url; ?>view/modelos/" class="btn btn-success btn-block"><i class="fa fa-university fa-5x" aria-hidden="true"></i><p>Modelos de Ampliacion</p></a>
						</div>						
					</div>						
				</div>				
			</div>
		</div>
	</div>	
</body>
</html>

