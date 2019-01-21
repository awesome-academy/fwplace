$(document).ready(function() {
    function isElementScrollingOut(element) {
        var pageTop = $(window).scrollTop();
        var pageBottom = pageTop + $(window).height();
        var elementTop = $(element).offset().top;
        var elementBottom = elementTop + $(element).height();

        if (elementBottom <= pageBottom) {
            return pageBottom - elementBottom;
        } else {
            return false;
        }
    }

    function resize() {
        let element = $('#scroll');
        scrolling();
        $(element).css('width', $('.report-section').innerWidth());
        $(element)
            .children('div')
            .css('width', $('.report-section')[0].scrollWidth);
    }

    resize();

    window.onresize = function() {
        resize();
    };

    $('#scroll').scroll(function() {
        $('.report-section')[0].scrollLeft = $('#scroll')[0].scrollLeft;
    });

    function scrolling() {
        var diff = isElementScrollingOut($('.report-section')[0]);
        if (diff) {
            $('#scroll').css('bottom', diff);
        } else {
            $('#scroll').css('bottom', 0);
        }
    }

    $(window).scroll(function() {
        scrolling();
    });
});
