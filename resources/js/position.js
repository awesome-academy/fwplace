$(function() {
    /*Lang-i18n*/
    var processing_lang = $('#processing_lang').val();
    var required_lang = $('#required_lang').val();
    var position_name_lang = $('#position_name_lang').val();
    var add_success_lang = $('#add_success_lang').val();
    var edit_success_lang = $('#edit_success_lang').val();
    var question_delete_lang = $('#question_delete_lang').val();
    var delete_success_lang = $('#delete_success_lang').val();
    var yes_lang = $('#yes_lang').val();
    var no_lang = $('#no_lang').val();
    var edit_lang = $('#edit_lang').val();
    var delete_lang = $('#delete_lang').val();
    var allow_register_lang = $('#allow_register_lang').val();
    /*---------*/

    /*DataTable*/
    var table = $('#positions_table').DataTable({
        processing: true,
        language: {
            processing: "<div id='loader'>" + processing_lang + "</div>"
        },
        ajax: {
            url: route('positions.get_positions'),
        },
        columns: [
            {data: 'DT_Row_Index', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'is_fulltime', name: 'is_fulltime'},
            {
                data: 'action',
                name: 'action',
                render: function (data) {
                    $string = '';

                    if (data.editPositions == 1) {
                        $string = $string + '&nbsp;&nbsp;' + '<a href="javascript:;" data-id="' + data.positionId + '"\
                        class="btn btn-warning m-btn m-btn--icon\
                        m-btn--icon-only m-btn--custom m-btn--pill edit_position"\
                        data-tooltip="tooltip" title="' + edit_lang + '">\
                        <i class="flaticon-edit-1" aria-hidden="true"></i></a>' + '&nbsp;&nbsp;';
                    }

                    if (data.deletePositions == 1) {
                        $string = $string + '&nbsp;&nbsp;' + '<a href="javascript:;" data-id="' + data.positionId + '"\
                        class="btn btn-danger m-btn m-btn--icon\
                        m-btn--icon-only m-btn--custom m-btn--pill delete_position"\
                        data-tooltip="tooltip" title="' + delete_lang + '">\
                        <i class="flaticon-cancel" aria-hidden="true"></i></a>';
                    }

                    return $string;
                }
            }
        ]
    });
    /*----------*/

    /*Gọi Modal thêm mới chức danh*/
    $(document).on('click', '#add_position_a', function() {
        $('#add_position_modal').modal('show');
        $('#name').val('');
    });
    /*--------------------------*/

    /*Ấn nút Tạo chức danh mới*/
    $('#add_position_btn').on('click', function (event) {
        event.preventDefault();

        var name = $('#name').val();

        var form = $('#add_position_form');
        var formData= form.serialize();

        if (name == '') {
            toastr.error(position_name_lang + required_lang)
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: route('positions.store'),
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

                        $('#add_position_modal').modal('hide');

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

    /*Gọi Modal Cập nhật chức danh*/
    $(document).on('click', '.edit_position', function() {
        $('#edit_position_modal').modal('show');

        var positionId =  $(this).data('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: route('positions.edit', [positionId]),
            success: function (res)
            {
                $('#edit_name').val(res.position.name);
                $('#edit_is_fulltime').val(res.position.is_fulltime);

                $('#remove_edit_allow_register').remove();

                if (res.position.allow_register == 1) {
                    $('#display_edit_allow_register').append('<div id="remove_edit_allow_register"><input type="checkbox"\
                                                                name="allow_register"\
                                                                id="edit_allow_register"\
                                                                checked> ' + allow_register_lang + '</div>');
                } else {
                    $('#display_edit_allow_register').append('<div id="remove_edit_allow_register"><input type="checkbox"\
                                                                name="allow_register"\
                                                                id="edit_allow_register"> ' + allow_register_lang + '</div>');
                }
                
                $('#position_id').val(res.position.id);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // 
            }
        });
    });
    /*--------------------------*/

    /*Ấn nút Cập nhật chức danh*/
    $('#edit_position_btn').on('click', function (event) {
        event.preventDefault();

        var positionId = $('#position_id').val();
        var name = $('#edit_name').val();
        var isFulltime = $('#edit_is_fulltime').val();
        var checked = $('#edit_allow_register').is(':checked');  

        if (name == '') {
            toastr.error(position_name_lang + required_lang)
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'PUT',
                url: route('positions.update', [positionId]),
                data: {
                    name: name,
                    is_fulltime: isFulltime,
                    checked: checked,
                },
                success: function (res) {
                    if (res.error == 'valid') {
                        var arr = res.message;
                        var key = Object.keys(arr);

                        for (var i = 0; i < key.length; i++) {
                            toastr.error(arr[key[i]]);
                        }
                    } else if (res.error == false) {
                        toastr.success(edit_success_lang);

                        $('#edit_position_modal').modal('hide');

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

    /*Xóa chức danh*/
    $(document).on('click', '.delete_position', function() {
        var positionId = $(this).data('id');

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
                url: route('positions.destroy', [positionId]),
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
