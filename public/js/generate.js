$(document).ready(function () {
    var paint = $('#colorLocation').val();
    var paintLocation = JSON.parse(paint);
    for (var i = 0 ; i < paintLocation.length; i++)
    {
        var colorNote = paintLocation[i][0]['color'];
        var nameLocation = paintLocation[i][0]['location'];
        $('#noteaddlocation').append('<div class="seat" style="background-color: ' + colorNote + '; width: 15px; height: 15px;">\n' +
            '</div> : ' + nameLocation + '<br>');
        for (var j = 0; j< paintLocation[i].length; j++)
        {
            var id = paintLocation[i][j]['name'];
            var color = paintLocation[i][j]['color'];
            $('#' + id + '').css('background-color', color);
            $('#' + id + '').removeClass('ui-selectee');
            $('#' + id + '').addClass('disabled');
        }
    }
    $('#show').click(function () {
        var array = [];
        $('.ui-selected').each(function () {
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
