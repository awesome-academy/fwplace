function getSpecialDay(day){
    $(document).ready(function () {
        $.ajax({
            url: 'getSpecialDay',
            method: 'GET'
        }).done(function (result) {
            var kq = result.filter(function (arr) {
                return arr.from <= day.date && arr.to >= day.date;
            });
            if (kq && kq[0]) {
                if (kq[0].is_compensation != null) {
                    $('#' + day.date).addClass('bg-warning')
                    $('#' + day.date).html(`
                        <th scope="row">${day.format}</th>
                        <td>${day.day}</td>
                        <td colspan="2">${kq[0].title}</td>
                    `)
                } else {
                    $('#' + day.date).addClass('bg-danger')
                    $('#' + day.date).html(`
                        <th scope="row" class="text-white">${day.format}</th>
                        <td class="text-white">${day.day}</td>
                        <td colspan="2" class="text-white">${kq[0].title}</td>
                    `)
                }
            }
        })
    });
}
$(function(){
    $('tr[onload]').trigger('onload');
});

