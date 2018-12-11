$(document).ready(function() {
    $('.options').click(function() {
        $('.options').removeClass('btn-warning');
        $(this).addClass('btn-warning');
        $('.design').toggleClass('d-none');
    });

    $('.options.without-diagram').click(function() {
        let id = $('#select_workspace').val();
        $.ajax({
            url: route('design_without_diagram', [id]),
            method: 'get',
            success: function(result) {
                $('.design.without-diagram').html(result);
            }
        });
    });
});
