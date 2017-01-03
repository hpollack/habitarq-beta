<?php
include '../lib/php/libphp.php';
$url = url();
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
							<ul class="nav navbar-nav">	
								<li><a href="#">Mantenedor 1</a></li>
								<li><a href="#">Mantenedor 2</a></li>								
							</ul>
							<p class="navbar-text pull-right">Aquí va el nombre de usuario</p>						
						</div>					
					</nav>
				</div>
				<div class="col-md-11" id="cuerpo">
					<div class="row">
						<ol class="breadcrumb">
							<li><a href="<?php echo $url; ?>">Inicio</a></li>
							<li class="active">Persona</li>
						</ol>
						<ul id = "Tab" class = "nav nav-tabs">
						   <li class = "active"><a id="uno" href = "#basicos" data-toggle = "tab">Datos Basicos</a></li>   
						   <li><a id="dos" href = "#ubicacion" data-toggle = "tab">Datos Ubicacion</a></li>
						   <li><a id="tres" href="#ficha" data-toggle = "tab">Datos Ficha</a></li>
						   <li><a id="cuatro" href="#vivienda" data-toggle="tab">Datos Vivienda</a></li>
						   <li><a id="cinco" href="#cuenta" data-toggle="tab">Datos Cuenta</a></li>	      
						</ul>
						<div id="TabContent" class="nav nav-tabs">
							<form class="form-horizontal" id="pers">
								<div id="Tab" class="tab-content">
									<div class="tab-pane fade in active" id="basicos">
										<br>				
										<div class="form-group">
											<label class="col-md-4 control-label" for="rut">RUT: </label>
											<div class="col-md-6">
												<input type="text" id="rut" name="rut" class="form-control" placeholder="Ingrese Rut">
												<input type="button" value="Buscar" class="btn btn-success" id="seek"><span id="b"></span>					
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
											<label class="col-md-4 control-label">Estado: </label>
											<div class="col-md-4">
												<label><input type="checkbox" id="vp" name="vp" value="1"> ¿Vigente?</label>
											</div>
										</div>				
									</div>
									<div class="tab-pane fade" id="ubicacion">
										<br>
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
									</div>
									<div class="tab-pane fade" id="ficha">
										<br>
										<div class="form-group">
											<label class="col-md-4 control-label" for="ec">Estado Civil: </label>
											<div class="col-md-6">
												<select class="form-control" id="ec" name="ec" disabled>
													<option value="0">Escoga una opcion: </option>
													<?php
														cargaCombo("select * from estado_civil");
													?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-md-4 control-label" for="fnac">Fecha de Nacimiento: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="fnac" name="fnac" placeholder="Ingrese Fecha de Nacimiento" disabled>
											</div>
										</div>											
										<div class="form-group">
											<label class="col-md-4 control-label" for="tmo" disabled>Tramo: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="tmo" name="tmo" placeholder="Ingrese Tramo" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="pnt">Puntaje: </label>
											<div class="col-md-4">
												<input type="text" class="form-control" id="pnt" name="pnt" placeholder="Ingrese Puntaje" disabled> 
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
													<label><input type="checkbox" id="adm" name="adm" value="1" disabled> ¿Algun Miembro es adulto mayor?</label>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="ds">Discapacidad: </label>
												<div class="col-md-4">
													<label><input type="checkbox" id="ds" name="ds" value="1" disabled> ¿Algun Miembro tiene discapacidad?</label>
												</div>
											</div>							
										</div>															
									</div>
									<div class="tab-pane fade" id="vivienda">
										<br>
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
											<label class="col-md-4 control-label" for="ar">Año de Recepción</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="ar" name="ar" placeholder="Ingrese Año (dd/mm/yyyy)" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Mts2 Construidos: </label>
											<div class="col-md-3">
												<label><input type="checkbox" id="p1" name="p1" disabled>Primer Piso</label>													
											</div>
											<div class="col-md-3">
												<label><input type="checkbox" id="p2" name="p2" disabled>Segundo Piso</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="mp1">Metros Primer Piso: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="mp1" name="mp1" placeholder="Metros" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="mp2">Metros Segundo Piso: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="mp2" name="mp2" placeholder="Metros" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Total: </label>
											<div class="col-md-4">
												<input type="text" readonly id="tms" name="tms" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="ac">Año: </label>
											<div class="col-md-4">
												<input type="text" class="form-control" id="ac" name="ac" placeholder="Ingrese año" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="tv">Tipo Vivienda: </label>
											<div class="col-md-4">
												<select class="form-control" id="tv" name="tv" disabled>
													<?php
														cargaCombo("SELECT idtipovivienda, tipo FROM tipo_vivienda");
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="st">Superficie del terreno: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="st" name="st" placeholder="Ingrese total superficie">
											</div>
										</div>																
									</div>
									<div class="tab-pane fade" id="cuenta">
										<br>
										<div class="form-group">
											<label class="col-md-4 control-label" for="nc">N° Cuenta</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="nc" name="nc" placeholder="Ingrese Numero de Cuenta" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="fap">Fecha de Apertura: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="fap" name="fap" placeholder="Ingrese fecha de Apertura (dd/mm/yyyy)" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Ahorro/Subsidio: </label>
											<div class="col-md-3">
												<label><input type="checkbox" id="ahc" name="ahc" value="1" disabled>Ahorro.</label>
											</div>
											<div class="col-md-3">
												<label><input type="checkbox" id="suc" name="suc" value="1" disabled>Subsidio.</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="ah">Ahorro: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="ah" name="ah" placeholder="Ingrese Monto del Ahorro" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="sb">Subsidio: </label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="sb" name="sb" placeholder="Ingrese Monto del Subsidio" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" for="td">Total: </label>
											<div class="col-md-6">
												<input type="hidden" class="form-control" id="td" name="td" placeholder="Total" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" id="accion">Acciones: </label>
											<div class="col-md-4">																
												<input type="button" id="grab" class="btn btn-primary" value="Grabar" disabled>
												<input type="button" id="edit" class="btn btn-primary" value="Editar" disabled>
												<input type="button" id="del" class="btn btn-danger" value="Quitar" disabled>
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
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/controladores/persona.js"></script>	
</body>
</html>

