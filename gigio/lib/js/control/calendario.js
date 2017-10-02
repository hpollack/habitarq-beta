
$(document).ready(function() {
	$(function () {
		$("#fev").datepicker({
			format: "dd/mm/yyyy",
			language : "es",
			autoclose : true
		});	

		$("#ffv").datepicker({
			format: "dd/mm/yyyy",
			language : "es",
			autoclose : true
		});
	});
	
	/* Al enfocar cualquier campo desaparecen los mensajes */
	$(".form-control").focus(function () {
		$(".error").html('');
	});

	$("#alerta").click(function() {
		$(this).removeClass('alert alert-success').html('');
	});

	//Mostrar calendario
	$("#calendario").load('../../model/calendario/calendario.php');

	$("#mes").datepicker({
		autoclose : true,			
		format : 'mm-yyyy',
		minViewMode : 1,
		language : "es"
	});

	

	$("#cm").click(function() {
					
		var mes = $("#mes").val();
		var url = '../../model/calendario/calendario.php';

		if (mes == "") {
			alert("debe incluir un mes");
		}else{
			$.ajax({
				type : 'get',
				url  : url,
				data : "mes="+mes,
				success:function(data) {					
					$("#calendario").load(url+'?mes='+mes);					
				}
			});
		}
		
	});	

	$("#agregaEventoCal").on('click', '#msg', function() {
		$("#msg").removeClass('alert alert-danger');
		$("#msg").html('');
	})

	$("#agregaEventoCal").on('click', '#agev', function() {
		if ($("#ev input").val() == "" && $("#cev").val() == "") {
			$("#msg").html('Los campos deben ser completados');
		}else {
			$.ajax({
				type : 'post',
				url : '../../model/calendario/meventos.php',
				data : $("#ev").serialize(),
				beforeSend:function() {
					$("#msg").html('Ingresando Evento');
				},
				error:function() {
					alert('Ocurrio un error');
				},
				success:function(data){
					if (data == 1) {
						$("#ev input").val('');
						$("#cev").val('');
						$("#agregaEventoCal").modal('hide');
						$("#calendario").load('../../model/calendario/calendario.php');
						$("#alerta").addClass('alert alert-success');
						$("#alerta").html('<b>Evento Creado</b>');
					}else if (data == 2) {
						$("#msg").addClass('alert alert-danger');
						$("#msg").html('<b>La fecha de inicio es mayor a la fecha final');
					}else{
						$("#msg").addClass('alert alert-danger').html('<b>La fecha de inicio es mayor a la fecha final');
					}
				}
			});
		}
		
	});

	$("#agregaEventoCal").on('click', '#rev', function() {
		//$(".error").html('');
		$("#msg").html('');
		$("#ev input").val('');
		$("#cev").val('');		
	});

	/*$("#agregaEventoCal").on('show.bs.modal', function(e) {
		var e = $(e.relatedTarget);
		var url = '../../view/calendario/evento.php'
		$(".modal-content").load(url, function(){
			$("#fev").datepicker({
				format : "dd/mm/yyyy",
				language: "es",
				autoclose: true
			}); 
		});
	});

*/

});



