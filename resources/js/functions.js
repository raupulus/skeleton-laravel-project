/**
 * Función que toma el atributo "data-route" del elemento al que
 * se asignó esta función como evento y redirige a esa url.
 */
function goToUrlData() {
    var route = $(this).attr('data-route');

    window.location.href = route;
}
