
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
include '../../../lib/php/libphp.php';

$rut = $_GET['r'];
$url = url();

$conn = conectar();

$string = "select distinct concat(pr.rut,'-',pr.dv) as rut, concat(pr.nombres,' ',pr.paterno,' ',pr.materno) as nombre, ".
		  "f.nucleo_familiar from frh as f ".
		  "inner join persona_ficha p on p.nficha = f.nficha ".
		  "inner join persona as pr on pr.rut = p.rutpersona ".
		  "inner join lista_postulantes as l on l.rutpostulante = p.rutpersona ".
		  "where l.rutpostulante = '".$rut."'";

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
			<div class="col-md-9" id="cuerpo">
				<div class="row">
					<ol class="breadcrumb">
						<li ><a href="<?php echo $url; ?>">Inicio</a></li>						
						<li><a href="<?php echo $url; ?>view/formularios/" title="">Formularios</a></li>
						<li><a href="<?php echo $url; ?>view/formularios/individual.php" title="">Individual</a></li>
						<li><a href="<?php echo $url; ?>view/formularios/documentos/nucleofamiliar.php" title="">Declaración de Núcleo Familiar</a></li>						
						<li class="active">Documento de Declaración</li>
					</ol>
				</div>
				<div class="row">
					<?php if ($f = mysqli_fetch_array($sql)) { ?>
						<form class="form-horizontal" id="fdnf" action="<?php echo $url; ?>model/formularios/nucleofamiliar.php" method="post">
							<div class="form-group">
								<label class="col-md-4 control-label" for="nnom">Nombre del Postulante: </label>
								<div class="col-md-6">
									<input type="hidden" id="rpers" name="rpers" value="<?php echo $f[0]; ?>">
									<input type="hidden" name="npers" value="<?php echo $f[1]; ?>">
									<p class="form-control-static" id="nnom"><?php echo $f[1]; ?></p>
								</div>
							</div>
							<?php for ($i=1;$i<=$f[2];$i++) { ?>
								<div class="form-group">
									<label class="col-md-4 control-label" for="mb<?php echo $i; ?>">Miembro <?php echo $i; ?></label>
									<div class="col-md-2">
										<input type="text" class="form-control" id="rt<?php echo $i; ?>" name="rt[]" placeholder="RUT">
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control" id="nom<?php echo $i; ?>" name="nom[]" placeholder="Nombre">
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" id="prt<?php echo $i; ?>" name="prt[]" placeholder="Parentesco">
									</div>
								</div>
							<?php } ?>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Generar</button>
									<button type="reset" class="btn btn-warning" id="nrs"><i class="fa fa-refresh"></i> Limpiar</button>
									<button type="button" class="btn btn-danger" id="ncnl"><i class="fa fa-times"></i> Cancelar</button>
								</div>
							</div>
						</form>
					<?php }else{ ?>
						<div class="alert alert-danger alert-dismissable">
							<strong>Este Usuario no se encuentra registrado</strong>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>