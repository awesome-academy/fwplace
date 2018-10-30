$(document).ready(function () {
    var paint = $('#colorLocation').val();
    var paintLocation = JSON.parse(paint);
    for (var i = 0 ; i < paintLocation.length; i++)
    {
        var colorNote = paintLocation[i][0]['color'];
        var nameLocation = paintLocation[i][0]['location'];
        $('#noteLocation').append('<div class="seat" style="background-color: ' + colorNote + '; width: 15px; height: 15px;">\n' +
            '</div> : ' + nameLocation + '<br>');
        for (var j = 0; j< paintLocation[i].length; j++)
        {
            var id = paintLocation[i][j]['name'];
            var color = paintLocation[i][j]['color'];
            $('#' + id + '').css('background-color', color);
        }
    }
});
