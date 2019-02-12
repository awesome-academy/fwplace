var data

$.ajax({
    url: 'getSpecialDay',
    method: 'GET'
}).done(function (result) {
    data = result
})

var specialDays;
$.ajax({
    url: window.location.origin + '/admin/special-days',
    method: 'GET',
}).done(res => {
    var specialDays = res.data
    var currentYear = new Date().getFullYear();
    $('.calendar').calendar({
        enableContextMenu: true,
        customDayRenderer: function(element, date) {
            var test = new Date(date)
            var kq = data.filter(function (arr) {
                return (new Date(arr.from)).setDate(new Date(arr.from).getDate() - 1) <= new Date(date) && new Date(arr.to) >= new Date(date);
            });
            if (kq && kq[0]) {
                if (kq[0].is_compensation != null) {
                    $(element).css('color', 'white');
                    $(element).css('border-radius', '15px');
                    $(element).css('background-color', '#F9AE00');
                } else {
                    $(element).css('background-color', 'red');
                    $(element).css('color', 'white');
                    $(element).css('border-radius', '15px');
                }
            }
            else {
                if (date.getDay() === 6 || date.getDay() === 0) {
                    $(element).css('background-color', '#7F7F7F');
                    $(element).css('border-radius', '15px');
                    $(element).css('color', 'white');
                }
            }
        },

        mouseOnDay: function(e) {
            var kq = data.filter(function (arr) {
                return (new Date(arr.from)).setDate(new Date(arr.from).getDate() - 1) <= new Date(e.date) && new Date(arr.to) >= new Date(e.date);
            });
                if (kq && kq[0]) {
                    var content = '<div class="event-tooltip-content">'
                        + '<div class="event-name">' + kq[0].title + '</div>'
                    + '</div>';
                    $(e.element).popover({ 
                        trigger: 'manual',
                        container: 'body',
                        html:true,
                        content: content
                    });
                    
                    $(e.element).popover('show');
                }
            
        },

        mouseOutDay: function(e) {
            $(e.element).popover('hide');
        },
    });
})

$('#special-day-form').hide()
$('#hide-form').hide()

$('#show-form').click(function () {
    $('#special-day-form').slideDown("slow")
    $('#hide-form').show()
    $(this).hide()
})

$('#hide-form').click(function () {
    $('#special-day-form').slideUp("slow")
    $('#show-form').show()
    $(this).hide()
})
