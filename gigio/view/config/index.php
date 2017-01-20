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

$uf = traeUF();
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/fa/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/hoja.css">
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/menu_ajax.js"></script>	
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div clas="row">
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
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
							<li class="active">Configuraciones Generales</li>
						</ol>
						<div class="alert alert-info alert-dismissable">
							<strong>Este apartado está en construcción</strong>
						</div>											
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>