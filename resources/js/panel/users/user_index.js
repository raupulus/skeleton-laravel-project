$(document).ready(function() {
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

        return $('#' + id).DataTable({...basic, ...options});
    }

    var panelUserTable = createDatatable(
        'panel-users-table',
        panelUsersGetAllUrl,
        [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'nick', name: 'nick' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action' }
        ],
        {}
    );
});
