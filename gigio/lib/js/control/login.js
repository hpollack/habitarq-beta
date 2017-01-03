$(document).ready(function() {
	$("#mensaje").css('display', 'none');
	$("#user").focus(function(event) {
		$("#mensaje").css('display', 'none');
		$("#mensaje").removeClass('alert alert-danger');			
	});
	$("#sub").click(function() {
		var id = $("#user").val();
		var pass = $("#pas").val();
		if(id=='' || pass==''){
			$("#mensaje").addClass('alert alert-danger');
			$("#mensaje").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>')
			$("#mensaje").fadeIn('fast');
			$("#mensaje").html(" Ningun campo debe quedar vacío");			
		}else{
			$.ajax({
				type : 'post',
				url : '../../model/auth.php',
				data : $("#login").serialize(),
				beforeSend:function(){
					$("#mensaje").fadeIn('slow');
					$("#mensaje").html("Iniciando sesion...");
				},
				success:function(data){
					if(data=="ok"){
						$("#mensaje").removeClass('alert alert-danger');
						$("#mensaje").addClass('alert alert-success');
						$("#mensaje").fadeIn('fast');
						$("#mensaje").html("Iniciando Sesion...");
						setTimeout('window.location.href = "index.php";', 3000);
					}else{
						$("#mensaje").addClass('alert alert-danger');
						$("#mensaje").fadeIn('fast');
						$("#mensaje").html(data);					
					}
				}
			});
		}		
	});
});
