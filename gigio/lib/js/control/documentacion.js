/* Controlador Documentacion. */
$(document).ready(function() {

	/* Cierra alertas */
	$("#alert-id").click(function() {		
		$(this).removeClass('alert alert-success').html('');
	});	

	$("#alert-id").click(function() {		
		$(this).removeClass('alert alert-danger').html('');
	});

	$("#upload").click(function() {
		$(".upload").slideDown('slow');
	});

	$("#cn").click(function() {
		$(".upload").slideUp('slow');
	});

	/* Activar o desactivar botones de borrado */
	$("#elim").change(function() {
		if ($(this).is(':checked')) {
			$(".elim").fadeIn('slow');
		} else {
			$(".elim").fadeOut('slow');
		}
	});
	

	/* Crear Directorio */
	$("#creaDirectorio").on('click', '#gdir', function() {

		var dir = $("#dir").val();
		$.ajax({
			type : 'post',
			url  : '../../model/documentacion/insdir.php',
			data : "dir="+dir,

			beforeSend:function() {
				$("#modal-msg").html('Creando Directorio...');
			},
			error:function() {
				$("#modal-msg").html('');
				alert('Ocurrio un error');
			},
			success:function(data) {
				$("#modal-msg").html('');
				if (data == 1) { 
					$("#gdir").modal('hide');					
					location.reload();					
				}else if (data == 2){
					$("#modal-msg").html("Debe ingresar un nombre");					
				}else {
					$("#modal-msg").html("Ocurrio un error al crear el directorio");					
				}
			}
		});
	});

	/* Crea subdirectorio */
	$("#creaDirectorio2").on('click', '#gdir', function() {

		var dir = $("#dir").val();
		var pnt = $("#pnt").val();

		$.ajax({
			type : 'post',
			url  : '../../model/documentacion/insdir2.php',
			data : "dir="+dir+"&pnt="+pnt,

			beforeSend:function() {
				$("#modal-msg").html('Creando Directorio...');
			},
			error:function() {
				$("#modal-msg").html('');
				alert('Ocurrio un error');
			},
			success:function(data) {
				$("#modal-msg").html('');
				if (data == 1) { 
					$("#gdir").modal('hide');					
					location.reload();					
				}else if (data == 2){
					$("#modal-msg").html("Debe ingresar un nombre");					
				}else {
					$("#modal-msg").html("Ocurrio un error al crear el directorio");					
				}
			}
		});
	});
	$("#upd").click(subeArchivos);
});

/* funcion para subir archivos. */
function subeArchivos() {
	var id  = $("#id").val(); //Valor del de id		
	var doc = document.getElementById('f'); //Se obtiene la id del campo para archivos
	var f   = doc.files; //se guardan los datos del o los archivos //

	/*  Se crea un objeto del tipo form data */
	var archivos = new FormData(); 

	/* Se guardan los archivos por el nombre mediante un ciclo */
	for (var i = 0; i < f.length; i++) {
		archivos.append('f'+i, f[i]);
	}

	/* Se crea el objeto ajax */	
	$.ajax({
		type : 'post',
		url  : '../../model/documentacion/uploaddoc.php?id='+id, // esta id se recibe como get en el archivo de procesos
		contentType : false,
		data : archivos,
		processData: false,
		cache : false,

		beforeSend:function() {
			$("#alert-id").removeClass('alert alert-success').html('Subiendo Archivos...');
		},
		error:function() {
			$("#alert-id").html('');
			alert("Ocurrió un error");
		},
		success:function(data) {
			if(data == "") {
				$("#alert-id").addClass('alert alert-warning').html("No ha subido ningun archivo");
			}else {
				$("#alert-id").addClass('alert alert-success').html(data);
				$("#archivos").load('../../model/documentacion/listdoc.php?id='+id);
				$("#f").val('');
			}
		}
	});
	
}

function borrarArchivos(id, nom, x) {
	var id = id;
	var nom = nom;
	var nid  = x;
	var c = "Desea borrar el archivo?";

	if (confirm(c)) {

		$.ajax({
			type :'post',
			url  : '../../model/documentacion/deletarchivo.php',
			data : "id="+id+"&nom="+nom,

			beforeSend:function() {
				$("#alert-id").removeClass('alert alert-success').html('Eliminando...');
			},
			error:function() {
				$("#alert-id").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (data == 1) {
					$("#alert-id").addClass('alert alert-success').html("<b>Archivo borrado exitosamente");
					$("#archivos").load('../../model/documentacion/listdoc.php?id='+id);					
				}else {
					//$("#alert-id").addClass('alert alert-danger').html("<b>Ocurrió un error en la transacción</b>");
					$("#alert-id").addClass('alert alert-danger').html(data);
				}
			}
		});	
	}

}

function listdoc(nro,id) {
	var num = nro;
	var id = id;
	var url = '../../model/documentacion/listdoc.php';
	var cadena = "id="+id+"&pag="+num;
	$.ajax({
		type : 'get',
		url  : url,
		data : cadena,
		success:function(data) {
			$("#archivos").load(url+'?'+cadena);
		}
	});
}

function borraDirVacio(id) {
	var id = id;
	var c = "Desea borrar este directorio?";
	if (confirm(c)) {
		$.ajax({
			type : 'post',
			url  : '../../model/documentacion/deldir.php',
			data : "id="+id,
			success: function(data) {
				if (data == 1) {
					$("#alert-id").addClass('alert alert-success')
					.html("<b>Directorio Borrado exitosamente</b>");
					location.reload();
				} else if (data == 2) {
					$("#alert-id").addClass('alert alert-danger')
					.html("<b>El directorio no puede ser eliminado, porque contiene archivos</b>");
				} else if (data == 3) {
					$("#alert-id").addClass('alert alert-danger')
					.html("<b>Este directorio no existe o ya ha sido removido</b>");
				} else {
					$("#alert-id").addClass('alert alert-danger')
					.html("<b>Ocurrio un error al eliminar</b>");
				}
			}
		});
	}
}