$(document).ready(function() {
    $('.options').click(function() {
        $('.options').removeClass('btn-warning');
        $(this).addClass('btn-warning');
        let index = $(this).index();
        $('.design').addClass('d-none');
        $('.design:eq(' + index + ')').removeClass('d-none');
    });

    function showDiagram() {
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
    }

    showDiagram();

    $('.options')
        .first()
        .click(function() {
            showDiagram();
        });

    $('#diagram-edit').click(function() {
        $('.image-map-section').removeClass('d-none');
        $('#diagram-img').addClass('d-none');
    });
});
