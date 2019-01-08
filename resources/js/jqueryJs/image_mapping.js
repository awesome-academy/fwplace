$(document).ready(function() {
    (function($) {
        $(document).trigger('init');
    })(jQuery);
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        (i[r] =
            i[r] ||
            function() {
                (i[r].q = i[r].q || []).push(arguments);
            }),
            (i[r].l = 1 * new Date());
        (a = s.createElement(o)), (m = s.getElementsByTagName(o)[0]);
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m);
    })(
        window,
        document,
        'script',
        'bower_components/lib_image_map/www.google-analytics.com/analytics.js',
        'ga'
    );
    ga('create', 'UA-50082177-1', 'image-map.net');
    ga('send', 'pageview');

    var _fo = _fo || [];
    _fo.push({
        m: 'true',
        c: 'f8e147',
        i: 10442
    });
    if (typeof fce == 'undefined') {
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src =
            ('https:' == document.location.protocol ? 'https://' : 'http://') +
            'formcrafts.com/js/fc.js';
        var fi = document.getElementsByTagName('script')[0];
        fi.parentNode.insertBefore(s, fi);
        fce = 1;
    }
});
