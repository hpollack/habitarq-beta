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
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/fa/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/hoja.css">
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/bootstrap.min.js"></script>
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
							</button> <a class="navbar-brand" href="#">Logo</a>
						</div>					
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<?php get_nav($perfil, $_SESSION['usuario']); ?>					
						</div>					
					</nav>
				</div>
				<div class="col-md-9" id="cuerpo">
					<ol class="breadcrumb">
						<li ><a href="<?php echo $url; ?>">Inicio</a></li>
						<li><a href="<?php echo $url; ?>view/persona/">Persona</a></li>
						<li class="active">Listado</li>
					</ol>
					<div class=row>
						<div class="col-md-12">
							<div class="form-group">
								<form class="form-horizontal" role="form">
									<label class="col-md-2 control-label" for="busc">Buscar: </label>
									<div class="col-md-6 input-group">
										<span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
										<input type="search" id="busc" class="form-control" name="busc" placeholder="Escriba el rut o nombre completo...">
									</div>															
								</form>	
								<div class="col-md-2">
									<a href="<?php echo $url; ?>view/persona/persona.php" class="btn btn-primary"><span class="fa fa-plus"></span> Agregar</a>
								</div>
								<div class="col-md-2">
									<span id="ms"></span>
								</div>
							</div>	
						</div>
					</div>
					<div class="row">						
						<div id="lista"></div>						
					</div>
					<div class="modal fade" id="myModal" role="dialog" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog" id="msize">
							<div class="modal-content">								
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?php echo $url;?>lib/js/control/persona.js"></script>
</html>