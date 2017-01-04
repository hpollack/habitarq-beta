$(document).ready(function() {
	$("#pers").validate({
		rules: {
			rut :{
				required : true,
				digits : true,
				minlength : 7,
				maxlength : 8
			},
			dv : {
				required : true,
				minlength : 1,
				maxlength : 1
			},
			nom : {
				required : true,
				//lettersonly : true,
				maxlength : 50
			},
			ap : {
				required : true,
				lettersonly : true,
				maxlength : 50
			},
			am : {
				required : true,
				lettersonly : true,
				maxlength : 50
			},
			dir : {
				required : true,
				//lettersonly : true,
				maxlength : 50
			},
			nd : {
				required : true,
				digits : true,
				maxlength : 5
			},
			tf : {
				required : true,
				digits : true,
				maxlength : 11
			},
			mail : {
				required : true,			
				maxlength : 50,
				email : true
			}
		},

		messages : {
			rut :{
				required : "Campo requerido",
				digits : "Solo debe ingresar numeros",
				minlength : "El rut no puede tener menos de 7 digitos",
				maxlength : "El rut no puede tener mas de 8 digitos"
			},
			dv : {
				required : "Campo requerido",
				minlength : "Solo debe tener un caracter",
				maxlength : "Solo debe tener un caracter"
			},
			nom : {
				required : "Campo requerido",
				//lettersonly : "Solo puede ingresar letras",
				maxlength : "El nombre no puede pasar de los 50 caracteres"
			},
			ap : {
				required : "Campo requerido",
				lettersonly : "Solo puede ingresar letras",
				maxlength : "El apellido paterno no puede pasar de los 50 caracteres"
			},
			am : {
				required : "Campo requerido",
				lettersonly : "Solo puede ingresar letras",
				maxlength : "El apellido materno no puede pasar de los 50 caracteres"
			},
			dir : {
				required : "Campo requerido",
				//lettersonly : "Solo puede ingresar letras",
				maxlength : "La direccion no puede pasar de los 50 caracteres"
			},
			nd : {
				required : "Campo requerido",
				digits : "Solo puede ingresar numeros",
				maxlength : "Solo 5 numeros como máximo"
			},
			tf : {
				required : "Campo requerido",
				digits : "Solo se permiten numeros",
				maxlength : "Máximo 11 numeros"
			},
			mail : {
				required : "Campo requerido",
				maxlength : "El correo no puede tener mas de 50 caracteres",
				email : "Debe ingresar una direccion de correo válida"
			}

		}
	});

	$("#grab").click(function() {
		$("#pers").valid();
	});

	$("#edit").click(function() {
		$("#pers").valid();
	});

	$("#seek").click(function(){
		$("#pers").valid();
	});
});

