$(document).ready(function() {

	//Formato de fecha calendario datepicker
	$(function(){
		$("#fi").datepicker({
			format : 'dd/mm/yyyy',
			language : "es"
		});
	});

	//Al enfocar el campo de busqueda, se quitan las clases bootstrap del div de respuesta.
	$("#num").focus(function() {
		$("#res").html('');
		$("#res").removeClass("alert alert-danger");
	});
	$("#num").focus(function() {
		$("#res").html('');
		$("#res").removeClass("alert alert-success");
	});
	$("#num").focus(function() {
		$("#res").html('');
		$("#res").removeClass("alert alert-warning");
	});

	//Al hacer click en la alerta
	$("#res").click(function() {
		$("#res").html('');
		$("#res").removeClass("alert alert-danger");
	});
	$("#res").click(function() {
		$("#res").html('');
		$("#res").removeClass("alert alert-success");
	});
	
	//Al hacer click en la alerta de postulantes
	$("#resp").click(function() {
		$("#resp").html('');
		$("#resp").removeClass("alert alert-danger");
	});
	$("#resp").click(function() {
		$("#resp").html('');
		$("#resp").removeClass("alert alert-success");
	});
	$("#resp").click(function() {
		$("#resp").html('');
		$("#resp").removeClass("alert alert-warning");
	});

	//Combos dependientes.	
	$("#tit").change(function() {
		$("#tit option:selected").each(function() {
			var tit = $(this).val();
			$.ajax({
				type : 'post',
				url  : '../../model/comite/seektipopostulacion.php',
				data : "tit="+tit,
				success:function(data) {
					$("#tip").removeAttr('disabled');
					$("#tip").html(data);
					$("#tip").prop('selected', true);
				}
			});
		});
	});

	$("#tip").change(function() {
		$("#tip option:selected").each(function() {
			var tip = $(this).val();
			$.ajax({
				type : 'post',
				url  : '../../model/comite/seekitempostulacion.php',
				data : "tip="+tip,
				success:function(data) {
					$("#item").removeAttr('disabled');
					$("#item").html(data);
					$("#item").prop('selected', true);
				}
			});
		});
	});

	//Combos dependientes pestaña historial
	$("#lcmt").change(function(){
		$("#lcmt option:selected").each(function() {
			var cmt = $(this).val();
			$.ajax({
				type : 'post',
				url  : '../../model/comite/seekllamadocomite.php',
				data : "cmt="+cmt,
				beforeSend:function() {
					$("#llmd").html('Cargando llamados...');
				},
				success:function(data) {
					$("#llmd").removeAttr('disabled');
					$("#llmd").html(data);
					$("#llmd").prop('selected', true);
				}
			});
		});
	});

	//Boton buscar
	$("#seek").click(function() {
		var num = $("#num").val();

		$.ajax({
			type : 'post',
			url  : '../../model/comite/seek_post_comite.php',
			data : "num="+num,

			beforeSend:function() {
				$("#res").html("Buscando...");
			},
			error:function() {
				$("#res").html("Ocurrio un error");
			},
			success:function(data) {
				if (data=="0") {
					$("#res").addClass("alert alert-warning");
					$("#res").html("<strong>Este grupo no existe en la base de datos</strong>");
				}else {
					var data = $.parseJSON(data);

					if (data.num != null) {
						$("#res").html('');						
						$("#idg").val(data.idg);
						$("#cmt").val(data.pos);
						$("#pos").val(data.pos);
						$("#nom").html(data.nom);
						$("#tit").val(data.tit);
						$("#tip").val(data.tip);
						$("#item").val(data.item);
						$("#con").val(data.con);
						$("#fi").val(data.fi);
						$("#ds").val(data.ds);
						$("#lmd").val(data.lmd);						
						$("#anl").val(data.anl);
						$("#ff").html(data.ff);
						$("#ff").css('font-size', '14px');
						$("#tit").removeAttr('disabled');
						$("#fpos input:text").removeAttr('disabled');
						$("#fpos select").removeAttr('disabled');
						$("#grab").attr('disabled', true);
						$("#edit").removeAttr('disabled');
						$("#lcomite").load("../../model/comite/listpostulantes.php?id="+data.idg);
					}else {
						$("#res").html('');
						$("#idg").val(data.idg);
						$("#nom").html(data.nom);
						$("#tit").removeAttr('disabled');
						$("#con").removeAttr('disabled');
						$("#fpos input:text").removeAttr('disabled');
						$("#fpos select").removeAttr('disabled');
						$("#edit").attr('disabled', true);
						$("#grab").removeAttr('disabled');
						$("#lcomite").html('');
					}
				}
			}
		});
	});

	//Boton grabar
	$("#grab").click(function() {
		var parametros = $("#fpos").serialize();

		$.ajax({
			type : 'post',
			url  : '../../model/comite/ins_postul_comite.php',
			data : parametros,

			beforeSend:function() {
				$("#res").html('Enviando datos...');
			},
			error:function() {
				alert("Ocurrió un error");
			},
			success:function(data) {
				$("#res").html('');

				if (data == 1) {
					$("#res").removeClass("alert alert-danger");
					$("#res").addClass("alert alert-success");
					$("#res").html("<b>Postulación creada</b>");
					$("#fpos input:text").val('');
					$("#fpos input:text").attr('disabled', true);
					$("#fpos select").val(0);
					$("#fpos select").attr('disabled', true);
					$("#num").removeAttr('disabled');
					$("#grab").attr('disabled', true);
				}else if (data == 2) {
					$("#res").removeClass('alert alert-success');
					$("#res").addClass('alert alert-danger');
					$("#res").html("<b>Este comité no posee postulantes</b>");							
				}else {
					$("#res").removeClass('alert alert-success');
					$("#res").addClass('alert alert-danger');
					$("#res").html("<b>Ocurrió un error en la transacción</b>");
					
				}
			}
		});
	});

	//Boton Editar
	$("#edit").click(function() {
		var parametros = $("#fpos").serialize();
		$.ajax({
			type : 'post',
			url  :  '../../model/comite/uppostulacion.php',
			data : parametros,

			beforeSend:function() {
				$("#res").html('Enviando datos...');
			},
			error:function() {
				alert("Ocurrió un error");
			},
			success:function(data) {
				$("#res").html('');

				if (data == 1) {
					$("#res").removeClass("alert alert-danger");
					$("#res").addClass("alert alert-success");
					$("#res").html("<b>Información Actualizada</b>");
					$("#fpos input:text").val('');
					$("#fpos input:text").attr('disabled', true);
					$("#fpos select").val(0);
					$("#fpos select").attr('disabled', true);
					$("#num").removeAttr('disabled');
					$("#edit").attr('disabled', true);
				}else {
					$("#res").removeClass('alert alert-success');
					$("#res").addClass('alert alert-danger');
					$("#res").html(data);
					//$("#res").html("<b>Ocurrió un error en la transacción</b>");
				}
			}

		});
	});

	//Boton Limpiar
	$("#rs").click(function() {
		$("#fpos select").removeAttr('disabled');
		$("#fpos input:text").removeAttr('disabled');
		$("#nom").html('');
		$("#grab").attr('disabled', true);
		$("#edit").attr('disabled', true);			
	});

	$("#can").click(function() {
		location.href = "../../view/comite/";
	});

	$("#lcomite").on('click', '#pst', function(event) {
		event.preventDefault();
		var lmd = $("#lm").val();
		var cmt = $("#cmt").val();		
		var chbx = new Array();

		$("#tcomite input[name='ps[]']:checked").each(function() {
			chbx.push(this.value);
		});

		$.ajax({
			type : 'post',
			url  : '../../model/comite/inspostulantesgrupal.php',
			data : $("#tcomite").serialize(),
			beforeSend:function() {
				$("#resp").html('Enviando información');				
			},
			error:function() {
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (data == 1) {
					$("#resp").removeClass('alert alert-danger');
					$("#resp").addClass('alert alert-success');
					$("#resp").html("Postulantes agregados: "+chbx.length);
					$("#lcomite").load('../../model/comite/listpostulantes.php?id='+cmt);
				} else if (data == 2) {
					$("#resp").removeClass('alert alert-success');
					$("#resp").addClass('alert alert-danger');
					$("#resp").html("No se encuentra registrado ninguna postulacion");
				}else if (data == 3){
					$("#resp").removeClass('alert alert-success');
					$("#resp").addClass('alert alert-danger');
					$("#resp").html("No se encuentra registrado ningun llamado");	
				}else {
					$("#resp").removeClass('alert alert-success');
					$("#resp").addClass('alert alert-danger');
					$("#resp").html("Debe chequear al menos un item");
				}
			}
		});
	});

	$("#glist").click(function() {
		var x = $("#lcmt").val();
		var y = $("#llmd").val();		

		$.ajax({
			type : 'post',
			url  : '../../model/comite/listhistorialllamados.php',
			data : "cmt="+x+"&lmd="+y,
			beforeSend:function() {
				$("#rl").html('Cargando...');
			},
			success: function() {
				$("#rl").html('');
				$("#lhistorial").load("../../model/comite/listhistorialllamados.php?cmt="+x+"&lmd="+y);
			}
		});
	});

	$("#gexcel").click(function(){
		var x = $("#lcmt").val();
		var y = $("#llmd").val();
		var page = '../../model/comite/excel_postulantes.php?cmt='+x+'&lmd='+y;
		window.location = page;
	});

});

function paginar2 (nro, id) {    
    var n = nro;
    var id = id;
    var url = '../../model/comite/listpostulantes.php';
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

function paginar3 (nro, cmt, lnd) {
	var n = nro;
	var x = cmt;
	var y = lnd;
	var url = '../../model/comite/listhistorialllamados.php';
	$.ajax({
		type : 'get',
		url  : url,
		data :  "cmt="+x+"&lmd="+y+"&pag="+n,
		beforeSend:function() {
			$("#rl").html('Cargando...');
		},
		success:function(data) {
			$("#rl").html('');
			$("#lhistorial").load(url+'?cmt='+x+'&lmd='+y+'&pag='+n);
		}
	});
}