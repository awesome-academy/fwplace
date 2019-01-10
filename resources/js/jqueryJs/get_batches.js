function getBatch() {
    $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        var program = $('#select_program').val();
        var position = $('#position').val();
        var workspace = $('#workspace_id').val();
        $.ajax({
            url: window.location.origin + '/getBatches',
            method: 'POST',
            data: {
                workspace_id: workspace,
                program_id: program,
                position_id: position
            }
        }).done(function (result) {
            if (result.length > 0) {
                for (var i = 0; i < result.length; i++) {
                    $('#batch').html('<option value="' + result[i].id + '">' + result[i].workspace.name + ' - ' + result[i].batch + ' - ' + result[i].program.name + ' - ' + result[i].position.name + '</option>')
                }
            } else {
                $('#batch').html('<option>Batches</option>')
            }
        })
    })
}
