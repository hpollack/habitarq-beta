//Controlador de la Configuracion
$(document).ready(function() {

	$("#msg").click(function() {
		$("#msg").removeClass('alert alert-success');
		$("#msg").html('');
	});

	$("#msg").click(function() {
		$("#msg").removeClass('alert alert-danger');
		$("#msg").html('');
	});
	
	$("#grab").click(function() {
		var parametros = $("#gen").serialize();

		$.ajax({
			type : 'post',
			url  : '../../model/config/parametros_generales.php',
			data : parametros,

			beforeSend:function() {
				$("#b").html('Guardando Configuración');
			},
			error:function() {
				alert("Ocurrio un error");
			},
			success:function(data) {
				$("#b").html('');
				if (data == 1) {					
					$("#msg").removeClass('alert alert-danger');
					$("#msg").addClass('alert alert-success');
					$("#msg").html("<b>Datos Almacenados</b>");
					window.scroll(0,1);
				}else {					
					$("#msg").removeClass('alert alert-success');
					$("#msg").addClass('alert alert-danger');
					$("#msg").html("<b>Error en la transacción</b>");
					window.scroll(0,1);
				}
			}
		});
	});
});