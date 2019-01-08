$(function() {
    /*Lang-i18n*/
    var add_success_lang = $('#add_success_lang').val();
    var delete_success_lang = $('#delete_success_lang').val();
    /*---------*/

    /*Thay đổi vai trò*/
    $(document).on('click', '.update-role', function() {
        var user_id = $(this).data('userid');
        var role_id = $(this).data('roleid');
        var checked = $('#checked-' + role_id).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: route('users.update_role_user'),
            data: {
                checked: checked,
                user_id: user_id,
                role_id: role_id,
            },
            success: function (res)
            {
                if (res.message == 'deleted') {
                    $('#action-' + role_id).removeClass('fa-check-circle').addClass('fa-circle-notch');
                    $('#checked-' + role_id).val(0);
                    toastr.success(delete_success_lang);
                } 

                if (res.message == 'added') {
                    $('#action-' + role_id).removeClass('fa-circle-notch').addClass('fa-check-circle');
                    $('#checked-' + role_id).val(1);
                    toastr.success(add_success_lang);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // 
            }
        });
    });
    /*-------------------*/
});
