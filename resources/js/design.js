$(document).ready(function() {
    $('.options').click(function() {
        $('.options').removeClass('btn-warning');
        $(this).addClass('btn-warning');
        let index = $(this).index();
        $('.design').addClass('d-none');
        $('.design:eq(' + index + ')').removeClass('d-none');
    });

    $('.options.without-diagram').click(function() {
        let id = $('#workspace_id').val();
        $('.image-map-section').addClass('d-none');
        $.ajax({
            url: route('design_without_diagram', [id]),
            method: 'get',
            success: function(result) {
                $('.design.without-diagram').html(result);
            }
        });
    });

    $('.options')
        .first()
        .click(function() {
            let id = $('#workspace_id').val();
            $('#diagram-img').removeClass('d-none');
            $('.image-map-section').addClass('d-none');
            $.ajax({
                url: route('design_diagram_image', [id]),
                method: 'get',
                success: function(result) {
                    $('#diagram-img').html(result);
                }
            });
        });

    $('#diagram-edit').click(function() {
        $('.image-map-section').removeClass('d-none');
        $('#diagram-img').addClass('d-none');
    });
});
