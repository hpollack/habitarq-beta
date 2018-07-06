<?php 
session_start();
include '../../lib/php/libphp.php';
//$rutus = '1-9';
$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$url = url();
$conn = conectar();

$sql = mysqli_query($conn, "select * from documentos_cat where parent=0");

?>
<!DOCTYPE html>
<html>
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
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/additional-methods.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/localization/messages_es.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/menu_ajax.js"></script>
	<style type="text/css" media="screen">
		.dir { margin-bottom: 20px; }
		.elim { display: none; }
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
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
			</div>
			<div class="col-md-10" id="cuerpo">
				<div class="row">
					<ol class="breadcrumb">
						<li ><a href="<?php echo $url; ?>">Inicio</a></li>						
						<li class="active">Documentación</li>
					</ol>
				</div>
				<div id="alert-id"></div>
				<div class="row" id="contenido">
					<h3 class="page-header">Módulo Gestión de Documentación. </h3>
					<a data-toggle="modal" href='#creaDirectorio' class="btn btn-primary"><i class="fa fa-plus"></i> Crear Directorio</a>
					<?php $disabled = (mysqli_num_rows($sql) > 0) ? "" : "disabled"  ?>
					<label class="control-label" for=""><i class="fa fa-trash"></i> Borrar Directorio: </label>
					<input type="checkbox" id="elim" value="1" <?php echo $disabled; ?>>	
					<br><br>
					<?php if (mysqli_num_rows($sql) == 0): ?>

						<div class="alert alert-info">							
							<b>Aun no existe directorios ni documentos</b>
						</div>

					<?php else: ?>			
							<!-- Se crean los enlaces -->						
							
							<?php while ($f = mysqli_fetch_array($sql)) { ?>
								<div class="col-md-4">
									<a href="<?php echo $url; ?>view/documentacion/dir.php?id=<?php echo $f[0]; ?>&pnt=0" class="btn btn-warning btn-block dir" title="">					
										<span class="fa fa-folder-open fa-4x"></span>
										<p><?php echo $f[1]; ?></p>										
									</a>
									<div class="col-md-3 elim">
										<a href="javascript:borraDirVacio('<?php echo $f[0]; ?>')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
									</div>
								</div>			
							<?php } ?>							
										
					<?php endif; ?>						
					</div>
				</div>				
				<div class="modal fade" id="creaDirectorio">
					<div class="modal-dialog">
						<form class="form-horizontal">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Crear Directorio</h4>
								</div>
								<div class="modal-body">
									<div id="modal-msg"></div>									
									<div class="form-group">
										<label class="col-md-4 control-label">Nombre del Directorio: </label>
										<div class="col-md-6">
											<input type="text" class="form-control" id="dir" name="dir" value="" placeholder="Ingresar Nombre">
										</div>
									</div>	
								</div>
								<div class="modal-footer">
									<button type="button" id="gdir" class="btn btn-primary"><i class="fa fa-plus"></i> Crear</button>
									<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>		
								</div>
							</div>
						</form>
					</div>
				</div>				
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/documentacion.js"></script>
</html>