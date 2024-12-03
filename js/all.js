
$(document).ready(function () {
    $("#loading-container").hide();

    // Mostrar la alerta y ocultarla después de 5 segundos (5000 milisegundos)
    function showAlert(alertClass) {
        $(alertClass).fadeIn().delay(6000).fadeOut();
    }

    // // Ejemplo de cómo llamar a la función para cada tipo de alerta
    showAlert('.alert_Error');
    showAlert('.alert_Warning');
    showAlert('.alert_Success');
});
