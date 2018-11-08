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
            var name_user = paintLocation[i][j]['user_name'].split(' ');
            var avatar = paintLocation[i][j]['avatar'];
            var color = paintLocation[i][j]['color'];
            var user_id = paintLocation[i][j]['user_id'];
            $('#' + id + '').attr('seat_id', paintLocation[i][j]['seat_id']);
            $('#' + id + '').css('background-color', color);
            $('#' + id + '').removeClass('ui-selectee');
            $('#' + id + '').addClass('disabled');
            $('#' + id + '').attr('full_name', paintLocation[i][j]['user_name']);
            $('#' + id + '').html(name_user[name_user.length -1]);
            $('#' + id + '').attr('avatar', avatar);
            $('#' + id + '').attr('user_id', user_id);
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
        var checkID = $(this).attr('full_name');
        var avatar = $(this).attr('avatar');
        if (avatar) {
            $(this).append('<div id="hello"><span><small><i class="fa fa-circle" style="color: green"></i></small> ' + checkID + ' <br> <img src="storage/user/'+avatar+'" alt="" style = "width: 40px; "></span></div>');
        } else {
            $(this).append('<div id="hello"><span><small><i class="fa fa-circle" style="color: green"></i></small> ' + checkID + ' <br> </span></div>');
        }

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
        var user_id = $(this).attr('user_id');
        $('#locations').val(user_id);
        var avatar = $(this).attr('avatar');
        if (avatar != '') {
            var id = $(this).attr('id');
            var $this = $(this);
            var url = route('edit_info_location');
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                type: 'POST',
                url: url,
                data: {'user_id' : user_id},
                success: function (data) {
                    var url ='../storage/user/'+ data.avatar;
                        if (url) {
                            $('#modal-info-user').find('#imagePreview').css('background-image', 'url(' + url + ')');
                        }
                        $('#modal-info-user').find('#list-name option[value = '+data.id+']').attr('selected','selected');
                        $('#modal-info-user').find('#list-language option[value = '+data.program_id+']').attr('selected','selected');
                        $('#modal-info-user').find('#list-position option[value = '+data.position_id+']').attr('selected','selected');
                }
            });
        };
    });

})
