$(document).ready(function() {
    $('.seat-options').click(function() {
        $('.seat-options').removeClass('selected');
        $(this).addClass('selected');
        $('.option-view').toggleClass('d-none');
    });

    $('#merge_cell').change(function() {
        $('#location_id').toggleClass('d-none');
        $('#location_id').toggleClass('d-inline-block');
    });
});
