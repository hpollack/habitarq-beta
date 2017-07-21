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
	$(function (){
		$("#numpe").datepicker({
			format : "dd/mm/yyyy",
            language : "es"
		});

		$("#numcr").datepicker({
			format : "dd/mm/yyyy",
            language : "es"
		});

		$("#numrg").datepicker({
			format : "dd/mm/yyyy",
            language : "es"
		});

		$("#numip").datepicker({
			format : "dd/mm/yyyy",
            language : "es"
		});
	});
	
	$("#rut").focus(function(event){
		$("#resp").removeClass('alert-success');
		$("#resp").html('');
	});

	$("#rut").focus(function(event){
		$("#resp").removeClass('alert-danger');
		$("#resp").html('');
	});

	$("#resp").click(function() {
		$("#resp").removeClass('alert-success');
		$("#resp").html('');
	});

	$("#resp").click(function() {
		$("#resp").removeClass('alert-danger');
		$("#resp").html('');
	});
	 
	$("#seek").click(function() {
		var rut = $("#rut").val();
		$.ajax({
			type : 'post',
			url : '../../model/persona/seekvivienda.php',
			data : "r="+rut,
			beforeSend:function(){
				$("#b").html(" Buscando...");
			},
			error:function(){
				alert("Ocurrio un error");
				$("#b").html('');
			},
			success:function(data){
				if(data=="0"){
					$("#b").addClass('text text-danger');					
					$("#b").html(" Esta persona no se encuentra registrada en la base de datos o bien no posee ficha");
				}else{
					data = $.parseJSON(data);					
					if(data.rol!=null){
						$("#b").html('');
						$("#viv input:text").removeAttr('disabled');
						$("#viv select").removeAttr('disabled');
						$("#rol").val(data.rol);
						//$("#rol").attr('disabled', true);
						$("#foj").val(data.foj);
						$("#ar").val(data.ar);
						$("#mp1").val(data.mp1);
						$("#mp2").val(data.mp2);
						$("#mp3").val(data.mp3);
						$("#mp4").val(data.mp4);
						$("#tmso").html(data.tmso);
						$("#tmsa").html(data.tmsa);
						$("#npe").val(data.npe);
						$("#numpe").val(data.numpe);
						$("#ncr").val(data.ncr);
						$("#numcr").val(data.numcr);
						$("#nrg").val(data.nrg);
						$("#numrg").val(data.numrg);
						$("#nip").val(data.nip);
						$("#numip").val(data.numip);						
						$("#tv").val(data.tv);
						$("#st").val(data.st);
						$("#cv").val(data.cv);
						$("#num").val(data.num);
						$("#nom").html(data.nom);
						$("#idr").val(data.idr);

						$("#tmso").addClass('text text-success');
						$("#tmsa").addClass('text text-success');
						$("#grab").attr('disabled',true);
						$("#edit").removeAttr('disabled');
						$("#del").removeAttr('disabled');
					}else{
						$("#b").html('');
						$("#nom").html(data.nom);
						$("#viv input:text").removeAttr('disabled');
						$("#viv select").removeAttr('disabled');			
						$("#grab").removeAttr('disabled');
						$("#edit").attr('disabled', true);
						$("#del").removeAttr('disabled');
					}
				}
			}
		});
	});
	$("#grab").click(function() {
		var rut = $("#rut").val();
		var rol = $("#rol").val();
		if(rol==''){
			alert("no hay valor");
		}
		var foj = $("#foj").val();
		var ar  = $("#ar").val();
		var mp1 = $("#mp1").val();
		var mp2 = $("#mp2").val();
		var mp3 = $("#mp3").val();
		var mp4 = $("#mp4").val();
		var npe = $("#npe").val();
		var numpe = $("#numpe").val();
		var ncr  = $("#ncr").val();
		var numcr = $("#numcr").val();
		var nrg  = $("#nrg").val();
		var numrg = $("#numrg").val();
		var nip = $("#nip").val();
		var numip = $("#numip").val();
		var ac = $("#ac").val();
		var tv = $("#tv").val();
		var st = $("#st").val();
		var cv = $("#cv").val();
		$.ajax({
			type : 'post',
			url : '../../model/persona/insvivienda.php',
			data : $("#viv").serialize(),
			beforeSend:function(){
				window.scroll(0,1);
				$("#b").html(" Enviando datos...");
			},
			error:function(){
				alert("Ocurrio un error");
			},
			success:function(data){
				if (data == 1) {
					$("#b").html('');
					$("#resp").removeClass('alert alert-danger');
					$("#resp").addClass('alert alert-success');
					$("#resp").html("<strong>Datos Ingresados exitosamente</strong>");				
					$("#viv input:text").val('');
					$("#viv input:text").attr('disabled', true);				
					$("#viv select").val(0);
					$("#viv select").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}else if (data == 2) {
					$("#b").html('');
					$("#resp").removeClass('alert alert-success');
					$("#resp").addClass('alert alert-danger');
					$("#resp").html("<strong>El año de recepción no debe ser anterior al año de registro del sistema</strong>");				
					$("#viv input:text").val('');
					$("#viv input:text").attr('disabled', true);				
					$("#viv select").val(0);
					$("#viv select").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}else {
					$("#b").html('');
					$("#resp").removeClass('alert alert-success');
					$("#resp").addClass('alert alert-danger');
					//$("#resp").html("<strong>Ocurrió un error al insertar</strong>");				
					$("#resp").html(data);
					$("#viv input:text").val('');
					$("#viv input:text").attr('disabled', true);				
					$("#viv select").val(0);
					$("#viv select").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}
			}
		});
	});
	$("#edit").click(function() {
		var rut = $("#rut").val();
		var rol = $("#rol").val();		
		var foj = $("#foj").val();
		var ar  = $("#ar").val();
		var mp1 = $("#mp1").val();
		var mp2 = $("#mp2").val();
		var mp3 = $("#mp3").val();
		var mp4 = $("#mp4").val();
		var npe = $("#npe").val();
		var numpe = $("#numpe").val();
		var ncr  = $("#ncr").val();
		var numcr = $("#numcr").val();
		var nrg  = $("#nrg").val();
		var numrg = $("#numrg").val();
		var nip = $("#nip").val();
		var numip = $("#numip").val();
		var ac = $("#ac").val();
		var tv = $("#tv").val();
		var st = $("#st").val();
		var cv = $("#cv").val();		
		$.ajax({
			type : 'post',
			url  : '../../model/persona/upvivienda.php',
			data : $("#viv").serialize(),
			beforeSend:function(){
				$("#b").html(' Actualizando información');				
			},
			error:function(){
				alert('Ocurrio un error');
			},
			success:function(data){
				if (data == 1) {
					$("#b").html('');
					$("#resp").removeClass('alert alert-danger');
					$("#resp").addClass('alert alert-success');
					$("#resp").html("<strong>Datos Actualizados exitosamente</strong>");				
					$("#viv input:text").val('');
					$("#viv input:text").attr('disabled', true);				
					$("#viv select").val(0);
					$("#viv select").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}else if (data == 2) {
					$("#b").html('');
					$("#resp").removeClass('alert alert-success');
					$("#resp").addClass('alert alert-danger');
					$("#resp").html("<strong>El año de recepción no debe ser anterior al año de registro del sistema</strong>");				
					$("#viv input:text").val('');
					$("#viv input:text").attr('disabled', true);				
					$("#viv select").val(0);
					$("#viv select").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#seek").removeAttr('disabled');
				}else {
					$("#b").html('');
					$("#resp").removeClass('alert alert-success');
					$("#resp").addClass('alert alert-danger');
					//$("#resp").html("<strong>Ocurrió un error al insertar</strong>");				
					$("#resp").html(data);
					/*$("#viv input:text").val('');
					$("#viv input:text").attr('disabled', true);				
					$("#viv select").val(0);
					$("#viv select").attr('disabled', true);
					$("#rut").removeAttr('disabled');
					$("#seek").removeAttr('disabled');*/
				}
			}
		});
	});
	$("#del").click(function() {
		var can = "Seguro que desea cancelar?";
		if(confirm(can)){
			location.href = "../../view/persona/";
		}
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

    $("#seek").focus(function(){
        $("#sug").fadeOut('fast');
    });

    $("#rut").blur(function(){
        $("#sug").fadeOut('fast');
    });
});