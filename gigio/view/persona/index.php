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
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/menu_ajax.js"></script>
</head>
<body>
	<div class="container-fluid" style="align:center;">		
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top""" role="navigation">
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
				<div class="col-md-9" id="cuerpo">					
					<div class="row">
						<ol class="breadcrumb">
							<li ><a href="<?php echo $url; ?>">Inicio</a></li>
							<li class="active">Persona</li>
						</ol>
						<h2>Panel de Control Módulo Persona.</h2>										
						<br>						
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/persona/persona.php" class="btn btn-success btn-block"><i class="fa fa-user fa-3x"></i><p>Datos Básicos</p></a>
						</div>
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/persona/ficha.php" class="btn btn-success btn-block"><i class="fa fa-file-text fa-3x"></i><p>Datos Ficha</p></a>
						</div>
						<div class="row">						
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/persona/vivienda.php" class="btn btn-success btn-block"><i class="fa fa-home fa-3x"></i><p>Datos Vivienda</p></a>
						</div>							
					</div>					
						<br>
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/persona/cuenta.php" class="btn btn-success btn-block"><i class="fa fa-credit-card-alt fa-3x"></i><p>Datos Cuenta</p></a>
						</div>
						<?php if ($perfil != 2)  { ?>						
							<div class="col-md-4">
								<a href="<?php echo $url; ?>view/persona/focalizacion.php" class="btn btn-success btn-block"><i class="fa fa-indent fa-3x"></i><p>Datos Focalización</p></a>
							</div>							
						<?php }else{ ?>
							<div class="col-md-4">
								<a href="javascript:void(0);" class="btn btn-default btn-block" disabled><i class="fa fa-indent fa-3x"></i><p>Datos Focalización</p></a>
							</div>
						<?php } ?>
						<div class="col-md-4">
							<a href="<?php echo $url; ?>view/persona/listpersona.php" class="btn btn-success btn-block"><i class="fa fa-list-alt fa-3x"></i><p>Listar personas</p></a>
						</div>		
					</div>
					<br>														
				</div>				
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>/lib/js/control/persona.min.js" ></script>
</body>
</html>