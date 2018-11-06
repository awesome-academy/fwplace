$(document).ready(function () {

    var paint = $('#colorLocation').val();
    var paintLocation = JSON.parse(paint);
    for (var i = 0 ; i < paintLocation.length; i++)
    {
        var colorNote = paintLocation[i][0]['color'];
        var nameLocation = paintLocation[i][0]['location'];
        var workspace_id = paintLocation[i][0]['workspace_id'];
        $('#noteaddlocation').append(
            '<div class="seat seat-info" info-id = "' + workspace_id + '" info-name = "' + nameLocation + '" info-color = "' + colorNote + '" style="background-color: ' + colorNote + '; width: 15px; height: 15px;">\n' + '</div> : ' + nameLocation + '<br>');
        for (var j = 0; j < paintLocation[i].length; j++)
        {
            var id = paintLocation[i][j]['name'];
            var str = String(id);
            var s = String();
            for ( var k = 0; k < str.length; k++ ) {
                if( str[k] != '-' ) {
                    s +=str[k];
                } else {
                    break;
                }
            }
            $('#' + s + '').val(paintLocation[i][j]['seat_id']);
            var color = paintLocation[i][j]['color'];
            $('#' + id + '').css('background-color', color);
            $('#' + id + '').removeClass('ui-selectee');
            $('#' + id + '').addClass('disabled');
            var name_user = paintLocation[i][j]['user_name'].split(" ");
            $('#' + id + '').html(name_user[name_user.length-1]);
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

    $(document).on('click', '.seat-info', function () {
        var name = $(this).attr('info-name');
        var color = $(this).attr('info-color');
        var id = $(this).attr('info-id');
        var array = [];
        $('.ui-selected').each(function () {
            array.push($(this).attr('id'));
        });
        var seat = array;
        var url = route('save_location_color');
        $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $.ajax({
            type: 'POST',
            url: url,
            data: {'id' : id, 'seat' : seat, 'name' : name, 'color' : color},
            success: function (data) {
                var val = $('.ui-selected').each(function () {
                    $(this).css('background-color', data.color);
                });
            }
        });

    })

    // Alert ID-User
    $('.all_seat .seat').hover(function () {
        var checkID = $(this).attr('id');
        $(this).append('<div id="hello"><span>"' + checkID + '"</span></div>');
    },
        function() {
        $( this ).find('#hello').remove();
  })

    //img-info-location
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#imageUpload').change(function() {
        readURL(this);
    });

    $(document).on('click',  '.seat', function() {
        var id = $(this).find('input[name="seat"]').val();
        $('#locations').val(id);
    });

})
