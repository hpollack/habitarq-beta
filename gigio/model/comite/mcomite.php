<?php 
session_start();
include_once '../../lib/php/libphp.php';
/*
Datos que se muestran en ventana modal al presionar el botón ver en la lista 
*/
$conn = conectar();
$seek = $_POST['num'];

if ($seek) {
	
	$string = "select g.numero, g.nombre, g.personalidad, g.fecha, g.direccion, ".
			  " c.COMUNA_NOMBRE, p.PROVINCIA_NOMBRE, r.REGION_NOMBRE".
			  " FROM grupo AS g".
			  " INNER JOIN comuna AS c ON g.idcomuna = c.COMUNA_ID".
			  " INNER JOIN provincia AS p ON c.COMUNA_PROVINCIA_ID = p.PROVINCIA_ID".
			  " INNER JOIN region AS r ON p.PROVINCIA_REGION_ID = r.REGION_ID".
			  " where g.numero = ".$seek."";

    $sql = mysqli_query($conn, $string);

    if ($f = mysqli_fetch_array($sql)) {
    	
    	?>
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal">&times;</button>
    		<h3>Comité <?php echo $f[1]; ?></h3>
    	</div>
    	<div class="modal-body">
    		<p><strong>Numero: </strong><?php echo $f[0]; ?></p>
	    	<p><strong>Personalidad Jurídica: </strong><?php echo $f[2]; ?></p>
	    	<p><strong>Fecha de Registro: </strong><?php echo $f[3]; ?></p>
	    	<p><strong>Dirección: </strong><?php echo $f[4]; ?></p>
	    	<p><strong>Comuna: </strong><?php echo $f[5]; ?></p>
	    	<p><strong>Provincia: </strong><?php echo $f[6]; ?></p>
	    	<p><strong>Region: </strong><?php echo $f[7]; ?></p>
    	</div>
    	<div class="modal-footer">
    		<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-1x"></i> Cerrar</button>
    	</div>
    	<?php
    }else{
    	echo "Ocurrió un error";
    }

    mysqli_free_result($sql);
    
}else{
	echo "No viene id";
}

mysqli_close($conn);

 ?>