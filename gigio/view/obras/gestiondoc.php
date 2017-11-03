
<?php 
session_start();
//$rutus = '1-9';
$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
include '../../lib/php/libphp.php';

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: login.php");
	exit();
}


$url = url();

$conn = conectar();
$id = $_GET['id'];

$string = "select g.idgrupo, g.nombre, p.dias ".
          "from grupo as g inner join postulaciones as p on g.idgrupo = p.idgrupo ".
          "where g.numero = ".$id."";

$sql = mysqli_query($conn, $string);
$f = mysqli_fetch_row($sql);
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
						<li><a href="<?php echo $url; ?>view/obras/" title="">Obras</a></li>						
						<li class="active">Gestión de Documentos</li>
					</ol>
				</div>
				<div class="row">
					<?php if (!$id[0]){ ?>

						<div class="alert alert-danger">							
							<strong>¡Atención!</strong> No existe el grupo solicitado
							<a class="alert alert-link" href="<?php echo $url ?>/view/obras/" title="">Volver</a>
						</div>

					<?php }else { ?>

						<div class="col-md-10 col-md-offset-0">
							<div id="alerta"></div>
							<form id="doc" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
								<div class="form-group">
									<legend>Formulario de Gestión de Documentos.</legend>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label">Comite: </label>
									<div class="col-md-6">
										<input type="hidden" id="id" name="id" class="form-control" value="<?php echo $f[0]; ?>">
										<input type="hidden" id="nid" name="nid" class="form-control" value="<?php echo $id; ?>">		
										<p class="form-control-static"><?php echo strtoupper($f[1]); ?></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label">Días Plazo Ejec. Obra: </label>
									<div class="col-md-6">
										<p class="form-control-static"><?php echo $f[2]; ?> días</p>
									</div>
								</div>						
								<?php if ($perfil == 1): ?>
									<div class="form-group">

										<label class="col-md-4 control-label">Archivos: </label>
										<div class="col-md-6">
											<input type="file" id="f" name="f[]" class="form-control" multiple>
											<p class="text-justify"><small class="text text-info"><span class="fa fa-info-o"></span> Archivos Permitidos: PDF, Word y Excel.
											<br>Apretando <b>Ctr+Click</b> puede escoger mas de un archivo.</small></p>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-10 col-sm-offset-2">
											<button type="button" class="btn btn-primary" id="updoc"> 
												<i class="fa fa-upload"></i> Subir
											</button>
											<button type="button" class="btn btn-danger" id="can">
												<i class="fa fa-times"></i> Cancelar
											</button>
										</div>
									</div>							
								<?php endif; ?>						
								
							</form>							
						</div>
						<div id="ldoc"></div>
					<?php } ?>
					
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/obras.js"></script>
<script type="text/javascript">
	$("#ldoc").load('../../model/obras/listdoc.php?id='+<?php echo $id; ?>);
</script>
</html>