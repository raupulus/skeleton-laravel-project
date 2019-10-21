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

        return await $('#' + id).DataTable({...basic, ...options});
    }

    async function allUsers() {
        return await createDatatable(
            'panel-users-table',
            panelUsersGetAllUrl,
            userColumns,
            {}
        );
    }

    // Al cargar por defecto cargo todos los usuarios.
    var panelUserTable = allUsers();

    $.when(panelUserTable).done((table) => {
        // Todos los Usuarios.
        $('a[data-name="all-users"]').click(function(e) {
            e.preventDefault();
            table.ajax.url(panelUsersGetAllUrl).load();
        });

        // Usuarios Filtrados.
        $('a[data-name="this-month-users"]').click(function(e) {
            e.preventDefault();
            table.ajax.url(panelUsersGetThisMonth).load();
        });

        // Usuarios Inactivos.
        $('a[data-name="inactive-users"]').click(function(e) {
            e.preventDefault();
            table.ajax.url(panelUsersGetInactive).load();
        });

        // Usuarios Bloqueados.
        /*
        $('a[data-name="blocked-users"]').click(function(e) {
            e.preventDefault();
            table.ajax.url(panelUsersGetInactive).load();
        });

         */
    });

    // Desactivo los botones al pulsarlo y marco los demás como activos.
    $('.btn-panel-selector').click(function() {
        console.log($(this).text());
        $('.btn-panel-selector').removeClass('disabled btn-secondary');
        $('.btn-panel-selector').addClass('btn-primary');
        $(this).addClass('disabled btn-secondary');
        $(this).removeClass('btn-primary');
    });
});
