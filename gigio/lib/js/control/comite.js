$(function(){
    $('a[data-toggle = "tab"]').on('shown.bs.tab', function (e) {
	     // Get the name of active tab
	    var activeTab = $(e.target).text(); 
	     
	     // Get the name of previous tab
	    var previousTab = $(e.relatedTarget).text(); 
	     
	    $(".active-tab span").html(activeTab);
	    $(".previous-tab span").html(previousTab);
    });    
});

$(document).ready(function() {
	/* EL div permanece oculto */
	$("#dpersona").css('display', 'none');

	/* Al hacer click en las alertas, estas se cierran */

	$("#alerta").click(function() {
		$(this).removeClass('alert alert-success').html('');
	});

	$("#alerta").click(function() {
		$(this).removeClass('alert alert-danger').html('');
	});

	$("#rp").focus(function(){
		/* Elimina la alerta */
		$("#alerta").removeClass('alert alert-success').html('');
	});
	$("#sug").css('display', 'none');
	$("#mrp").focus(function(){
		/* Elimina la alerta */
		$("#malerta").removeClass('alert alert-success').html('');
		/* limpia el di */				
		$("#mdpersona").html('');
	});

	$("#malerta").click(function() {
		$("#malerta").removeClass('alert alert-success').html('');		
		$("#mdpersona").html('');
	});

	$(function(){
		/* Configuracion del datepicker al español y formato usado en el sistema */
		$("#fec").datepicker({
			format : "dd/mm/yyyy",
			language : "es"
		});
	});

	$("#num").focus(function(event) {
		$("#res").removeClass('alert alert-danger').html('');
	});
	$("#num").focus(function(event) {
		$("#res").removeClass('alert alert-success').html('');
	});


	$("#res").click(function(event) {
		$("#res").removeClass('alert alert-danger');
		$("#res").html('');
	});
	$("#res").click(function(event) {
		$("#res").removeClass('alert alert-success');
		$("#res").html('');
	});

	$("#info").click(function(){
		$("#info").removeClass('alert alert-danger');
		$("#info").html('');
	});

	$("#info").click(function(){
		$("#info").removeClass('alert alert-success');
		$("#info").html('');
	});

	$("#autobusc").css('display', 'none');
	$("#fmgp").css('display', 'none');

	$("#lcomite").load('../../model/comite/listcomite.php');

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
	
	$("#seek").click(function() {
		var num = $("#num").val();
		$.ajax({
			type : 'post',
			url : '../../model/comite/seek_comite.php',
			data : "num="+num,
			beforeSend:function(){
				$("#res").html("Buscando");
			},
			error:function(){
				$("#res").fadeIn('slow');
				$("#res").addClass('alert alert-danger');
				$("#res").html("Ocurrio un error");				
				$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
			},
			success:function(data){
				
				var datos = $.parseJSON(data);
				
				if(datos.num!=null){					
					$("#res").html('');
					$("#idg").val(datos.idg);
					$("#fec").val(datos.fec);
					$("#nc").val(datos.nc);
					$("#nper").html(datos.nper);
					$("#per").val(datos.per);
					$("#dir").val(datos.dir);
					$("#reg").val(datos.reg);
					$("#pr").val(datos.pr);
					$("#cm").val(datos.cmn);
					$("#loc").val(datos.loc);
					$("#egis").val(datos.egis);
					if (datos.ec == 1) {
						$("#ec").prop('checked', true);
					}
					//Desbloqueado campos
					$("#dcom input").removeAttr('disabled');					
					$("#dcom select").removeAttr('disabled');					
					$("#edit").removeAttr('disabled');
					$("#can").removeAttr('disabled');
					$("#grab").attr('disabled', true);
				}else{
					$("#res").html('');					
					$("#dcom input").removeAttr('disabled');					
					$("#dcom select").removeAttr('disabled');					
					$("#nper").html('');
					$("#grab").removeAttr('disabled');
					$("#edit").attr('disabled', true);
					$("#can").attr('disabled', true);
				}
			}
		});
	});

	$("#grab").click(function() {
		var num = $("#num").val();
		var fec = $("#fec").val();		
		var nc = $("#nc").val();		
		var dir = $("#dir").val();
		var reg = $("#reg").val();
		var pr = $("#pr").val();
		var cm = $("#cm").val();
		var egis = $("#egis").val();
		var ec = $("#ec").is(':checked');
		$.ajax({
			type : 'post',
			url : '../../model/comite/incomite.php',
			data : $("#dcom").serialize(),
			beforeSend:function(){
				$("#res").html('Enviando datos');				
			},
			error:function(){
				$("#res").addClass('alert alert-danger');
				$("#res").html("Ocurrio un error");
				
			},
			success:function(data){	
				if(data==1){
					$("#res").addClass('alert alert-success');
					$("#res").html("Datos agregados");					
					$("#dcom input").val('');
					$("#dcom input").attr("disabled", true);
					$("#dcom select").val('');
					$("#dcom select").attr("disabled", true);
					$("#nper").html('');
					$("#num").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}else if (data==2) {
					$("#res").addClass('alert alert-danger');
					//$("#res").html("Ocurrio un error al grabar en la base de datos");
					$("#res").html("</strong>Este nombre ya existe y solo puede ser ingresado una vez</strong>");				
					$("#dcom input").val('');
					$("#dcom input").attr("disabled", true);
					$("#nper").html('');
					$("#dcom select").val('');
					$("#dcom button").attr('disabled', true);
					$("#dcom select").attr("disabled", true);
					$("#num").removeAttr('disabled');
					$("#seek").removeAttr('disabled');	
				}else{
					$("#res").addClass('alert alert-danger');
					//$("#res").html("Ocurrio un error al grabar en la base de datos");
					$("#res").html("Ocurrió un error en la transacción");
					$("#dcom input").val('');
					$("#dcom input").attr("disabled", true);
					$("#nper").html('');
					$("#dcom select").val('');
					$("#dcom button").attr('disabled', true);
					$("#dcom select").attr("disabled", true);
					$("#num").removeAttr('disabled');
					$("#seek").removeAttr('disabled');					
				}
			}
		});

	});

	$("#edit").click(function(){
		var idg = $("#idg").val();
		var num = $("#num").val();
		var fec = $("#fec").val();		
		var nc = $("#nc").val();		
		var dir = $("#dir").val();
		var reg = $("#reg").val();
		var pr = $("#pr").val();
		var cm = $("#cm").val();
		var egis = $("#egis").val();
		var ec = $("#ec").is(':checked');
		$.ajax({
			type : 'post',
			url : '../../model/comite/upcomite.php',
			data : $("#dcom").serialize(),
			beforeSend:function(){
				$("#res").html("Actualizando información ...");
			},
			error:function(){
				$("#res").addClass('alert alert-danger');
				$("#res").html("Ocurrio un error");
			},
			success:function(data){
				if(data==1){
					$("#res").removeAttr('alert alert-danger');
					$("#res").addClass('alert alert-success');
					$("#res").html("Informacion Actualizada");			
					$("#dcom input:text").val('');
					$("#dcom input:checkbox").prop('checked', false);
					$("#dcom input").attr("disabled", true);
					$("#dcom select").val('');
					$("#dcom select").attr("disabled", true);
					$("#nper").html('');
					$("#num").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}else if(data == 2) {
					$("#res").removeClass('alert alert-success');
					$("#res").addClass('alert alert-danger');
					$("#res").html("<b>El nombre no puede ser cambiado</b>");
					$("#dcom input:text").val('');
					$("#dcom input:text").attr("disabled", true);
					$("#dcom select").val('');
					$("#dcom select").attr("disabled", true);
					$("#nper").html('');
					$("#num").removeAttr('disabled');
					$("#seek").removeAttr('disabled');	
				}else{
					$("#res").removeClass('alert alert-success');
					$("#res").addClass('alert alert-danger');
					$("#res").html("Ocurrió un error en la transacción");					
					//$("#res").html(data);
					$("#dcom input:text").val('');
					$("#dcom input:text").attr("disabled", true);
					$("#dcom select").val('');
					$("#dcom select").attr("disabled", true);
					$("#nper").html('');
					$("#num").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}
			}
		});
	});

	$("#can").click(function(){
		var can = "Seguro que desea cancelar?"
		if(confirm(can)){
			location.href = "../../view/comite/";
		}
	});
	$("#myModal").on('shown.bs.modal', function(event){
		event.preventDefault();

		var x = $(event.relatedTarget);
		var id = x.data('id');
		$.ajax({
			type : 'post',
			url : '../../model/comite/mcomite.php',
			data : "num="+id,
			beforeSend:function(){
				$(".modal-content").html("Cargando...");
			},
			error:function(){				
				$(".modal-content").html("Error al procesar datos");
			},
			success:function(data){
				$(".modal-content").html(data);
			}
		});		
	});

	$("#EliminaSocio").on('shown.bs.modal', function(event) {
		event.preventDefault();

		var x = $(event.relatedTarget);
		var rut = x.data('id');
		$.ajax({
			type : 'post',
			url  : '../../view/comite/elim_socio_motivo.php',
			data : 'rut='+rut,
			beforeSend:function(){
				$(".modal-content").html("Cargando...");
			},
			error:function(){
				$(".modal-content").html("Error al procesar datos");
			},
			success:function(data){
				$(".modal-content").html(data);
			}
		});		
	});

	
	$("#EliminaSocio").on('submit', '#motelim', function(event) {
		var cmt = $("#cmt").val();
		$.ajax({
			type : 'post',
			url  :  $(this).attr('action'),
			data : $(this).serialize(),
			success:function(data){
				if (data == 1) {					
					$("#EliminaSocio").modal('hide');					
					$("#lcomite").load('../../model/comite/list_comite_pers.php?id='+cmt);
				}else {
					$(".modal-content").html("Ocurrio un error");
				}
			}
		});

		//event.preventDefault();
		return false;
	});

		

	/*$("#obs").keyup(function() {
		var max = 500;
		//$("#max").html(max);

		var caracteres = $(this).val().length;
		var diff = max - caracteres;
		$("#cont").html(diff);

	});*/

	//Segunda pestaña: Directiva
	$("#lista").css('display', 'none');
	
	$("#busc").click(function () {
		$("#lista").css('display', 'block');		
		$("#lcomite").load("../../model/comite/list_comite_pers.php?id=0");
		var rut = $("#rp").val();		
		$.ajax({
			type : 'post',
			url : '../../model/comite/seek_pers_comite.php',
			data : "rut="+rut,
			beforeSend:function(){
				$("#rg").html('Cargando informacion...');
			},
			error: function(){
				$("#rg").html('');
				$("#dpersona").slideDown('slow');
				$("#dpersona").html("Ocurrio un error...");
			},
			success:function(data) {
				$("#dpersona").removeClass('alert alert-danger');
				$("#rg").html('');
				$("#dpersona").slideDown('slow');				
				$("#dpersona").html(data);
				$("#gp select").removeAttr('disabled');
				$("#ag").removeAttr('disabled');
			}
		});
	});

	$("#cmt").change(function(){
		$("#cmt option:selected").each(function(){
			var id = $(this).val();
			$("#lcomite").load('../../model/comite/list_comite_pers.php?id='+id);
		});		
	});

	$("#ag").click(function(){
		var rut = $("#rp").val();
		var cmt = $("#cmt").val();
		var crg = $("#crg").val();

		$.ajax({
			type : 'post',
			url : '../../model/comite/in_list_comite.php',
			data : $("#gp").serialize(),
			beforeSend:function(){
				$("#rg").html("Enviando información...");
			},
			error:function(){
				$("#rg").html('');				
				$("#dpersona").html("Ocurrio un error...");
			},
			success:function(data){
				if(data==1){
					$("#rg").html('');
					$("#alerta").removeClass('alert alert-danger');
					$("#alerta").addClass('alert alert-success');
					//$("#alerta").html('<strong> Transaccion realizada </strong>');
					$("#alerta").html(data);
					$("#dpersona").html('');	
					$("#rp").val('');
					$("#gp select").val(0);
					$("#gp select").attr('disabled', true);
					$("#ag").attr('disabled', true);
					$("#lcomite").load("../../model/comite/list_comite_pers.php?id="+cmt);
					window.scroll(0,1);
				}else if(data==2) {
					$("#rg").html('');	
					$("#alerta").removeClass('alert alert-success');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html('<strong>Esta persona existe o el cargo seleccionado solo puede ser ocupado por una persona</strong>');
					$("#dpersona").html('');
					window.scroll(0,1);
				}else if(data==3){
					$("#rg").html('');	
					$("#alerta").removeClass('alert alert-success');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html('<strong>Solo es permitido ser miembro de este grupo</strong>');
					window.scroll(0,1);
				}else if(data == 4){
					$("#rg").html('');
					$("#alerta").removeClass('alert alert-success');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html('<strong>Esta persona no posee ficha, por lo que no puede postular</strong>');
					window.scroll(0,1);
				}else if(data == 5){
					$("#rg").html('');
					$("#alerta").removeClass('alert alert-success');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html('<strong>Esta persona no posee cuenta asociada, por lo que no puede postular</strong>');
					window.scroll(0,1);
				}else if (data == 7) {
					$("#rg").html('');
					$("#alerta").removeClass('alert alert-success');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html('<strong>Debe elegir un cargo</strong>');
					window.scroll(0,1);
				}else{
					$("#rg").html('');
					$("#alerta").removeClass('alert alert-success');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html(data);
					$("#alerta").html('<strong>Error en la transaccion</strong>');
					$("#dpersona").html('');
					$("#rp").val('');
					$("#gp select").val('');
					$("#gp select").attr('disabled', true);
					$("#ag").attr('disabled', true);
					window.scroll(0,1);
				}		
			}    
		});
	});
	$("#lsc2").css('display', 'none');
	$("#lsc").click(function() {
		var cmt = $("#cmt").val();
		$("#lcomite").hide(700);
		$("#lcomite").load("../../model/comite/list_comite_pers.php?id="+cmt);
		$("#lcomite").show(700);
		$("#lsc").hide(700);
		$("#lsc2").show(700);
	});
	$("#lsc2").click(function() {
		$("#lcomite").hide(700);
		$("#lcomite").load("../../model/comite/listcomite.php");
		$("#lcomite").show(700);
		$("#lsc2").hide(700);
		$("#lsc").show(700);
	});

	$("#mbusc").click(function() {
		var rut = $("#mrp").val();

		$.ajax({
			type : 'post',
			url : '../../model/comite/seek_pers_comite.php',
			data : "rut="+rut,
			beforeSend:function(){
				$("#mrg").html('Cargando informacion...');
			},
			error: function(){
				$("#mrg").html('');
				$("#mdpersona").slideDown('slow');
				$("#mdpersona").html("Ocurrio un error...");
			},
			success:function(data) {
				$("#mdpersona").removeClass('alert alert-danger');
				$("#mrg").html('');
				$("#mdpersona").slideDown('slow');				
				$("#mdpersona").html(data);
				$("#mgp select").removeAttr('disabled');
				$("#mag").removeAttr('disabled');
			}
		});
	});

	$("#mag").click(function(){
		var rut = $("#mrp").val();
		var id = $("#midg").val();
		var crg = $("#crg").val();
		var es  = $("#es").val();
		
		$.ajax({
			type : 'post',
			url  : '../../model/comite/in_list_comite.php',
			data : $("#mgp").serialize(),
			beforeSend:function(){
				$("#mrg").html("Inscribiendo persona...");
			},
			error:function(){
				$("#mrg").html('');				
				$("#mdpersona").html("Ocurrio un error...");
			},
			success:function(data){
				if(data==1){
					$("#mrg").html('');
					$("#malerta").removeClass('alert alert-danger');
					$("#info").addClass('alert alert-success');
					$("#info").html('<strong> Transaccion realizada </strong>');
					$("#mdpersona").html('');	
					$("#mrp").val('');
					$("#mgp select").val(0);
					$("#mgp select").attr('disabled', true);
					$("#mag").attr('disabled', true);
					$("#lcomite").load('../../model/comite/listcomite.php');
					$("#fmgp").slideUp('slow');
				}else if(data==2) {
					$("#mrg").html('');	
					$("#malerta").removeClass('alert alert-success');
					$("#malerta").addClass('alert alert-danger');
					$("#malerta").html('<strong>Esta persona no posee cuenta, por lo que no puede postular</strong>');
					$("#mdpersona").html('');
					window.scroll(0,1);
				}else if(data==3){
					$("#mrg").html('');	
					$("#malerta").removeClass('alert alert-success');
					$("#malerta").addClass('alert alert-danger');
					$("#malerta").html('<strong>Este usuario ya existe</strong>');
				}else if(data==4){
					$("#mrg").html('');	
					$("#malerta").removeClass('alert alert-success');
					$("#malerta").addClass('alert alert-danger');
					$("#malerta").html('<strong>Este cargo solo puede ocuparlo una sola persona</strong>');					
				}else if(data == 5){
					$("#mrg").html('');
					$("#malerta").removeClass('alert alert-success');
					$("#malerta").addClass('alert alert-danger');
					$("#malerta").html('<strong>Solo es permitido ser miembro de este grupo</strong>');
				}else if (data == 6) {
					$("#mrg").html('');
					$("#malerta").removeClass('alert alert-success');
					$("#malerta").addClass('alert alert-danger');
					$("#malerta").html('<strong>El usuario no posee ficha por lo que no puede postular</strong>');	
				}else{
					$("#mrg").html('');
					$("#malerta").removeClass('alert alert-success');
					$("#malerta").addClass('alert alert-danger');					
					//$("#malerta").html('<strong>Error en la transaccion</strong>');
					$("#malerta").html(data);
					$("#mdpersona").html('');
					$("#mrp").val('');
					$("#mgp select").val('');
					$("#mgp select").attr('disabled', true);
					$("#mag").attr('disabled', true);
					window.scroll(0,1);
				}		
			}    
		});
	});

	$("#lpostedit").on('click', '#can', function(event) {
		event.preventDefault();
		var c = "Atencion! Aun no ha guardado los cambios. Desea cancelar de la transaccion?";

		if (confirm(c)) {
			location.href = '../../view/comite/listpostedit.php';
		}
	}); 	

	$("#mrp").keypress(function(){
        var rut = $(this).val();

        $.ajax({
            type : 'post',
            url  : '../../model/persona/seek_autocomplete.php',
            data : 'rut='+rut,
            success:function(data){                
                $("#sug").fadeIn('fast').html(data);
                $(".element").on('click', 'a', function() {                    
                    var id = $(this).attr('id');
                    $("#mrp").val($("#"+id).attr('data'));
                    $("#sug").fadeOut('fast');
                });
            }
        });
    });

	$("#busc").focus(function(){
        $("#sug").fadeOut('fast');
    });

    $("#rp").blur(function(){
        $("#sug").fadeOut('fast');
    });

	$("#mbusc").focus(function(){
        $("#sug").fadeOut('fast');
    });

    $("#mrp").blur(function(){
        $("#sug").fadeOut('fast');    
    });

    /* Modulo nuevo: busqueda y edicion masiva de datos de postulantes */

    $("#lcomitedit").load('../../model/comite/listcomitedit.php');

    $("#busc").keyup(function() {
    	var busc = $(this).val();

    	$.ajax({
    		type : 'post',
    		url  : '../../model/comite/listcomitedit.php',
    		data : "busc="+busc,
    		beforeSend:function(){
				$("#ms").html(' Buscando...');
			},
			success:function(data){
				$("#lcomitedit").html(data);
				$("#ms").html('');				
			}
    	});
    }); 

    $("#busc2").keyup(function() {
    	var ruk = $("#ruk").val();
    	var busc = $(this).val();

    	$.ajax({
    		type : 'get',
    		url  : '../../model/comite/lpostedit.php',
    		data : "ruk="+ruk+"&rut="+busc,

    		beforeSend:function() {
    			$("#ms").html('Buscando...');
    		},
    		success:function(data){
    			$("#lpostedit").html(data);
    			$("#ms").html('');
    		}
    	});
    });

    $("#modal-id").on('shown.bs.modal', function(e) {
    	e.preventDefault();

    	var r  = $(e.relatedTarget);
    	var rut = r.data('id');
    	var url = '../../model/comite/modalbulk.php';

    	$.ajax({
    		type : 'post',
    		url  : url,
    		data : "rut="+rut,
    		beforeSend:function(){
				$(".modal-content").html("Cargando...");
			},
			error:function(){
				$(".modal-content").html("Error al procesar datos");
			},
			success:function(data){
				$(".modal-content").html(data);
			}

    	});
    });

    $("#modal-id").on('click', '#edit', function(e) {
    	e.preventDefault();

    	var rol = $("#rol").val();
    	var mts = $("#mts").val();
    	var ps  = $("#ps").val();
    	var ruk = $("#ruk").val();

    	$.ajax({
    		type : 'post',
    		url  : '../../model/comite/upbulkpost.php',
    		data : 'rol='+rol+'&mts='+mts+'&ps='+ps,
    		beforeSend:function() {
    			$("#edit").html('Guardando');
    		},
    		error:function() {
    			$("#modal-id").modal('hide');
    			$("#alerta").addClass('alert alert-danger').html('<b>¡Ocurrio un error inesperado!</b>');
    		},
    		success:function(data) {
    			if (data == 1) {
    				$("#modal-id").modal('hide');
	    			$("#alerta").addClass('alert alert-success').html('<b>¡Información Actualizada!</b>');
	    			$("#lpostedit").load('../../model/comite/lpostedit.php?ruk='+ruk);
	    		}else if(data == 2) {	
	    			$("#modal-id").modal('hide');
    				$("#alerta").addClass('alert alert-warning').html('<b>¡Debe escoger un piso!</b>');
	    		}else {
	    			$("#modal-id").modal('hide');
    				$("#alerta").addClass('alert alert-danger').html('<b>¡No se pudo actualizar la información!</b>');    				
	    		}
    		}

    	});

    });

    $("#rp").keypress(function() {
    	var url = '../../model/comite/com_autocomplete.php';
		var inp = $(this).val();

		$.ajax({
			type : 'post',
			url  : url,
			data : "inp="+inp,
			success: function(data) {
				$("#sug1").fadeIn('fast').html(data);
				$(".element").on('click', 'a', function() {                    
	                var id = $(this).attr('id');
	                $("#rp").val($("#"+id).attr('data'));
	                $("#sug1").fadeOut('fast');
	            });
			}
		});
    });
});

