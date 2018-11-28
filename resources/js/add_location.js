$(document).ready(function () {
    var paint = $('#colorLocation').val();
    var paintLocation = JSON.parse(paint);
    for (var i = 0 ; i < paintLocation.length; i++)
    {
        var colorNote = paintLocation[i][0]['color'];
        var nameLocation = paintLocation[i][0]['location'];
        var workspace_id = paintLocation[i][0]['workspace_id'];
        $('#noteaddlocation').append('' +
            '<div class="seat seat-info" info-id = "' + workspace_id + '" info-name = "' + nameLocation + '" info-color = "' + colorNote + '" style="background-color: ' + colorNote + '; width: 15px; height: 15px;">\n' + '</div> : ' + nameLocation + '<br>'
        );
        for (var j = 0; j < paintLocation[i].length; j++)
        {
            var id = paintLocation[i][j]['name'];
            var color = paintLocation[i][j]['color'];
            var seat = $('#' + id + '');
            seat.attr('seat_id', paintLocation[i][j]['seat_id']);
            seat.css({
                'background-color': color,
                'font-size': '18px',
                'color': '#232121'
            });
            seat.removeClass('ui-selectee');
            seat.addClass('disabled');
            if (paintLocation[i][j]['usable'] != 1) {
                seat.parent('a').addClass('disabled');
            }
        }
    }

    $('#show').click(function() {
        var array = [];
        $('.ui-selected').each(function() {
            array.push($(this).attr('id'));
        });
        $('#seats').val(array);
        if (array.length > 0) {
            $('.form-workspace').show();
        }
        else {
            alert('Please select location before click button Add location');
        }
    });
    $('.all_seat').selectable({
        filter: '.seat',
        cancel: '.disabled',
        selected: function (event, ui) {
            $('.disabled').each(function () {
                if ($(this).hasClass('ui-selected')) {
                    $(this).removeClass('ui-selected');
                }
            });
        }
    });
});
