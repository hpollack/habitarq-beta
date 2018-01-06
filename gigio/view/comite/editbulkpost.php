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

$ruk = $_GET['ruk'];

$sql = mysqli_query($conn, "select * from grupo where numero = ".$ruk."");
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
			<div class="col-md-10">
				<div class="row">
					<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
							</button> <a class="navbar-brand" href="<?php echo $url; ?>index.php">Sistema E.P. Habitarq</a>
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
						<li><a href="<?php echo $url; ?>view/comite/">Comité</a></li>
						<li><a href="<?php echo $url; ?>view/comite/listpostedit.php">Lista de Comités</a></li>
						<li class="active">Lista de Postulantes Editable</li>
					</ol>
				</div>
				<div class="row">
					<?php if (mysqli_num_rows($sql) > 0): ?>
						<div id="alerta"></div>
						<div class="col-md-10 col-md-offset-0">							
							<form class="form-horizontal" role="form">
								<label class="col-lg-2 control-label" for="busc2">Buscar: </label>
								<div class="col-lg-6 input-group">
									<span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
									<input type="hidden" id="ruk" name="ruk" value="<?php echo $ruk ?>">
									<input type="text" id="busc2" class="form-control" name="busc2" placeholder="Escriba el Rut o el nombre completo"><br><span id="msg"></span>										
								</div>
							</form>										
						</div>
						<div id="lpostedit"></div>

						<div class="modal fade" id="modal-id">
							<!-- Modal -->
							<div class="modal-dialog">
								<div class="modal-content">
									<!-- Contenido traido de forma externa -->
								</div>
							</div>
						</div>
					<?php else: ?>
						<div class="alert alert-danger">
							<strong>¡El comité no existe u ocurrió un error!</strong> 
							<a class="alert alert-link" href="<?php echo $url; ?>view/comite/listpostedit.php">Volver</a>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/comite.js"></script>
<script type="text/javascript">
	$("#lpostedit").load('../../model/comite/lpostedit.php?ruk='+<?php echo $ruk; ?>);
</script>
</html>