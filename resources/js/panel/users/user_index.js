$(document).ready(function() {
    var panelUserTable = $('#panel-users-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        select: true,
        ajax: panelUsersGetAllUrl,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'nick', name: 'nick' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action' }
        ],
        language: {
            search: "Search in table:"
            //url : dataTableTranslations,
        }
    });
});
