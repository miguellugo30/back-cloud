$(function() {

    var currentURL = window.location.href;
    var newUrl = currentURL.replace('home', 'empresas');

    $(document).on("click", ".empresas", function(e) {
        e.preventDefault();

        $.get(newUrl, function(data, textStatus, jqXHR) {

            $(".container-fluid h1").text('Empresas');

            $(".content ").html(data);
        });
    });
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newEmpresa", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Empresa');
        $('#action').removeClass('updateEmpresa');
        $('#action').addClass('saveEmpresa');

        let url = newUrl + '/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveEmpresa', function(event) {
        event.preventDefault();

        let razon_social = $("#razon_social").val();
        let intercompania = $("#intercompania").val();
        let url_respaldo = $("#url_respaldo").val();
        let no_respaldos = $("#no_respaldos").val();
        let dia_mes = $("#dia_mes").val();
        let dia_semana = $("#dia_semana").val();
        let _token = $("input[name=_token]").val();

        if( $('#fin_mes').prop('checked') ) {
            fin_mes = 1;
        }else{
            fin_mes = 0;
        }

        $.post(newUrl, {
            razon_social: razon_social,
            intercompania: intercompania,
            url_respaldo: url_respaldo,
            no_respaldos: no_respaldos,
            dia_mes: dia_mes,
            dia_semana: dia_semana,
            fin_mes: fin_mes,
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
     * Evento para mostrar el formulario de edicion de un canal
     */
    $(document).on("click", ".editEmpresa", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Editar Empresa');
        $('#action').removeClass('saveEmpresa');
        $('#action').addClass('updateEmpresa');

        let id = $("#idSeleccionado").val();

        let url = newUrl + "/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para mostrar el formulario editar modulo
     */
    $(document).on('click', '#table-empresas tbody tr', function(event) {
        event.preventDefault();

        let id = $(this).data("id");
        $(".editEmpresa").slideDown();
        $(".deleteEmpresa").slideDown();

        $("#idSeleccionado").val(id);

        $("#table-empresas tbody tr").removeClass('table-primary');
        $(this).addClass('table-primary');
    });
    /**
     * Evento para editar el modulo
     */
    $(document).on('click', '.updateEmpresa', function(event) {
        event.preventDefault();

        let razon_social = $("#razon_social").val();
        let intercompania = $("#intercompania").val();
        let url_respaldo = $("#url_respaldo").val();
        let no_respaldos = $("#no_respaldos").val();
        let dia_mes = $("#dia_mes").val();
        let dia_semana = $("#dia_semana").val();
        let id = $("#idSeleccionado").val();
        let _token = $("input[name=_token]").val();
        let _method = "PUT";
        let url = newUrl + "/" + id;

        if( $('#fin_mes').prop('checked') ) {
            fin_mes = 1;
        }else{
            fin_mes = 0;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                razon_social: razon_social,
                intercompania: intercompania,
                url_respaldo: url_respaldo,
                no_respaldos: no_respaldos,
                dia_mes: dia_mes,
                dia_semana: dia_semana,
                fin_mes: fin_mes,
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
    $(document).on('click', '.deleteEmpresa', function(event) {
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
     * Evento para mostrar los permisos por menu
     */
    $(document).on('click', '.modulo', function() {
        var id = $(this).data("value");
        if ($(this).prop('checked')) {
            $("#sub_cat_" + id).slideDown();
        } else {
            $("#sub_cat_" + id).slideUp();
        }
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
