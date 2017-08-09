$(document).ready(function() {
	$(function(){
		$("#fap").datepicker({
			format: "dd/mm/yyyy",
			language : "es"
		});
	});
	$("#ahc").change(function(event) {
		if($(this).is(':checked')){
			$("#ah").removeAttr('disabled');
		}else{
			$("#ah").attr('disabled', true);			
		}
	});
	$("#suc").change(function(event) {
		if($(this).is(':checked')){
			$("#sb").removeAttr('disabled');			
		}else{
			$("#sb").attr('disabled', true);
		}
	});

	$("#resp").click(function() {
		$("#resp").removeClass('alert alert-success');
		$("#resp").html('');
	});

	$("#resp").click(function() {
		$("#resp").removeClass('alert alert-danger');
		$("#resp").html('');
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
						$("#vtd").html("<b>"+datos.vtd+" UF</b>");
						$("#vtd").css('font-size', '20px');
						$("#tp").html("<b>$ "+datos.tp+"</b>");
						$("#tp").css('font-size', '20px');
						$("#rcye").val(datos.con);
						$("#ncye").html(datos.ncon);
						$("#edit").removeAttr('disabled');
						$("#grab").attr('disabled', true);
						$("#del").removeAttr('disabled');
						$("#cuen input:text").removeAttr('disabled');
						$("#cuen input:checkbox").removeAttr('disabled');
						$("#cuen select").removeAttr('disabled');
					}else{
						$("#b").html('');
						$("#nom").html(datos.nom);
						$("#rcye").val(datos.con);
						$("#ncye").html(datos.ncon);
						$("#cuen input:checkbox").removeAttr('disabled');						
						$("#cuen input:text").removeAttr('disabled');
						$("#ahc").prop('checked', true);
						$("#suc").prop('checked', true);
						$("#grab").removeAttr('disabled');
						$("#edit").attr('disabled', true);
						$("#cuen select").removeAttr('disabled');
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
				if (data == 1) {
					$("#b").html('');
					$("#nom").html('');
					$("#resp").removeClass('alert alert-danger');
					$("#resp").addClass('alert alert-success');
					$("#resp").html("<b>Información actualizada</b>");
					$("#resp").fadeIn('slow');				
					$("#cuen input:text").val('');
					$("#cuen input:text").attr('disabled', true);
					$("#cuent input:checkbox").prop('checked', false);
					$("#cuent input:checkbox").attr('disabled', true);
					$("#cuen input:button").attr('disabled', true);
					$("#cuen select").attr('disabled', true);
					$("#vtd").html('');
					$("#tp").html('');
					$("#rut").removeAttr('disabled');
					$("#busc").removeAttr('disabled');
				}else {
					$("#b").html('');
					$("#nom").html('');
					$("#resp").removeClass('alert alert-success');
					$("#resp").addClass('alert alert-danger');
					$("#resp").html("<b>Ocurrió un error al actualizar</b>");
					$("#resp").fadeIn('slow');				
					$("#cuen input:text").val('');
					$("#cuen input:text").attr('disabled', true);
					$("#cuent input:checkbox").prop('checked', false);
					$("#cuent input:checkbox").attr('disabled', true);
					$("#cuen input:button").attr('disabled', true);
					$("#cuen select").attr('disabled', true);
					$("#vtd").html('');
					$("#tp").html('');
					$("#rut").removeAttr('disabled');
					$("#busc").removeAttr('disabled');
				}		
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
				if (data == 1) {
					$("#b").html('');
					$("#nom").html('');
					$("#resp").removeClass('alert alert-danger');
					$("#resp").addClass('alert alert-success');
					$("#resp").html("<b>Información actualizada</b>");
					$("#resp").fadeIn('slow');				
					$("#cuen input:text").val('');
					$("#cuen input:text").attr('disabled', true);
					$("#cuent input:checkbox").prop('checked', false);
					$("#cuent input:checkbox").attr('disabled', true);
					$("#cuen input:button").attr('disabled', true);
					$("#cuen select").attr('disabled', true);
					$("#vtd").html('');
					$("#tp").html('');
					$("#rut").removeAttr('disabled');
					$("#busc").removeAttr('disabled');
				}else {
					$("#b").html('');
					$("#nom").html('');
					$("#resp").removeClass('alert alert-success');
					$("#resp").addClass('alert alert-danger');
					$("#resp").html("<b>Ocurrió un error al actualizar</b>");
					$("#resp").fadeIn('slow');				
					$("#cuen input:text").val('');
					$("#cuen input:text").attr('disabled', true);
					$("#cuent input:checkbox").prop('checked', false);
					$("#cuent input:checkbox").attr('disabled', true);
					$("#cuen input:button").attr('disabled', true);
					$("#cuen select").attr('disabled', true);
					$("#vtd").html('');
					$("#tp").html('');
					$("#rut").removeAttr('disabled');
					$("#busc").removeAttr('disabled');
				}		
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

    $("#rs").click(function() {
    	$("#nom").html('');    	
		$("#vtd").html('');
		$("#tp").html('');
		$("#rut").removeAttr('disabled');
		$("#busc").removeAttr('disabled');		
		$("#cuen input:text").attr('disabled', true);
		$("#cuent input:checkbox").prop('checked', false);
		$("#cuent input:checkbox").attr('disabled', true);
		$("#cuen input:button").attr('disabled', true);
		$("#rut").removeAttr('disabled');
		$("#busc").removeAttr('disabled');
    });

    $("#busc").focus(function(){
        $("#sug").fadeOut('fast');
    });

    $("#rut").blur(function(){
        $("#sug").fadeOut('fast');
    });
});
