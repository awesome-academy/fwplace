$(document).ready(function() {
    $('.generate').click(function() {
        let row = $('input[name=row]').val();
        let column = $('input[name=column').val();
        let table = document.createElement('table');
        let tbody = document.createElement('tbody');
        tbody.setAttribute('id', 'selectable');
        for (let i = 0; i < row; i++) {
            let tr = document.createElement('tr');
            tr.classList.add('row');
            tr.setAttribute('draggable', false);
            for (let j = 0; j < column; j++) {
                let td = document.createElement('td');
                td.classList.add('seat-cell');
                td.setAttribute('draggable', false);
                tr.append(td);
            }
            tbody.append(tr);
        }
        table.setAttribute('draggable', false);
        table.append(tbody);
        $('.design-section').html(table);
    });

    $(document).on('mousedown', '.seat-cell', function(event) {
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
    });

    function appendAreaList(color, name) {
        $('.area-section').append(
            `<li class="area-list" data-name="${name}">
                <div class="area-color" style="background-color: ${color}"></div>
                <label>${name}</label>
                <a href="javascript:void(0)" class="remove-area">X</a>
            </li>`
        );
        $('.cell-selected').css({
            'background-color': color
        });
        $('.cell-selected').attr('data-name', name);
        $('.cell-selected').attr('class', 'seat-cell area-selected');
    }

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
        appendAreaList(color, name);
    });

    function removeArea(name, areaList) {
        $(areaList)
            .parents('li')
            .remove();
        let elements = $(`.seat-cell[data-name=${name}]`);
        $(elements).removeAttr('style');
        $(elements).removeAttr('data-name');
        $(elements).attr('class', 'seat-cell');
    }

    $(document).on('click', '.remove-area', function() {
        let param;
        let name = $(this)
            .parents('li')
            .attr('data-name');
        removeArea(name, $(this));
    });

    function checkSelect() {
        if ($('.design-section').children().length == 0) {
            swal('Please generate area table!');

            return false;
        }
        if ($('.cell-selected').length == 0) {
            swal('Please select area!');

            return false;
        }

        return true;
    }

    $('#newArea').click(function() {
        if ($('input[type=text][name=name]').val().length < 1) {
            swal('Please input area name!');

            return;
        }

        if (!checkSelect()) {
            return;
        }

        appendAreaList(
            $('input[type=color][name=color]').val(),
            $('input[type=text][name=name]').val()
        );
    });
});
