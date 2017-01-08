$(document).ready(function() {
	$("#fich").validate({
		rules : {
			rut : {
				required : true,
				digits : true,
				minlength : 7,
				maxlength : 8				
			},
			fnac : {
				required :true,
				date : true
			},
			pnt : {
				required: true,
				digits: true,
				maxleng: 6
			},
			gfm : {
				required : true,
				digits: true,
				maxlength : 2
			}
		},

		messages : {
			rut : {
				required : "Campo requerido",
				minlength : "Los digitos no pueden ser menores que 7",
				maxlength : "Los digitos no pueden ser mayores a 8",
				digits : "Solo puede ingresar numeros"		
			},
			fnac : {
				required : "Campo requerido",
				date : "El formato de fecha es dd/mm/aaaa",
			},
			pnt : {
				required : "Campo requerido",
				digits : "Solo puede ingresar numeros",
				maxlength : "No puede ingresar un numero de mas de 6 cifras"
			},
			gfm : {
				required : "Campo requerido",
				digits : "Solo puede ingresar numeros",
				maxlength : "No puede ingresar mas de 2 cifras"
			}			
		}
	});

	$("#grab").click(function() {
		$("#fich").valid();
	});

	$("#edit").click(function() {
		$("#fich").valid();
	});

	$("#seek").click(function(){
		$("#fich").valid();
	});
});