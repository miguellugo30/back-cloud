/******/ (() => { // webpackBootstrap
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
    var rfc = $("#rfc").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();
    var colonia = $("#colonia").val();
    var municipio = $("#municipio").val();
    var cp = $("#cp").val();
    var telefono_1 = $("#telefono_1").val();
    var telefono_2 = $("#telefono_2").val();
    var sitio_web = $("#sitio_web").val();

    var _token = $("input[name=_token]").val();

    $.post(newUrl, {
      razon_social: razon_social,
      rfc: rfc,
      calle: calle,
      numero: numero,
      colonia: colonia,
      municipio: municipio,
      cp: cp,
      telefono_1: telefono_1,
      telefono_2: telefono_2,
      sitio_web: sitio_web,
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
    var rfc = $("#rfc").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();
    var colonia = $("#colonia").val();
    var municipio = $("#municipio").val();
    var cp = $("#cp").val();
    var telefono_1 = $("#telefono_1").val();
    var telefono_2 = $("#telefono_2").val();
    var sitio_web = $("#sitio_web").val();
    var id = $("#idSeleccionado").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = newUrl + "/" + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        razon_social: razon_social,
        rfc: rfc,
        calle: calle,
        numero: numero,
        colonia: colonia,
        municipio: municipio,
        cp: cp,
        telefono_1: telefono_1,
        telefono_2: telefono_2,
        sitio_web: sitio_web,
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
    var tel_movil = $("#tel_movil").val();
    var tel_fijo = $("#tel_fijo").val();
    var extension = $("#extension").val();
    var empresa = $("#empresa").val();
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
      tel_movil: tel_movil,
      tel_fijo: tel_fijo,
      extension: extension,
      empresa: empresa,
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
    var tel_movil = $("#tel_movil").val();
    var tel_fijo = $("#tel_fijo").val();
    var extension = $("#extension").val();
    var empresa = $("#empresa").val();
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
        tel_movil: tel_movil,
        tel_fijo: tel_fijo,
        extension: extension,
        empresa: empresa,
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

/******/ })()
;