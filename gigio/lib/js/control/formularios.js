$(document).ready(function() {
	
	$("#dgr").css('display', 'none');
	$("#bnom").css('display', 'none');

	$("#info").click(function() {
		$("#info").removeClass('alert alert-danger');
		$("#info").html('');
	});

	$("#info").click(function() {
		$("#info").removeClass('alert alert-warning');
		$("#info").html('');
	});

	$("#seek").click(function() {
		var ruk = $("#ruk").val();
		var lmd = $("#lmd").val();
		var anio = $("#canio").val();

		$.ajax({
			type : 'post',
			url  : '../../../model/formularios/seekcaratula.php',
			data : "ruk="+ruk+"&lmd="+lmd+"&anio="+anio,
			beforeSend:function() {
				$("#bgr").html("Buscando información..");
			},
			error:function() {
				$("#bgr").html('');
				alert("Ocurrió un error");
			},
			success:function(data) {
				if (ruk == "" || lmd == 0 || anio == 0) {
					$("#bgr").html('');
					$("#info").addClass('alert alert-warning');
					$("#info").html("<b>Los campos no pueden quedar vacíos</b>");
				}else{
					datos = $.parseJSON(data);	
					if (datos.ruk != null) {
						$("#bgr").html('');					
						$("#dgr").slideDown('slow');
						$("#nom").html(datos.nom);
						$("#tit").html(datos.tit);
						$("#pj").html(datos.pj);
						$("#rl").html(datos.rl);
						$("#at").html(datos.at);
						$("#ctr").html(datos.ctr);
						$("#nom").html(datos.nom);
						$("#np").html(datos.np);
						$("#tf").html(datos.tf);
						$("#org").removeAttr('disabled');
						$("#cnv").removeAttr('disabled');
						$("#cnt").removeAttr('disabled');
						$("#reg").removeAttr('disabled');
						$("#gcar").removeAttr('disabled');
					}else {
						$("#bgr").html('');
						$("#info").addClass('alert alert-danger');
						$("#info").html("<b>Este Comité o llamado no existe en la base de datos</b>");
					}

				}
				
			}
		});
	});
	$("#gcar").click(function() {
		if ($("#ruk").val() == "" || $("#lmd") == 0) {
			$("#bgr").html('');
			$("#info").addClass('alert alert-warning');
			$("#info").html("<b>Los campos no pueden quedar vacíos</b>");
		}
	});	
	

	$("#rcar").click(function() {
		$("#fcar input:checkbox").attr('disabled', true);
		$("#dgr").slideUp('slow');
		$("#gcar").attr('disabled', true);
	});

	$("#cnr").click(function() {
		location.href = '../../../view/formularios/grupal.php';
	});

	//Nómina Financiera
	$("#seek1").click(function() {
		var ruk = $("#ruk1").val();
		var lmd = $("#llmd").val();
		var anio = $("#ganio").val();
		$.ajax({
			type : 'post',
			url  : '../../../model/formularios/seeknomfinanciera.php',
			data : "ruk="+ruk+"&lmd="+lmd+"&anio="+anio,
			beforeSend:function() {
				$("#gbr").html('Buscando información...');
			},
			error:function() {
				$("#gbr").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (ruk == "" || lmd == 0 || anio == 0) {
					$("#gbr").html('');
					$("#info").addClass('alert alert-warning');
					$("#info").html("<b>Los campos no pueden quedar vacíos</b>");
				}else {
					datos = $.parseJSON(data);

					if (datos.gruk != null) {
						$("#gbr").html('');
						$("#bnom").slideDown('slow');
						$("#gnom").html(datos.gnom);
						$("#gpos").html(datos.gpos);
						$("#guf").html(datos.guf);
						if (datos.gpos > 0) {
							$("#gsub").removeAttr('disabled');
						}else {
							$("#gsub").attr('disabled', true);
						}					
					}else {
						$("#gbr").html('');
						$("#info").addClass('alert alert-danger');
						$("#info").html("<b>El comité, el llamado o el año no se encuentran registrados en la base de datos</b>");
					}
				}
			}
		});

		$("#grs").click(function() {
			$("#gnom").html('');
			$("#gpos").html('');
			$("#guf").html('');
			$("#gsub").attr('disabled', true);
			$("#bnom").slideUp('slow');
		});
	});

	$("#gcnl").click(function() {
		location.href = '../../../view/formularios/grupal.php';
	});

	//Nomina de postulantes sola
	$("#pseek").click(function(){
		var ruk = $("#ruk2").val();
		var lmd = $("#llmd1").val();
		var anio = $("#panio").val();

		$.ajax({
			type :'post',
			url  : '../../../model/formularios/seeknompostulantes.php',
			data : "ruk="+ruk+"&lmd="+lmd+"&anio="+anio,
			beforeSend:function() {
				$("#gbr").html('Buscando información...');
			},
			error:function() {
				$("#gbr").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (ruk == "" || lmd == 0 || anio == 0) {
					$("#gbr").html('');
					$("#info").addClass('alert alert-warning');
					$("#info").html("<b>Los campos no deben ir vacíos</b>");
				}else {
					var datos = $.parseJSON(data);

					if (datos.pruk != null) {
						$("#gbr").html('');
						$("#bnom").slideDown('slow');
						$("#pnom").html(datos.pnom);
						$("#ppos").html(datos.ppos);
						 if (datos.ppos > 0) {
							$("#psub").removeAttr('disabled'); 	
						 }else {
						 	$("#psub").attr('disabled', true);
						 }						
					}else {
						$("#gbr").html('');
						$("#info").addClass('alert alert-danger');
						$("#info").html("<b>El comité, el llamado o el año no se encuentran registrados en la base de datos</b>");
					}
				}
			}
		});
	});

	$("#prs").click(function() {
		$("#pnom").html('');
		$("#ppos").html('');
		$("#bnom").slideUp('slow');
		$("#psub").attr('disabled', true);
	});

	$("#pcnl").click(function() {
		history.back(1);
	});

	//Nómina por Puntaje

	$("#seek3").click(function() {
		var ruk = $("#ruk3").val();
		var lmd = $("#llmd3").val();
		var anio = $("#nanio").val();

		$.ajax({
			type : 'post',
			url  : '../../../model/formularios/seeknompuntaje.php',
			data : "ruk="+ruk+"&lmd="+lmd+"&anio="+anio,

			beforeSend:function() {
				$("#gbr").html('Buscando información...');
			},
			error:function() {
				$("#gbr").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {			

				if (ruk == "" || lmd == 0 || anio == 0) {
					$("#gbr").html('');
					$("#info").addClass('alert alert-warning');
					$("#info").html("<b>Los campos no deben ir vacíos</b>");
				}else {
					var datos = $.parseJSON(data);

					if (datos.pruk != null) {
						$("#gbr").html('');
						$("#bnom").slideDown('slow');
						$("#anom").html(datos.anom);
						$("#apos").html(datos.apos);
						$("#ppr").html(datos.ppr);
						$("#apr").html(datos.apr);
						if (datos.apos > 0) {
							$("#asub").removeAttr('disabled');
						}else{
							$("#asub").attr('disabled', true);
						}						
					}else {
						$("#gbr").html('');
						$("#info").addClass('alert alert-danger');
						$("#info").html("<b>El comité, el llamado o el año no se encuentran registrados en la base de datos</b>");
						$("#info").html(data);
					}
				}
			}
		});		
	});

	$("#ars").click(function() {
		$("#anom").html('');
		$("#apos").html('');
		$("#bnom").slideUp('slow');
		$("#asub").attr('disabled', true);
	});	

	$("#nbusc").click(function() {
		var x = $("#nruk").val();
		var y = $("#nlmd").val();
		var z = $("#nnanio").val();
		$.ajax({
			type : 'get',
			url  : '../../../model/formularios/listpostulantesnucleo.php',
			data : "cmt="+x+"&lmd="+y+"&anio="+z,
			beforeSend:function() {
				$("#gbr").html('Cargando listado...');
			},
			error:function(){
				$("#gbr").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (x=="" || y==0 || z==0) {
					$("#gbr").html('');
					$("#info").addClass("alert alert-warning");
					$("#info").html('<b>Los campos no pueden quedar vacíos</b>');
				}else{
					$("#gbr").html('');
					$("#nlist").load("../../../model/formularios/listpostulantesnucleo.php?cmt="+x+"&lmd="+y+"&anio="+z);	
				}				
			}
		});
	});

	$("#mbusc").click(function(){
		var x = $("#mruk").val();
		var y = $("#mlmd").val();
		var z = $("#manio").val();
		$.ajax({
			type : 'get',
			url  : '../../../model/formularios/listmandato.php',
			data : "cmt="+x+"&lmd="+y+"&anio="+z,
			beforeSend:function() {
				$("#gbr").html('Cargando listado...');
			},
			error:function(){
				$("#gbr").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (x=="" || y==0 || z==0) {
					$("#gbr").html('');
					$("#info").addClass("alert alert-warning");
					$("#info").html('<b>Los campos no pueden quedar vacíos</b>');
				}else{
					$("#gbr").html('');
					$("#mlist").load("../../../model/formularios/listmandato.php?cmt="+x+"&lmd="+y+"&anio="+z);	
				}				
			}
		});		
	});

	$("#tseek").click(function() {
		var x = $("#truk").val();
		var y = $("#tllmd").val();
		var z = $("#tanio").val();

		$.ajax({
			type : 'post',
			url  : '../../../model/formularios/seektipodeobra.php',
			data : "cmt="+x+"&lmd="+y+"&anio="+z,
			beforeSend:function() {
				$("#gbr").html('Buscando informacion...');
			},
			error:function() {
				$("#gbr").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (x=="" || y==0 || z==0) {
					$("#gbr").html('');
					$("#info").addClass("alert alert-warning");
					$("#info").html('<b>Los campos no pueden quedar vacíos</b>');
				}else {
					datos = $.parseJSON(data);

					if (datos.cmt != null) {
						$("#gbr").html('');
						$("#bnom").slideDown('slow');
						$("#cmt").html(datos.cmt);
						$("#nm").html(datos.nm);
						if (datos.nm > 0) {
							$("#tsub").removeAttr('disabled');
						}else {
							$("#tsub").attr('disabled', true);
						}						
					}else {
						$("#gbr").html('');
						$("#info").addClass('alert alert-danger');
						$("#info").html("<b>El comité, el llamado o el año no se encuentran registrados en la base de datos</b>");
					}
				}
			}
		});
	});

	$("#trs").click(function() {
		$("#cmt").html('');
		$("#nm").html('');
		$("#bnom").slideUp('slow');
		$("#tsub").attr('disabled', true);
	});

	$("#tcnl").click(function() {
		history.back(1);
	});

	$("#aseek").click(function() {
		var x = $("#aruk").val();
		var y = $("#allmd").val();
		var z = $("#aanio").val();

		$.ajax({
			type : 'post',
			url  : '../../../model/formularios/seekampliacion.php',
			data : "cmt="+x+"&lmd="+y+"&anio="+z,
			beforeSend:function() {
				$("#gbr").html('Buscando informacion...');
			},
			error:function() {
				$("#gbr").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (x=="" || y==0 || z==0) {
					$("#gbr").html('');
					$("#info").addClass("alert alert-warning");
					$("#info").html('<b>Los campos no pueden quedar vacíos</b>');
				}else {
					datos = $.parseJSON(data);

					if (datos.cmt != null) {
						$("#gbr").html('');
						$("#bnom").slideDown('slow');
						$("#cmt").html(datos.cmt);
						$("#nm").html(datos.nm);
						if (datos.nm > 0) {
							$("#asub").removeAttr('disabled');
						}else {
							$("#asub").attr('disabled', true);
						}						
					}else {
						$("#gbr").html('');
						$("#info").addClass('alert alert-danger');
						$("#info").html("<b>El comité, el llamado o el año no se encuentran registrados en la base de datos</b>");
					}
				}
			}
		});
	});

	$("#ars").click(function() {
		$("#cmt").html('');
		$("#nm").html('');
		$("#bnom").slideUp('slow');
		$("#tsub").attr('disabled', true);
	});

	$("#acnl").click(function() {
		history.back(1);
	});
});

function paginarListaNucleo(nro, cmt, lmd, anio) {
	var n = nro;
	var x = cmt;
	var y = lmd;
	var z = anio;
	var url = '../../../model/formularios/listpostulantesnucleo.php';
	$.ajax({
		type : 'get',
		url  : url,
		data : "cmt="+x+"&lmd="+y+"&anio="+z+"&pag="+n,
		success:function(data){
			$("#gbr").html('');
			$("#nlist").load(url+"?cmt="+x+"&lmd="+y+"&anio="+z+"&pag="+n);
		}
	});
}

function paginarListaMandato(nro, cmt, lmd, anio) {
	var n = nro;
	var x = cmt;
	var y = lmd;
	var z = anio;
	var url = '../../../model/formularios/listmandato.php';
	$.ajax({
		type : 'get',
		url  : url,
		data : "cmt="+x+"&lmd="+y+"&anio="+z+"&pag="+n,
		success:function(data) {
			$("#gbr").html('');
			$("#mlist").load(url+"?cmt="+x+"&lmd="+y+"&anio="+z+"&pag="+n);
		}
	});
}