$(function() {
    /*Lang-i18n*/
    var processing_lang = $('#processing_lang').val();
    var required_lang = $('#required_lang').val();
    var display_name_lang = $('#display_name_lang').val();
    var role_lang = $('#role_lang').val();
    var add_success_lang = $('#add_success_lang').val();
    var edit_success_lang = $('#edit_success_lang').val();
    var question_delete_lang = $('#question_delete_lang').val();
    var delete_success_lang = $('#delete_success_lang').val();
    var yes_lang = $('#yes_lang').val();
    var no_lang = $('#no_lang').val();
    var permission_lang = $('#permission_lang').val();
    var edit_lang = $('#edit_lang').val();
    var delete_lang = $('#delete_lang').val();
    /*---------*/

    /*DataTable*/
    var table = $('#roles_table').DataTable({
        processing: true,
        language: {
            processing: "<div id='loader'>" + processing_lang + "</div>"
        },
        serverSide: true,
        ajax: {
            url: route('roles.get_roles'),
        },
        columns: [
            {data: 'DT_Row_Index', name: 'id'},
            {data: 'display_name', name: 'display_name'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at'},
            {
                data: 'action',
                name: 'action',
                render: function (data) {
                    $string = '';

                    if (data.permissionRoles == 1) {
                        $string = $string + '<a href="' + route('roles.show', data.roleId) + '"\
                                                class="m-portlet__nav-link btn m-btn m-btn--hover-brand\
                                                        m-btn--icon m-btn--icon-only m-btn--pill"\
                                                data-tooltip="tooltip" title="' + permission_lang + '">\
                                                <i class="la la-shield" aria-hidden="true"></i></a>' + '&nbsp;&nbsp;';
                    }

                    if (data.editRoles == 1) {
                        $string = $string + '&nbsp;&nbsp;' + '<a href="javascript:;" data-id="' + data.roleId + '"\
                                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand\
                                                    m-btn--icon m-btn--icon-only m-btn--pill edit_role"\
                                            data-tooltip="tooltip" title="' + edit_lang + '">\
                                            <i class="la la-edit" aria-hidden="true"></i></a>' + '&nbsp;&nbsp;';
                    }

                    if (data.deleteRoles == 1) {
                        $string = $string + '&nbsp;&nbsp;' + '<a href="javascript:;" data-id="' + data.roleId + '"\
                                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand\
                                                    m-btn--icon m-btn--icon-only m-btn--pill delete_role"\
                                            data-tooltip="tooltip" title="' + delete_lang + '">\
                                            <i class="la la-trash"></i></a>';
                    }

                    return $string;
                }
            }
        ]
    });
    /*----------*/

    /*Gọi Modal thêm mới vai trò*/
    $(document).on('click', '#add_role_a', function() {
        $('#add_role_modal').modal('show');
        $('#name').val('');
        $('#display_name').val('');
        $('#description').val('');
    });
    /*--------------------------*/

    /*Ấn nút Tạo vai trò mới*/
    $('#add_role_btn').on('click', function (event) {
        event.preventDefault();

        var name = $('#name').val();
        var display_name = $('#display_name').val();

        var form = $('#add_role_form');
        var formData= form.serialize();

        if (display_name == '') {
            toastr.error(display_name_lang + required_lang);
        } else if (name == '') {
            toastr.error(role_lang + required_lang)
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: route('roles.store'),
                data: formData,
                success: function (res) {
                    if (res.error == 'valid') {
                        var arr = res.message;
                        var key = Object.keys(arr);

                        for (var i = 0; i < key.length; i++) {
                            toastr.error(arr[key[i]]);
                        }
                    } else if (res.error == false) {
                        toastr.success(add_success_lang);

                        $('#add_role_modal').modal('hide');

                        table.ajax.reload();
                    } else {
                        //
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // 
                }
            });
        }
    });
    /*------------------------*/

    /*Gọi Modal Cập nhật vai trò*/
    $(document).on('click', '.edit_role', function() {
        $('#edit_role_modal').modal('show');

        var role_id =  $(this).data('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: route('roles.edit', [role_id]),
            success: function (res)
            {
                $('#edit_display_name').val(res.role.display_name);
                $('#edit_name').val(res.role.name);
                $('#edit_description').val(res.role.description);
                $('#role_id').val(res.role.id);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // 
            }
        });
    });
    /*--------------------------*/

    /*Ấn nút Cập nhật vai trò*/
    $('#edit_role_btn').on('click', function (event) {
        event.preventDefault();

        var name = $('#edit_name').val();
        var display_name = $('#edit_display_name').val();

        var role_id = $('#role_id').val();
        var form = $('#edit_role_form');
        var formData= form.serialize();

        if (display_name == '') {
            toastr.error(display_name_lang + required_lang);
        } else if (name == '') {
            toastr.error(role + required_lang)
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'PUT',
                url: route('roles.update', [role_id]),
                data: formData,
                success: function (res) {
                    if (res.error == 'valid') {
                        var arr = res.message;
                        var key = Object.keys(arr);

                        for (var i = 0; i < key.length; i++) {
                            toastr.error(arr[key[i]]);
                        }
                    } else if (res.error == false) {
                        toastr.success(edit_success_lang);

                        $('#edit_role_modal').modal('hide');

                        table.ajax.reload();
                    } else {
                        //
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // 
                }
            });
        }
    });
    /*------------------------*/

    /*Xóa vai trò*/
    $(document).on('click', '.delete_role', function() {
        var role_id = $(this).data('id');

        swal({
            title: question_delete_lang,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            cancelButtonText: no_lang,
            confirmButtonText: yes_lang,
        },
        function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'DELETE',
                url: route('roles.destroy', [role_id]),
                success: function(res)
                {
                    toastr.success(delete_success_lang);

                    table.ajax.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // 
                }
            });
        });
    });
    /*------------*/
});
