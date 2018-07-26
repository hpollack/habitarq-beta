$(document).ready(function() {

    /* Al enfocar cualquier campo desaparecen los mensajes */
    $(".form-control").focus(function() {
        $(".error").html('');
    });

    /* Despliega datepicker */
    $(".f-date").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        setDate: new Date(),
        autoclose: true
    });


    //Remueve la alerta 
    $("#alerta").click(function() {
        $(this).removeClass('alert alert-success').html('');
    });

    //Mostrar calendario
    $("#calendario").load('../../model/calendario/calendario.php');

    $("#mes").datepicker({
        autoclose: true,
        format: 'mm-yyyy',
        minViewMode: 1,
        language: "es"
    });


    //Para cambiar el mes del calendario.
    $("#cm").click(function() {

        var mes = $("#mes").val();
        var url = '../../model/calendario/calendario.php';

        if (mes == "") {
            alert("debe incluir un mes");
        } else {
            $.ajax({
                type: 'get',
                url: url,
                data: "mes=" + mes,
                success: function(data) {
                    $("#calendario").load(url + '?mes=' + mes);
                }
            });
        }

    });

    //Botones atrás y adelante para cambiar el mes
    $("#calendario").on('click', '#iz', function(event) {
        event.preventDefault();
        /* Act on the event */
        var url = '../../model/calendario/calendario.php';
        var mes = $("#iz").data('id');
       
       $.ajax({
            type : 'get',
            url  : url,
            data : "mes="+mes,
            success:function(data) {
                $("#calendario").load(url + '?mes=' + mes);                
            }
        });

    });

    $("#calendario").on('click', '#de', function(event) {
        event.preventDefault();
        /* Act on the event */
        var url = '../../model/calendario/calendario.php';
        var mes = $("#de").data('id');
       
       $.ajax({
            type : 'get',
            url  : url,
            data : "mes="+mes,
            success:function(data) {
                $("#calendario").load(url + '?mes=' + mes);                
            }
        });

    });

    //Remueve alerta en modal de creacion de evento
    $("#agregaEventoCal").on('click', '#msg', function() {
        $("#msg").removeClass('alert alert-danger').html('');
    });

    //Insertar evento del calendario.
    $("#agregaEventoCal").on('click', '#agev', function() {
        if ($("#ev input").val() == "" && $("#cev").val() == "") {
            // Si vienen vacíos
            $("#msg").html('Los campos deben ser completados');
        } else {
            $.ajax({
                type: 'post',
                url: '../../model/calendario/meventos.php',
                data: $("#ev").serialize(),
                beforeSend: function() {
                    $("#msg").html('Ingresando Evento');
                },
                error: function() {
                    alert('Ocurrio un error');
                },
                success: function(data) {
                    if (data == 1) {
                        $("#ev input").val('');
                        $("#cev").val('');
                        $("#agregaEventoCal").modal('hide');
                        $("#calendario").load('../../model/calendario/calendario.php');
                        window.scroll(0, 1);
                        $("#alerta").addClass('alert alert-success').html('<b>Evento Creado</b>');
                    } else if (data == 2) {
                        window.scroll(0, 1);
                        $("#msg").addClass('alert alert-danger').html('<b>La fecha de inicio es mayor a la fecha final</b>');
                    } else {
                        window.scroll(0, 1);
                        $("#msg").addClass('alert alert-danger').html('<b>Ocurrió un error al grabar el evento</b>');
                    }
                }
            });
        }

    });

    //Limpia los campos-
    $("#agregaEventoCal").on('click', '#rev', function() {
        //$(".error").html('');
        $("#msg").html('');
        $("#ev input").val('');
        $("#cev").val('');
    });


    //Editar evento.
    $("#editaEventoCal").on('click', '#egev', function() {
        if ($("#ev input").val() == "" && $("#ecev").val() == "") {
            $("#msg").addClass('alert alert-warning').html('<b>Los campos no pueden quedar vacíos</b>');
        } else {
            var fev = $("#efev").val();
            var hev = $("#ehev").val();
            var ffv = $("#effv").val();
            var hfv = $("#ehfv").val();
            var tev = $("#etev").val();
            var cev = $("#ecev").val();

            //Id del evento.
            var id = $("#ide").val();

            $.ajax({
                type: 'post',
                url: '../../model/calendario/uevento.php',
                data: "fev=" + fev + "&hev=" + hev + "&ffv=" + ffv + "&hfv=" + hfv + "&tev=" + tev + "&cev=" + cev + "&id=" + id,
                beforeSend: function() {
                    $("#emsg").html('Actualizando informacion');
                },
                error: function() {
                    $("#emsg").html('');
                    alert("Ocurrio un error");
                },
                success: function(data) {
                    if (data == 1) {
                        $("#editaEventoCal").modal('hide');
                        $("#calendario").load('../../model/calendario/calendario.php');
                        window.scroll(0, 1);
                        $("#alerta").addClass('alert alert-success').html('<b>Evento Actualizado</b>');
                    } else if (data == 2) {
                        window.scroll(0, 1);
                        $("#emsg").addClass('alert alert-danger').html('<b>La fecha de inicio es mayor a la fecha final</b>');
                    } else {
                        window.scroll(0, 1);
                        $("#emsg").addClass('alert alert-danger').html('<b>Ocurrió un error al grabar el evento</b>');
                    }
                }

            });
        }
    });

    $("#editaEventoCal").on('click', '#emsg', function() {
        $("#emsg").removeClass('alert alert-danger').html('');
    });


    /* limpia los campos del calendario, excepto el id */
    $("#editaEventoCal").on('click', '#rev', function(event) {
        event.preventDefault();
        /* Act on the event */
        $("#ev input:text").val('');
        $("#ev input:time").val('');
        $("#ecev").val('');
    });

    /* Borra el evento del calendario */
    $("#editaEventoCal").on('click', '#bev', function() {
        var id = $("#ide").val();
        var c = "Desea eliminar el evento?";
        if (confirm(c)) {
            $.ajax({
                type: 'post',
                url: '../../model/calendario/devento.php',
                data: "id=" + id,
                beforeSend: function() {
                    $("#emsg").html('Eliminando evento');
                },
                error: function() {
                    $("#emsg").html('');
                    alert("Ocurrio un error");
                },
                success: function(data) {
                    if (data == 1) {
                        $("#emsg").html('');
                        $("#editaEventoCal").modal('hide');
                        $("#calendario").load('../../model/calendario/calendario.php');
                        $("#alerta").addClass('alert alert-success').html('<b>Evento Eliminado</b>');
                        window.scroll(0, 1);
                    } else {
                        $("#emsg").addClass('alert alert-danger').html('<b>Ocurrió un error</b>');
                    }
                }
            });
        }

    });


});

//Llama a ventana modal para edicion.
function editarEvento(x) {
    var id = x;
    var url = '../../view/calendario/evento.php';

    if (!id) {
        alert("No se pudo traer el elemento");
    } else {
        $("#editaEventoCal").load(url + "?id=" + id).modal('show');
    }
}