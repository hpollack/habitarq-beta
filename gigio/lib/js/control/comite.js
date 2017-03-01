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
	$("#dpersona").css('display', 'none');
	$("#rp").focus(function(){
		$("#alerta").removeClass('alert alert-success');
		$("#alerta").html('');
	});
	$("#sug").css('display', 'none');
	$("#mrp").focus(function(){
		$("#malerta").removeClass('alert alert-success');
		$("#malerta").html('');
		$("#mdpersona").html('');
	});
	$(function(){
		$("#fec").datepicker({
			format : "dd/mm/yyyy",
			language : "es"
		});
	});

	$("#num").focus(function(event) {
		$("#res").removeClass('alert alert-danger');
		$("#res").html('');
	});
	$("#num").focus(function(event) {
		$("#res").removeClass('alert alert-success');
		$("#res").html('');
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
					$("#egis").val(datos.egis);
					//Desbloqueado campos
					$("#dcom input:text").removeAttr('disabled');					
					$("#dcom select").removeAttr('disabled');					
					$("#edit").removeAttr('disabled');
					$("#can").removeAttr('disabled');
					$("#grab").attr('disabled', true);
				}else{
					$("#res").html('');
					$("#dcom input:text").removeAttr('disabled');					
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
				$("#res").fadeIn('slow');
				$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
			},
			success:function(data){	
				if(data==1){
					$("#res").addClass('alert alert-success');
					$("#res").html("Datos agregados");
					$("#res").fadeIn('slow');
					$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
					$("#dcom input:text").val('');
					$("#dcom input:text").attr("disabled", true);
					$("#dcom select").val('');
					$("#dcom select").attr("disabled", true);
					$("#nper").html('');
					$("#num").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}else if (data==2) {
					$("#res").addClass('alert alert-danger');
					//$("#res").html("Ocurrio un error al grabar en la base de datos");
					$("#res").html("</strong>Este nombre ya existe y solo puede ser ingresado una vez</strong>");
					$("#res").fadeIn('slow');
					$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
					$("#dcom input:text").val('');
					$("#dcom input:text").attr("disabled", true);
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
					$("#res").fadeIn('slow');
					$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
					$("#dcom input:text").val('');
					$("#dcom input:text").attr("disabled", true);
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
				$("#res").fadeIn('slow');
				$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
			},
			success:function(data){
				if(data==1){
					$("#res").addClass('alert alert-success');
					$("#res").html("Informacion Actualizada");
					$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
					$("#res").fadeIn('slow');
					$("#dcom input:text").val('');
					$("#dcom input:text").attr("disabled", true);
					$("#dcom select").val('');
					$("#dcom select").attr("disabled", true);
					$("#nper").html('');
					$("#num").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}else{
					$("#res").addClass('alert alert-danger');
					//$("#res").html("Ocurrio un error al grabar en la base de datos");
					//$("#res").html("Ocurrió un error en la transacción");					
					$("#res").html(data);
					$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
					$("#res").fadeIn('slow');
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

	//Segunda pestaña: Directiva
	$("#lista").load("../../model/comite/list_comite_pers.php?id=0");
	$("#busc").click(function () {
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
			$("#lista").load('../../model/comite/list_comite_pers.php?id='+id);
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
					$("#alerta").html('<strong> Transaccion realizada </strong>');
					$("#dpersona").html('');	
					$("#rp").val('');
					$("#gp select").val(0);
					$("#gp select").attr('disabled', true);
					$("#ag").attr('disabled', true);
					$("#lista").load("../../model/comite/list_comite_pers.php?id="+cmt);
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
				}else{
					$("#rg").html('');
					$("#alerta").removeClass('alert alert-success');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html(data);
					//$("#alerta").html('<strong>Error en la transaccion</strong>');
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
					$("#malerta").html('<strong>Esta persona existe o el cargo seleccionado solo puede ser ocupado por una persona</strong>');
					$("#mdpersona").html('');
					window.scroll(0,1);
				}else if(data==3){
					$("#mrg").html('');	
					$("#malerta").removeClass('alert alert-success');
					$("#malerta").addClass('alert alert-danger');
					$("#malerta").html('<strong>Solo es permitido ser miembro de este grupo</strong>');
				}else if(data==4){
					$("#mrg").html('');	
					$("#malerta").removeClass('alert alert-success');
					$("#malerta").addClass('alert alert-danger');
					$("#malerta").html('<strong>Debe escoger un cargo</strong>');
				}else if(data == 5){
					$("#rg").html('');
					$("#alerta").removeClass('alert alert-success');
					$("#alerta").addClass('alert alert-danger');
					$("#alerta").html('<strong>Esta persona no posee ficha, por lo que no puede postular</strong>');						
				}else{
					$("#mrg").html('');
					$("#malerta").removeClass('alert alert-success');
					$("#malerta").addClass('alert alert-danger');
					//$("#malerta").html(data);
					$("#malerta").html('<strong>Error en la transaccion</strong>');
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

	$("#cn").click(function(){
		$("#lcomite").load("../../model/comite/listcomite.php");
		$("#fmgp").slideUp('slow');
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
					$("#lista").load("../../model/comite/list_comite_pers.php?id="+y);
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
             $("#lista").load(url+"?id="+id+"&pag="+n);
        }
    });
}