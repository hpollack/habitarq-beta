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
				maxlength : 9
			},
			ar : {
				required : true,
				digits : true,
				maxlength : 9
			},
			mp1 : {
				required : true,
				number: true,
				maxlength : 9
			},
			mp2 : {
				number: true,
				maxlength : 9
			},
			},
			mp3 : {				
				number: true,
				maxlength : 9
			},
			mp4 : {
				number: true,
				maxlength : 9
			},
			st : {
				required : true,
				number: true,
				maxlength : 9
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
				number: "Solo puede agregar numeros (separados los decimales por un punto)",
				maxlength : "El largo maximo son 9 caracteres",
			},
			mp2 : {
				number: "Solo puede agregar numeros (separados los decimales por un punto)",
				maxlength : "El largo maximo son 9 caracteres",
			},
			mp3 : {
				number: "Solo puede agregar numeros (separados los decimales por un punto)",
				maxlength : "El largo maximo son 9 caracteres",
			},
			mp4 : {
				number: "Solo puede agregar numeros (separados los decimales por un punto)",
				maxlength : "El largo maximo son 9 caracteres",
			},
			st : {
				required : "Campo requerido",
				number: "Solo puede agregar numeros (separados los decimales por un punto)",
				maxlength : "El largo maximo son 9 digitos"
			}
		}
	});

	$("#grab").click(function(){
		$("#viv").valid();
	});
	$("#edit").click(function(){
		$("#viv").valid();
	});

});