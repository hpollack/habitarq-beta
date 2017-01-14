$(document).ready(function() {
	
	$("#busc").click(function() {
		var rut = $("#rut").val();
		$.ajax({
			type : 'post',
			url : '../../model/persona/dpersonafoc.php',
			data : "rut="+rut,
			beforeSend:function(){
				$("#res").html('Buscando...');
			},
			error:function(){
				$("#res").html('');
				$("#alerta").fadeIn('slow');
				$("#alerta").addClass('alert alert-danger');
				$("#alerta").html("Ocurrio un error");								
			},
			success:function(data){
				if(data=="no"){
					$("#res").html('');
					$("#alerta").fadeIn('slow');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html("<strong>Esta persona no se encuentra en la base de datos");
					$("#alerta").fadeIn('slow');
				}else{
					$("#res").html('');
					$("#dpersona").fadeIn();
					$("#dpersona").html(data);
				}
			}
		});
	});
});