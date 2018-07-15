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

    //Busqueda de datos por rut.
    //Si existen datos, se llenaran campos y activará el botón editar
    //Si no existen datos, desbloqueara los campos y habilitará el botón grabar

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
                    //Si no existe en los registros, marcará el mensaje desde el servidor
                    $("#msg").addClass('text-danger');
                    $("#msg").html(' Esta persona no se encuentra registrada en la base de datos.');
                    $("#fich input").attr('disabled', true);
                    $("#fich select").attr('disabled', true);
                    $("#rut").removeAttr('disabled');
                    $("#busc").removeAttr('disabled');
                }else{

                    //Los datos llegan en JSON, los cuales serán separados e ingresados en los campos
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

                        if (data.ec == 2) {
                            $("#agc").removeAttr('disabled');                            
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

        //LLamada ajax que trae los valores de los factores.       
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
        var chbx = new Array(); // array donde guardaremos los valores.

        //Si los checkbox vienen marcados, se guardan los valores en el array
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


    //Sugerencias. Funcion que controla la creacion de una lista combo con las personas activas
    //Por cada numero que se incluya en el rut, este ira filtrando a medida ques e va completando.
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


    /*Ventana emergente para manejar datos del conyuge */

    $("#agregaConyuge").on('shown.bs.modal', function(e) {
        var e = $(e.relatedTarget);
        var rut = $("#rut").val();

        $.ajax({
            type : 'post',
            url  : '../../view/persona/conyuge.php',
            data : "rut="+rut,
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
        var rp = $("#rutp").val();

        $.ajax({
            type : 'post',
            url  : '../../model/comite/processconyuge.php',
            data : 'rut='+r+'&rp='+rp,
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
                    $("#sx").val(datos.sx);                                        
                    if (datos.vpc == 1) {
                        $("#vpc").prop('checked', true);
                    }

                    $("#cye input").removeAttr('disabled');
                    $("#gcon").attr('disabled', true);
                    $("#econ").removeAttr('disabled');
                }else{
                    $("#bc").html('');
                    $("#cye input").removeAttr('disabled');
                    $("#econ").attr('disabled', true);
                    $("#gcon").removeAttr('disabled');
                }
            }
        });

    });

    $("#agregaConyuge").on('click', '#msj', function() {
        $("#msj").removeClass('alert alert-success');
        $("#msj").html('');
    });

     $("#agregaConyuge").on('click', '#msj', function() {
        $("#msj").removeClass('alert alert-danger');
        $("#msj").html('');
    });

    $("#agregaConyuge").on('click', '#gcon', function() {
        $.ajax({
            type : 'post',
            url  : '../../model/persona/insconyuge.php',
            data : $("#cye").serialize(),
            beforeSend:function() {
                $("#bc").html('Ingresando datos');
            },
            error:function(){
                $("#bc").html('Ocurrio un error');
            },
            success:function(data){
                $("#bc").html('');
                if(data == 1) {                    
                    $("#msj").addClass('alert alert-success');
                    $("#msj").html('<b>Datos agregados exitosamente, Puede cerrar esta ventana</b>');                    
                }else if (data == 2) {
                    $("#msj").addClass('alert alert-danger');
                    $("#msj").html('<b>El rut ingresado ya existe</b>');
                }else if (data == 3) {
                    $("#msj").addClass('alert alert-danger');
                    $("#msj").html('<b>El dígito verificador es erróneo</b>');
                }else if (data == 4) {    
                    $("#msj").addClass('alert alert-danger');
                    $("#msj").html('<b>El rut del conyuge ya existe');
                }else{
                    $("#bc").html('');
                    $("#msj").addClass('alert alert-danger');
                    $("#msj").html('<b>Ocurrio un error al ingresar datos</b>');
                }
            }

        });
    });

    $("#agregaConyuge").on('click', '#econ', function() {        
        $.ajax({
            type : 'post',
            url  : '../../model/persona/upconyuge.php',
            data : $("#cye").serialize(),
            beforeSend:function() {
                $("#bc").html('Actualizando Datos');
            },
            error:function() {
                $("#bc").html("Ocurrio un error");
            },
            success:function(data) {
                $("#bc").html('');
                if(data == 1) {                     
                    $("#msj").addClass('alert alert-success');
                    $("#msj").html('<b>Datos actualizados exitosamente, Puede cerrar esta ventana</b>');                                        
                }else if (data == 2) {
                    $("#msj").addClass('alert alert-danger');
                    $("#msj").html('<b>El rut ingresado ya existe</b>');
                }else if (data == 3) {
                    $("#msj").addClass('alert alert-danger');
                    $("#msj").html('<b>El dígito verificador es erróneo</b>');                
                }else{
                    $("#bc").html('');
                    $("#msj").addClass('alert alert-danger');
                    $("#msj").html('<b>Ocurrio un error al ingresar datos</b>');                    
                }
            }

        });
        
    });

    $("#agregaConyuge").on('click', '#dcon', function() {
        var conf = "Desea quitar este registro?";

        if (confirm(conf)) {
             $.ajax({
                type : 'post',
                url  : '../../model/persona/desconyuge.php',
                data : $("#cye").serialize(),
                beforeSend:function() {
                    $("#bc").html('Borrando registro');
                },
                error:function() {
                    $("#bc").html("Ocurrio un error");
                },
                success:function(data) {
                    $("#bc").html('');
                    if(data == 1) {
                        $("#agregaConyuge").modal('hide');
                        $("#res").addClass('alert alert-success');
                        $("#res").html('<b>Información eliminada</b>');
                        $("#ec").val(0);
                        $("#agc").attr('disabled', true);
                    }else{
                        $("#bc").html('');
                        $("#msj").addClass('alert alert-danger');
                        $("#msj").html('<b>Ocurrio un error al borrar</b>');                        
                    }
                }
            });
        }
        
    });

});
    
