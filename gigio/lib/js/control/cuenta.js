$(document).ready(function() {
	$(function(){
		$("#fap").datepicker({
			format: "dd/mm/yyyy",
			language : "es"
		});
	});
	$("#ahc").change(function(event) {
		if($(this).is(':checked')){
			$("ah").removeAttr('disabled');
		}else{
			$("ah").attr('disabled', true);			
		}
	});
	$("#suc").change(function(event) {
		if($(this).is(':checked')){
			$("#sb").removeAttr('disabled');			
		}else{
			$("#sb").attr('disabled', true);
		}
	});
	$("#busc").click(function() {
		var rut = $("#rut").val();
		$.ajax({
			type : 'post',
			url : '../../model/persona/seekcuenta.php',
			data : "r="+rut,
			beforeSend:function(){
				$("#b").html('Buscando información de la cuenta...');				
			},
			error:function(){
				alert("Ocurrio un error");
				$("#b").html('');
			},
			success:function(data){
				if(data=="0"){
					$("#b").html('Esta persona no se encuentra en nuestra base de datos');
				}else{
					var datos = $.parseJSON(data);
					if(datos.nc!=null){
						$("#b").html('');
						$("#nom").html(datos.nom);
						$("#nc").val(datos.nc);
						$("#fap").val(datos.fap);
						$("#ah").val(datos.ah);
						$("#ahc").prop('checked', true);
						$("#sb").val(datos.sb);
						$("#suc").prop('checked', true);
						$("#td").val(datos.td);
						$("#vtd").html("<b>"+datos.vtd+"</b>");
						$("#vtd").css('font-size', '20px');
						$("#edit").removeAttr('disabled');
						$("#del").removeAttr('disabled');
						$("#cuen input:text").removeAttr('disabled');
						$("#cuen input:checkbox").removeAttr('disabled');
					}else{
						$("#b").html('');
						$("#nom").html(datos.nom);
						$("#cuen input:checkbox").removeAttr('disabled');						
						$("#cuen input:text").removeAttr('disabled');
						$("#ahc").prop('checked', true);
						$("#suc").prop('checked', true);
						$("#grab").removeAttr('disabled');
					}
				}
			}
		});
	});
	$("#grab").click(function() {
		var rut  = $("#rut").val();
		var nc   = $("#nc").val();
		var fap  = $("#fap").val();
		var ah   = $("#ah").val();
		var sb   = $("#sb").val();		
		$.ajax({
			type : 'post',
			url : '../../model/persona/inscuenta.php',
			data : $("#cuen").serialize(),
			beforeSend:function(){
				$("#b").html('Grabando información');
			},
			error:function(){
				alert("Ocurrio un error");
				$("#b").html('');
			},
			success:function(data){
				$("#b").html('');
				$("#resp").addClass('alert alert-success');
				$("#resp").html(data);
				$("#resp").fadeIn('slow');
				$("#resp").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>')
				$("#cuen input:text").val('');
				$("#cuen input:text").attr('disabled', true);
				$("#cuent input:checkbox").prop('checked', false);
				$("#cuent input:checkbox").attr('disabled', true);
				$("#cuen input:button").attr('disabled', true);
				$("#rut").removeAttr('disabled');
				$("#busc").removeAttr('disabled');
			}

		});
	});
	$("#edit").click(function() {
		var rut  = $("#rut").val();
		var nc   = $("#nc").val();
		var fap  = $("#fap").val();
		var ah   = $("#ah").val();
		if($("#suc").is(':checked')){
			var sb   = $("#sb").val();
		}else{
			sb = 0;
		}
		$.ajax({
			type : 'post',
			url  : '../../model/persona/upcuenta.php',
			data : $("#cuen").serialize(),
			beforeSend:function(){
				$("#b").html('Actualizando información...');
			},
			error:function(){
				alert("Ocurrio un error");
			},
			success:function(data){
				$("#b").html('');
				$("#resp").addClass('alert alert-success');
				$("#resp").html(data);
				$("#resp").fadeIn('slow');
				$("#resp").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>')
				$("#cuen input:text").val('');
				$("#cuen input:text").attr('disabled', true);
				$("#cuent input:checkbox").prop('checked', false);
				$("#cuent input:checkbox").attr('disabled', true);
				$("#cuen input:button").attr('disabled', true);
				$("#vtd").html('');
				$("#rut").removeAttr('disabled');
				$("#busc").removeAttr('disabled');		
			}
		});	
	});
	$("#del").click(function() {
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

    $("#rut").blur(function(){
        $("#sug").fadeOut('fast');
    });
});
