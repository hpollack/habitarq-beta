<?php
/**
 * ==========================================
 *  VISTA PARA DATOS COMITE
 * ==========================================
 * 
 * Esta interfaz permite.
 *  - Obtener datos desde la BD codificados como JSON y mediante AJAX cargarlos en los campos
 *  - Si vienen datos, es posible editarlos (se desbloquea boton editar)
 *  - De no venir datos, se desbloquea el boton guardar.
 * 
 * @version 1.1: Se agregó un autocompletado en el campo del codigo rukam. Es posible buscarlo por nombre.
 * 
**/
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
							<?php get_nav($perfil, $nombre); ?>
						</div>
					</nav>
				</div>
				<div class="col-md-10" id="cuerpo">
					<div class="row">
						<ol class="breadcrumb">
							<li ><a href="<?php echo $url; ?>">Inicio</a></li>
							<li ><a href="<?php echo $url; ?>view/comite/">Comité</a></li>
							<li class="active">Datos Comite</li>
						</ol>
						<ul id="tab" class="nav nav-tabs">
							<li class="active"><a id="uno" href="#datos" data-toggle="tab">Datos Comite</a></li>
							<li><a href="#directiva" id="dos" data-toggle="tab">Inscritos</a></li>							
						</ul>
						<div id="TabContent" class="nav nav-tabs">							
							<div id="Tab" class="tab-content">
								<div class="tab-pane in active" id="datos">
									<br>
									<div id="res"></div>
									<form class="form-horizontal" id="dcom">
										<div class="form-group">
											<label class="col-md-4 control-label">Código Rukam: </label>
											<div class="col-md-6">
												<div class="input-group">
													<input type="text" id="num" name="num" class="form-control" placeholder="Ingrese Código y presione buscar">
													<span class="input-group-btn"><button class="btn btn-success" id="seek" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button></span>			
												</div>
												<div id="sug"></div>
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
												<input type="hidden" id="idg" name="idg">
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
											<label class="col-md-4 control-label">Localidad: </label>
											<div class="col-md-6">
												<input type="text" id="loc" name="loc" placeholder="Ingrese Nombre de Localidad" class="form-control" disabled>
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
											<label class="col-md-4 control-label" for="ec">Estado: </label>
											<div class="col-md-6">
												<label><input class="form-control-static" type="checkbox" id="ec" name="ec" value="1"></label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" id="accion">Acciones: </label>
											<div class="col-md-6">																
												<button class="btn btn-primary" id="grab" type="button" disabled><i class="fa fa-plus fa-1x"></i> Grabar</button>
												<button class="btn btn-primary" id="edit" type="button" disabled><i class="fa fa-edit fa-1x"></i> Editar</button>
												<button id="limp" type="reset" class="btn btn-warning"><i class="fa fa-reload"></i> Limpiar</button>
												<button class="btn btn-danger" id="can" type="button" disabled><i class="fa fa-ban fa-1x"></i> Cancelar</button>											
											</div>
										</div>
										</form>
								</div>					
								<div class="tab-pane" id="directiva">
									<br>
									<form class="form-horizontal" id="gp">
										<div class="form-group">
											<label class="col-md-4 control-label" for="mbusc">Buscar: </label>
											<div class="col-md-6">
												<div class="input-group">
													<input type="text" id="rp" name="rp" class="form-control" placeholder="Ingrese Rut y presione buscar">
													<span class="input-group-btn"><button class="btn btn-success" id="busc" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button></span>			
												</div>
												<div id="sug"></div>
											</div>										
											<div id="mrg"></div>	
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
											<div class="form-group">
												<label class="col-md-4 control-label" for="es">Estado: </label>
												<div class="col-md-5">
													<select id="es" name="es" class="form-control" disabled>
														<option value="">Seleccione una Opcion</option>
														<option value="Postulante">Postulante</option>
														<option value="No Postulante">No Postulante</option>
													</select>
												</div>
											</div>
											<div class="col-md-12" id="lista">
												<div id="lcomite"></div>
											</div>
										</div>
									</form>
								</div>								
							</div>								
						</div>
						<div class="modal fade" id="EliminaSocio" role="dialog" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-sm" id="msize">
								<div class="modal-content">								
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
