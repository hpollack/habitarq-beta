// Controlador Vista Persona.
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
	$("#rut").focus(function(event) {
		$("#msg").removeClass('alert alert-success');
		$("#msg").html('');
	});
	$("#rut").focus(function(){
		$("#msg").removeClass('alert alert-danger');
		$("#msg").html('');
	});
	$("#lista").load('../../model/persona/listpersona.php');
	$("#p1").click(function() {
		if($("#p1").prop('checked')){
			$("#mp1").removeAttr('disabled');
		}else{
			$("#mp1").attr('disabled', true);
			$("#mp1").val('');			
		}
	});	
	$("#p2").click(function() {
		if($("#p2").prop('checked')){
			$("#mp2").removeAttr('disabled');
		}else{
			$("#mp2").attr('disabled', true);
			$("#mp2").val('');
		}
	});
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
		var busc = $("#rut").val();
		$.ajax({
			type : 'post',
			url : '../../model/persona/seekpersona.php',
			data : "s="+busc,
			beforeSend:function(){
				$("#b").html("Buscando...");
			},
			success:function(data){
				$("#b").html("");
				data = $.parseJSON(data);
				if(data.rut!=null){
					$("#dv").val(data.dv);					
					$("#nom").val(data.nom);
					$("#ap").val(data.ap);
					$("#am").val(data.am);
					if(data.vp==1){
						$("#vp").prop('checked', true);
					}
					$("#dir").val(data.dir);
					$("#nd").val(data.nd);
					$("#reg").val(data.reg);
					$("#pr").val(data.pr);
					$("#cm").val(data.cm);
					$("#tf").val(data.tf);
					$("#tp").val(data.tp);
					$("#mail").val(data.mail);
					$(".form-control").removeAttr('disabled');
					$("#pers input[type='checkbox']").removeAttr('disabled');
					$("#edit").removeAttr('disabled');
					$("#can").removeAttr('disabled');
					$("#grab").attr('disabled', true);
				}else{
					$("#pers input[type='text']").val('');
					$(".form-control").removeAttr('disabled');
					$("#pers input[type='checkbox']").removeAttr('disabled');
					$("#grab").removeAttr('disabled');	
					$("#edit").attr('disabled', true);					
				}
			}
		});		
	});
	$("#grab").click(function() {
		var rut= $("#rut").val();
		var dv = $("#dv").val();
		var nom = $("#nom").val();
		var ap = $("#ap").val();
		var am = $("#am").val();
		var vp = $("#vp").is(':checked');
		var dir = $("#dir").val();
		var nd = $("#nd").val();
		var reg = $("#reg").val();
		var pr = $("#pr").val();
		var cm = $("#cm").val();
		var em = $("#mail").val();
		var tf = $("#tf").val();
		var tp = $("#tp").val();

		$.ajax({
			type : 'post',
			url : '../../model/persona/inspersona.php',
			data : $("#pers").serialize(),
			beforeSend:function(){
				$("#msg").html("Enviando...");				
			},
			error:function(data){
				$("#msg").addClass('alert alert-danger');
				$("#msg").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
				$("#msg").html('Ocurrio un error');
			},
			success:function(data){
				if(data==2){
					$("#msg").addClass('alert alert-danger');					
					$("#msg").html("El dígito verificador es erróneo");
				}else if(data=0){
					$("#msg").addClass('alert alert-danger');					
					$("#msg").html("Error en la transaccion");	
				}else{
					$("#msg").addClass('alert alert-success');
					$("#msg").html(data);			
					$("#pers imput:text").val('');
					$("#pers select").val(0);
					$("#pers imput:checkbox").attr('disabled', true);
					$(".form-control").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#dv").removeAttr('disabled');
				}		
			}
		});
	});
	$("#edit").click(function() {
		var rut= $("#rut").val();
		var dv = $("#dv").val();
		var nom = $("#nom").val();
		var ap = $("#ap").val();
		var am = $("#am").val();
		var vp = $("#vp").is(':checked');
		var dir = $("#dir").val();
		var nd = $("#nd").val();
		var reg = $("#reg").val();
		var pr = $("#pr").val();
		var cm = $("#cm").val();
		var em = $("#mail").val();
		var tf = $("#tf").val();
		var tp = $("#tp").val();
		$.ajax({
			type : 'post',
			url : '../../model/persona/uppersona.php',
			data :$("#pers").serialize(),
			beforeSend: function(data){
				$("#msg").html("Actualizando información");
			},
			error:function(){
				$("#msg").addClass('alert alert-danger');
				$("#msg").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>')
				$("#msg").html("Ocurrio un Error");
			},
			success:function(data){
				if(data==2){
					$("#msg").addClass('alert alert-danger');					
					$("#msg").html("El dígito verificador es erróneo");
				}else if(data=0){
					$("#msg").addClass('alert alert-danger');					
					$("#msg").html("Error en la transaccion");	
				}else{
					$("#msg").addClass('alert alert-success');
					$("#msg").html("Datos actualizados");			
					$("#pers imput:text").val('');
					$("#pers select").val(0);
					$("#pers imput:checkbox").attr('disabled', true);
					$(".form-control").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#dv").removeAttr('disabled');
				}				
				
			}
		});
	});
	$("#can").click(function(){
		var can = "Seguro que desea cancelar?";
		if(confirm(can)){
			//alert("Tarea cancelada");
			location.href = "../../view/persona/";
		}
	});
	$("#busc").keyup(function() {
		var busc = $("#busc").val();	
		$.ajax({
			type : 'post',
			url : '../../model/persona/listpersona.php',
			data : "busc="+busc,
			dataType : 'html',
			beforeSend:function(){
				$("#ms").html(' Buscando...');
			},
			success:function(data){
				$("#lista").html(data);
				$("#ms").html('');				
			}
		});
	});	
});

$(document).on('click', '.open-modal', function() {
	var x = $(this).data('id');
	$.ajax({
		type : 'post',
		url : '../../model/persona/mpersona.php',
		data : "rut="+x,
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
function deleteLista(x){
	var x = x;
	var url = '../../model/persona/despersona.php';
	var c = "Desea quitar ete registro?";
	if(confirm(c)){
		$.ajax({
			type : 'get',
			url : url,
			data : 'r='+x,
			success:function(data){
				if(data==1){
					alert("Registro quitado");
					$("#lista").load("../../model/persona/listpersona.php");
				}else{
					alert("Ocurrió un error");
				}
			}
		});
	}
}
/*
funcion ajax que permite el refresco del div donde ira la lista. 
*/
function paginar2 (nro) {    
    var n = nro;
    var url = '../../model/persona/listpersona.php';
    $.ajax({
        type : 'get',
        url : url,
        data : "pag="+n,
        success:function(data){
             $("#lista").load(url+"?pag="+n);
        }
    });
}
