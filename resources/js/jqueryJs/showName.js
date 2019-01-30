$(document).ready(function() {
    function created() {
        let areas = $('area');
        resizeAreas(areas, true);
        $(areas).remove();
    }

    let image = document.getElementById('workspace_img');
    image.onload = function() {
        created();
    };

    window.onresize = function() {
        resizeAreas($('.areas'));
    };

    function resizeAreas(areas, isCreate) {
        isCreate = isCreate || false;
        let width = $('#workspace_img')[0].naturalWidth;
        let clientWidth = $('#workspace_img')[0].clientWidth;
        let height = $('#workspace_img')[0].naturalHeight;
        let clientHeight = $('#workspace_img')[0].clientHeight;

        for (let i = 0; i < areas.length; i++) {
            let coords = $(areas[i])
                .attr('coords')
                .split(',');
            coords.forEach(function(value, index) {
                coords[index] = parseInt(value);
            });
            let x = ((coords[2] - coords[0]) / width) * clientWidth;
            let y = ((coords[3] - coords[1]) / height) * clientHeight;
            let mleft =
                (coords[0] / width) * clientWidth +
                $('#workspace_img')[0].offsetLeft;
            let mtop = (coords[1] / height) * clientHeight;

            if (isCreate) {
                appendElement(areas[i], mleft, mtop, x, y);
            } else {
                $(areas[i]).attr(
                    'style',
                    `margin-left: ${mleft}px;
                    margin-top: ${mtop}px;
                    width: ${x}px;
                    height: ${y}px;
                    background-color: white`
                );
            }
        }
    }

    function appendElement(area, mleft, mtop, width, height) {
        let name = $(area).attr('title');
        let element = document.createElement('div');
        $(element).addClass('font-weight-bold position-absolute');
        let link = document.createElement('a');
        $(link).text(name);
        link = setFontSize(link, width, height);
        $(link).addClass('d-block h-100');
        // $(link).css('line-height', height + 'px');
        $(element).addClass('areas text-center');
        $(link).attr('href', $(area).attr('href'));
        $(link).attr('target', $(area).attr('target'));
        $(element).append(link);

        $('#workspace_img')
            .parent()
            .prepend(element);

        $(element).attr(
            'style',
            `margin-left: ${mleft}px;
            margin-top: ${mtop}px;
            width: ${width}px;
            height: ${height}px;
            background-color: white`
        );
        $(element).attr('coords', $(area).attr('coords'));
    }

    function setFontSize(element, width, height) {
        let min = width < height ? width : height;
        $(element).css({
            'line-height': height + 'px',
            'font-size': min / 5 + 'px',
            'text-decoration': 'none'
        });

        return element;
    }
});
