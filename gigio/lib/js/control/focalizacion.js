$(document).ready(function() {
	$("#rut").focus(function(){
		$("#alerta").removeClass('alert alert-danger');
		$("#alerta").html('');
	});

	$("#rut").focus(function(){
		$("#alerta").removeClass('alert alert-success');
		$("#alerta").html('');
	});

	$("#alerta").click(function(){
		$("#alerta").removeClass('alert');
		$("#alerta").html('');
	});

	$("#dp").css('display', 'none');
	
	$("#busc").click(function() {
		var rut = $("#rut").val();

		$.ajax({
			url  : '../../model/persona/dpersonafoc.php',
			type : 'post',
			data : 'rut='+rut,
			beforeSend:function() {
				$("#b").removeClass("text text-danger");
				$("#b").html('Cargando información...');
			},
			error:function() {
				alert("Ocurrio un error");
			},
			success:function(data) {
				if(data == "no") {
					$("#b").addClass('text text-danger');
					$("#b").html("Esta persona no se encuentra registrada en la base de datos");
				}else {
					$("#b").html('');
					datos = $.parseJSON(data);
					if (datos.r!=null && datos.id!=null) {
						$("#dp").slideDown('slow');
						$("#r").html(datos.r);
						$("#idf").val(datos.id);
						$("#nom").html(datos.nom);
						$("#fic").html(datos.fic);
						$("#ng").html(datos.ng);
						$("#ed").html(datos.ed+" años");
						if (datos.am == 1) {
							$("#fed").removeAttr('disabled');
						}					
						if (datos.fed == 1) {
							$("#fed").prop('checked', true);
						}
						if (datos.dis == 1) {
							$("#dis").html("Si");
							$("#fdis").removeAttr('disabled');
							if (datos.fdis == 1) {
								$("#fdis").prop('checked', true);
							}
						}else{
							$("#dis").html("No");
						}
						if (datos.hac) {
							$("#hac").html("Si");
							$("#fhac").removeAttr('disabled');
							if (datos.fhac == 1) {
								$("#fhac").prop('checked', true);
							}
						}else {
							$("#hac").html("No");
						}
						$("#at").removeAttr('disabled');
						if (datos.at == 1) {
							$("#at").prop('checked', true);
						}
						$("#soc").removeAttr('disabled');
						if (datos.soc == 1) {
							$("#soc").prop('checked', true);
						}
						$("#xil").removeAttr('disabled');
						if (datos.xil == 1) {
							$("#xil").prop('checked', true);
						}
						$("#sst").removeAttr('disabled');
						if (datos.sis == 1) {
							$("#sst").prop('checked', true);
						}
						$("#ses").removeAttr('disabled');
						if (datos.seg == 1) {
							$("#ses").prop('checked', true);
						}
						$("#elc").removeAttr('disabled');
						if (datos.ele == 1) {
							$("#elc").prop('checked', true);
						}
						$("#san").removeAttr('disabled');
						if (datos.san == 1) {
							$("#san").prop('checked', true);							
						}
						$("#alc").removeAttr('disabled');
						if (datos.alc == 1) {
							$("#alc").prop('checked', true);
						}
						$("#idg").val(datos.idg);
						$("#mts").html(datos.mts);
						if (datos.mts <= datos.omts) {
							$("#fmts").removeAttr('disabled');
							if (datos.fmts == 1) {
								$("#fmts").prop('checked', true);
							}
						}
						$("#edit").removeAttr('disabled');
						$("#grab").attr('disabled', true);
					}else if (datos.r!=null) {
						$("#dp").slideDown('slow');
						$("#r").html(datos.r);
						$("#nom").html(datos.nom);
						$("#fic").html(datos.fic);
						$("#ng").html(datos.ng);
						$("#ed").html(datos.ed+" años");
						if (datos.am == 1) {
							$("#fed").removeAttr('disabled');
						}					
						if (datos.fed == 1) {
							$("#fed").prop('checked', true);
						}
						if (datos.dis == 1) {
							$("#dis").html("Si");
							$("#fdis").removeAttr('disabled');
							if (datos.fdis == 1) {
								$("#fdis").prop('checked', true);
							}
						}else{
							$("#dis").html("No");
						}
						if (datos.hac) {
							$("#hac").html("Si");
							$("#fhac").removeAttr('disabled');
							if (datos.fhac == 1) {
								$("#fhac").prop('checked', true);
							}
						}else {
							$("#hac").html("No");
						}
						$("#at").removeAttr('disabled');
						if (datos.at == 1) {
							$("#at").prop('checked', true);
						}
						$("#soc").removeAttr('disabled');
						if (datos.soc == 1) {
							$("#soc").prop('checked', true);
						}
						$("#xil").removeAttr('disabled');
						if (datos.xil == 1) {
							$("#xil").prop('checked', true);
						}
						$("#sst").removeAttr('disabled');
						if (datos.sis == 1) {
							$("#sst").prop('checked', true);
						}
						$("#ses").removeAttr('disabled');
						if (datos.seg == 1) {
							$("#ses").prop('checked', true);
						}
						$("#elc").removeAttr('disabled');
						if (datos.ele == 1) {
							$("#elc").prop('checked', true);
						}
						$("#san").removeAttr('disabled');
						if (datos.san == 1) {
							$("#san").prop('checked', true);							
						}
						$("#alc").removeAttr('disabled');
						if (datos.alc == 1) {
							$("#alc").prop('checked', true);
						}
						$("#idg").val(datos.idg);
						$("#mts").html(datos.mts);
						if (datos.mts <= 40) {
							$("#fmts").removeAttr('disabled');
							if (data.fmts == 1) {
								$("#fmts").prop('checked', true);
							}
						}
						$("#grab").removeAttr('disabled');
						$("#edit").attr('disabled', true);	
					}else{
						$("#alerta").addClass('alert alert-warning');
						$("#alerta").html('<b>Esta persona no cumple los requisitos u ocurrió un error</b>');
					}
				}
			}
		});		
	});

	$("#grab").click(function() {
		
		$.ajax({
			type : 'post',
			url  : '../../model/persona/insfocalizacion.php',
			data : $("#focal").serialize(),

			beforeSend:function() {
				$("#b").html('Enviando datos');
			},
			error:function(){
				alert("Ocurrio un error");
			},
			success:function(data){
				if (data == 1) {
					$("#dp").css('display', 'none');
					$("#b").html('');
					$("#alerta").removeClass('alert alert-danger');
					$("#alerta").addClass('alert alert-success');
					$("#alerta").html('<strong>Datos agregados</strong>');
					$("#focal input:checkbox").prop('checked', false);
					$("#focal input:checkbox").attr('disabled', true);
					$("p").html('');
					window.scroll(0,1);
				}else {
					$("#dp").css('display', 'none');
					$("#b").html('');
					$("#alerta").removeClass('alert alert-danger');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html('<strong>Ocurrió un error al procesar datos</strong>');
					window.scroll(0,1);
				}
			}
		});		
	});

	$("#edit").click(function() {
		
		$.ajax({
			type : 'post',
			url  : '../../model/persona/upfocalizacion.php',
			data : $("#focal").serialize(),

			beforeSend:function() {
				$("#b").html('Enviando datos');
			},
			error:function(){
				alert("Ocurrio un error");
			},
			success:function(data){
				if (data == 1) {
					$("#dp").css('display', 'none');
					$("#b").html('');
					$("#alerta").removeClass('alert alert-danger');
					$("#alerta").addClass('alert alert-success');
					$("#alerta").html('<strong>Datos Actualizados</strong>');
					$("#focal input:checkbox").prop('checked', false);
					$("#focal input:checkbox").attr('disabled', true);
					$("p").html('');
					window.scroll(0,1);
				}else {
					$("#dp").css('display', 'none');
					$("#b").html('');
					$("#alerta").removeClass('alert alert-success');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html('<strong>Ocurrió un error al procesar datos</strong>');					
					window.scroll(0,1);
				}

			}
		});		
	});

	$("#rst").click(function() {
		$("#focal input:checkbox").prop('checked', false);
		$("#focal input:checkbox").attr('disabled', true);
		$("p").html('');
		$("#dp").slideUp('slow');
		$("#grab").attr('disabled', true);
		$("#edit").attr('disabled', true);
		window.scroll(0,1);
	});

	$("#can").click(function() {
		location.href = '../../view/persona/';
	});

	$("#rut").keypress(function(){
        var rut = $(this).val();

        $.ajax({
            type : 'post',
            url  : '../../model/persona/seek_autocomplete.php',
            data : 'rut='+rut,
            success:function(data){                
                $("#sug").fadeIn('fast').html(data);
                $(".element").on('click', 'a', function() {                    
                    var id = $(this).attr('id');
                    $("#rut").val($("#"+id).attr('data'));
                    $("#sug").fadeOut('fast');
                });
            }
        });
    });

    $("#busc").focus(function(){
        $("#sug").fadeOut('fast');
    });

    $("#rut").focusout(function(){
        $("#sug").fadeOut('fast');    
    });
});