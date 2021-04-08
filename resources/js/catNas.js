$(function() {

    var currentURL = window.location.href;
    var newUrl = currentURL.replace('home', 'cat-nas');

    $(document).on("click", ".nas", function(e) {
        e.preventDefault();

        $.get(newUrl, function(data, textStatus, jqXHR) {

            $(".container-fluid h1").text('Nas');

            $(".content ").html(data);
        });
    });

    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
     $(document).on("click", ".newNas", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Nas');
        $('#action').removeClass('updateNas');
        $('#action').addClass('saveNas');

        let url = newUrl + '/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
     $(document).on('click', '.saveNas', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let ruta = $("#ruta").val();
        let _token = $("input[name=_token]").val();

        $.post(newUrl, {
            nombre: nombre,
            ruta: ruta,
            _token: _token
        }, function(data, textStatus, xhr) {

            $(".content ").html(data);
        }).done(function() {
            $('.modal-backdrop ').css('display', 'none');
            $('#modal').modal('hide');
            Swal.fire(
                'Correcto!',
                'El registro ha sido guardado.',
                'success'
            )
        }).fail(function(data) {
            printErrorMsg(data.responseJSON.errors);
        });
    });
    /**
     * Evento para mostrar el formulario editar modulo
     */
     $(document).on('click', '#table-nas tbody tr', function(event) {
        event.preventDefault();

        let id = $(this).data("id");
        $(".editNas").slideDown();
        $(".deleteNas").slideDown();

        $("#idSeleccionado").val(id);

        $("#table-nas tbody tr").removeClass('table-primary');
        $(this).addClass('table-primary');
    });
    /**
     * Evento para mostrar el formulario de edicion de un canal
     */
     $(document).on("click", ".editNas", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Editar Nas');
        $('#action').removeClass('saveNas');
        $('#action').addClass('updateNas');

        let id = $("#idSeleccionado").val();

        let url = newUrl + "/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
     $(document).on('click', '.updateNas', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let ruta = $("#ruta").val();
        let id = $("#idSeleccionado").val();
        let _token = $("input[name=_token]").val();
        let _method = "PUT";

        $.post(newUrl+"/"+id, {
            nombre: nombre,
            ruta: ruta,
            _method:_method,
            _token: _token
        }, function(data, textStatus, xhr) {

            $(".content ").html(data);
        }).done(function() {
            $('.modal-backdrop ').css('display', 'none');
            $('#modal').modal('hide');
            Swal.fire(
                'Correcto!',
                'El registro ha sido edita.',
                'success'
            )
        }).fail(function(data) {
            printErrorMsg(data.responseJSON.errors);
        });
    });
    /**
     * Evento para eliminar el modulo
     */
     $(document).on('click', '.deleteNas', function(event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Deseas eliminar el registro seleccionado!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                let id = $("#idSeleccionado").val();
                let _token = $("input[name=_token]").val();
                let _method = "DELETE";
                let url = newUrl + "/" + id;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: _token,
                        _method: _method
                    },
                    success: function(result) {
                        $(".content ").html(result);
                        Swal.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        )
                    }
                });
            }
        });
    });
    /**
     * Funcion para mostrar los errores de los formularios
     */
     function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $(".form-control").removeClass('is-invalid');
        for (var clave in msg) {
            $("#" + clave).addClass('is-invalid');
            if (msg.hasOwnProperty(clave)) {
                $(".print-error-msg").find("ul").append('<li>' + msg[clave][0] + '</li>');
            }
        }
    }
});
