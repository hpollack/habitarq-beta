//Controlador de la Configuracion
$(document).ready(function() {

	$("#msg").click(function() {
		$("#msg").removeClass('alert alert-success');
		$("#msg").html('');
	});

	$("#msg").click(function() {
		$("#msg").removeClass('alert alert-danger');
		$("#msg").html('');
	});


	$("#fms").click(function() {
		$("#fms").removeClass('alert alert-success');
		$("#fms").html('');
	});

	$("#fms").click(function() {
		$("#fms").removeClass('alert alert-danger');
		$("#fms").html('');
	});
	
	$("#grab").click(function() {
		var parametros = $("#gen").serialize();

		$.ajax({
			type : 'post',
			url  : '../../model/config/parametros_generales.php',
			data : parametros,

			beforeSend:function() {
				$("#b").html('Guardando Configuración');
			},
			error:function() {
				alert("Ocurrio un error");
			},
			success:function(data) {
				$("#b").html('');
				if (data == 1) {					
					$("#msg").removeClass('alert alert-danger');
					$("#msg").addClass('alert alert-success');
					$("#msg").html("<b>Datos Almacenados</b>");
					window.scroll(0,1);
				}else {					
					$("#msg").removeClass('alert alert-success');
					$("#msg").addClass('alert alert-danger');
					$("#msg").html("<b>Error en la transacción</b>");
					window.scroll(0,1);
				}
			}
		});
	});

	$("#can").click(function() {
		location.href="../../index.php";
	});

	$("#lfer").load("../../model/config/listferiados.php");

	$("#fech").datepicker({
		format : "dd/mm/yyyy",
        language : "es"
	});

	$("#bfech").click(function() {
		var param = $("#fer").serialize();

		$.ajax({
			type : 'post',
			url  : '../../model/config/insferiados.php',
			data : param,
			beforeSend:function() {
				$("#c").html('Grabando día...');
			},
			error:function() {
				$("#c").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				$("#c").html('');
				if (data == 1) {
					$("#fms").removeClass('alert alert-danger');
					$("#fms").addClass('alert alert-success');
					$("#fms").html("<b>Fecha agregada</b>");
					$("#fer input:text").val('');
					$("#lfer").load("../../model/config/listferiados.php");
				}else if (data == 2) {
					$("#fms").removeClass('alert alert-success');
					$("#fms").addClass('alert alert-danger');
					$("#fms").html("<b>La fecha no debe quedar vacía</b>");	
				}else if (data == 3) {
					$("#fms").removeClass('alert alert-success');
					$("#fms").addClass('alert alert-danger');
					$("#fms").html("<b>Debe ingresar un motivo</b>");	
				}else {
					$("#fms").removeClass('alert alert-success');
					$("#fms").addClass('alert alert-danger');
					$("#fms").html("<b>No se pudo realizar la transacción</b>");
				}
			}
		});
	});

	//Gestion de Usuarios.

	$("#lusuarios").load('../../model/config/usuarios/listusuarios.php');

	$("#seek").click(function() {
		var us = $("#us").val();

		$.ajax({
			type : 'post',
			url  : '../../model/config/usuarios/seekusuario.php',
			data : "us="+us,
			beforeSend:function() {
				$("#bsc").html('Buscando...');
			},
			error:function() {
				alert("Ocurrio un error");
			},
			success:function(data) {
				$("#bsc").html('');
				datos = $.parseJSON(data);

				if (datos.us != null) {
					$("#nom").val(datos.nom);
					$("#ap").val(datos.ap);
					$("#mail").val(datos.mail);
					$("#pfl").val(datos.pfl);
					if (datos.est == 1) {
						$("#est").prop('checked', true);
					}
					$("#fus input").removeAttr('disabled');
					$("#fus select").removeAttr('disabled');
					$("#edt").removeAttr('disabled');
					$("#grb").attr('disabled', true);					
				}else {
					$("#fus input").removeAttr('disabled');
					$("#fus select").removeAttr('disabled');
					$("#grb").removeAttr('disabled');
					$("#edt").attr('disabled', true);
				}
			}
		});
	});

	$("#grb").click(function() {
		var parametros = $("#fus").serialize();

		$.ajax({
			type : 'post',
			url  : '../../model/config/usuarios/insusuario.php',
			data : parametros,

			beforeSend:function() {
				$("#bsc").html('Editando información de usuario');
			},
			error:function() {
				$("#bsc").html('');
				alert("Ocurrió un error");
			},
			success:function(data) {
				if (data == 1) {
					$("#msg").removeClass('alert alert-danger');
					$("#msg").addClass('alert alert-success');
					$("#msg").html("<b>Información actualizada</b>");
					$("#fus input").val('');
					$("#fus select").val('');
					$("#fus input").attr('disabled', true);
					$("#fus select").attr('disabled', true);
					$("#edt").attr('disabled', true);
					$("#us").removeAttr('disabled');
					$("#lusuarios").load('../../model/config/usuarios/listusuarios.php');
				}else if (data == 2) {
					$("#msg").removeClass('alert alert-success');
					$("#msg").addClass('alert alert-danger');
					$("#msg").html("<b>El nombre de usuario ya existe</b>");
					$("#us").removeAttr('disabled');
				}else if (data == 3) {
					$("#msg").removeClass('alert alert-success');
					$("#msg").addClass('alert alert-danger');
					$("#msg").html("<b>El dígito verificador es erróneo</b>");
					$("#us").removeAttr('disabled');		
				}else {
					$("#msg").removeClass('alert alert-success');
					$("#msg").addClass('alert alert-danger');
					$("#msg").html(data);
					//$("#msg").html("<b>Ocurrió un error en la transaccion</b>");
					$("#us").removeAttr('disabled');
				}
			}
		});
	});

	$("#edt").click(function() {
		var parametros = $("#fus").serialize();

		$.ajax({
			type : 'post',
			url  : '../../model/config/usuarios/upusuario.php',
			data : parametros,

			beforeSend:function() {
				$("#bsc").html('Editando información de usuario');
			},
			error:function() {
				$("#bsc").html('');
				alert("Ocurrió un error");
			},
			success:function(data) {
				if (data == 1) {
					$("#msg").removeClass('alert alert-danger');
					$("#msg").addClass('alert alert-success');
					$("#msg").html("<b>Información actualizada</b>");
					$("#fus input").val('');
					$("#fus select").val('');
					$("#fus input").attr('disabled', true);
					$("#fus select").attr('disabled', true);
					$("#edt").attr('disabled', true);
					$("#us").removeAttr('disabled');
					$("#lusuarios").load('../../model/config/usuarios/listusuarios.php');
				}else {
					$("#msg").removeClass('alert alert-success');
					$("#msg").addClass('alert alert-danger');
					$("#msg").html(data);
					//$("#msg").html("<b>Ocurrió un error en la transaccion</b>");
					$("#us").removeAttr('disabled');
				}
			}
		});
	});

	$("#rst").click(function() {
		$("#fus input").attr('disabled', true);
		$("#fus select").attr('disabled', true);
		$("#grb").attr('disabled', true);
		$("#edt").attr('disabled', true);
		$("#us").removeAttr('disabled');
	});

	$("#cnl").click(function() {
		//location.href = '../../index.php';
		history.back(1);
	});

	/*
	Configuracion de registros.
	*/
	$("#fi").datepicker({
		format : 'dd/mm/yyyy',
		language : 'es'
	});

	$("#ft").datepicker({
		format : 'dd/mm/yyyy',
		language : 'es'
	});

	//Cerrar alertas
	$("#rmsg").click(function() {
		$("#rmsg").removeClass('alert alert-success');
		$("#rmsg").html('');
	});

	$("#rmsg").click(function() {
		$("#rmsg").removeClass('alert alert-danger');
		$("#rmsg").html('');
	});
    
    $("#lr").change(function(event) {
    	if($(this).is(':checked')) {
    		$("#dr").removeAttr('disabled');
    	}else {
    		$("#dr").attr('disabled', true);
    	}
    });

	$("#gdb").click(function() {
		var parametros = $("#fdb").serialize();

		$.ajax({
			type : 'post',
			url  : '../../model/config/dataconfig.php',
			data : parametros,
			beforeSend:function() {
				$("#rmsg").html('Guardando los cambios...');
			},
			error:function() {
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (data == 1) {
					$("#rmsg").removeClass('alert alert-danger');
					$("#rmsg").addClass('alert alert-success');
					$("#rmsg").html("<b>Cambios Guardados</b>");
					window.scroll(0,1);
				}else {
					$("#rmsg").removeClass('alert alert-success');
					$("#rmsg").addClass('alert alert-danger');
					//$("#rmsg").html("<b>Ocurrió un error</b>");
					$("#rmsg").html(data);
					window.scroll(0,1);
				}
			}
		});
	});

	$("#rdbm").click(function(){
		window.location = '../../model/config/registros/dumpdb.php';
	});

	//Vista de registros.
	$("#ralerta").click(function(){
		$("#ralerta").removeClass('alert alert-danger');
		$("#ralerta").html('');
	});

	$("#lreg").load("../../model/config/registros/registros.php");

	$("#flt").click(function(event) {
		var filtros = $("#freg").serialize();

		$.ajax({
			type : 'post',
			url  : '../../model/config/registros/registros.php',
			data : filtros,
			dataType : 'html',
			beforeSend:function() {
				$("#fil").html('Filtrando resultados...');
			},
			error: function() {
				$("#fil").html('');
				alert("Ocurrió un error");
			},
			success:function (data) {
				if (data == 0) {
					$("#fil").html('');
					$("#ralerta").addClass('alert alert-danger');
					$("#ralerta").html("<b>La fecha de inicio no puede ser mayor a la fecha final</b>");
				}else {
					$("#fil").html('');
					$("#lreg").html(data);
				}				
			}
		});
	});

	$("#bclv").click(function() {
		var parametros = $("#fcl").serialize();

		$.ajax({
			type : 'post',
			url  : '../../model/config/usuarios/cambiaclave.php',
			data : parametros,
			beforeSend:function() {
				$("#msg").html("Guardando Cambios");
			},
			error:function(){
				$("#msg").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				if ($("#cla").val() == "" || $("#cln").val() == "" || $("#rlv").val() == "") {
					$("#msg").html('');
					$("#msg").addClass('alert alert-warning');
					$("#msg").html('<b>Todos los campos deben ser completados</b>');
				}else {
					if (data == 1) {
						$("#msg").html('');
						$("#msg").addClass('alert alert-success');
						$("#msg").html('<b>Contraseña Cambiada</b>');
						$("#fcl input").val('');
					}else if (data == 2){
						$("#msg").html('');
						$("#msg").addClass('alert alert-danger');
						$("#msg").html('<b>La contraseña nueva no puede ser igual a la anterior</b>');
					}else if (data == 3){
						$("#msg").html('');
						$("#msg").addClass('alert alert-danger');
						$("#msg").html('<b>Los campos son distintos</b>');
					}else if (data == 4) {
						$("#msg").html('');
						$("#msg").addClass('alert alert-danger');
						$("#msg").html('<b>La clave original es incorrecta</b>');					
					}else {
						$("#msg").html('');
						$("#msg").addClass('alert alert-danger');
						$("#msg").html(data);
					}
				}
			}
		});
	});

	$("#cclv").click(function() {
		history.back(1);
	});
});

