$(document).ready(function() {
    $(function () {
        $("#fnac").datepicker({
            format : "dd/mm/yyyy",
            language : "es"
        });                
    });
    $("#rut").focus(function(){
        $("#res").removeClass('alert alert-success');
        $("#res").html('');
    });

    $("#re").click(function(){
        $("#rut").removeAttr('disabled');
    });

    $("#res").click(function(){
        $("#res").removeClass('alert alert-success');
        $("#res").html('');
    });

    $("#res").click(function(){
        $("#res").removeClass('alert alert-danger');
        $("#res").html('');
    });

	$("#busc").click(function() {		
        rut = $("#rut").val();
		$.ajax({
   			type : 'post',
   			url : '../../model/persona/seek_persona_ficha.php',
   			data : "r="+rut,            
   			beforeSend:function(){
   				$("#msg").html(" Buscando...");
   			},
   			error:function(){
   				alert("Error al ejecutar peticion");
   			},
   			success:function(data){                
                if(data=="0"){
                    $("#msg").addClass('text-danger');
                    $("#msg").html(' Esta persona no se encuentra registrada en la base de datos.');
                    $("#fich input").attr('disabled', true);
                    $("#fich select").attr('disabled', true);
                    $("#rut").removeAttr('disabled');
                    $("#busc").removeAttr('disabled');
                }else{
                    data = $.parseJSON(data);                              
                    if(data.fch==null){
                        $("#msg").html('');
                        $("#nom").html(data.nom);
                        $("#grab").removeAttr('disabled');
                        $("#fich input[type='text']").removeAttr('disabled');
                        $("#fich input[type='checkbox']").removeAttr('disabled');
                        $("#fich select").removeAttr('disabled');
                        $("#grab").removeAttr('disabled');
                    }else{                                            
                        $("#msg").html('');
                        $("#nom").html(data.nom);
                        $("#fch").val(data.fch);
                        $("#ec").val(data.ec);
                        $("#fnac").val(data.fnac);
                        $("#tmo").val(data.tmo);                        
                        $("#gfm").val(data.gfm);                        
                        $("#dh").val(data.dh);
                        if(data.adm==1){
                            $("#adm").prop('checked', true);
                        }
                        if(data.ds==1){
                            $("#ds").prop('checked', true);
                        }
                        $("#edit").removeAttr('disabled');
                        $("#del").removeAttr('disabled');
                        $("#fich input[type='text']").removeAttr('disabled');
                        $("#fich input[type='checkbox']").removeAttr('disabled');
                        $("#fich select").removeAttr('disabled');
                        $("#rut").attr('disabled', true);
                    }   
                }   				
   			}            
		});        
        $.ajax({
            type : 'post',
            url : '../../model/persona/seek_ficha_factor.php',
            data : "rut="+rut,
            success:function (data) {
                datos = $.parseJSON(data);               
                $.each(datos, function(index, datos) {                    
                    $("#fich input[id='ch"+datos+"']").prop('checked', true);                    
                });
            }
        });
	}); 
    /*
    Inserción y actualización de datos:
    Aquí se envían los valores marcados en los checkbox.
    */ 
    $("#grab").click(function() {
        var rut = $("#rut").val();
        var fch = $("#fch").val();
        var ec  = $("#ec").val();
        var fnac = $("#fnac").val();
        var tmo = $("#tmo").val();
        var pnt = $("#pnt").val();       
        var gfm = $("#gfm").val();
        var adm = $("#adm").is(':checked');
        var ds = $("#ds").is(':checked');
        var chbx = new Array();
        $("#fich input[name='ch[]']:checked").each(function() {
            chbx.push(this.value);
        });
        
        $.ajax({
            type : 'post',
            url  : '../../model/persona/insficha.php',
            data : $("#fich").serialize(),
            beforeSend:function(){
                $("#msg").html(" Grabando información... ");
            },
            error:function(){
                alert("Ocurrio un error");
            },
            success:function(data) {
                if(rut!=""){
                    if(data=="no"){
                        $("#res").removeClass('alert alert-success');
                        $("#res").addClass('alert alert-danger');
                        $("#res").html(data);
                        $("#res").html("<strong>La edad no corresponde con la seleccion. Por favor, desmarque la opcion</strong>");
                        window.scroll(0, 1);
                    }else{
                        $("#res").removeClass('alert alert-danger');
                        $("#res").addClass('alert alert-success');
                        $("#msg").html('');
                        $("#res").addClass('alert alert-success');
                        $("#res").html(data);                    
                        $("#fich input:text").val('');
                        $("#fich input:text").attr('disabled', true);
                        $("#fich select").val(0);
                        $("#fich select").attr('disabled', true);
                        $("#fich input:checkbox").prop('checked', false);
                        $("#fich input:checkbox").attr('disabled', true);
                        $("#grab").attr('disabled', true);
                        $("#rut").removeAttr('disabled');
                        window.scroll(0, 1);
                    }
                }else{                    
                    $("#res").addClass('alert alert-danger');
                    $("#res").html(" El rut es un dato obligatorio");
                    window.scroll(0, 1);
                }                
            }
        });            
    });    
    $("#edit").click(function() {
        var rut = $("#rut").val();
        var fch = $("#fch").val();
        var ec  = $("#ec").val();
        var fnac = $("#fnac").val();
        var tmo = $("#tmo").val();
        var pnt = $("#pnt").val();       
        var gfm = $("#gfm").val();
        var adm = $("#adm").is(':checked');
        var ds = $("#ds").is(':checked');
        var chbx = new Array();
        $("#fich input[name='ch[]']").each(function() {
            chbx.push(this.value);            
        });        
        $.ajax({
            type : 'post',
            url : '../../model/persona/upficha.php',
            data : $("#fich").serialize(),
            success:function(data) {
                if(data=="no"){                    
                    $("#res").addClass('alert alert-danger');
                    $("#res").html("<strong>La edad no corresponde con la selección. Por favor, desmarque la opción</strong>");                    
                    window.scroll(0, 1);
                }else{                    
                    $("#res").addClass('alert alert-success');
                    $("#res").html(data);                                    
                    $("#fich input:text").val('');
                    $("#fich input:text").attr('disabled', true);
                    $("#fich input:checkbox").prop('checked', false);
                    $("#fich input:checkbox").attr('disabled', true);
                    $("#fich select").val(0);
                    $("#fich select").attr('disabled', true);
                    $("#rut").removeAttr('disabled');
                    $("#fich input:button").attr('disabled', true);
                    $("#busc").removeAttr('disabled');
                    window.scroll(0,1);
                }
                
            }
        });
    });
    $("#del").click(function() {
        var can = "Seguro que desea cancelar?";
        if(confirm(can)){
            //alert("Tarea cancelada");
            location.href = "../../view/persona/";
        }
    });    
    //
    $("#ec").change(function() {
        /* Act on the event */
        $("#ec option:selected").each(function() {
            var ec = $(this).val();

            if (ec == 2) {
                $("#agc").removeAttr('disabled');
            }else{
                $("#agc").attr('disabled', true);
            }
        });

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


    $("#agregaConyuge").on('shown.bs.modal', function(e) {
        var e = $(e.relatedTarget);
        var rut = e.data('rut');

        $.ajax({
            type : 'post',
            url  : '../../view/persona/conyuge.php',
            data : "rut"+rut,
            beforeSend:function() {
                $(".modal-content").html("Cargando...");
            },
            error:function() {
                $(".modal-content").html("Ocurrio un error inesperado");
            },
            success:function(data) {
                $(".modal-content").html(data);
            }
        });
    });

    $("#agregaConyuge").on('click', '#seekc', function() {
        /* Act on the event */
        var r = $("#rutc").val();

        $.ajax({
            type : 'post',
            url  : '../../model/comite/processconyuge.php',
            data : 'rut='+r,
            beforeSend:function() {
                $("#bc").html('Buscando...');
            },
            error:function() {
                $("#bc").html('Ocurrio un error');
            },
            success:function(data){
                var datos = $.parseJSON(data);

                if (datos.rutc != null) {
                    $("#bc").html('');
                    $("#dvc").val(datos.dvc)
                    $("#nomc").val(datos.nomc);
                    $("#apc").val(datos.apc);
                    $("#amc").val(datos.amc);
                    $("#vpc").val(datos.vpc);

                    $("#cye input").removeAttr('disabled');
                    $("#gcon").attr('disabled', true);
                    $("#econ").removeAttr('disabled');
                }else{
                    $("#cye input").removeAttr('disabled');
                    $("#econ").attr('disabled', true);
                    $("#gcon").removeAttr('disabled');
                }
            }
        });

    });

    $("#gcon").click(function() {
        /* Act on the event */
        parametros = $("#cye").serialize();

        $.ajax({

        })
    });
});
