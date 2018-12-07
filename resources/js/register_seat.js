$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var paint = $('#color-location').val();
    var paintLocation = JSON.parse(paint);
    var userPosition = $('#user-position').val();
    var note = $('#noteaddlocation');
    var day = $('#select-day');
    var seatOfUser = JSON.parse($('#seat-of-user').val());
    var schedules = JSON.parse($('#schedules').val());
    var dayRegistered = $('p#day-registered');
    var nameOfSeat = $('p#seat-name');
    var getSeat = $('a > span.nor-seat');
    var shiftUser = $('#shift-user');
    var curDay = $('#select-day :selected').text();
    var registerSeatForm = $('#register-seat-form');
    var seatOfUserId;
    var locationIdSchedules;
    dayRegistered.html('<b>' + curDay + '</b>');
    seatOfUserId = seatOfUser.length != 0 ? seatOfUser[0]['id'] : 0;
    locationIdSchedules = schedules.length != 0 ? schedules[0]['location_id'] : 0;
    renderSeat(paintLocation, note, userPosition, seatOfUserId, shiftUser, locationIdSchedules);
    getScheduleByDay(schedules[0]['shift'], shiftUser, curDay, schedules[0]['location_id'], note);
    day.on('change', function () {
        var curDay = $('#select-day :selected').text();
        var baseUrl = 'http://127.0.0.1:8000';
        var shiftUser = $('#shift-user');
        var workspaceId = $('#get-workspace-id').val();
        $.ajax({
            type: "POST",
            url: baseUrl + '/get-seat-status',
            data: {
                day: curDay,
                workspace_id: workspaceId,
            },
            success: function (data) {
                var parseData = JSON.parse(data);
                var count = 0;
                var locationId;
                for (var i = 0; i < schedules.length; i++) {
                    if (schedules[i]['date'] == curDay) {
                        getScheduleByDay(schedules[i]['shift'], shiftUser, curDay, schedules[i]['location_id'], note);
                        locationId = schedules[i]['location_id'];
                    }
                }
                for (var i = 0; i < parseData.length; i++) {
                    for (var j = 0; j < parseData[i].length; j++) {
                        var id = parseData[i][j]['name'];
                        var color = parseData[i][j]['color'];
                        var seat = $('#' + id + '');
                        if (parseData[i][j]['usable'] == 1) {
                            seat.children('p[class="seat-status"]').empty();
                            seat.children('p[class="seat-status"]').append('Used: ' + parseData[i][j]['status']['use']);
                            if (parseData[i][j]['position_id'] == userPosition &&
                                parseData[i][j]['status']['use'] != 'All day' &&
                                parseData[i][j]['location_id'] == locationId
                            ) {
                                seat.parent('a').removeClass('disabled');
                                seat.css('background-color', '#b5fffa');
                            } else {
                                seat.parent('a').addClass('disabled');
                                seat.css('background-color', color);
                            }
                        }

                        if (parseData[i][j]['seat_user'] != null) {
                            count += 1;
                            seat.css('background-color', '#40ff36');
                            shiftUser.attr('data-cur-seat', parseData[i][j]['seat_id']);
                            seat.parent('a').addClass('disabled');
                        }
                    }
                }

                if (count == 0) {
                    shiftUser.attr('data-cur-seat', 0);
                }
            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);
            },
        })
    });
    getSeat.on('click', function (event) {
        var seatId = $('input#seat-id-registered');
        var curSeat = $('input#cur-seat');
        event.preventDefault();
        nameOfSeat.empty();
        nameOfSeat.html('Name of seat: <b>' + $(this).attr('id'));
        seatId.val($(this).data('seat_id'));
        curSeat.val(shiftUser.attr('data-cur-seat'));
    });
    registerSeatForm.on('submit', function () {
        var shift = $('input#shift-registered').val();
        if (shift == 0) {
            swal({
                text: "Your schedule is Off, so you can not register seat!",
                type: "error",
                allowOutsideClick: true,
            })
        } else {
            return true;
        }

        return false;
    });
});
function renderSeat(data, note, userPosition, seatOfUserId, shiftUser, locationId) {
    for (var i = 0 ; i < data.length; i++)
    {
        var colorNote = data[i][0]['color'];
        var nameLocation = data[i][0]['location'];
        note.append(
            '<div class="seat seat-info" data-location-name="'+ nameLocation +'"'
            + 'data-location-id="' + data[i][0]['location_id'] + '" style="background-color: '
            + colorNote + '; width: 25px; height: 25px;">\n' + '</div> : ' + nameLocation + '<br>');
        for (var j = 0; j < data[i].length; j++) {
            var id = data[i][j]['name'];
            var color = data[i][j]['color'];
            var seat = $('#' + id + '');
            seat.attr('usable', data[i][j]['usable']);
            seat.attr('position_id', data[i][j]['position_id']);
            seat.css('background-color', color);
            seat.removeClass('ui-selectee');
            seat.attr('data-seat_id', data[i][j]['seat_id']);
            if (data[i][j]['usable'] == 1) {
                seat.append('<br><p class="seat-status">Used: ' + data[i][j]['status']['use'] + '</p>');
                if (data[i][j]['position_id'] == userPosition &&
                    data[i][j]['status']['use'] != 'All day' &&
                    data[i][j]['location_id'] == locationId
                ) {
                    seat.parent('a').removeClass('disabled');
                    seat.css('background-color', '#b5fffa');
                } else {
                    seat.parent('a').addClass('disabled');
                    seat.css('background-color', color);
                }
            }

            if (data[i][j]['seat_id'] == seatOfUserId) {
                seat.css('background-color', '#40ff36');
                seat.parent('a').addClass('disabled');
                shiftUser.attr('data-cur-seat', seatOfUserId);
            }
        }
    }
    note.append(
        '<div class="seat seat-info" style="background-color: #b5fffa; width: 25px; height: 25px;">\n' + '</div> : Registrable<br>' +
        '<div class="seat seat-info" style="background-color: #40ff36; width: 25px; height: 25px;">\n' + '</div> : Your seat<br>'
    );
}
function getScheduleByDay(shift, shiftUser, curDay, locationId, note) {
    var text = '';
    switch (shift) {
        case 1:
            text = 'All day';
            break;
        case 2:
            text = 'Morning';
            break;
        case 3:
            text = 'Afternoon';
            break;
        default:
            text = 'Off';
    }
    var location = note.find('div[data-location-id="' + locationId + '"]').data('location-name');

    shiftUser.empty();
    shiftUser.attr('data-shift', shift);
    shiftUser.html('<b>Your schedule on ' + curDay + ': ' + text + '</b><br><b> Location: ' + location + '</b>');
    $('input#shift-registered').val(shift);
    $('input#day_registered').val(curDay);
}
