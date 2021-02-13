$(function() {

    var currentURL = window.location.href;

    $(document).on("click", ".menu_empresas", function(e) {
        e.preventDefault();

        let id = $(this).data('empresa_id');
        let text = $(this).data('empresa_nombre');

        let _token = $("input[name=_token]").val();

        $.post(currentURL+'/drive', {
            ruta: id,
            _token: _token
        }, function(data, textStatus, xhr) {

            $(".content ").html(data);
            $(".container-fluid h1").text(text);

        });
    });
    /**
     * Evento para crear un nuevo directorio
     */
    $(document).on("click", "#makeDirectory", function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Nombre del nuevo directorio',
            input: 'text',
            inputAttributes: {
              autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Crear',
            cancelButtonText: 'Cancelar',
        }).then((result) => {

            if ( result.value == '' ) {

                Swal.fire(
                    'Espera!',
                    'Debes ingresar un nombre para el nuevo directorio.',
                    'error'
                )

            } else {

                let id = $('#ruta').val();
                let _token = $("input[name=_token]").val();

                $.post(currentURL+'/drive/makeDirectory', {
                    nombre: result.value,
                    ruta: id,
                    _token: _token
                }, function(data, textStatus, xhr) {

                    $.post(currentURL+'/drive', {
                        ruta: id,
                        _token: _token
                    }, function(data, textStatus, xhr) {

                        $(".content ").html(data);
                        $(".container-fluid h1").text('Empresas');

                    });

                }).done(function() {
                    Swal.fire(
                        'Muy bien!',
                        'Se ha creado el directorio correctamente.',
                        'success'
                    )
                }).fail(function(data) {
                    printErrorMsg(data.responseJSON.errors);
                });
            }

        });
    });

    $(document).on("click", ".selectFile", function(e) {
        e.preventDefault();

        $(".selectFile").removeClass('bg-info');
        $(this).addClass('bg-info');
        let file = $(this).data('url');
        let type = $(this).data('type');

        $("#fileSelected").val(file);
        $("#fileSelectedType").val(type);

        if (type == 'file') {
            $("#downloadFile").slideDown();
            $("#deleteFile").slideDown();
        } else if( type == 'directory' ) {
            $("#downloadFile").slideUp();
            $("#deleteFile").slideDown();
        }
    });

    $(document).on("dblclick", ".selectFile", function(e) {
        e.preventDefault();

        let file = $(this).data('url');
        let type = $(this).data('type');
        let _token = $("input[name=_token]").val();
        $("#fileSelected").val(file);

        if (type == 'file') {
            $.post(currentURL+'/drive/viewFile', {
                file: file,
                _token: _token
            }, function(data, textStatus, xhr) {

                $('#modal').modal('show');
                $("#modal-body").html(data);
            });
        } else if( type == 'directory' ){
            $.post(currentURL+'/drive', {
                ruta: file,
                _token: _token
            }, function(data, textStatus, xhr) {

                $(".content ").html(data);
                $(".container-fluid h1").text('Empresas');

            });
        }


    });

    $(document).on("click", "#deleteFile", function(e) {
        e.preventDefault();

        Swal.fire({
            title: '¿Estas seguro?',
            text: "Deseas eliminar el archivo seleccionado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, deseo eliminarlo!',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.value) {

                let file = $("#fileSelected").val();
                let type = $("#fileSelectedType").val();
                let ruta = $("#ruta").val();

                let _method = "DELETE";
                let _token = $("input[name=_token]").val();

                $.post(currentURL+'/drive/deleteFile', {
                    file: file,
                    type: type,
                    _method: _method,
                    _token: _token
                }, function(data, textStatus, xhr) {

                    $.post(currentURL+'/drive', {
                        ruta: ruta,
                        _token: _token
                    }, function(data, textStatus, xhr) {

                        $(".content ").html(data);
                        $(".container-fluid h1").text('Empresas');

                    });

                }).done(function() {
                    Swal.fire(
                        'Eliminado!',
                        'Se ha eliminado correctamente el archivo.',
                        'success'
                    )
                }).fail(function(data) {
                    printErrorMsg(data.responseJSON.errors);
                });


            }
        })

    });

    $(document).on("click", "#downloadFile", function(e) {
        e.preventDefault();

        let file = $("#fileSelected").val();
        let _token = $("input[name=_token]").val();
        $("#fileSelected").val(file);
        let archivo = file.split('/');

        $.ajax({

            type: 'post',
            url: currentURL+'/drive/downloadFile',
            data: {
                file: file,
                _token: _token
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response){

                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = archivo[1];
                link.click();
            },

            error: function(blob){
                console.log(blob);
            }

        });
    });

    $(document).on("click", "#uploadFile", function(e) {
        e.preventDefault();
        $('#modalUploadFile #tituloModal').html('Subir Archivo');
        $('#modalUploadFile').modal({backdrop: 'static', keyboard: false, 'show': true});
    });

    $(document).on("click", "#actionUploadFile", function(e) {
        e.preventDefault();

        let formData = new FormData();
        for (var index = 0; index < document.getElementById('newFiles').files.length; index++) {
            formData.append("files[]", document.getElementById('newFiles').files[index]);
        }
        let ruta = $("#ruta").val();
        let _token = $("input[name=_token]").val();

        formData.append("ruta", ruta);
        formData.append("_token", _token);

        $.ajax({
            url: currentURL + '/drive/upload/file',
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        })
        .done(function(data) {
            //$(".content ").html(data);

            $.post(currentURL+'/drive', {
                ruta: ruta,
                _token: _token
            }, function(data, textStatus, xhr) {

                $(".content ").html(data);
                $(".container-fluid h1").text('Empresas');

            });

            $('.modal-backdrop ').css('display', 'none');
            $('#modalUploadFile').modal('hide');

            $('.viewResult').html(data);
            Swal.fire(
                'Correcto!',
                'Archivo(s) subidos correctamente.',
                'success'
            )

        }).fail(function(data) {
            printErrorMsg(data.responseJSON.errors);
        });
    });

    $(document).on("change", "#newFiles", function(e) {

        var files = document.getElementById('newFiles').files;

        for (let i = 0; i < files.length; i++) {

            var size = humanFileSize(files[i]['size'],true);

            var data = size.split(" ");

            if ( data[1] == 'MB' && data[1] > '30' ) {
                $("#mensajeList").html('Los archivos marcados en rojo, no sera cargados');
                $("#listFiles").append(
                    '<li class="list-group-item d-flex justify-content-between align-items-center list-group-item-danger">'
                    + files[i]['name'] +
                    '<span class="badge badge-primary badge-pill">'
                    + humanFileSize(files[i]['size'],true) +
                    '</span></li>'
                );
            } else {
                $("#listFiles").append(
                    '<li class="list-group-item d-flex justify-content-between align-items-center">'
                    + files[i]['name'] +
                    '<span class="badge badge-primary badge-pill">'
                    + humanFileSize(files[i]['size'],true) +
                    '</span></li>'
                );
            }
        }
    });

    $(document).on("click", ".return", function(e) {

        let ruta = $(this).data('url_return');
        let _token = $("input[name=_token]").val();

        $.post(currentURL+'/drive', {
            ruta: ruta,
            _token: _token
        }, function(data, textStatus, xhr) {

            $(".content ").html(data);
            $(".container-fluid h1").text('Empresas');

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
    /**
     * Funcion para convertir bytes
     */
    function humanFileSize(bytes, si=false, dp=1) {
        const thresh = si ? 1000 : 1024;

        if (Math.abs(bytes) < thresh) {
          return bytes + ' B';
        }

        const units = si
          ? ['KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
          : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
        let u = -1;
        const r = 10**dp;

        do {
          bytes /= thresh;
          ++u;
        } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);


        return bytes.toFixed(dp) + ' ' + units[u];
      }
});
