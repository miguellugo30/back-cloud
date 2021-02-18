$(function() {

    var currentURL = window.location.href;
    var newUrl = currentURL.replace('home', 'log-actividades');

    $(document).on("click", ".logs", function(e) {
        e.preventDefault();

        $.get(newUrl, function(data, textStatus, jqXHR) {

            $(".container-fluid h1").text('Log Actividades');

            $(".content ").html(data);
        });
    });

});
