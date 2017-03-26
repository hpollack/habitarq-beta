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

$conn = conectar();

$EdadVaron = mysqli_fetch_row(mysqli_query($conn, "select * from configuracion where idconfig = 1"));
$EdadMujer = mysqli_fetch_row(mysqli_query($conn, "select * from configuracion where idconfig = 2"));
$UFAmpliacion = mysqli_fetch_row(mysqli_query($conn, "select * from configuracion where idconfig = 3"));
$UFMejoramiento = mysqli_fetch_row(mysqli_query($conn, "select * from configuracion where idconfig = 4"));
$UFTermico = mysqli_fetch_row(mysqli_query($conn, "select * from configuracion where idconfig = 5"));
$UFSolar = mysqli_fetch_row(mysqli_query($conn, "select * from configuracion where idconfig = 6"));
$UFFocalizacion = mysqli_fetch_row(mysqli_query($conn, "select * from configuracion where idconfig = 7"));



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
	<style type="text/css" media="screen">
		#uf {
			font-size: 14px;
		}		
	</style>	
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
							<li><a href="<?php echo $url; ?>view/config/" >General</a></li>
							<li class="active">Configuraciones Generales</li>
						</ol>						
						<div id="msg"></div>
						<h3 class="page-header">Configuraciones Generales</h3>
						<p class="text text-info">
						 Esta página contiene los parámetros de configuración general del sistema. Los valores pueden ser actualizados de acuerdo a la necesidad 
						 y cambios que sean requeridos y afectaran las funcionalidades del sistema.
						</p>
						<p class="text text-warning"><b>Si no está seguro, deje los valores por defecto.</b></p>
						<form class="form-horizontal" id="gen">
							<fieldset>
								<legend>Parámetros de Edad de Jubilación</legend>
								<p class="text text-info"><i class="fa fa-info-circle fa-1x"></i>
								 En este apartado, se debe configurar la edad de jubilación, tanto de varón como mujer. Por defecto los valores son
								 65 para el varón y 60 para la mujer.								 
								</p>
								<div class="form-group">
									<label class="col-md-4 control-label" for="vr">Edad Varon: </label>
									<div class="col-md-3">
									<input type="hidden" name="idvr" value="<?php echo $EdadVaron[0]; ?>">
										<input type="text" id="vr" name="vr" value="<?php echo $EdadVaron[2]; ?>" class="form-control" placeholder="Ingrese Edad Varón">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="mj">Edad Mujer: </label>
									<div class="col-md-3">
										<input type="hidden" id="idmj" name="idmj" value="<?php echo $EdadMujer[0]; ?>">
										<input type="text" id="mj" name="mj" value="<?php echo $EdadMujer[2] ?>" class="form-control" placeholder="Ingrese Edad Mujer">
									</div>
								</div>
							</fieldset>
							<fieldset>
								<legend>Parámetros de UF</legend>
								<p class="text text-info"><i class="fa fa-info-circle"></i> 
								En este apartado se deben ajustar los valores en número de las UF de cada item.. 
								</p>
								<div class="form-group">
									<label class="col-md-4 control-label" for="uf">Valor UF Hoy: </label>
									<div class="col-md-5">
										<p class="text text-success form-control-static" id="uf"><strong>$ <?php echo number_format($uf, 0, ',', '.') ?></strong></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="amp">Uf Ampliación: </label>
									<div class="col-md-3">
										<input type="hidden" id="idamp" name="idamp" value="<?php echo $UFAmpliacion[0]; ?>">
										<input type="text" id="amp" name="amp" value="<?php echo $UFAmpliacion[2]; ?>" class="form-control" placeholder="Ingrese Cantidad de UF">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="mej">Uf Mejoramiento: </label>
									<div class="col-md-3">
										<input type="hidden" id="idmej" name="idmej" value="<?php echo $UFMejoramiento[0]; ?>">
										<input type="text" id="mej" name="mej" value="<?php echo $UFMejoramiento[2] ?>" class="form-control" placeholder="Ingrese Cantidad de UF">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="ter">Uf Térmico: </label>
									<div class="col-md-3">
									<input type="hidden" id="idter" name="idter" value="<?php echo $UFTermico[0]; ?>">
										<input type="text" id="ter" name="ter" value="<?php echo $UFTermico[2]; ?>" class="form-control" placeholder="Ingrese Cantidad de UF">
									</div>
								</div><div class="form-group">
									<label class="col-md-4 control-label" for="sol">Uf Colector Solar: </label>
									<div class="col-md-3">
										<input type="hidden" id="idsol" name="idsol" value="<?php echo$UFSolar[0]; ?>">
										<input type="text" id="sol" name="sol" value="<?php echo $UFSolar[2]; ?>" class="form-control" placeholder="Ingrese Cantidad de UF">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="foc">Uf Focalización: </label>
									<div class="col-md-3">
										<input type="hidden" id="idfoc" name="idfoc" value="<?php echo $UFFocalizacion[0]; ?>">
										<input type="text" id="foc" name="foc" value="<?php echo $UFFocalizacion[2]; ?>" class="form-control" placeholder="Ingrese Cantidad de UF">
									</div>
								</div>								
							</fieldset>							
							<div class="form-group">
								<div class="col-md-6 col-md-offset-3">
									<button type="button" id="grab" class="btn btn-primary"><i class="fa fa-plus"></i> Guardar</button>
									<button type="button" id="can" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</button>
									<div id="b"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url ?>lib/js/control/config.js"></script>
</body>
</html>