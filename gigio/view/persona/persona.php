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
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/additional-methods.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/localization/messages_es.min.js"></script>	
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
				<div class="col-md-11" id="cuerpo">
					<div class="row">
						<ol class="breadcrumb">
							<li ><a href="<?php echo $url; ?>">Inicio</a></li>
							<li><a href="<?php echo $url; ?>view/persona/">Persona</a></li>
							<li>Datos Persona</li>
						</ol>
						<ul id="Tab" class="nav nav-tabs">
							<li class="active"><a id="uno" href="#basicos" data-toggle="tab">Datos Basicos</a></li>
							<li><a id="dos" href="#ubicacion" data-toggle="tab">Datos Ubicación</a></li>
						</ul>
						<div id="msg"></div>						
						<div id="TabContent" class="nav nav-tabs">
							<form class="form-horizontal" id="pers">
								<div id="Tab" class="tab-content">
									<div class="tab-pane in active" id="basicos">
										<br>				
										<div class="form-group">
											<label class="col-md-4 control-label" for="rut">RUT: </label>
											<div class="row">
												<div class="col-md-4">
													<input type="text" id="rut" name="rut" class="form-control" placeholder="Ingrese Rut" />																				
												</div>
												<div class="col-md-1">
													<input type="text" class="form-control" id="dv" name="dv" placeholder="DV" />													
												</div>
												<div class="col-md-2">
													<button class="btn btn-success" id="seek" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button><span id="b"></span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="nom">Nombres: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="nom" name="nom" placeholder="Ingrese Nombres" disabled>						
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="ap">Paterno: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="ap" name="ap" placeholder="Ingrese Apellido Paterno" disabled>						
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="am">Materno: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="am" name="am" placeholder="Ingrese Apellido Materno" disabled>						
											</div>
										</div>
										<div class="form-group" >
											<label class="col-md-4 control-label" for="vp">Estado: </label>
											<div class="col-md-4">
												<label><input type="checkbox" id="vp" name="vp" value="1"> ¿Vigente?</label>
											</div>
										</div>				
									</div>
									<div class="tab-pane" id="ubicacion">
										<br>									
										<div id="msg"></div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="dir">Dirección: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="dir" name="dir" placeholder="Ingrese Direccion" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="nd">Número: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="nd" name="nd" placeholder="Ingrese Numero" disabled>
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
											<label class="col-md-4 control-label" for="tf">Fono: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="tf" name="tf" placeholder="Ingrese Número de Telefono" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Fijo/Celular: </label>
											<div class="col-md-6">
												<select class="form-control" id="tp" name="tp">
													<?php
													cargaCombo("SELECT idtipo, tipo FROM tipofono");
													?>
												</select>
											</div>
										</div>										
										<div class="form-group">
											<label class="col-md-4 control-label" for="mail">Correo Electrónico: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="mail" name="mail" placeholder="Ingrese Correo Electrónico" disabled>
											</div>
										</div>										
										<div class="form-group">
											<label class="col-md-4 control-label" id="accion">Acciones: </label>
											<div class="col-md-6">																
												<button class="btn btn-primary" id="grab" type="button" disabled><i class="fa fa-plus fa-1x"></i> Grabar</button>
												<button class="btn btn-primary" id="edit" type="button" disabled ><i class="fa fa-edit fa-1x"></i> Editar</button>
												<button class="btn btn-warning" id="re" type="reset"><i class="fa fa-refresh"></i> Limpiar</button>
												<button class="btn btn-danger" id="can" type="button" disabled><i class="fa fa-ban fa-1x"></i> Cancelar</button>											
											</div>
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
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/persona.js" ></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/control/persona.validate.js"></script>	
</body>
</html>