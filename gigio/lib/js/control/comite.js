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
	$(function(){
		$("#fec").datepicker({
			format : "dd/mm/yyyy",
			language : "es"
		});
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
		var num = $("#num").val();
		$.ajax({
			type : 'post',
			url : '../../model/comite/seek_comite.php',
			data : "num="+num,
			beforeSend:function(){
				$("#res").html("Buscando");
			},
			error:function(){
				$("#res").addClass('alert alert-danger');
				$("#res").html("Ocurrio un error");
				$("#res").fadeIn('slow');
				$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
			},
			success:function(data){
				
				var datos = $.parseJSON(data);
				
				if(datos.num!=null){					
					$("#res").html('');
					$("#idg").val(datos.idg);
					$("#fec").val(datos.fec);
					$("#nc").val(datos.nc);
					$("#per").val(datos.per);
					$("#dir").val(datos.dir);
					$("#reg").val(datos.reg);
					$("#pr").val(datos.pr);
					$("#cm").val(datos.cmn);
					$("#ds10").val(datos.ds10);
					$("#egis").val(datos.egis);
					//Desbloqueado campos
					$("#dcom input:text").removeAttr('disabled');
					$("#dcom select").removeAttr('disabled');
				}else{
					$("#res").html('');
					$("#dcom input:text").removeAttr('disabled');
					$("#dcom select").removeAttr('disabled');
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
				}else{
					$("#res").addClass('alert alert-danger');
					$("#res").html("Ocurrio un error al grabar en la base de datos");
					$("#res").fadeIn('slow');
					$("#res").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
					$("#dcom input:text").val('');
					$("#dcom input:text").attr("disabled", true);
					$("#dcom select").val('');
					$("#dcom select").attr("disabled", true);	
				}
			}
		});

	});
});