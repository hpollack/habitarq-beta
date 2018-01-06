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


$rut = explode('-', $_POST['rut']);
$ruk = $_POST['ruk'];



$string  = "select v.rol, 
			(
				select m.metros from mts as m
				inner join piso as p on p.idpiso = m.idpiso
				inner join estado_vivienda as e on e.idestado_vivienda = m.idestado_vivienda
				where e.idestado_vivienda = 2 and m.rol = v.rol
			) as metros,
			(
				select m.idpiso from mts as m
				inner join piso as p on p.idpiso = m.idpiso
				inner join estado_vivienda as e on e.idestado_vivienda = m.idestado_vivienda
				where e.idestado_vivienda = 2 and m.rol = v.rol
			) as piso
			from vivienda as v
			inner join persona_vivienda as ps on ps.rol = v.rol
			where ps.rut = '".$rut[0]."'";
		
			
$sql = mysqli_query($conn, $string);

?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Editar Información Ampliación Vivienda Rol <?php echo $row[0]; ?></h4>
</div>
<div class="modal-body">
	<?php if (mysqli_num_rows($sql) > 0): ?>

		<?php if ($row = mysqli_fetch_array($sql)): ?>			
			<form class="form-horizontal">				
				<div class="form-group">
					<label class="col-md-4 control-label">Metros Ampliación: </label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="mts" name="mts" value="<?php echo  (isset($row[1])) ? $row[1] : 0; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label">Piso: </label>
					<div class="col-md-6">
						<select id="ps" name="ps" class="form-control" >
							<option value="0">Escoja Piso</option>
							<?php cargaComboId("select * from piso", $row[2]); ?>
						</select>
						<input type="hidden" id="rol" name="rol" value="<?php echo $row[0]; ?>">
						<input type="hidden" id="ruk" name="ruk" value="<?php echo $row[3]; ?>">
					</div>
				</div>		
			</form>
		<?php endif; ?>
		
	<?php else: ?>
		<div class="alert alert-danger">			
			<strong>¡Ocurrió un error al cargar el formulario!</strong> 
		</div>
	<?php endif ?>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="edit"><i class="fa fa-edit"></i> Editar</button>
	<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
</div>