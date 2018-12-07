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
$('form#add_form').on('submit', function () {
    var totalDay = 0;
    $('select.tar').each(function () {
        var data = $(this).val();
        if (data === '1') {
            totalDay += 1;
        } else if (data === '2' || data === '3') {
            totalDay += 0.5;
        }
    });
    if (totalDay < 10) {
        alert('Not enough working day!\n You registered ' + totalDay + 'days.\n Please try again!');

        return false;
    } else {
        return true;
    }
});
