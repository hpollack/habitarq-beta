$(document).ready(function() {
	$("#mensaje").css('display', 'none');

	$("#user").focus(function(event) {
		$("#mensaje").css('display', 'none');
		$("#mensaje").removeClass('alert alert-danger');			
	});

	$("#mensaje").click(function(event) {
		$("#mensaje").css('display', 'none');
		$("#mensaje").removeClass('alert alert-danger');
	});
	 
	$("#sub").click(function(e) {
		var id = $("#user").val();
		var pass = $("#pas").val();
		//var url = 'http://localhost/gigio/';
		if(id=='' || pass==''){
			$("#mensaje").addClass('alert alert-danger');
			$("#mensaje").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>')
			$("#mensaje").fadeIn('fast');
			$("#mensaje").html(" Ningun campo debe quedar vacío");			
		}else{
			$.ajax({
				type : 'post',
				url : $("#login").attr("action"),
				data : $("#login").serialize(),
				beforeSend:function(){
					$("#mensaje").fadeIn('slow');
					$("#mensaje").html("Iniciando sesion...");
				},
				success:function(data){
					if(data=="ok"){
						$("#pas").val('')
						$("#mensaje").removeClass('alert alert-danger');
						$("#mensaje").addClass('alert alert-success');
						$("#mensaje").fadeIn('fast');
						$("#mensaje").html("Iniciando Sesion...");
						window.location.href = "index.php";
					}else if (data == 2) {						
						$("#mensaje").addClass('alert alert-danger');
						$("#mensaje").fadeIn('fast');
						$("#mensaje").html('<b>No es un rut válido</b>');
						$("#login input").val('');
					}else{
						$("#pas").val('');
						$("#mensaje").addClass('alert alert-danger');
						$("#mensaje").fadeIn('fast');
						$("#mensaje").html(data);
						$("#login input").val('');						
					}
				}
			});
		}
		e.preventDefault();
	});
});