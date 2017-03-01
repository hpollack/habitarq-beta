<?php
session_start();
include_once '../../lib/php/libphp.php';
$url = url();
$perfil = $_SESSION['perfil'];
$rutus = $_SESSION['rut'];
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
							</button> <a class="navbar-brand" href="#">Logo</a>
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
							<li>Datos Vivienda</li>
						</ol>
						<ul id="Tab" class="nav nav-tabs">
							<li class="active"><a id="uno" href="#vivienda" data-toggle = "tab">Datos Vivienda</a></li>
							<li><a id="dos" href="#metros" data-toggle="tab">Metros</a></li>
							<li><a id="tres" href="#permisos" data-toggle="tab">Permisos y Certificados</a></li>
						</ul>
						<div id="resp"></div>
						<div id="TabContent" class="nav nav-tabs">
							<form class="form-horizontal" id="viv">
								<div id="Tab" class="tab-content">
									<div class="tab-pane fade in active" id="vivienda">
										<br>
										<div class="form-group">
											<label class="col-md-4 control-label" for="rut">RUT: </label>
											<div class="col-md-6">
												<div class="input-group">
													<input type="text" id="rut" name="rut" class="form-control" placeholder="Ingrese Rut y presione buscar">
													<span class="input-group-btn"><button class="btn btn-success" id="seek" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button></span>			
												</div>
												<span id="b"></span>
												<div id="sug"></div>
												<input type="hidden" name="idr" id="idr">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Nombre: </label>
											<div class="col-md-6">
												<p class="form-control" id="nom"></p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="rol">Rol</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="rol" name="rol" placeholder="Ingrese Rol" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="foj">Fojas</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="foj" name="foj" placeholder="Ingrese Fojas" disabled>
											</div>
										</div>									
										<div class="form-group">
											<label class="col-md-4 control-label">Número: </label>
											<div class="col-md-3">
												<input type="text" id="num" name="num" class="form-control" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="ac">Año: </label>
											<div class="col-md-4">
												<input type="text" class="form-control" id="ac" name="ac" placeholder="Ingrese año (yyyy)" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Conservador: </label>
											<div class="col-md-6">
												<select id="cv" name="cv" class="form-control" disabled>
													<option value="0">Escoja conservador.</option>
													<?php echo cargaCombo("select * from conservador") ?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-md-4 control-label" for="ar">Año de Recepción</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="ar" name="ar" placeholder="Ingrese Año (yyyy)" disabled>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="metros">
										<br>
										<div class="form-group">
											<label class="col-md-4 control-label" for="tv">Tipo Vivienda: </label>
											<div class="col-md-4">
												<select class="form-control" id="tv" name="tv" disabled>
													<option value="0">Escoja tipo de vivienda.</option>
													<?php
														cargaCombo("SELECT idtipovivienda, tipo FROM tipo_vivienda");
													?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<h4 class="page-header">Casa Original</h4>
											<input type="hidden" name="id1" id="id1">
											<label class="col-md-4 control-label" for="mp1">Primer Piso: </label>
											<div class="col-md-2">
												<input type="text" class="form-control" id="mp1" name="mp1" placeholder="Metros" disabled>
											</div>										
											<input type="hidden" name="id2" id="id2">
											<label class="col-md-2 control-label" for="mp2">Segundo Piso: </label>
											<div class="col-md-2">
												<input type="text" class="form-control" id="mp2" name="mp2" placeholder="Metros" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Total Original: </label>	
											<div class="col-md-4">
											<p id="tmso" class="form-control-static"></p>
										</div>
										</div>
										<div class="form-group">
											<h4 class="page-header">Ampliación</h4>
											<input type="hidden" name="id3" id="id3">
											<label class="col-md-4 control-label" for="mp3">Primer Piso: </label>
											<div class="col-md-2">
												<input type="text" class="form-control" id="mp3" name="mp3" placeholder="Metros" disabled>
											</div>
										
											<input type="hidden" name="id4" id="id4">
											<label class="col-md-2 control-label" for="mp4"> Segundo Piso: </label>
											<div class="col-md-2">
												<input type="text" class="form-control" id="mp4" name="mp4" placeholder="Metros" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Total Ampliación: </label>
											<div class="col-md-4">
												<p id="tmsa" class="form-control-static"></p>
											</div>
										</div>
										<hr>										
										<div class="form-group">
											<label class="col-md-4 control-label" for="st">Superficie del terreno: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="st" name="st" placeholder="Ingrese total superficie" disabled="">
											</div>
										</div>											
									</div>
									<div class="tab-pane fade" id="permisos">
										<div class="form-group">
											<h4 class="page-header">Permiso de Edificación</h4>
											<label class="col-md-4 control-label">Número: </label>
											<div class="col-md-2">
												<input type="text" id="npe" name="npe" class="form-control">
											</div>
											<label class="col-md-2 control-label">Fecha: </label>
											<div class="col-md-2">
												<input type="text" id="numpe" name="numpe" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<h4 class="page-header">Certificado de Recepción</h4>
											<label class="col-md-4 control-label">Número: </label>
											<div class="col-md-2">
												<input type="text" id="ncr" name="ncr" class="form-control">
											</div>
											<label class="col-md-2 control-label">Fecha: </label>
											<div class="col-md-2">
												<input type="text" id="numcr" name="numcr" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<h4 class="page-header">Regularizaciones</h4>
											<label class="col-md-4 control-label">Número: </label>
											<div class="col-md-2">
												<input type="text" id="nrg" name="nrg" class="form-control">
											</div>
											<label class="col-md-2 control-label">Fecha: </label>
											<div class="col-md-2">
												<input type="text" id="numrg" name="numrg" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<h4 class="page-header">Informe Previo</h4>
											<label class="col-md-4 control-label">Número: </label>
											<div class="col-md-2">
												<input type="text" id="nip" name="nip" class="form-control">
											</div>
											<label class="col-md-2 control-label">Fecha: </label>
											<div class="col-md-2">
												<input type="text" id="numip" name="numip" class="form-control">
											</div>
										</div>
										<br>
										<div class="form-group" id="viv">
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
</body>
<script type="text/javascript" src= "<?php echo $url; ?>lib/js/control/vivienda.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/control/vivienda.validate.js"></script>
</html>