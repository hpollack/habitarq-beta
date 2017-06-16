$(document).ready(function() {
	$("#cuen").validate({
		rules: {
			rut : {
				required : true,
				digits : true
			},
			nc :{
				required : true
			},
			fap : {
				required : true
			},
			ah : {
				required : true,
				digits : true
			}			
		},

		messages : {
			rut : {
				required : "Campo requerido",
				digits : "Solo puede ingresar numeros"
			},
			nc : {
				required : "Campo requerido"
			},
			fap : {
				required : "Fecha requerida"
			},
			ah : {
				required : "Campo requerido",
				digits : "Solo puede agregar numeros"
			}
		}
	});

	$("#grab").click(function() {
		$("#cuen").valid();
	});
	$("#edit").click(function() {
		$("#cuen").valid();
	});
	$("#busc").click(function() {
		$("#cuen").valid();
	});
});