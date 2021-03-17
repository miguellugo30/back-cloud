/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**********************************!*\
  !*** ./resources/js/empresas.js ***!
  \**********************************/
$(function () {
  var currentURL = window.location.href;
  var newUrl = currentURL.replace('home', 'empresas');
  $(document).on("click", ".empresas", function (e) {
    e.preventDefault();
    $.get(newUrl, function (data, textStatus, jqXHR) {
      $(".container-fluid h1").text('Empresas');
      $(".content ").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newEmpresa", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Empresa');
    $('#action').removeClass('updateEmpresa');
    $('#action').addClass('saveEmpresa');
    var url = newUrl + '/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveEmpresa', function (event) {
    event.preventDefault();
    var razon_social = $("#razon_social").val();
    var intercompania = $("#intercompania").val();
    var no_respaldos = $("#no_respaldos").val();
    var dia_mes = $("#dia_mes").val();
    var dia_semana = $("#dia_semana").val();

    var _token = $("input[name=_token]").val();

    if ($('#fin_mes').prop('checked')) {
      fin_mes = 1;
    } else {
      fin_mes = 0;
    }

    $.post(newUrl, {
      razon_social: razon_social,
      intercompania: intercompania,
      no_respaldos: no_respaldos,
      dia_mes: dia_mes,
      dia_semana: dia_semana,
      fin_mes: fin_mes,
      _token: _token
    }, function (data, textStatus, xhr) {
      $(".content ").html(data);
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el formulario de edicion de un canal
   */

  $(document).on("click", ".editEmpresa", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Empresa');
    $('#action').removeClass('saveEmpresa');
    $('#action').addClass('updateEmpresa');
    var id = $("#idSeleccionado").val();
    var url = newUrl + "/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario editar modulo
   */

  $(document).on('click', '#table-empresas tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editEmpresa").slideDown();
    $(".deleteEmpresa").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-empresas tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateEmpresa', function (event) {
    event.preventDefault();
    var razon_social = $("#razon_social").val();
    var intercompania = $("#intercompania").val();
    var no_respaldos = $("#no_respaldos").val();
    var dia_mes = $("#dia_mes").val();
    var dia_semana = $("#dia_semana").val();
    var id = $("#idSeleccionado").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = newUrl + "/" + id;

    if ($('#fin_mes').prop('checked')) {
      fin_mes = 1;
    } else {
      fin_mes = 0;
    }

    $.ajax({
      url: url,
      type: 'POST',
      data: {
        razon_social: razon_social,
        intercompania: intercompania,
        no_respaldos: no_respaldos,
        dia_mes: dia_mes,
        dia_semana: dia_semana,
        fin_mes: fin_mes,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $(".content ").html(result);
      }
    }).done(function (data) {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido actualizado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para eliminar el modulo
   */

  $(document).on('click', '.deleteEmpresa', function (event) {
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
    }).then(function (result) {
      if (result.value) {
        var id = $("#idSeleccionado").val();

        var _token = $("input[name=_token]").val();

        var _method = "DELETE";
        var url = newUrl + "/" + id;
        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: _token,
            _method: _method
          },
          success: function success(result) {
            $(".content ").html(result);
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
      }
    });
  });
  /**
   * Evento para mostrar los permisos por menu
   */

  $(document).on('click', '.modulo', function () {
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
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**********************************!*\
  !*** ./resources/js/usuarios.js ***!
  \**********************************/
$(function () {
  var currentURL = window.location.href;
  var newUrl = currentURL.replace('home', 'usuarios');
  $(document).on("click", ".usuarios", function (e) {
    e.preventDefault();
    $.get(newUrl, function (data, textStatus, jqXHR) {
      $(".container-fluid h1").text('Usuarios');
      $(".content ").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newUsuario", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Usuario');
    $('#action').removeClass('updateUsuario');
    $('#action').addClass('saveUsuario');
    var url = newUrl + '/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para mostrar los permisos de la empresa seleccionada
   */

  $(document).on("change", "#empresa", function (e) {
    e.preventDefault();
    $('.permisos_empresas').slideUp();
    $(".views_empresas").prop("checked", false);
    var empresa_id = $(this).val();
    $(".view_empresa_" + empresa_id).prop("checked", true);
    $("#permisos_empresa_" + empresa_id).slideDown();
  });
  /**
   * Evento para mostrar los permisos de empresas y usuarios
   */

  $(document).on('click', '.permisos_config', function () {
    var id = $(this).data("value");

    if ($(this).prop('checked')) {
      $(".permisos_config_" + id).slideDown();
    } else {
      $(".permisos_config_" + id).slideUp();
    }
  });
  /**
   * Evento para mostrar los permisos por empresa
   */

  $(document).on('click', '.views_empresas', function () {
    var id = $(this).data("value");

    if ($(this).prop('checked')) {
      $("#permisos_empresa_" + id).slideDown();
    } else {
      $("#permisos_empresa_" + id).slideUp();
    }
  });
  /**
   * Evento para mostrar los permisos con base al rol selecionado
   */

  $(document).on("change", "#rol", function (e) {
    e.preventDefault();

    if ($(this).val() == '3') {
      $(".permisos_config").slideUp();
    } else {
      $(".permisos_config").slideDown();
    }
  });
  /**
   * Evento para guardar el nuevo usuario
   */

  $(document).on('click', '.saveUsuario', function (event) {
    event.preventDefault();
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var password_confirmation = $("#password_confirmation").val();
    var rol = $("#rol").val();
    var arr = $('[name="permisos[]"]:checked').map(function () {
      return this.value;
    }).get();

    var _token = $("input[name=_token]").val();

    $.post(newUrl, {
      name: name,
      email: email,
      password: password,
      password_confirmation: password_confirmation,
      rol: rol,
      arr: arr,
      _token: _token
    }, function (data, textStatus, xhr) {
      $(".content ").html(data);
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el formulario editar
   */

  $(document).on('click', '#table-usuarios tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editUsuario").slideDown();
    $(".deleteUsuario").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-usuarios tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para mostrar el formulario de edicion
   */

  $(document).on("click", ".editUsuario", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Usuario');
    $('#action').removeClass('saveUsuario');
    $('#action').addClass('updateUsuario');
    var id = $("#idSeleccionado").val();
    var url = newUrl + "/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateUsuario', function (event) {
    event.preventDefault();
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var password_confirmation = $("#password_confirmation").val();
    var rol = $("#rol").val();
    var arr = $('[name="permisos[]"]:checked').map(function () {
      return this.value;
    }).get();
    var id = $("#idSeleccionado").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = newUrl + '/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        name: name,
        email: email,
        password: password,
        password_confirmation: password_confirmation,
        rol: rol,
        arr: arr,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $(".content ").html(result);
        console.log(result);
      }
    }).done(function (data) {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido actualizado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para eliminar el modulo
   */

  $(document).on('click', '.deleteUsuario', function (event) {
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
    }).then(function (result) {
      if (result.value) {
        var id = $("#idSeleccionado").val();

        var _token = $("input[name=_token]").val();

        var _method = "DELETE";
        var url = newUrl + "/" + id;
        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: _token,
            _method: _method
          },
          success: function success(result) {
            $(".content ").html(result);
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
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
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!******************************************!*\
  !*** ./resources/js/acciones_empresa.js ***!
  \******************************************/
$(function () {
  var currentURL = window.location.href;
  $(document).on("click", ".menu_empresas", function (e) {
    e.preventDefault();
    var id = $(this).data('empresa_id');
    var text = $(this).data('empresa_nombre');
    var ruta = $(this).data('empresa_ruta');

    var _token = $("input[name=_token]").val();

    $.post(currentURL + '/drive', {
      id: id,
      ruta: ruta,
      _token: _token
    }, function (data, textStatus, xhr) {
      $(".content ").html(data);
      $(".container-fluid h1").text(text);
    });
  });
  /**
   * Evento para crear un nuevo directorio
   */

  $(document).on("click", "#makeDirectory", function (e) {
    e.preventDefault();
    Swal.fire({
      title: 'Nombre del nuevo directorio',
      input: 'text',
      inputAttributes: {
        autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonText: 'Crear',
      cancelButtonText: 'Cancelar'
    }).then(function (result) {
      if (result.value == '') {
        Swal.fire('Espera!', 'Debes ingresar un nombre para el nuevo directorio.', 'error');
      } else {
        var id = $('#ruta').val();

        var _token = $("input[name=_token]").val();

        $.post(currentURL + '/drive/makeDirectory', {
          nombre: result.value,
          ruta: id,
          _token: _token
        }, function (data, textStatus, xhr) {
          $.post(currentURL + '/drive', {
            ruta: id,
            _token: _token
          }, function (data, textStatus, xhr) {
            $(".content ").html(data);
            $(".container-fluid h1").text('Empresas');
          });
        }).done(function () {
          Swal.fire('Muy bien!', 'Se ha creado el directorio correctamente.', 'success');
        }).fail(function (data) {
          printErrorMsg(data.responseJSON.errors);
        });
      }
    });
  });
  $(document).on("click", ".selectFile", function (e) {
    e.preventDefault();
    $(".selectFile").removeClass('bg-info');
    $(this).addClass('bg-info');
    var file = $(this).data('url');
    var type = $(this).data('type');
    $("#fileSelected").val(file);
    $("#fileSelectedType").val(type);

    if (type == 'file') {
      $("#downloadFile").slideDown();
      $("#deleteFile").slideDown();
    } else if (type == 'directory') {
      $("#downloadFile").slideUp();
      $("#deleteFile").slideDown();
    }
  });
  $(document).on("dblclick", ".selectFile", function (e) {
    e.preventDefault();
    var file = $(this).data('url');
    var type = $(this).data('type');

    var _token = $("input[name=_token]").val();

    $("#fileSelected").val(file);

    if (type == 'file') {
      $.post(currentURL + '/drive/viewFile', {
        file: file,
        _token: _token
      }, function (data, textStatus, xhr) {
        $('#modal').modal('show');
        $("#modal-body").html(data);
      });
    } else if (type == 'directory') {
      $.post(currentURL + '/drive', {
        ruta: file,
        _token: _token
      }, function (data, textStatus, xhr) {
        $(".content ").html(data);
        $(".container-fluid h1").text('Empresas');
      });
    }
  });
  $(document).on("click", "#deleteFile", function (e) {
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
    }).then(function (result) {
      if (result.value) {
        var file = $("#fileSelected").val();
        var type = $("#fileSelectedType").val();
        var ruta = $("#ruta").val();
        var _method = "DELETE";

        var _token = $("input[name=_token]").val();

        $.post(currentURL + '/drive/deleteFile', {
          file: file,
          type: type,
          _method: _method,
          _token: _token
        }, function (data, textStatus, xhr) {
          $.post(currentURL + '/drive', {
            ruta: ruta,
            _token: _token
          }, function (data, textStatus, xhr) {
            $(".content ").html(data);
            $(".container-fluid h1").text('Empresas');
          });
        }).done(function () {
          Swal.fire('Eliminado!', 'Se ha eliminado correctamente el archivo.', 'success');
        }).fail(function (data) {
          printErrorMsg(data.responseJSON.errors);
        });
      }
    });
  });
  $(document).on("click", "#downloadFile", function (e) {
    e.preventDefault();
    var file = $("#fileSelected").val();

    var _token = $("input[name=_token]").val();

    $("#fileSelected").val(file);
    var archivo = file.split('/');
    $.ajax({
      type: 'post',
      url: currentURL + '/drive/downloadFile',
      data: {
        file: file,
        _token: _token
      },
      xhrFields: {
        responseType: 'blob'
      },
      success: function success(response) {
        var blob = new Blob([response]);
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = archivo[1];
        link.click();
      },
      error: function error(blob) {
        console.log(blob);
      }
    });
  });
  $(document).on("click", "#uploadFile", function (e) {
    e.preventDefault();
    $('#modalUploadFile #tituloModal').html('Subir Archivo');
    $('#modalUploadFile').modal({
      backdrop: 'static',
      keyboard: false,
      'show': true
    });
  });
  $(document).on("click", "#actionUploadFile", function (e) {
    e.preventDefault();
    var formData = new FormData();

    for (var index = 0; index < document.getElementById('newFiles').files.length; index++) {
      formData.append("files[]", document.getElementById('newFiles').files[index]);
    }

    var ruta = $("#ruta").val();

    var _token = $("input[name=_token]").val();

    formData.append("ruta", ruta);
    formData.append("_token", _token);
    $.ajax({
      url: currentURL + '/drive/upload/file',
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function (data) {
      //$(".content ").html(data);
      $.post(currentURL + '/drive', {
        ruta: ruta,
        _token: _token
      }, function (data, textStatus, xhr) {
        $(".content ").html(data);
        $(".container-fluid h1").text('Empresas');
      });
      $('.modal-backdrop ').css('display', 'none');
      $('#modalUploadFile').modal('hide');
      $('.viewResult').html(data);
      Swal.fire('Correcto!', 'Archivo(s) subidos correctamente.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  $(document).on("change", "#newFiles", function (e) {
    var files = document.getElementById('newFiles').files;

    for (var i = 0; i < files.length; i++) {
      var size = humanFileSize(files[i]['size'], true);
      var data = size.split(" ");

      if (data[1] == 'MB' && data[1] > '30') {
        $("#mensajeList").html('Los archivos marcados en rojo, no sera cargados');
        $("#listFiles").append('<li class="list-group-item d-flex justify-content-between align-items-center list-group-item-danger">' + files[i]['name'] + '<span class="badge badge-primary badge-pill">' + humanFileSize(files[i]['size'], true) + '</span></li>');
      } else {
        $("#listFiles").append('<li class="list-group-item d-flex justify-content-between align-items-center">' + files[i]['name'] + '<span class="badge badge-primary badge-pill">' + humanFileSize(files[i]['size'], true) + '</span></li>');
      }
    }
  });
  $(document).on("click", ".return", function (e) {
    var ruta = $(this).data('url_return');

    var _token = $("input[name=_token]").val();

    $.post(currentURL + '/drive', {
      ruta: ruta,
      _token: _token
    }, function (data, textStatus, xhr) {
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


  function humanFileSize(bytes) {
    var si = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var dp = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;
    var thresh = si ? 1000 : 1024;

    if (Math.abs(bytes) < thresh) {
      return bytes + ' B';
    }

    var units = si ? ['KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
    var u = -1;
    var r = Math.pow(10, dp);

    do {
      bytes /= thresh;
      ++u;
    } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);

    return bytes.toFixed(dp) + ' ' + units[u];
  }
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!************************************!*\
  !*** ./resources/js/conexiones.js ***!
  \************************************/
$(function () {
  var currentURL = window.location.href;
  var newUrl = currentURL.replace('home', 'conexiones');
  $(document).on("click", ".conexiones", function (e) {
    e.preventDefault();
    $.get(newUrl, function (data, textStatus, jqXHR) {
      $(".container-fluid h1").text('Conexiones');
      $(".content ").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newConexion", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Conexion');
    $('#action').removeClass('updateConexion');
    $('#action').addClass('saveConexion');
    var url = newUrl + '/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveConexion', function (event) {
    event.preventDefault();
    var empresa = $("#empresa").val();
    var ruta = $("#ruta").val();
    var host_principal = $("#host_principal").val();
    var puerto_principal = $("#puerto_principal").val();
    var usuario_principal = $("#usuario_principal").val();
    var contrasena_principal = $("#contrasena_principal").val();
    var host_secundario = $("#host_secundario").val();
    var puerto_secundario = $("#puerto_secundario").val();
    var usuario_secundario = $("#usuario_secundario").val();
    var contrasena_secundario = $("#contrasena_secundario").val();

    var _token = $("input[name=_token]").val();

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
    }, function (data, textStatus, xhr) {
      $(".content ").html(data);
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el formulario editar modulo
   */

  $(document).on('click', '#table-conexiones tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editConexion").slideDown();
    $(".deleteConexion").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-conexiones tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para mostrar el formulario de edicion de un canal
   */

  $(document).on("click", ".editConexion", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Conexion');
    $('#action').removeClass('saveConexion');
    $('#action').addClass('updateConexion');
    var id = $("#idSeleccionado").val();
    var url = newUrl + "/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateConexion', function (event) {
    event.preventDefault();
    var ruta = $("#ruta").val();
    var host_principal = $("#host_principal").val();
    var puerto_principal = $("#puerto_principal").val();
    var usuario_principal = $("#usuario_principal").val();
    var contrasena_principal = $("#contrasena_principal").val();
    var id = $("#idSeleccionado").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = newUrl + "/" + id;
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
      success: function success(result) {
        $(".content ").html(result);
      }
    }).done(function (data) {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido actualizado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para eliminar el modulo
   */

  $(document).on('click', '.deleteConexion', function (event) {
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
    }).then(function (result) {
      if (result.value) {
        var id = $("#idSeleccionado").val();

        var _token = $("input[name=_token]").val();

        var _method = "DELETE";
        var url = newUrl + "/" + id;
        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: _token,
            _method: _method
          },
          success: function success(result) {
            $(".content ").html(result);
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
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
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!****************************************!*\
  !*** ./resources/js/logactividades.js ***!
  \****************************************/
$(function () {
  var currentURL = window.location.href;
  var newUrl = currentURL.replace('home', 'log-actividades');
  $(document).on("click", ".logs", function (e) {
    e.preventDefault();
    $.get(newUrl, function (data, textStatus, jqXHR) {
      $(".container-fluid h1").text('Log Actividades');
      $(".content ").html(data);
    });
  });
});
})();

/******/ })()
;