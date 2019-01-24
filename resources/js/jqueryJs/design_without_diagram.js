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

    function checkDuplicateName(name) {
        let list = $('.area-list');
        for (let i = 0; i < list.length; i++) {
            if ($(list[i]).attr('data-name') == name) {
                return true;
            }
        }

        return false;
    }

    function appendAreaList(color, name, usable) {
        usable = usable || 1;
        if (!checkDuplicateName(name)) {
            $('.area-section').append(
                `<li class="area-list" data-name="${name}" data-usable="${usable}">
                <a href="javascript:void(0)" class="color"><div class="area-color" style="background-color: ${color}"></div></a>
                <label>${name}</label>
                <a href="javascript:void(0)" class="remove-area">X</a>
            </li>`
            );
        } else {
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
        }
        $('.cell-selected').css({
            'background-color': color
        });

        $('.cell-selected').attr('data-name', name);
        $('.cell-selected').attr('data-usable', usable);
        $('.cell-selected').attr('class', 'seat-cell area-selected');
    }

    $(document).on('click', '.options.without-diagram', function() {
        let id = $('#workspace_id').val();
        $('.image-map-section').addClass('d-none');
        $.ajax({
            async: false,
            url: route('design_without_diagram', [id]),
            method: 'get',
            success: function(result) {
                $('.design.without-diagram').html(result);
            }
        });

        created();
    });

    $(document).on('click', '#edit_diagram_trigger', function() {
        editingFunc();
    });

    function editingFunc() {
        $('.choose-column-row').removeClass('d-none');
        $('#edit_diagram_trigger').addClass('d-none');
        $('.area-selected')
            .children('a')
            .remove();
        $('.design-section').addClass('editting');
        resize();
    }

    $(document).on('click', '.generate', function() {
        let row = $('input[name=row]').val();
        let column = $('input[name=column').val();
        let table = document.createElement('table');
        table.classList.add('m-auto');
        let tbody = document.createElement('tbody');
        tbody.setAttribute('id', 'selectable');
        for (let i = 0; i < row; i++) {
            let tr = document.createElement('tr');
            tr.classList.add('d-flex');
            tr.setAttribute('draggable', false);
            for (let j = 0; j < column; j++) {
                let td = document.createElement('td');
                td.classList.add('seat-cell');
                td.setAttribute('draggable', false);
                td.setAttribute('row', i);
                td.setAttribute('column', j);
                tr.append(td);
            }
            tbody.append(tr);
        }
        table.setAttribute('draggable', false);
        table.append(tbody);
        $('.design-section').html(table);
        resize();
    });

    $(document).on('mousedown', '.seat-cell', function(event) {
        if ($('.design-section').hasClass('editting')) {
            let flag;
            $(document).on('dragging', '.seat-cell', function(event) {
                $(document).on('mouseenter', '.seat-cell', function() {
                    if (flag === 1) {
                        if ($(this).hasClass('cell-selected')) {
                            $(this).attr('class', 'seat-cell');
                            $(this).removeAttr('style');
                        } else {
                            $(this).attr('class', 'seat-cell cell-selected');
                            $(this).removeAttr('style');
                        }
                    }
                });
            });
            $(document).on('dragend', '.seat-cell', function(event) {
                $(this).trigger('mouseup');
            });
            if (event.which === 1) {
                flag = 1;
                if ($(this).hasClass('cell-selected')) {
                    $(this).attr('class', 'seat-cell');
                    $(this).removeAttr('style');
                    $(this).removeAttr('data-name');
                } else {
                    $(this).attr('class', 'seat-cell cell-selected');
                    $(this).removeAttr('style');
                    $(this).removeAttr('data-name');
                }
                $(document).on('mouseenter', '.seat-cell', function() {
                    if (flag === 1) {
                        if ($(this).hasClass('cell-selected')) {
                            $(this).attr('class', 'seat-cell');
                        } else {
                            $(this).attr('class', 'seat-cell cell-selected');
                            $(this).removeAttr('style');
                            $(this).removeAttr('data-name');
                        }
                    }
                });

                $(document).on('mouseup', function() {
                    flag = 0;
                });
            }
        }
    });

    $(document).on('click', '.default-areas', function() {
        if (!checkSelect()) {
            return;
        }
        let color;
        let name;
        if ($(this).hasClass('door')) {
            color = '#757575';
            name = 'door';
        }
        if ($(this).hasClass('path')) {
            color = '#af5c5c';
            name = 'path';
        }
        if ($(this).hasClass('freespace')) {
            color = '#5caf8d';
            name = 'freespace';
        }
        appendAreaList(color, name, 2);
    });

    function removeArea(name, areaList) {
        $(areaList)
            .parents('li')
            .remove();
        let elements = $(`.seat-cell[data-name='${name}']`);
        $(elements).removeAttr('style');
        $(elements).removeAttr('data-name');
        $(elements).attr('class', 'seat-cell');
    }

    $(document).on('click', '.remove-area', function() {
        let name = $(this)
            .parents('li')
            .attr('data-name');
        removeArea(name, $(this));
        editingFunc();
    });

    function checkSelect() {
        if ($('.design-section').children().length == 0) {
            swal(Lang.get('messages.swal_title.generate'));

            return false;
        }
        if ($('.seat-cell.cell-selected').length == 0) {
            swal(Lang.get('messages.swal_title.select_area'));

            return false;
        }

        return true;
    }

    $(document).on('click', '#newArea', function() {
        if ($('input[type=text][name=name]').val().length < 1) {
            swal(Lang.get('messages.swal_title.input_name'));

            return;
        }

        if (!checkSelect()) {
            return;
        }

        appendAreaList(
            $('input[type=color][name=color]').val(),
            $('input[type=text][name=name]').val(),
            $('#usable').is(':checked') ? 2 : 1
        );
    });

    function getName() {
        let result = [];
        $('.area-list').each(function() {
            result.push($(this).attr('data-name'));
        });

        return result;
    }

    function getCellArray(elements) {
        let result = {};
        let data = [];
        $(elements).each(function() {
            let cell = {};
            cell['row'] = $(this).attr('row');
            cell['column'] = $(this).attr('column');
            cell['usable'] = $(this).attr('data-usable');
            data.push(cell);
        });

        result['color'] = $(elements)
            .first()
            .css('background-color');
        result['data'] = data;
        result['usable'] = $(elements)
            .first()
            .attr('data-usable');

        return result;
    }

    $(document).on('click', '#saveDiagram', function() {
        let arrayName = getName();
        let sendData = {};
        let len = arrayName.length;
        for (let i = 0; i < len; i++) {
            sendData[arrayName[i]] = getCellArray(
                $(`.area-selected[data-name='${arrayName[i]}']`)
            );
        }
        let id = $('#workspace_id').val();
        let row = $('#row').val();
        let column = $('#column').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: route('save_design_without_diagram'),
            method: 'POST',
            data: {
                content: sendData,
                workspace_id: id,
                row: row,
                column: column
            },
            success: function(result) {
                swal({
                    type: 'success',
                    title: Lang.get('messages.swal_title.success'),
                    text: result.message
                });
            },
            error: function(result) {
                swal({
                    type: 'error',
                    title: Lang.get('messages.swal_title.error'),
                    text: result.message
                });
            }
        });
    });

    $(document).on('click', '.area-color', function() {
        if (
            $('.design-section').hasClass('editting') &&
            $('.cell-selected').length > 0
        ) {
            let element = $(this).parents('li');
            let name = $(element).attr('data-name');
            let usable = $(element).attr('data-usable');
            let color = $(this).attr('style');

            $('.cell-selected').each(function() {
                $(this).attr('data-name', name);
                $(this).attr('data-usable', usable);
                $(this).attr('style', color);
                $(this).attr('class', 'seat-cell area-selected');
            });
        }
    });

    $(document).on('click', '#cancel', function() {
        $('.options.without-diagram').trigger('click');
    });
});
