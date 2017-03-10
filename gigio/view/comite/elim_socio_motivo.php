<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();
$url = url();

$seek = $_POST['rut'];

if ($seek) {
	$rut = explode('-', $seek, -1);

	$string = "select concat(p.rut,'-',p.dv) as rut, p.nombres, concat(p.paterno,' ',p.materno) as apellidos, c.nombre, c.idgrupo ".
			  "from persona as p ".
			  "inner join persona_comite as pc on pc.rutpersona = p.rut ".
			  "inner join grupo as c on c.idgrupo = pc.idgrupo ".
			  "where pc.rutpersona = '".$rut[0]."'";
	
	$sql = mysqli_query($conn, $string);

	if ($f = mysqli_fetch_array($sql)) {
		?>
		<form class="form-horizontal" id="motelim" name="motelim" action="<?php echo $url; ?>model/comite/despersonacomite.php" method="post">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3>Motivo de Eliminación del Comité <?php echo $f[3]; ?></h3>										
			</div>		
			<div class="modal-body">			
				<input type="hidden" name="crut" id="crut" class="form-control" value="<?php echo $rut[0]; ?>">
				<input type="hidden" name="idg" id="idg" value="<?php echo $f[4]; ?>">
				<div class="form-group">
					<label class="col-md-4 control-label">RUT: </label>
					<div class="col-md-6">
						<p class="form-control-static"><?php echo $f[0]; ?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label">Nombre: </label>
					<div class="col-md-6">
						<p class="form-control-static"><?php echo $f[1]; ?></p>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-md-4 control-label">Motivos</label>
					<div class="col-md-6">
						<select name="mot" id="mot" class="form-control" >
							<option value="">Escoja un motivo</option>
							<?php cargaCombo("select * from motivo_eliminacion") ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obs">Observaciones</label>										
					<div class="col-md-6">
						<textarea name="obs" id="obs" class="form-control" rows="10" placeholder="Ingrese Observaciones (máximo 500 caracteres)" maxlength="500"></textarea>
						<p id="cuenta" class="form-control-static" >500</p>
					</div>						
				</div>				
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="env">	<i class="fa fa-thrash fa-1x"></i>  Aceptar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-1x"></i> Cerrar</button>
			</div>
		</form>			
	<?php	
	}

}

?>