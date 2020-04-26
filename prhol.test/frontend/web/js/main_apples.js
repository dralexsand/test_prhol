$(function () {

    let unit = parseInt($('#unit').html());
    let time_to_disapperance = parseInt($('#time_to_disappearance').html()) * parseInt($('#unit').html());

    var count = 0;

    var timer = $.timer(function () {
        $('#counter').html(++count);
        checkTimeAfterFall();
    });
    timer.set({time: 1000, autostart: true});

    function checkTimeAfterFall() {
        let obj = getDataItems();
        let time_after_fall, attr_id, el, ms, message;
        for (let entry of obj) {

            if (entry.status !== 1) { // check only lives apples
                if (entry.date_fall !== 0) { // check only falling apples

                    ms = new Date();

                    message = 'Current time: ' + parseInt(ms.getTime());
                    message += '<br> date_fall: ' + parseInt(entry.date_fall);
                    let time_after_fall = parseInt(parseInt(ms.getTime() / 60) - parseInt(entry.date_fall) / 60);
                    message += '<br> time_after_fall: ' + time_after_fall;
                    message += '<br> time_to_disapperance: ' + time_to_disapperance;

                    //$('#timemessage').html(message);

                    if (time_to_disapperance <= time_after_fall) {
                        let id = '#' + entry.id;
                        let attr_id = $(id).attr('attr-order');
                        setDataById(attr_id, entry.top, entry.date_fall, entry.size, 1); // Hide when apple is out of range of time_to_disapperance
                    }

                }
            }
        }
    }

    function setPositionContent() {
        let pos_left = (window.innerWidth - 1200) / 2;
        document.getElementById("content").style.left = parseInt(pos_left) + "px";
    }

    setPositionContent();

    $('body').on('click', '.apple_form', function (e) {
        let item_id = $(this).attr('id');
        let item_id_full = '#' + item_id;
        let attr_id = $(this).attr('attr-order');

        let dataItems = getDataItems();

        let generation_id = dataItems[attr_id]['generation_id'];
        let color = dataItems[attr_id]['color'];
        let date_appearance = dataItems[attr_id]['date_appearance'];
        let date_fall = dataItems[attr_id]['date_fall'];
        let size = dataItems[attr_id]['size'];
        let status = dataItems[attr_id]['status'];
        let reason = dataItems[attr_id]['reason'];
        let pos_left = dataItems[attr_id]['left'] + 'px';
        let pos_top_init = (parseInt(dataItems[attr_id]['top']));
        let pos_top = (parseInt(dataItems[attr_id]['top']) + 600);
        let pos_top_fall = pos_top + 'px';
        var ms;

        if (parseInt(date_fall) === 0) {
            var dialog = bootbox.dialog({
                title: 'Что сделать с яблоком?',
                message: "<p>Размер яблока: " + size + "</p>",
                size: 'medium',
                locale: 'ru',
                buttons: {
                    cancel: {
                        label: "Отменить",
                        className: 'btn-info',
                        callback: function () {
                            return;
                        }
                    },
                    fall: {
                        label: "Уронить",
                        className: 'btn-danger',
                        callback: function () {
                            $(item_id_full).animate({
                                'left': pos_left,
                                'top': pos_top_fall,
                            }, 1000);
                            size = parseInt(size) - parseInt($('#eat').val());
                            status = parseInt(size) == 0 ? 1 : 0;
                            ms = new Date();
                            date_fall = ms.getTime();
                            setDataById(attr_id, pos_top, date_fall, size, status);
                            return;
                        }
                    },
                    ok: {
                        label: "Откусить",
                        className: 'btn-info',
                        callback: function () {
                            size = parseInt(size) - parseInt($('#eat').val());
                            status = parseInt(size) == 0 ? 1 : 0;
                            date_fall = 0;
                            setDataById(attr_id, pos_top_init, date_fall, size, status);
                        }
                    }
                }
            });

            dialog.init(function () {
                dialog.find('.bootbox-body').append('Сколько откусить, % <input id="eat" type="number" step=5 placeholder="%" min="0" max="' + size + '" value="0">');
            });

        } else {

            var dialog = bootbox.dialog({
                title: 'Яблоко уже на земле. Можно только откусить',
                message: "<p>Размер яблока: " + size + "</p>",
                size: 'medium',
                locale: 'ru',
                /*inputType: 'number',*/
                buttons: {
                    cancel: {
                        label: "Отменить",
                        className: 'btn-info',
                        callback: function () {
                            return;
                        }
                    },
                    ok: {
                        label: "Откусить",
                        className: 'btn-info',
                        callback: function () {
                            size = parseInt(size) - parseInt($('#eat').val());
                            status = parseInt(size) == 0 ? 1 : 0;
                            setDataById(attr_id, pos_top_init, date_fall, size, status);
                        }
                    }
                }
            });

            dialog.init(function () {
                dialog.find('.bootbox-body').append('Сколько откусить, % <input id="eat" type="number" step=5 placeholder="%" min="0" max="' + size + '" value="0">');
            });
        }


    });

    function getDataItems() {
        return JSON.parse($('#items_data').html());
    }

    function setDataById(attr_id, pos_top_fall, date_fall, size, status) {
        let dataItems = getDataItems();
        dataItems[attr_id]['top'] = pos_top_fall;
        dataItems[attr_id]['date_fall'] = date_fall;
        dataItems[attr_id]['size'] = size;
        dataItems[attr_id]['status'] = status;
        let jsonItems = JSON.stringify(dataItems);

        $('#items_data').html(jsonItems);

        let el = $("div[attr-order='" + attr_id + "']");
        if (parseInt(status) === 1) el.hide();
        if (parseInt(size) === 0) el.hide();
    }

    $('body').on('click', '#generate_harvest', function () {
        let redirect = document.location.href;
        document.location.href = redirect;
    });

    $('body').on('click', '#save_harvest', function () {

        let data = $('#items_data').html();

        let params = {
            'action': 'save_harvest',
            'generation_id': $('#generation_id').html(),
            'data': $('#items_data').html(),
        };

        ajaxRequest(params);

    });

    function ajaxRequest(params) {

        let url = location.origin + '/ajax/request';
        let datatype = 'text';

        jQuery.ajax({
            url: url,
            async: false,
            type: 'POST',
            data: {'param': params},
            dataType: datatype,
            success: function (data) {
                ajaxSuccess(data, params);
            },
            error: function (data) {
                ajaxError(data);
            }
        });
    }

    function ajaxSuccess(data, params) {

        switch (params.action) {
            case 'save_harvest':
                $('#status-area').flash_message({
                    text: 'Данные сохранены успешно',
                    how: 'append'
                });
                break;
        }
    }

    function ajaxError(data) {
        console.log('ajax error:');
        console.log(data);
    }


});

(function ($) {
    $.fn.flash_message = function (options) {

        options = $.extend({
            text: 'Done',
            time: 1000,
            how: 'before',
            class_name: ''
        }, options);

        return $(this).each(function () {
            if ($(this).parent().find('.flash_message').get(0))
                return;

            var message = $('<span />', {
                'class': 'flash_message ' + options.class_name,
                text: options.text
            }).hide().fadeIn('fast');

            $(this)[options.how](message);

            message.delay(options.time).fadeOut('normal', function () {
                $(this).remove();
            });

        });
    };
})(jQuery);