function deleteLista(x){
	var x = x;
	var url = '../../model/config/usuarios/delusuario.php';
	var c = "Desea quitar este registro?";
	if(confirm(c)){
		$.ajax({
			type : 'get',
			url : url,
			data : 'us='+x,
			success:function(data){
				if(data==1){
					alert("Registro quitado");
					$("#lusuarios").load('../../model/config/usuarios/listusuarios.php');
				}else{
					alert("Ocurrió un error");
				}
			}
		});
	}
}

function paginar2 (nro) {    
    var n = nro;
    var url = '../../model/config/usuarios/listusuarios.php';
    $.ajax({
        type : 'get',
        url : url,
        data : "pag="+n,
        success:function(data){        	
            $('#lusuarios').load(url+"?pag="+n);
            $("#lusuarios").fadeIn('slow');
        }
    });
}

function paginar (nro) {    
    var n = nro;
    var url = '../../model/config/listferiados.php';
    $.ajax({
        type : 'get',
        url : url,
        data : "pag="+n,
        success:function(data){        	
            $("#lfer").load(url+"?pag="+n);
            $("#lfer").fadeIn('slow');
        }
    });
}

function paginarReg (nro) {    
    var n = nro;
    var url = '../../model/config/registros/registros.php';
    $.ajax({
        type : 'get',
        url : url,
        data : "pag="+n,
        success:function(data){        	
            $("#lreg").load(url+"?pag="+n);
            $("#lreg").fadeIn('slow');
        }
    });
}