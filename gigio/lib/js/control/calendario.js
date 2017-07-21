$(document).ready(function() {
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
		$.ajax({
			type : 'get',
			url  : url,
			data : "mes="+mes,
			success:function(data) {
				$("#calendario").fadeOut('slow');
				$("#calendario").load(url+'?mes='+mes).fadeIn('slow');				
			}
		});
	});

});