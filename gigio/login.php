<?php
include_once 'lib/php/libphp.php';
$url = url();
?>
<!doctype>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/fa/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>lib/css/login.css">
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/additional-methods.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/dist/localization/messages_es.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-10 col-md-offset-0">
						<div class="row">
							<div class="col-md-2">
							</div>
							<div class="col-md-6" id="login-form">
								<div id="mensaje"></div>
								<form role="form" id="login" class="form-horizontal" action="<?php echo $url; ?>model/auth.php" method="post">
									<div class="form-group">										 
										<label class="control-label" for="user">
											Usuario: 
										</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
											<input type="text" class="form-control" id="user" name="user" placeholder="Usuario" />
										</div>
									</div>
									<div class="form-group">										 
										<label class="control-label" for="pas">
											Contraseña
										</label>
										<div class="input-group">
											<span class="input-group-addon"><li class="fa fa-key fa-fw"></li></span>
											<input type="password" class="form-control" id="pas" name="pas" placeholder="Contraseña" />
										</div>
									</div>									
									<button type="submit" class="btn btn-primary" id="sub">
									<i class="fa fa-sign-in"></i>
										Ingresar
									</button>
								</form>
							</div>
							<div class="col-md-2">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/control/login.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>lib/js/validate/control/login.validate.js"></script>	
</body>
</html>