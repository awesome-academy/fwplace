$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let location_id = parseInt(window.location.pathname.split('/').pop());
    $.ajax({
        url: route('seats.show', [location_id]),
        method: 'get',
        success: function(result) {
            for (i in result) {
                users = result[i].users;
                let append = '';
                for (j in users) {
                    let schedules = users[j].schedules;
                    let title = users[j].name + '\n';
                    for (k in schedules) {
                        title +=
                            schedules[k].date +
                            ' : ' +
                            Lang.get('messages.shift.' + schedules[k].shift) +
                            '\n';
                    }
                    append += `<div class="seat-avatar" 
                        data-user_id="${users[j].id}"
                        data-seat_id="${result[i].id}"
                    >
                        <img class="seat-user-img" data-toggle="tooltip" src="${
                            users[j].avatar
                        }" title="${title}">
                    </div>`;
                }
                $('#' + result[i].name).append(append);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            swal(thrownError);
        }
    });
    let workDays = [];
    $('.work-day').each(function() {
        workDays.push($(this).text());
    });

    $('img[data-toggle=tooltip]').tooltip();
});
