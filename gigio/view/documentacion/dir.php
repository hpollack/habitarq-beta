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

$conn = conectar();
$id = $_GET['id'];
$pnt = $_GET['pnt'];

$string = "select * from documentos_cat where idcat = ".$id." and parent = ".$pnt."";

$sql = mysqli_query($conn, $string);



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
		.upload {
			display: none;
		}
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
							</button> <a class="navbar-brand" href="#">Sistema E.P Habitarq</a>
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
						<li><a href="<?php echo $url; ?>view/documentacion/" title="">Documentacion</a></li>
						<?php if (mysqli_num_rows($sql) > 0):
							$a = mysqli_fetch_row($sql);
						 ?>
							<li class="active"><?php echo $a[1]; ?></li>
						<?php endif; ?>
					</ol>
				</div>
				<div class="row">
					<div class="col-md-10">
						<div id="alert-id"></div>
					</div>
					<?php if (mysqli_num_rows($sql) > 0){ ?>
						<div class="col-md-10">							
							<h3 class="page-header">Directorio <?php echo $a[1]; ?> </h3>							
							<div class="row">
								<a class="btn btn-info pull-left" href="javascript:history.back(1)"><i class="fa fa-arrow-left"></i> Volver</a>
								<a class="btn btn-primary pull-right" data-toggle="modal" href='#creaDirectorio2'><i class="fa fa-plus"></i> Crear Directorio</a>
								<button type="button" class="btn btn-success pull-right" style="margin-right: 10px;" id="upload">
								<i class="fa fa-upload"></i> Subir Archivos</button>
							</div>
							<br><br>
							<div class="row folder">
								<?php 
								
								 $sql2 = mysqli_query($conn, "select * from documentos_cat where parent = ".$id."");
								 if (mysqli_num_rows($sql2) > 0) {
								 	
								 	while ($f = mysqli_fetch_array($sql2)) {
								 		
								 		?>
								 		
									 	<div class="col-md-4">
											<a href="<?php echo $url; ?>view/documentacion/dir.php?id=<?php echo $f[0]; ?>&pnt=<?php echo $f[2]; ?>" class="btn btn-warning btn-block dir" title="">					
												<span class="fa fa-folder-open fa-4x"></span>
												<p><?php echo $f[1]; ?></p>										
											</a>
										</div>

									 	<?php
								 	}
								 	
								} 								 

								?>
							</div>
							<br>
							<div class="row upload">
								<form action="" method="POST" class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-md-4 control-label">Subir Archivos: </label>
										<div class="col-md-6">
											<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
											<input type="file" id="f" name="f[]" class="form-control" multiple>
											<p class="text-justify"><small class="text text-info"><span class="fa fa-info-o"></span> Archivos Permitidos: PDF, Word y Excel.
											<br>Apretando <b>Ctr+Click</b> puede escoger mas de un archivo.</small></p>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-10 col-sm-offset-4">
											<button type="button" class="btn btn-primary" id="upd"> 
												<i class="fa fa-upload"></i> Subir
											</button>
											<button type="button" class="btn btn-danger" id="cn">
												<i class="fa fa-times"></i> Cancelar
											</button>
										</div>
									</div>	
								</form>
							</div>
							<div id="archivos"></div>
						</div>
					<?php } else if (!$sql){ ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>¡Ocurrió un error al procesar la información!</strong> <a href="index.php" class="alert-link"> Volver</a>
						</div>
					<?php } else { ?>	
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>¡El Directorio que busca no existe!</strong> <a href="index.php" class="alert-link"> Volver</a>
						</div>
					<?php } ?>
				</div>				
				<div class="modal fade" id="creaDirectorio2">
					<div class="modal-dialog">
						<form class="form-horizontal" role="form">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Crear Directorio.</h4>
								</div>
								<div class="modal-body">
									<div id="modal-msg"></div>									
									<div class="form-group">
										<label class="col-md-4 control-label">Nombre del Directorio: </label>
										<div class="col-md-6">
											<input type="hidden" id="pnt" name="pnt" value="<?php echo $id; ?>" placeholder="">
											<input type="text" class="form-control" id="dir" name="dir" value="" placeholder="Ingresar Nombre">
										</div>
									</div>	
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" id="gdir" ><i class="fa fa-plus"></i> Crear</button>
									<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
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
<script type="text/javascript">
	$("#archivos").load('../../model/documentacion/listdoc.php?id='+<?php echo $id; ?>);
</script>
</html>