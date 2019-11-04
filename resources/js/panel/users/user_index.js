$(document).ready(function() {
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

    // Cuando se completa la promesa añado eventos a botones de acción.
    $.when(panelUserTable).done((table) => {
        // Todos los Usuarios.
        $('a[data-name="all-users"]').click(function(e) {
            e.preventDefault();
            table.ajax.url(panelUsersGetAllUrl).load();

            $('#title-users').text('Viendo todos los usuarios');
        });

        // Usuarios Filtrados.
        $('a[data-name="this-month-users"]').click(function(e) {
            e.preventDefault();
            table.ajax.url(panelUsersGetThisMonth).load();

            $('#title-users').text('Viendo usuarios del último mes');
        });

        // Usuarios Activos.
        $('a[data-name="active-users"]').click(function(e) {
            e.preventDefault();
            table.ajax.url(panelUsersGetActive).load();

            $('#title-users').text('Viendo los usuarios activos');
        });

        // Usuarios Inactivos.
        $('a[data-name="inactive-users"]').click(function(e) {
            e.preventDefault();
            table.ajax.url(panelUsersGetInactive).load();

            $('#title-users').text('Viendo los usuarios inactivos');
        });
    });

    // Desactivo el botón al ser pulsado y marco los demás como activos.
    $('.btn-panel-selector').click(function() {
        $('.btn-panel-selector').removeClass('disabled btn-secondary');
        $('.btn-panel-selector').addClass('btn-primary');
        $(this).addClass('disabled btn-secondary');
        $(this).removeClass('btn-primary');
    });
});
