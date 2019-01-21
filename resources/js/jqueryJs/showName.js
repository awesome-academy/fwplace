$(document).ready(function() {
    let areas = $('area');
    for (let i = 0; i < areas.length; i++) {
        let name = $(areas[i]).attr('title');
        let coords = $(areas[i])
            .attr('coords')
            .split(',');
        coords.forEach(function(value, index) {
            coords[index] = parseInt(value);
        });
        let x = (coords[0] + coords[2]) / 2;
        let y = (coords[1] + coords[3]) / 2;
        let element = document.createElement('span');
        $(element).addClass('font-weight-bold');
        $(element).addClass('position-absolute');
        $(element).text(name);

        $('#diagram-img')
            .children()
            .first()
            .prepend(element);

        x = x - $(element)[0].offsetWidth / 2;
        y = y - $(element)[0].offsetHeight / 2;
        $(element).attr('style', `margin-top: ${y}px; margin-left: ${x}px;`);
    }
});
