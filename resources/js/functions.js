/**
 * Función que toma el atributo "data-route" del elemento al que
 * se asignó esta función como evento y redirige a esa url.
 */
function goToUrlData() {
    var route = $(this).attr('data-route');

    window.location.href = route;
}

async function createDatatable(id, url, columns, options = {}) {
    let basic = {
        processing: true,
        serverSide: true,
        responsive: true,
        select: true,
        //dom: '<"toolbar">frtip', // Barra para añadir arriba
        ajax: url,
        columns: columns,
        language: {
            url : dataTableTranslation
        }

        /*
         // Botones
         dom: 'Bfrtip',
         buttons: [
             {
             text: 'Example Button',
             action: function ( e, dt, node, config ) {
                 alert('Botón pulsado');
                 }
             }
         ]
         */
    };

    return await $('#' + id).DataTable({...basic, ...options});
}
