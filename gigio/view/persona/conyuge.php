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

$rutpersona = $_POST['rut'];

?>
<form class="form-horizontal" id="cye">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h2>Agregar o Editar Conyuge</h2>
	</div>
	<br>		
	<div class="modal-body">
		<div id="msj"></div>
	   <div class="form-group">
			<label class="col-md-4 control-label" for="rut">RUT: </label>
			<div class="row">
				<div class="col-md-4">
					<input type="text" id="rutc" name="rutc" class="form-control" placeholder="Ingrese Rut" />					
				</div>
				<div class="col-md-1">
					<input type="text" class="form-control" id="dvc" name="dvc" placeholder="DV" />			
				</div>
				<div class="col-md-2">
					<button class="btn btn-success" id="seekc" type="button"><i class="fa fa-search fa-1x"></i> Buscar</button><span id="bc"></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label" for="nom">Nombres: </label>
			<div class="col-md-6">
				<input type="text" class="form-control" id="nomc" name="nomc" placeholder="Ingrese Nombres" disabled>						
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label" for="apc">Paterno: </label>
			<div class="col-md-6">
				<input type="text" class="form-control" id="apc" name="apc" placeholder="Ingrese Apellido Paterno" disabled>						
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label" for="amc">Materno: </label>
			<div class="col-md-6">
				<input type="text" class="form-control" id="amc" name="amc" placeholder="Ingrese Apellido Materno" disabled>		
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label">Sexo: </label>
			<div class="col-md-6">
				<select  id="sx" name="sx" class="form-control" >
					<option value="">Escoja Sexo</option>
					<option value="M">Masculino</option>
					<option value="F">Femenino</option>
				</select>
			</div>
		</div>
		<div class="form-group" >
			<label class="col-md-4 control-label" for="vpc">Estado: </label>
			<div class="col-md-4">
				<label><input type="checkbox" id="vpc" name="vpc" value="1"> ¿Vigente?</label>
				<input type="hidden" id="rutp" name="rutp" value="<?php echo $rutpersona; ?>">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" id="gcon" class="btn btn-primary" disabled><i class="fa fa-plus"></i> Grabar</button>
		<button type="button" id="econ" class="btn btn-primary" disabled><i class="fa fa-edit"></i> Editar</button>
		<button type="reset" id="rcon" class="btn btn-warning"><i class="fa fa-reload"></i> Limpiar</button>
		<button type="button" id="dcon" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times fa-1x"></i> Cerrar</button>
	</div>
</form>
<script type="text/javascript">	
	$("#rutp").val(function() {
		var rp = $(this).val();
		$.ajax({
			type : 'post',
			url  : '<?php echo url(); ?>model/persona/processconyuge.php',
			data : "rp="+rp,
			success:function(data) {
				var datos = $.parseJSON(data);
				if(datos.rutc!=null) {
					$("#rutc").val(datos.rutc);
					$("#dvc").val(datos.dvc);
					$("#nomc").val(datos.nomc);
					$("#apc").val(datos.apc);
					$("#amc").val(datos.amc);
					$("#sx").val(datos.sx);
					if(datos.vpc==1) {
						$("#vpc").prop('checked', true);
					}
					$("#rutp").val(datos.rutp);
					$(".form-control").removeAttr('disabled');
					$("#econ").removeAttr('disabled');
					$("#gcon").attr('disabled', true);					
				}else {
					$("#rutp").val(datos.rutp);
					$("#econ").attr('disabled', true);
					$("#gcon").removeAttr('disabled');
					$("#dcon").attr('disabled', true);
				}
			}
		})
	});
</script>
