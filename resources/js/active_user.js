function activeUser(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + '/admin/active-user/' + id,
        method: 'post',
    }).done(function (result) {
        swal({
            type: 'success',
            title: result.message,
        });
        $('#user-' + id).hide();
    })
}
