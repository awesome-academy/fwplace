$(document).ready(function() {
    function created() {
        let id = $('#workspace_id').val();

        $.ajax({
            url: route('api.get_design_without_diagram', [id]),
            method: 'get',
            success: function(result) {
                let diagram = result;
                let keys = Object.keys(diagram);

                for (let i = 0; i < keys.length; i++) {
                    let color = diagram[keys[i]].color;
                    let data = diagram[keys[i]].data;
                    for (let j = 0; j < data.length; j++) {
                        let cell = $(
                            `.seat-cell[row=${data[j].row}][column=${
                                data[j].column
                            }]`
                        );
                        $(cell).css('background-color', color);
                        $(cell).attr('data-name', keys[i]);
                        $(cell).attr('data-usable', data[i].usable);
                        if (data[i].usable == 1) {
                            $(cell).append(
                                `<a href="${route('generate', [
                                    diagram[keys[i]].id
                                ])}"></a>`
                            );
                        }
                    }

                    appendAreaList(color, keys[i], data[i].usable);
                }
            }
        });
    }

    function appendAreaList(color, name, usable) {
        usable = usable || 1;

        $('.area-section').append(
            `<li class="area-list" data-name="${name}" data-usable="${usable}">
            <a href="javascript:void(0)" class="color"><div class="area-color" style="background-color: ${color}"></div></a>
            <label>${name}</label>
        </li>`
        );
        let element = $(`.area-list[data-name="${name}"]`)
            .children('.color')
            .children('.area-color');
        $(`td[data-name="${name}"]`).css({
            'background-color': color
        });
        $(`td[data-name="${name}"]`).attr('data-usable', usable);
        $(element).css({
            'background-color': color
        });
        $('.cell-selected').css({
            'background-color': color
        });

        $('.cell-selected').attr('data-name', name);
        $('.cell-selected').attr('data-usable', usable);
        $('.cell-selected').attr('class', 'seat-cell area-selected');
    }

    $(document).on('click', '.options.without-diagram', function() {
        created();
    });
});
