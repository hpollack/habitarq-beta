<?php
/**
 * ========================================================
 *   VISTA: FORMULARIO DE DATOS DE FICHA
 * ========================================================
 * 
 * Esta vista, permite crear y modificar los datos datos de la fichas.
 * Interactua con el servidor mediante JQuery Ajax. Se hace una busqueda por el rut y trae los datos
 * por medio de un JSON llenando los campos en caso de haber datos. Dependiendo de estos, se activaran los botones
 * tanto para insertar o editar datos.
 * 
 * Archivos que interactuan:
 * @link lib/js/control/ficha.js : controla el traspaso de datos desde el servidor a la vista.
 * @link model/persona/seekficha.php: busca y devuelve los datos a la vista
 * @link model/persona/insficha.php: inserta los datos al registro.
 * @link model/perona/upficha.php: edita los datos en el registro.
 * 
 **/
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
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
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
				<div class="col-md-11" id="cuerpo">
					<div class="row">
						<ol class="breadcrumb">
							<li ><a href="<?php echo $url; ?>">Inicio</a></li>
							<li><a href="<?php echo $url; ?>view/persona/">Persona</a></li>
							<li>Datos Ficha</li>
						</ol>
						<ul id="tab" class="nav nav-tabs">
							<li class="active"><a id="uno" href="#" id="ficha" data-toggle="tab">Datos Ficha</a></li>
						</ul>
						<div id="TabContent" class="nav nav-tabs">
							<form class="form-horizontal" id="fich">
								<div id="Tab" class="tab-content">
									<div class="tab-pane fade in active">
										<br>
										<div id="res"></div>
										<div class="form-group">
											<label class="col-md-4 control-label">RUT Persona: </label>
											<div class="col-md-6">												
												<div class="input-group">
													<input type="text" id="rut" name="rut" class="form-control" placeholder="Ingrese Rut y presione buscar">
													<span class="input-group-btn"><button class="btn btn-success" id="busc" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button></span>				
												</div>
												<span id="msg"></span>
												<div id="sug"></div>
											</div>											
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="nom">Nombre persona: </label>
											<div class="col-md-6">
												<p class="form-control" id="nom"></p>
												<input type="hidden" id="fch" name="fch">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="ec">Estado Civil: </label>
											<div class="col-md-4">
												<select class="form-control" id="ec" name="ec" disabled>
													<option value="0">Escoga una opcion: </option>
													<?php
														cargaCombo("select * from estado_civil");
													?>
												</select>												
											</div>
											<div class="col-md-3">
												<!-- <a href="#agregaConyuge" id="agc" class="open-modal btn btn-primary" data-toggle="modal" disabled>Agregar Conyuge</a>  -->
												<button type="button" id="agc" class="btn btn-primary" data-toggle="modal" data-target="#agregaConyuge" disabled>Agregar Conyuge</button>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="fnac">Fecha de Nacimiento: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="fnac" name="fnac" placeholder="Ingrese Fecha de Nacimiento (dd/mm/aaaa)" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="tmo" disabled>Tramo: </label>
											<div class="col-md-6">
												<select id="tmo" name="tmo" class="form-control" disabled>
													<option value="0">Escoga Tramo</option>
													<?php 
														cargaCombo("select * from tramo"); 
													?>
												</select>
											</div>
										</div>										
										<div class="form-group" id="factor">
											<label class="col-md-4 control-label" for="dh">Déficit Habitacional: </label>
											<div class="col-md-6">												
												<select id="dh" name="dh" class="form-control">
													<option value="0">Escoja un nivel</option>
													<?php cargaCombo("select * from deficit_habitacional") ?>
												</select>												
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="ch">Carencia Habitacional: </label>
											<div class="col-md-6">
												<?php cargaCheckBox("select * from factores_carencia", "ch"); ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="gfm" disabled>Grupo Familiar: </label>
											<div class="col-md-2">
												<input type="text" class="form-control" id="gfm" name="gfm" placeholder="N° Miembros" disabled> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="adm">Adulto Mayor: </label>
											<div class="col-md-4">												
												<label><input type="checkbox" id="adm" name="adm" value="1" disabled> ¿Adulto mayor?</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="ds">Discapacidad: </label>
											<div class="col-md-4">
												<label><input type="checkbox" id="ds" name="ds" value="1" disabled> ¿Tiene discapacidad?</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" id="accion">Acciones: </label>
											<div class="col-md-6">																
												<button class="btn btn-primary" id="grab" type="button" disabled><i class="fa fa-plus fa-1x"></i> Grabar</button>
												<button class="btn btn-primary" id="edit" type="button" disabled ><i class="fa fa-edit fa-1x"></i> Editar</button>
												<button class="btn btn-warning" id="re" type="reset"><i class="fa fa-refresh"></i> Limpiar</button>
												<button class="btn btn-danger" id="del" type="button" disabled><i class="fa fa-times fa-1x"></i> Cancelar</button>
											</div>
										</div>					
									</div>
								</div>
							</form>
							<div class="modal fade" id="agregaConyuge" role="dialog" tabindex="-1" aria-hidden="true">
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
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/ficha.js"></script>
	<!-- <script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/control/ficha.validate.js"></script>  -->
</body>
</html>