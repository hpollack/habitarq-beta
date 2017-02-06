$(document).ready(function() {
	$("#p2").change(function(event) {
		if($(this).is(':checked')){
			$("#mp2").removeAttr('disabled');
		}else{
			$("#mp2").attr('disabled', true);
			$("#mp2").val(0);
		}
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
					$("#b").html(" Esta persona no se encuentra registrada en la base de datos.");
				}else{
					data = $.parseJSON(data);					
					if(data.rol!=null){
						$("#b").html('');
						$("#viv input:text").removeAttr('disabled');
						$("#viv select").removeAttr('disabled');
						$("#viv input:checkbox").removeAttr('disabled');
						$("#rol").val(data.rol);
						//$("#rol").attr('disabled', true);
						$("#foj").val(data.foj);
						$("#ar").val(data.ar);
						$("#mp1").val(data.mp1);
						if(data.mp2!=0||data.mp2!=null){
							$("#p2").prop('checked', true);
							$("#mp2").removeAttr('disabled');
							$("#mp2").val(data.mp2);														
						}else{
							$("#p2").prop('checked', false);
							$("#mp2").val(0);
						}
						
						$("#ac").val(data.ac);
						$("#tv").val(data.tv);
						$("#st").val(data.st);
						$("#cv").val(data.cv);
						$("#num").val(data.num);
						$("#nom").html(data.nom);
						$("#idr").val(data.idr);

						$("#tms").html(data.tms);
						$("#tms").addClass('text text-primary');
						$("#edit").removeAttr('disabled');
						$("#del").removeAttr('disabled');
					}else{
						$("#b").html('');
						$("#nom").html(data.nom);
						$("#viv input:text").removeAttr('disabled');
						$("#viv select").removeAttr('disabled');
						$("#viv input:checkbox").prop('checked', false);
						$("#viv input:checkbox").removeAttr('disabled');					
						if($("#p2").prop('checked',false)){
							$("#mp2").attr('disabled', true);
						}					
						$("#grab").removeAttr('disabled');
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
		if($("#mp2").val()==''){
			var mp2 = 0;
		}else{
			var mp2 = $("#mp2").val();
		}
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
				$("#b").html('');
				$("#resp").addClass('alert alert-success');
				$("#resp").html(data);
				$("#resp").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
				$("#viv input:text").val('');
				$("#viv input:text").attr('disabled', true);
				$("#viv input:checkbox").prop('checked', false);
				$("#viv input:checkbox").attr('disabled', true);
				$("#viv select").val(0);
				$("#viv select").attr('disabled', true);
				$("#rut").removeAttr('disabled');
				$("#seek").removeAttr('disabled');
			}
		});
	});
	$("#edit").click(function() {
		var rut = $("#rut").val();
		var rol = $("#rol").val();
		var foj = $("#foj").val();
		var ar  = $("#ar").val();
		var mp1 = $("#mp1").val();
		if($("#mp2").val()==''){
			var mp2 = 0;
		}else{
			var mp2 = $("#mp2").val();
		}
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
				$("#b").html('');
				$("#nom").html('');
				$("#resp").addClass('alert alert-success');
				$("#resp").html(data);
				$("#resp").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');				
				$("#viv input:text").val('');
				$("#viv input:text").attr('disabled', true);
				$("#viv input:checkbox").prop('checked', false);
				$("#viv input:checkbox").attr('disabled', true);
				$("#viv select").val(0);
				$("#viv select").attr('disabled', true);
				$("#rut").removeAttr('disabled');
				$("#seek").removeAttr('disabled');
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
});
