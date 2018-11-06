$(function() {
    /*Lang-i18n*/
    var processing_lang = $('#processing_lang').val();
    var add_success_lang = $('#add_success_lang').val();
    var delete_success_lang = $('#delete_success_lang').val();
    var add_lang = $('#add_lang').val();
    var delete_lang = $('#delete_lang').val();
    /*---------*/

    /*DataTable*/
    var role_id = $('#role_id').val();

    var table = $('#permission_role_table').DataTable({
        processing: true,
        language: {
            processing: "<div id='loader'>" + processing_lang + "</div>"
        },
        serverSide: true,
        ajax: {
            url: route('roles.get_permission_role', [role_id]),
        },
        columns: [
            {data: 'DT_Row_Index', name: 'id'},
            {data: 'display_name', name: 'display_name'},
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at'},
            {
                data: 'action',
                name: 'action',
                render: function (data) {
                    if (data.flag == 1) {
                        $string = '<input type="hidden" id="checked-' + data.permissionId + '" value="1">';

                        $string = $string + '<i id="action-' + data.permissionId + '"\
                                                class="fa fa-check-circle update-permission"\
                                                data-tooltip="tooltip"\
                                                title="' + delete_lang + '"\
                                                aria-hidden="true"\
                                                data-roleid="' + data.roleId + '"\
                                                data-permissionid="' + data.permissionId + '"\
                                                style="cursor: pointer; color: #3598dc; font-size: 20px;">\
                                            </i>';
                    } else {
                        $string = '<input type="hidden" id="checked-' + data.permissionId + '" value="0">';

                        $string = $string + '<i id="action-' + data.permissionId + '"\
                                                class="fa fa-circle-notch update-permission"\
                                                data-tooltip="tooltip"\
                                                title="' + add_lang + '"\
                                                aria-hidden="true"\
                                                data-roleID="' + data.roleId + '"\
                                                data-permissionId="' + data.permissionId + '"\
                                                style="cursor: pointer; color: #3598dc; font-size: 20px;">\
                                            </i>';
                    }

                    return $string;
                }
            }
        ]
    });
    /*----------*/

    /*Thay đổi quyền hạn*/
    $(document).on('click', '.update-permission', function() {
        var role_id = $(this).data('roleid');
        var permission_id = $(this).data('permissionid');
        var checked = $('#checked-' + permission_id).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: route('roles.update_permission_role'),
            data: {
                checked: checked,
                role_id: role_id,
                permission_id: permission_id,
            },
            success: function (res)
            {
                if (res.message == 'deleted') {
                    $('#action-' + permission_id).removeClass('fa fa-check-circle').addClass('fa fa-circle-notch');
                    $('#checked-' + permission_id).val(0);
                    toastr.success(delete_success_lang);
                } 

                if (res.message == 'added') {
                    $('#action-' + permission_id).removeClass('fa fa-circle-notch').addClass('fa fa-check-circle');
                    $('#checked-' + permission_id).val(1);
                    toastr.success(add_success_lang);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // 
            }
        });
    });
    /*--------------------*/
});
