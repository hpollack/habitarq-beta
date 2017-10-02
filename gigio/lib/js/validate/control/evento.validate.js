$(document).ready(function() {
	$("#ev").validate({
		rules : {
			fev : { required : true },
			hev : { required : true },
			ffv : { required : true },
			hfv : { required : true },
			tev : { required : true },
			cev : {
				required : true,
				maxlength : 200
			}

		},

		messages : {
			fev : { required : "Campo Obligatorio" },
			hev : { required : "Campo Obligatorio" },
			ffv : { required : "Campo Obligatorio" },
			hfv : { required : "Campo Obligatorio" },
			tev : { required : "Campo Obligatorio" },
			cev : {
				required : "Campo Obligatorio",
				maxlength : "El límite es de 200 caracteres" 
			}
		}
	});

	$("#agev").click(function() {
		/* Act on the event */
		$("#ev").valid();
	});
});
