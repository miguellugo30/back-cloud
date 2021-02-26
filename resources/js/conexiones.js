$(function() {

    var currentURL = window.location.href;
    var newUrl = currentURL.replace('home', 'conexiones');

    $(document).on("click", ".conexiones", function(e) {
        e.preventDefault();

        $.get(newUrl, function(data, textStatus, jqXHR) {

            $(".container-fluid h1").text('Conexiones');

            $(".content ").html(data);
        });
    });

    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newConexion", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Conexion');
        $('#action').removeClass('updateConexion');
        $('#action').addClass('saveConexion');

        let url = newUrl + '/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });

    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveConexion', function(event) {
        event.preventDefault();

        let empresa = $("#empresa").val();
        let ruta = $("#ruta").val();
        let host_principal = $("#host_principal").val();
        let puerto_principal = $("#puerto_principal").val();
        let usuario_principal = $("#usuario_principal").val();
        let contrasena_principal = $("#contrasena_principal").val();
        let host_secundario = $("#host_secundario").val();
        let puerto_secundario = $("#puerto_secundario").val();
        let usuario_secundario = $("#usuario_secundario").val();
        let contrasena_secundario = $("#contrasena_secundario").val();
        let _token = $("input[name=_token]").val();

        $.post(newUrl, {
            empresa: empresa,
            ruta: ruta,
            host_principal: host_principal,
            puerto_principal: puerto_principal,
            usuario_principal: usuario_principal,
            contrasena_principal: contrasena_principal,
            host_secundario: host_secundario,
            puerto_secundario: puerto_secundario,
            usuario_secundario: usuario_secundario,
            contrasena_secundario: contrasena_secundario,
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
    $(document).on('click', '#table-conexiones tbody tr', function(event) {
        event.preventDefault();

        let id = $(this).data("id");
        $(".editConexion").slideDown();
        $(".deleteConexion").slideDown();

        $("#idSeleccionado").val(id);

        $("#table-conexiones tbody tr").removeClass('table-primary');
        $(this).addClass('table-primary');
    });
    /**
     * Evento para mostrar el formulario de edicion de un canal
     */
    $(document).on("click", ".editConexion", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Editar Conexion');
        $('#action').removeClass('saveConexion');
        $('#action').addClass('updateConexion');

        let id = $("#idSeleccionado").val();

        let url = newUrl + "/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para editar el modulo
     */
    $(document).on('click', '.updateConexion', function(event) {
        event.preventDefault();

        let ruta = $("#ruta").val();
        let host_principal = $("#host_principal").val();
        let puerto_principal = $("#puerto_principal").val();
        let usuario_principal = $("#usuario_principal").val();
        let contrasena_principal = $("#contrasena_principal").val();
        let id = $("#idSeleccionado").val();
        let _token = $("input[name=_token]").val();
        let _method = "PUT";
        let url = newUrl + "/" + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                empresa: id,
                ruta: ruta,
                host_principal: host_principal,
                puerto_principal: puerto_principal,
                usuario_principal: usuario_principal,
                contrasena_principal: contrasena_principal,
                _token: _token,
                _method: _method
            },
            success: function(result) {
                $(".content ").html(result);
            }
        }).done(function(data) {
            $('.modal-backdrop ').css('display', 'none');
            $('#modal').modal('hide');
            Swal.fire(
                'Correcto!',
                'El registro ha sido actualizado.',
                'success'
            )
        }).fail(function(data) {
            printErrorMsg(data.responseJSON.errors);
        });
    });
    /**
     * Evento para eliminar el modulo
     */
    $(document).on('click', '.deleteConexion', function(event) {
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
