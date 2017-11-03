
/* Controlador Modulo Obras */
$(document).ready(function() {
	
	// Despliega la lista de comites
	$("#listcomite").load('../../model/obras/listcomiteobras.php');

	// Cierra alerta ok
	$("#alerta").click(function () {
		$(this).removeClass('alert alert-success').html('');
	});

	//Cierra alerta error
	$("#alerta").click(function () {
		$(this).removeClass('alert alert-danger').html('');
	});

	// Cierra alerta warning
	$("#alerta").click(function () {
		$(this).removeClass('alert alert-warning').html('');
	});

	//Subir archivos.
	$("#updoc").click(subeArchivos);

	//Cancelar
	$("#can").click(function() {
		location.href = '../../view/obras/';
	});


	

});

function subeArchivos() {
	var id  = $("#id").val(); //Valor del de id	
	var nid = $("#nid").val();
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
		url  : '../../model/obras/uploaddoc.php?id='+id,
		contentType : false,
		data : archivos,
		processData: false,
		cache : false,

		beforeSend:function() {
			$("#alerta").html('Subiendo Archivos...');
		},
		error:function() {
			$("#alerta").html('');
			alert("Ocurrió un error");
		},
		success:function(data) {
			if(data == "") {
				$("#alerta").addClass('alert alert-warning').html("No ha subido ningun archivo");
			}else {
				$("#alerta").addClass('alert alert-success').html(data);
				$("#ldoc").load('../../model/obras/listdoc.php?id='+nid);
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
			url  : '../../model/obras/deletarchivo.php',
			data : "id="+id+"&nom="+nom,

			beforeSend:function() {
				$("#alerta").html('Eliminando...');
			},
			error:function() {
				$("#alerta").html('');
				alert("Ocurrio un error");
			},
			success:function(data) {
				if (data == 1) {
					$("#alerta").addClass('alert alert-success').html("<b>Archivo borrado exitosamente");
					$("#ldoc").load('../../model/obras/listdoc.php?id='+nid);					
				}else {
					$("#alerta").addClass('alert alert-danger').html("<b>Ocurrió un error en la transacción</b>");
					
				}
			}
		});	
	}

}

function listdoc(nro,id) {
	var num = nro;
	var id = id;
	var url = '../../model/obras/listdoc.php';
	var cadena = "id="+id+"&pag="+num;
	$.ajax({
		type : 'get',
		url  : url,
		data : cadena,
		success:function(data) {
			$("#ldoc").load(url+'?'+cadena);
		}
	});
}

