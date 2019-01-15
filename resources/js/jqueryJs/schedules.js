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
});
