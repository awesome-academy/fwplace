$(document).ready(function() {
    var todayDate = moment().format('YYYY-MM-DD');
    var getAllUrl = $('#m_calendar').attr('data-url');
    var findOneUrl = $('#m_calendar').attr('data-one');
    $('#m_calendar').fullCalendar({
        views: {
            month: {
                titleFormat: 'MM-YYYY',
            }
        }, 
        defaultDate: todayDate,
        selectable: true,
        displayEventTime: false,
        fixedWeekCount: false,
        select: function (start) {
            var getClickedDate = start.format('YYYY-MM-DD');
            $('#clicked_date').text(moment(getClickedDate).format('DD-MM-YYYY'));
            $.get({
                url: findOneUrl,
                data: {
                    date: getClickedDate
                },
                success: function (data) {
                    if (data == null || !Array.isArray(data) || data.length == 0) {
                        return false;
                    }
                    let reset = [0, 1, 2, 3];
                    for (let item of reset) {
                        $('#area' + item).text('0');
                    }
                    for (let elm of data) {
                        $('#area' + elm.shift).text(elm.total);
                    }
                    $('#m_modal_1').modal(true);
                }
            });
        },
        events: {
            url: getAllUrl
        },
        loading: function(bool) {
            $('#loading').toggle(bool);
        },
        eventRender: function(eventObj, $el) {
            $el.popover({
                content: eventObj.description,
                trigger: 'hover',
                placement: 'top',
                container: 'body',
            });
        }
    });
});
