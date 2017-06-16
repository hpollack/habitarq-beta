$(document).ready(function() {
	$("#viv").validate({
		rules : {
			rut : {
				required : true,
				digits : true,
				minlength : 7,
				maxlength : 8
			},
			rol : {
				required : true,
				//digits : true,				
			},
			foj : {
				required : true
			},
			num : {
				required : true,
				digits : true,
				maxlength : 4
			},
			ar : {
				required : true,
				digits : true,
				maxlength : 4
			},
			mp1 : {
				required : true,
				number: true,
				maxlength : 5
			},
			mp2 : {
				number: true,
				maxlength : 5
			},
			},
			mp3 : {				
				number: true,
				maxlength : 5
			},
			mp4 : {
				number: true,
				maxlength : 5
			},
			st : {
				required : true,
				digits: true,
				maxlength : 5
			}

		},

		messages : {
			rut : {
				required : "Campo requerido",
				digits : "Solo puede ingresar numeros",
				minlength : "El largo minimo son 7 digitos",
				maxlength : "El largo maximo son 8 digitos"
			},
			rol : {
				required : "Campo requerido",
				digits : "Solo puede ingresar numeros",				
			},
			foj : {
				required : "Campo requerido"
			},
			num : {
				required : "Campo requerido",
				digits : "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 4 digitos"
			},
			ar : {
				required : "Campo requerido",
				digits : "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 4 digitos"
			},
			mp1 : {
				required : "Campo requerido",
				number: "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 5 caracteres",
			},
			mp2 : {
				number: "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 5 caracteres",
			},
			mp3 : {
				number: "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 5 caracteres",
			},
			mp4 : {
				number: "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 5 caracteres",
			},
			st : {
				required : "Campo requerido",
				number: "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 5 digitos"
			}
		}
	});

	$("#grab").click(function(){
		$("#viv").valid();
	});
	$("#edit").click(function(){
		$("#viv").valid();
	});
	$("#del").click(function(){
		$("#viv").valid();
	});

});