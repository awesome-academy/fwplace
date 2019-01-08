$(function() {
    /*Lang-i18n*/
    var processing_lang = $('#processing_lang').val();
    /*---------*/

    /*DataTable*/
    var table = $('#permissions_table').DataTable({
        processing: true,
        language: {
            processing: "<div id='loader'>" + processing_lang + "</div>"
        },
        serverSide: true,
        ajax: {
            url: route('permissions.get_permissions'),
        },
        columns: [
            {data: 'DT_Row_Index', name: 'id'},
            {data: 'display_name', name: 'display_name'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at'}
        ]
    });
    /*----------*/
});
