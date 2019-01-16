$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let location_id = parseInt(window.location.pathname.split('/').pop());

    let disabling = false;
    let enabling = false;
    let clearing = false;

    $('.btn-seat').click(function() {
        $('.btn-seat').removeClass('btn-warning');
        $(this).addClass('btn-warning');
        if ($(this).attr('id') == 'disable-seat') {
            disabling = true;
            enabling = false;
            clearing = false;
        }

        if ($(this).attr('id') == 'enable-seat') {
            enabling = true;
            disabling = false;
            clearing = false;
        }

        if ($(this).attr('id') == 'clear-seat') {
            disabling = false;
            enabling = false;
            clearing = true;
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

    $(document).on('click', '.seat-avatar', function() {
        if (clearing == false) {
            return;
        }
        if ($(this).hasClass('avatar-selected')) {
            $(this)
                .children('.img-selected')
                .remove();
            $(this).removeClass('avatar-selected');

            return;
        }
        let div = $('<div class="img-selected"></div>');
        $(this).append(div);
        $(this).addClass('avatar-selected');
    });

    $('#cancel').click(function() {
        disabling = false;
        enabling = false;
        clearing = false;
        $('.seat').each(function() {
            $(this).removeClass('seat-enable');
            $(this).removeClass('seat-chosed');
            if ($(this).hasClass('bg-primary')) {
                $(this).addClass('disabled');
                $(this).removeClass('bg-primary');
            }
            $(this).removeClass('bg-warning');
        });

        $('.seat-avatar').each(function() {
            $(this).removeClass('avatar-selected');
            let div = $(this).children('.img-selected');
            if ($(div).length > 0) {
                $(div).remove();
            }
        });

        $('.btn-seat').removeClass('btn-warning');
    });

    $('#submit').click(function() {
        let row = $('#row').val();
        let column = $('#column').val();
        let element = $('.seat-chosed');
        let avatarSelected = $('.avatar-selected');
        let seats = [];
        let clearUsers = [];
        for (let i = 0; i < element.length; i++) {
            seats[i] = {
                name: $(element[i]).attr('id'),
                usable: $(element[i]).hasClass('seat-enable') ? 1 : 2
            };
        }
        for (let i = 0; i < avatarSelected.length; i++) {
            clearUsers[i] = {
                seat_id: $(avatarSelected[i]).attr('data-seat_id'),
                user_id: $(avatarSelected[i]).attr('data-user_id')
            };
        }
        $.ajax({
            url: route('locations.update_row_column', [location_id]),
            method: 'post',
            data: {
                _method: 'put',
                row: row,
                column: column,
                seats: seats,
                clearUsers: clearUsers
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
