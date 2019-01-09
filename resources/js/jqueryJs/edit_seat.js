$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let location_id = parseInt(window.location.pathname.split('/').pop());

    let disabling = false;
    let enabling = false;

    $('.btn-seat').click(function() {
        $('.btn-seat').removeClass('btn-warning');
        $(this).addClass('btn-warning');
        if ($(this).attr('id') == 'disable-seat') {
            disabling = true;
            enabling = false;
        }

        if ($(this).attr('id') == 'enable-seat') {
            enabling = true;
            disabling = false;
        }
    });

    $('.seat').click(function() {
        if (disabling) {
            if (
                !$(this).hasClass('disabled') &&
                !$(this).hasClass('seat-enable')
            )
                $(this).toggleClass('seat-chosed');

            if ($(this).hasClass('seat-chosed')) {
                $(this).addClass('bg-warning');
            } else {
                $(this).removeClass('bg-warning');
            }
        }

        if (enabling) {
            if ($(this).hasClass('disabled')) {
                $(this).removeClass('disabled');
                $(this).addClass('seat-enable');
                $(this).toggleClass('seat-chosed');
                if ($(this).hasClass('seat-chosed'))
                    $(this).addClass('bg-primary');
                else $(this).removeClass('bg-primary');

                return;
            }

            if ($(this).hasClass('seat-enable')) {
                $(this).addClass('disabled');
                $(this).removeClass('seat-enable');
                $(this).toggleClass('seat-chosed');
                if ($(this).hasClass('seat-chosed'))
                    $(this).addClass('bg-primary');
                else $(this).removeClass('bg-primary');
            }
        }
    });

    $('#cancel').click(function() {
        window.location.reload();
    });

    $('#submit').click(function() {
        let row = $('#row').val();
        let column = $('#column').val();
        let element = $('.seat-chosed');
        let seats = [];
        for (let i = 0; i < element.length; i++) {
            seats[i] = {
                name: $(element[i]).attr('id'),
                usable: $(element[i]).hasClass('seat-enable') ? 1 : 2
            };
        }
        $.ajax({
            url: route('locations.update_row_column', [location_id]),
            method: 'post',
            data: {
                _method: 'put',
                row: row,
                column: column,
                seats: seats
            },
            success: function(result) {
                window.location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                swal(thrownError);
            }
        });
    });
});
