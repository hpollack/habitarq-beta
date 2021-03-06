<?php
/**
 * ======================================================================
 * DATOS PARA CARGA EN VENTANA MODAL
 * ======================================================================
 * 
 * Datos Básicos de la persona que se cargan en ua ventana modal, al presionar
 * el botón ver, en cada fila de la lista de personas.
 * 
 * @author Hermann Pollack
 * @version 1.0
 * 
 * @param string $seek: rut de la persona, pasado por parámetro desde la lista.
**/
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}
/*
Datos que se muestran en ventana modal al presionar el botón ver en las lista de personas
*/
$conn = conectar();

$seek = $_POST['rut'];

//Se valida que el rut esté correcto.
if($seek){

	$rut = explode('-', $seek, -1);

	$string = "select
		concat(p.rut,'-', p.dv) as rut, concat(p.nombres,' ', p.paterno,' ', p.materno) as nombre, p.correo, p.estado, d.calle,
		d.numero, c.COMUNA_NOMBRE, pr.PROVINCIA_NOMBRE, r.REGION_NOMBRE, 
		f.numero as fono, tf.idtipo 
	FROM
		persona AS p
	INNER JOIN direccion AS d ON d.rutpersona = p.rut
	INNER JOIN comuna AS c ON d.idcomuna = c.COMUNA_ID
	INNER JOIN provincia AS pr ON c.COMUNA_PROVINCIA_ID = pr.PROVINCIA_ID
	INNER JOIN region AS r ON pr.PROVINCIA_REGION_ID = r.REGION_ID
	INNER JOIN fono AS f ON f.rutpersona = p.rut
	INNER JOIN tipofono AS tf ON f.tipo = tf.idtipo WHERE p.rut = '".$rut[0]."'";

	$sql = mysqli_query($conn, $string);

	if ($f = mysqli_fetch_array($sql)) {

		# Se crea la estructura interna de la ventana Modal
		?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3> <?php echo $f[1]; ?></h3>										
		</div>
		<div class="modal-body">
				<form class="form-horizontal">
				<input type="hidden" name="mrut" id="mrut" class="form-control" value="<?php echo $rut[0]; ?>">
				<p><strong>Rut: </strong><?php echo $f[0]; ?></p>			
				<p><strong>Correo: </strong><?php echo $f[2]; ?></p>
				<p><strong>Direccion: </strong><?php echo $f[4]." # ".$f[5]; ?></p>
				<p><strong>Comuna: </strong><?php echo $f[6]; ?></p>
				<p><strong>Provincia: </strong><?php echo $f[7]; ?></p>
				<p><strong>Región: </strong><?php echo $f[8]; ?></p>
				<p><strong>Teléfono: </strong>
				<?php
				# Se verifica si el numero es fijo o celular
				switch ($f[10]) {
					case 1:
						echo $f[9];
						break;
					case 2:
						echo "+569".$f[9];
						break;
					default:
						break;
				}
				?>
				</p>			
			</div>
			<div class="modal-footer">				
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-1x"></i> Cerrar</button>
			</div>
		</form>			
		<?php
	}
	
}else{
	echo "<strong>El Parámetro no es correcto o ilegible</strong>";
}

mysqli_free_result($sql);
mysqli_close($conn);
?>