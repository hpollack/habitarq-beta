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
				digits : true,				
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
				digits: true,
				maxlength : 3
			},
			mp2 : {
				digits: true,
				maxlength : 3
			},
			st : {
				required : true,
				digits: true,
				maxlength : 4
			}

		},

		messages : {
			rut : {
				required : "Campo requerido",
				digits : "Solo puede ingresar numeros",
				minlength : "El largo minimo so 7 digitos",
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
				digits: "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 3 digitos"
			},
			mp2 : {
				digits: "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 3 digitos"
			},
			st : {
				required : "Campo requerido",
				digits: "Solo puede ingresar numeros",
				maxlength : "El largo maximo son 4 digitos"
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