function sel(x) {
	var num = x;
	$.ajax({
		type : 'post',
		url  : '../../model/comite/seek_comite_ins.php',
		data : 'num='+num,
		beforeSend:function(){
			$("#info").html('Cargando formulario...');
		},
		error:function(){
			$("#info").addClass('alert alert-danger');
			$("#info").html("Ocurrio un error inesperado");
		},
		success:function(data){
			datos = $.parseJSON(data);
			if (datos.midg != null) {
				$("#info").removeClass("alert alert-danger");
				$("#info").html('');
				$("#fmgp").slideDown('slow');
				$("#cmt").val(datos.midg);
				$("#nomb").html(datos.nomb);				
			}else{
				$("#info").addClass('alert alert-danger');
				$("#info").html("Ocurrio un error");
			}
		}
	});
}

function deleteComite(x) {
	var x = x;
	var c = "Desea quitar el registro?";
	if (confirm(c)) {
		$.ajax({
			type : 'get',
			url  : '../../model/comite/descomite.php',
			data : "num="+x,
			beforeSend:function () {
				$("#mrg").html("Eliminando...");
			},
			error:function() {
				alert("Ocurrio un error");
			},
			success:function(data) {
				$("#lcomite").load("../../model/comite/listcomite.php");
			}
		});
	}
	
}


