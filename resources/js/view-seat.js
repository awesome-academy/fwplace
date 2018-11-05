$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('select[name="shift"]').each(function () {
        $(this).find('option[value="1"]').prop('selected', true);
    });
    $('select[class="form-control tar"]').each(function () {
        $(this).find('option[value="1"]').prop('selected', true);
    });
    var location_id = $('select#select_location').val();
    var seatsByRow = $('select.seat-target');
    var shift = $('#select_shift').val();
    $('select[name="seat_id"]').empty();
    getAllSeats(location_id);
    seatsByRow.empty();
    seatsByRow.each(function () {
        var date = $(this).data('date');
        getSeatsEachDay(date, shift, location_id);
    })
});

$('#select_location').on('change', function () {
    var location_id = $(this).val();
    $('select[name="seat_id"]').empty();
    getAllSeats(location_id);
});

$('select.target').on('change ready', function () {
    var location_id = $(this).val();
    var date = $(this).data('date');
    var shift = $('select[name="shift[' + date +']"]').val();
    $('select[name="seat[' + date +']"]').empty();
    getSeatsEachDay(date, shift, location_id);
});

$('#select_shift').change(function() {
    var value = $(this).val();
    var targerClass = $('select[class="form-control target"]');
    var seatTargetClass = $('select[class="form-control seat-target"]');
    $('.tar').each(function() {
        $(this).val(value);
    });

    if ($(this).val() !== '0') {
        targerClass.removeAttr('disabled');
        seatTargetClass.removeAttr('disabled');
    } else {
        targerClass.attr('disabled', 'disbled');
        seatTargetClass.attr('disabled', 'disbled');
    }
});

$('select.tar').on('change', function () {
    var date = $(this).data('date');
    var location = $('select[name="location[' + date + ']"]');
    var seats = $('select[name="seat[' + date +']"]');
    var location_id = location.val();
    var shift = $(this).val();

    if (shift === '0') {
        location.attr('disabled', 'disabled');
        seats.attr('disabled', 'disabled');
    } else {
        location.removeAttr('disabled');
        seats.removeAttr('disabled');
        seats.empty();
        getSeatsEachDay(date, shift, location_id);
    }
});

function getSeatsEachDay(date, shift, location_id) {
    var base_url = 'http://127.0.0.1:8000';
    $.ajax({
        type: "POST",
        url: base_url + "/get-seat-by-day",
        dataType: "json",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            location_id: location_id,
            date: date,
            shift: shift
        },
        success: function (data) {
            $.each(data, function (key, value) {
                $('select[name="seat[' + date +']"]').append('<option value="'+ key +'">' + value + '</option>');
            });
        },
        error: function () {
            alert('get all seats by day error');
        }
    });
}

function getAllSeats(location_id) {
    var base_url = 'http://127.0.0.1:8000';
    $.ajax({
        type: "POST",
        url: base_url + "/get-seat",
        dataType: "json",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            location_id: location_id
        },
        success: function (data) {
            $.each(data, function (key, value) {
                $('select[name="seat_id"]').append('<option value="'+ key +'">' + value + '</option>');
            });
        },
        error: function () {
            alert('get all seats error');
        }
    });
}
