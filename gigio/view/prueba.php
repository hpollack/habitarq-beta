<?php
include 'lib/php/libphp.php';
$url = url();
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/fa/css/font-awesome.min.css">
	<script type="text/javascript" src="<<?php echo $url; ?>lib/bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/menu_ajax.js"></script>
	<style type="text/css">
		body{
			padding-top: 70px;
			padding-left: 200px;
		}
	</style>	
</head>
<body>
	<div class="container-fluid">
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
								<ul class="nav navbar-nav">	
									<li><a href="#">Mantenedor 1</a></li>
									<li><a href="#">Mantenedor 2</a></li>								
								</ul>
								<p class="navbar-text pull-right">Aquí va el nombre de usuario</p>						
							</div>					
						</nav>
					</div>
					<div class="col-md-10" id="cuerpo">
						<div class="row">
							<ol class="breadcrumb">
								<li><a href="#">Inicio</a></li>
								<li class="active">Persona</li>
							</ol>
							<ul id = "Tab" class = "nav nav-tabs">
							   <li class = "active"><a id="uno" href = "#basicos" data-toggle = "tab">Datos Basicos</a></li>   
							   <li><a id="dos" href = "#ubicacion" data-toggle = "tab">Datos Ubicacion</a></li>
							   <li><a id="tres" href="#ficha" data-toggle = "tab">Datos Ficha</a></li>	      
							</ul>
							<div id="TabContent" class="nav nav-tabs">
								<form class="form-horizontal">
									<div id="Tab" class="tab-content">
										<div class="tab-pane fade in active" id="basicos">
										<br>				
											<div class="form-group">
												<label class="col-md-4 control-label" for="rut">RUT: </label>
												<div class="col-md-6">
													<input type="text" id="rut" name="rut" class="form-control" placeholder="Ingrese Rut">
													<input type="button" value="Buscar" class="btn btn-success" id="rut"><span id="b"></span>					
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="nom">Nombres: </label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="nom" name="nom" placeholder="Ingrese Nombres">						
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="ap">Paterno: </label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="ap" name="ap" placeholder="Ingrese Apellido Paterno">						
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="am">Materno: </label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="am" name="am" placeholder="Ingrese Apellido Materno">						
												</div>
											</div>				
										</div>
										<div class="tab-pane fade" id="ubicacion">
											<br>
											<div class="form-group">
												<label class="col-md-4 control-label" for="dir">Dirección: </label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="dir" name="dir" placeholder="Ingrese Direccion">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="mail">Fono: </label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="mail" name="name" placeholder="Ingrese Correo Electrónico">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="mail">Fijo/Celular: </label>
												<div class="col-md-6">
													<label class="radio-inline"><input type="radio" id="fj" name="fj" value="1">Fijo</label>
													<label class="radio-inline"><input type="radio" id="fj" name="cl" value="1">Celular</label>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="mail">Correo Electrónico: </label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="mail" name="name" placeholder="Ingrese Correo Electrónico">
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="ficha">
											<br>
											<div class="form-group">
												<label class="col-md-4 control-label" for="fnac">Fecha de Nacimiento: </label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="fnac" name="fnac" placeholder="Ingrese Fecha de Nacimiento">
												</div>
											</div>
											<div>
												<label ="col-md-4 control-label">Estado Civil: </label>
												<div class="col-md-4">
													<!combo -->
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="tr">Tramo: </label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="tmo" name="tmo" placeholder="Ingrese Tramo">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="pnt">Puntaje: </label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="pnt" name="pnt" placeholder="Ingrese Puntaje"> 
												</div>
												<div class="form-group">
												<label class="col-md-4 control-label" for="gfm">Grupo Familiar: </label>
												<div class="col-md-2">
													<input type="text" class="form-control" id="gfm" name="gfm" placeholder="N° Miembros"> 
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="am">Adulto Mayor: </label>
												<div class="col-md-4">
													<label><input type="checkbox" id="am" name="am" value="1"> ¿Algun Miembro es adulto mayor?</label>
												</div>
											</div>						
										</div>					
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" id="accion">Acciones: </label>
										<div class="col-md-4">
											<input type="button" class="btn btn-primary" value="Grabar" disabled>
											<input type="button" class="btn btn-primary" value="Editar" disabled>
											<input type="button" class="btn btn-danger" value="Quitar" disabled>
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
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/controladores/persona.js"></script>	
</body>
</html>

