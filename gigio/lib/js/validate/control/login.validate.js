$(document).ready(function() {
	jQuery.validator.addMethod("lettersonly", function(element, value){
		return this.optional(element) || /^[0-9a-zA-Z]+$/i.test(value);
	}, "La clave solo acepta numeros o letras");

	$("#login").validate({
		rules : {
			user : {
				required : true
			},
			pas : {
				required: true,
				lettersonly : true,
				minlength : 4
			}
		},
		messages : {
			us : { required : "Campo requerido" },
			pas : { required : "Campo requerido" }
		}		
	});

	$("#sub").click(function () {
		$("#login").valid();
	});
});

