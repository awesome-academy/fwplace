$('#select_location').change(function() {
    var all_value = $(this).val();

    $('.target').each(function() {
        $(this).val(all_value);
    });
});
$('#select_shift').change(function() {
    var value = $(this).val();

    $('.tar').each(function() {
        $(this).val(value);
    });
});
