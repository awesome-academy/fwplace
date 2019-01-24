window.isElementScrollingOut = function(element) {
    var pageTop = $(window).scrollTop();
    var pageBottom = pageTop + $(window).height();
    var elementTop = $(element).offset().top;
    var elementBottom = elementTop + $(element).height();

    if (elementBottom <= pageBottom) {
        return pageBottom - elementBottom;
    } else {
        return false;
    }
};

window.scrolling = function() {
    var diff = isElementScrollingOut($('.scroll-section')[0]);
    if (diff) {
        $('#scroll').css('bottom', diff);
    } else {
        $('#scroll').css('bottom', 0);
    }
};

window.resize = function() {
    let element = $('#scroll');
    scrolling();
    $(element).css('width', $('.scroll-section').innerWidth());
    $(element)
        .children('div')
        .css('width', $('.scroll-section')[0].scrollWidth);
};

$(document).ready(function() {
    resize();

    window.onresize = function() {
        resize();
    };

    $('#scroll').scroll(function() {
        $('.scroll-section')[0].scrollLeft = $('#scroll')[0].scrollLeft;
    });

    $(window).scroll(function() {
        scrolling();
    });
});
