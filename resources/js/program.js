$(function() {
    /*Lang-i18n*/
    var processing_lang = $('#processing_lang').val();
    var required_lang = $('#required_lang').val();
    var program_name_lang = $('#program_name_lang').val();
    var add_success_lang = $('#add_success_lang').val();
    var edit_success_lang = $('#edit_success_lang').val();
    var question_delete_lang = $('#question_delete_lang').val();
    var delete_success_lang = $('#delete_success_lang').val();
    var yes_lang = $('#yes_lang').val();
    var no_lang = $('#no_lang').val();
    var edit_lang = $('#edit_lang').val();
    var delete_lang = $('#delete_lang').val();
    /*---------*/

    /*DataTable*/
    var table = $('#programs_table').DataTable({
        processing: true,
        language: {
            processing: "<div id='loader'>" + processing_lang + "</div>"
        },
        ajax: {
            url: route('programs.get_programs'),
        },
        columns: [
            {data: 'DT_Row_Index', name: 'id'},
            {data: 'name', name: 'name'},
            {
                data: 'action',
                name: 'action',
                render: function (data) {
                    $string = '';

                    if (data.editPrograms == 1) {
                        $string = $string + '&nbsp;&nbsp;' + '<a href="javascript:;" data-id="' + data.programId + '"\
                                            class="btn btn-warning m-btn m-btn--icon\
                                                    m-btn--icon-only m-btn--custom m-btn--pill edit_program"\
                                            data-tooltip="tooltip" title="' + edit_lang + '">\
                                            <i class="flaticon-edit-1" aria-hidden="true"></i></a>' + '&nbsp;&nbsp;';
                    }

                    if (data.deletePrograms == 1) {
                        $string = $string + '&nbsp;&nbsp;' + '<a href="javascript:;" data-id="' + data.programId + '"\
                                            class="btn btn-danger m-btn m-btn--icon\
                                                    m-btn--icon-only m-btn--custom m-btn--pill delete_program"\
                                            data-tooltip="tooltip" title="' + delete_lang + '">\
                                            <i class="flaticon-cancel" aria-hidden="true"></i></a>';
                    }

                    return $string;
                }
            }
        ]
    });
    /*----------*/

    /*Gọi Modal thêm mới ngôn ngữ*/
    $(document).on('click', '#add_program_a', function() {
        $('#add_program_modal').modal('show');
        $('#name').val('');
    });
    /*--------------------------*/

    /*Ấn nút Tạo ngôn ngữ mới*/
    $('#add_program_btn').on('click', function (event) {
        event.preventDefault();

        var name = $('#name').val();

        if (name == '') {
            toastr.error(program_name_lang + required_lang)
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: route('programs.store'),
                data: {
                    name: name,
                },
                success: function (res) {
                    if (res.error == 'valid') {
                        var arr = res.message;
                        var key = Object.keys(arr);

                        for (var i = 0; i < key.length; i++) {
                            toastr.error(arr[key[i]]);
                        }
                    } else if (res.error == false) {
                        toastr.success(add_success_lang);

                        $('#add_program_modal').modal('hide');

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

    /*Gọi Modal Cập nhật ngôn ngữ*/
    $(document).on('click', '.edit_program', function() {
        $('#edit_program_modal').modal('show');

        var programId =  $(this).data('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: route('programs.edit', [programId]),
            success: function (res)
            {
                $('#edit_name').val(res.program.name);
                
                $('#program_id').val(res.program.id);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // 
            }
        });
    });
    /*--------------------------*/

    /*Ấn nút Cập nhật ngôn ngữ*/
    $('#edit_program_btn').on('click', function (event) {
        event.preventDefault();

        var programId = $('#program_id').val();
        var name = $('#edit_name').val();

        if (name == '') {
            toastr.error(program_name_lang + required_lang)
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'PUT',
                url: route('programs.update', [programId]),
                data: {
                    name: name,
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

                        $('#edit_program_modal').modal('hide');

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

    /*Xóa ngôn ngữ*/
    $(document).on('click', '.delete_program', function() {
        var programId = $(this).data('id');

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
                url: route('programs.destroy', [programId]),
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