function deleteLista(x, y){
	var x = x;
	var id = y;
	var url = '../../model/comite/despersonacomite.php';
	var c = "Desea quitar este registro?";
	if(confirm(c)){
		$.ajax({
			type : 'get',
			url : url,
			data : 'rut='+x,
			beforeSend:function(){
				$("#rg").html('Quitando de la lista...');
			},
			error:function(){
				$("#rg").html('');
				$("#dpersona").html('Ocurrio un error');
			},
			success:function(data){				
				if(data==1){					
					//alert("Registro quitado");
					$("#rg").html('');
					$("#lcomite").load("../../model/comite/list_comite_pers.php?id="+y);
				}else{
					alert("Ocurrió un error");
				}
			}
		});
	}
}
function paginar2 (nro, id) {    
    var n = nro;
    var id = id;
    var url = '../../model/comite/list_comite_pers.php';
    $.ajax({
        type : 'get',
        url : url,
        data : "id="+id+"&pag="+n,
        success:function(data){        	
        	 //$("#rg").html(data);
             $("#lcomite").load(url+"?id="+id+"&pag="+n);
        }
    });
}

function paginar3 (nro, id) {    
    var n = nro;
    var id = id;
    var url = '../../model/comite/listcomitedit.php';
    $.ajax({
        type : 'get',
        url : url,
        data : "id="+id+"&pag="+n,
        success:function(data){        	
        	 //$("#rg").html(data);
             $("#lcomite").load(url+"?id="+id+"&pag="+n);
        }
    });
}

function paginar (nro, id) {    
    var n = nro;
    var id = id;
    var url = '../../model/comite/listcomite.php';
    $.ajax({
        type : 'get',
        url : url,
        data : "id="+id+"&pag="+n,
        success:function(data){        	
        	 //$("#rg").html(data);
             $("#lcomite").load(url+"?id="+id+"&pag="+n);
        }
    });
}





/*function contarCaracteres() {
	var max = 20;
	$("#cont").html(max);

	var obs = $("#obs").val().length;
	var falt = max - obs;



	if ($falt == 10) {
		$("#cont").css('color', '#ff0000');
	}

	if (falt == 0) {
		$("#cont").html('Ha llegado al máximo de caracteres!!')
	}
}*/