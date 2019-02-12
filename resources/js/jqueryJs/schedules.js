$(document).ready(function() {
    function resize() {
        let left = $('.left-row');
        let right = $('.right-row');
        for (let i = 0; i < left.length; i++) {
            let height = $(left[i]).height();
            if ($(right[i]).height() > height) {
                $(left[i]).height($(right[i]).height());
            } else {
                $(right[i]).height(height);
            }
        }
    }

    window.onresize = function(event) {
        resize();
    };

    var readyStateCheckInterval = setInterval(function() {
        if (document.readyState === 'complete') {
            clearInterval(readyStateCheckInterval);
            resize();
        }
    }, 10);

    $('.right-schedule').scroll(function(event) {
        $('.left-schedule').scrollTop($(this).scrollTop());
    });

    $('#submit-filter').click(function() {
        $('#form-filter').attr('action', route('schedule.index'));
        $('#form-filter').submit();
    });

    $('#export').click(function() {
        $('#form-filter').attr('action', route('schedule.export'));
        $('#form-filter').submit();
    });

    function showSpecialDays() {
        $.ajax({
            url: 'getSpecialDay',
            method: 'get',
            success: function(result) {
                for (let i = 0; i < result.length; i++) {
                    let from = new Date(result[i].from);
                    let to = new Date(result[i].to);
                    for (
                        let date = from;
                        date <= to;
                        date.setDate(date.getDate() + 1)
                    ) {
                        let element = $(
                            `td[data-date='${[
                                date.getDate(),
                                date.getMonth() + 1,
                                date.getFullYear()
                            ].join('-')}']`
                        );
                        $(element).attr('data-toggle', 'tooltip');
                        $(element).attr('title', result[i].title);
                        $(element).removeClass('bg-danger');
                        if (result[i].is_compensation) {
                            $(element).addClass('bg-success');
                        } else {
                            $(element).addClass('bg-warning');
                        }
                    }
                }

                $('[data-toggle=tooltip]').tooltip();
            }
        });
    }

    showSpecialDays();
});
