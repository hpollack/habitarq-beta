<?php
	session_start();
	include_once '../../lib/php/libphp.php';
	

	date_default_timezone_set("America/Santiago");
	setlocale(LC_TIME, 'spanish');

	$rutus = $_SESSION['rut'];
	$perfil = $_SESSION['perfil'];
	$nombre = $_SESSION['usuario'];
	if(!$rutus){
	    echo "No puede ver esta pagina";
	    header("location: ".url()."login.php");
	    exit();
	}

	$conn = conectar();

	$id = $_GET['id'];	

	$string = "select * from eventos_calendario where idevento = ".$id."";

	$sql = mysqli_query($conn ,$string);

	while ($f = mysqli_fetch_array($sql)) {
		# code...
		$fi = date("d/m/Y", $f[2]);
		$hi = date('H:i', $f[2]);
		$ff = date("d/m/Y", $f[3]);
		$hf = date('H:i', $f[3]);		
	
?>
<div class="modal-dialog modal-sm" id="msize" >
	<div class="modal-content">
		<form class="form-horizontal" id="ev">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3>Editar Evento</h3>
			</div>
			<div class="modal-body">
				<div id="emsg"></div>
				<div class="form-group">
					<label class="col-md-4 control-label">Fecha Inicio: </label>
					<div class="col-md-6">
						
						<input type="text" class="form-control f-date" id="efev" name="efev" value="<?php echo $fi; ?>" placeholder="Ingrese Fecha (dd/mm/yyyy)">
					</div>			
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label">Hora Inicio: </label>
					<div class="col-md-6">
						<input class="form-control" type="time" id="ehev" name="ehev" value="<?php echo $hi; ?>" placeholder="Ingrese Hora (hh:mm)">
					</div>
				</div>	
				<div class="form-group">
					<label class="col-md-4 control-label">Fecha Final: </label>
					<div class="col-md-6">
						<input class="form-control f-date" type="text" id="effv" name="effv" value="<?php echo $ff; ?>" placeholder="Ingrese Fecha (dd/mm/yyyy)">
					</div>			
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label">Hora Final: </label>
					<div class="col-md-6">
						<input class="form-control" type="time" id="ehfv" name="ehfv" value="<?php echo $hf; ?>" placeholder="Ingrese Hora (hh:mm)">
					</div>
				</div>		
				<div class="form-group">
					<label class="col-md-4 control-label">Título: </label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="etev" name="etev" value="<?php echo $f[1]; ?>" placeholder="Ingrese Titulo">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label">Detalle: </label>
					<div class="col-md-6">
						<textarea class="form-control" rows="10" id="ecev" name="ecev" placeholder="Ingrese Detalle (máximo 200 caracteres)" maxlength="200"><?php echo $f[4]; ?></textarea>
						<input type="hidden" class="form-control" id="ide" name="ide" value="<?php echo $f[0]; ?>" placeholder="">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="button" class="btn btn-primary" id="egev"><i class="fa fa-plus"></i> Editar</button>
						<button type="reset" class="btn btn-warning" id="rev"><i class="fa fa-refresh"></i> Limpiar</button>
						<button type="button" class="btn btn-danger" id="bev" ><i class="fa fa-trash"></i> Borrar</button>
						<button type="button" class="btn btn-default" id="caev" data-dismiss="modal"><i class="fa fa-times"></i> Salir</button>	
					</div>
				</div>
			</div>
		</form>		
	</div>
</div>
<script type="text/javascript">
	$(".f-date").datepicker({
		format: "dd/mm/yyyy",
		language : "es",
		autoclose : true
	});	

</script>
<?php 
}

mysqli_close($conn);
?>