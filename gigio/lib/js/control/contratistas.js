$(document).ready(function() {
	$("#rut").focus(function(){
		$("#res").removeClass('alert alert-success');
		$("#res").html('');
	});
	$("#rut").focus(function(){
		$("#res").removeClass('alert alert-danger');
		$("#res").html('');
	});

	$("#res").click(function() {
		$(this).removeClass('alert alert-success');
		$(this).html('');
	});

	$("#res").click(function() {
		$(this).removeClass('alert alert-danger');
		$(this).html('');
	});

	$("#lcontratistas").load('../../model/contratistas/listcontratistas.php');

	$("#reg").change(function(){
		$("#reg option:selected").each(function(){
			var idcmn = $(this).val();
			$("#pr").html("<option value=''>Cargando...</option>");
			$.ajax({
				type : 'post',
				url : '../../model/persona/seek_persona_provincia.php',
				data : 'idreg='+idcmn,
				success:function(data){
					$("#pr").removeAttr('disabled');
					$("#pr").html(data);
					$("#pr").attr('selected', true);
				}
			});
		});		
	});	
	$("#pr").change(function() {
		$("#pr option:selected").each(function() {
			var idpr = $(this).val();
			$("#cm").html("<option value=''>Cargando...</option>");
			$.ajax({
				type : 'post',
				url : '../../model/persona/seek_persona_comuna.php',
				data: 'idpr='+idpr,
				success:function(data){
					$("#cm").removeAttr('disabled');
					$("#cm").html(data);										
				}
			});
		});
	});

	$("#seek").click(function(){
		var rut = $("#rut").val();

		$.ajax({
			type : 'post',
			url : '../../model/contratistas/seek_contratistas.php',
			data : "rut="+rut,
			beforeSend:function(){
				$("#res").html("Buscando informacion...");
			},
			error:function(e){
				$("#res").addClass("alert alert-danger alert-dismissable");
				$("#res").html("Ocurrio un error inesperado");
			},
			success:function(data){

				var datos = $.parseJSON(data);

				if(datos.rut!=null){
					$("#res").html('');
					$("#dv").val(datos.dv);
					$("#nom").val(datos.nom);
					$("#ape").val(datos.ape);
					$("#dir").val(datos.dir);
					$("#tel").val(datos.tel);
					$("#cm").val(datos.cm);
					$("#em").val(datos.em);
					$("#crg").val(datos.crg);
					
					if (datos.est == 1) {
						$("#est").prop('checked', true);
					}

					$("#pr").val(datos.prv);
					$("#reg").val(datos.reg);

					$("#prof input:text").removeAttr('disabled');
					$("#prof select").removeAttr('disabled');
					$("#edit").removeAttr('disabled');
					$("#can").removeAttr('disabled');
					$("#grab").attr('disabled', true);
				}else{
					$("#res").html('');
					$("#prof input:text").removeAttr('disabled');
					$("#prof select").removeAttr('disabled');
					$("#edit").attr('disabled', true);
					$("#can").attr('disabled', true);
					$("#grab").removeAttr('disabled');
				}
			}
		});
	});

	$("#grab").click(function() {
		var rut = $("#rut").val();
		var dv  = $("#dv").val();
		var nom = $("#nom").val();
		var ape = $("#ape").val();
		var dir = $("#dir").val();
		var cm  = $("#cm").val();
		var tel = $("#tel").val();
		var em  = $("#em").val();
		var crg = $("#crg").val();

		$.ajax({
			type : 'post',
			url : '../../model/contratistas/inscontratistas.php',
			data : $("#prof").serialize(),
			beforeSend: function(){
				$("#res").html('Ingresando datos...');
			},
			error:function(){
				$("#res").addClass('alert alert-danger');
				$("#res").html("<strong>Ocurrio un error inesperado");				
			},
			success:function(data){
				if(data==1){
					$("#res").removeClass('alert alert-danger');
					$("#res").addClass('alert alert-success');
					$("#res").fadeIn('slow');
					$("#res").html("<strong>Datos ingresados</strong>");
					$("#prof input:text").val('');
					$("#prof select").val(0);
					$("#prof input:text").attr('disabled',true);
					$("#prof select").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#grab").attr('disabled', true);
					window.scroll(0,1);
				}else if (data==2) {
					$("#res").removeClass('alert alert-success');
					$("#res").addClass('alert alert-danger');
					$("#res").html("<strong>Este rut ya existe como beneficiario</strong>");
					$("#prof input:text").val('');
					$("#prof select").val(0);
					$("#prof input:text").attr('disabled',true);
					$("#prof select").attr('disabled', true);
					window.scroll(0,1);
				}else if(data=="no"){
					$("#res").removeClass('alert alert-success');
					$("#res").addClass('alert alert-danger');
					$("#res").html("<strong>El dígito verificador es erróneo</strong>");
					window.scroll(0,1);
				}else{
					$("#res").removeClass('alert alert-success');
					$("#res").addClass('alert alert-danger');
					//$("#res").html(data);
					$("#res").html("<strong>Error al insertar</strong>");
					$("#prof input:text").val('');
					$("#prof select").val(0);
					$("#prof input:text").attr('disabled',true);
					$("#prof select").attr('disabled', true);
					window.scroll(0,1);
				}
			}
		});
	});

	$("#edit").click(function(){
		var rut = $("#rut").val();
		var dv  = $("#dv").val();
		var nom = $("#nom").val();
		var ape = $("#ape").val();
		var dir = $("#dir").val();
		var cm  = $("#cm").val();
		var tel = $("#tel").val();
		var em  = $("#em").val();
		var crg = $("#crg").val();
		var est = $("#est").is(':checked');

		$.ajax({
			type : 'post',
			url : '../../model/contratistas/upcontratistas.php',
			data : $("#prof").serialize(),
			beforeSend: function(){
				$("#res").html('Ingresando datos...');
			},
			error:function(){
				$("#res").addClass('alert alert-danger');
				$("#res").html("<strong>Ocurrio un error inesperado");				
			},
			success:function(data){
				if(data==1){
					$("#res").addClass('alert alert-success');
					$("#res").fadeIn('slow');
					$("#res").html("<strong>Datos ingresados</strong>");
					$("#prof input:text").val('');
					$("#prof select").val(0);
					$("#prof input:text").attr('disabled',true);
					$("#prof select").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#grab").attr('disabled', true);
					$("#lcontratistas").load('../../model/contratistas/listcontratistas.php');
					window.scroll(0,1);
				}else if (data==2) {
					$("#res").addClass('alert alert-danger');
					$("#res").html("<strong>Este rut ya existe como beneficiario</strong>");
					$("#prof input:text").val('');
					$("#prof select").val(0);
					$("#prof input:text").attr('disabled',true);
					$("#prof select").attr('disabled', true);
					window.scroll(0,1);
				}else if(data=="no"){
					$("#res").addClass('alert alert-danger');
					$("#res").html("<strong>El dígito verificador es erróneo</strong>");
					window.scroll(0,1);		
				}else{
					$("#res").addClass('alert alert-danger');
					//$("#res").html(data);
					$("#res").html("<strong>Error al actualizar</strong>");					
					window.scroll(0,1);
				}
			}
		});
	});

	$("#can").click(function() {
		history.back(1);
	})
});

function paginar(nro) {
	var n = nro;
    var url = '../../model/contratistas/listcontratistas.php';
    $.ajax({
        type : 'get',
        url : url,
        data : "pag="+n,
        success:function(data){        	
            $('#lcontratistas').load(url+"?pag="+n);
            $("#lcontratistas").fadeIn('slow');
        }
    });
}

function delContrat(id) {
	var id = id;
	var c = "Desea quitar el registro?";

	if (confirm(c)) {
		$.ajax({
			type : 'post',
			url  : '../../model/contratistas/deprofesionales.php',
			data : 'rut='+id,

			beforeSend:function() {
				$("#res2").html('Quitando registro...');
			},
			error:function() {
				alert("Ocurrio un error");
			},
			success:function(data) {
				$("#res2").html('');
				window.scroll(0,1);
				if (data == 1) {
					$("#res").addClass('alert alert-success');
					$("#res").html("<b>Registro quitado</b>");
					$("#lcontratistas").load('../../model/contratistas/listcontratistas.php');
				} else {
					$("#res").addClass('alert alert-danger');
					$("#res").html('<b>Ocurrio un error al procesar la acción</b>');
				}
			}
		});
	} 
}