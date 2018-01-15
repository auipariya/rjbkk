/**
 * Created by Aui on 23/6/2559.
 */
if(typeof jQuery === 'undefined'){
    throw new Error('Main\'s JavaScript requires jQuery');
}

$('[data-toggle="popover"]').popover();

/**
 * Change password
 */
+function($){
    'use strict';

    var formChangePassword = $('#formChangePassword');
    var modalChangePassword = $('#modalChangePassword');
    var modalAlertMessage = modalChangePassword.find('div[role="alert"]');

    reset();
    modalChangePassword.on('hidden.bs.modal', function (e) {
        reset();
    });
    modalChangePassword.find('[data-dismiss="modal"]').on('click', function (e) {
        reset();
    });
    modalChangePassword.find('button[type="submit"]').on('click', function (e) {
        e.preventDefault();

        modalAlertMessage.css('display', 'none');
        modalAlertMessage.find('ul').remove();
        $(e.target).prop('disabled', true);
        $.ajax({
            url: formChangePassword[0].action,
            method: formChangePassword[0].method,
            data: formChangePassword.serialize(),
            dataType: 'json',
            success: function (response) {
                $(e.target).prop('disabled', false);

                if (response.success == true) {
                    location.href = ''
                }
                else {
                    $("<ul>").appendTo(modalAlertMessage);
                    for(var i in response.data){
                        $('<li>', { text: response.data[i] }).appendTo(modalAlertMessage.find('ul'));
                    }
                    modalAlertMessage.fadeIn();
                }
            }
        });
    });

    function reset () {
        modalChangePassword.find('button[type="submit"]').prop('disabled', false);
        modalAlertMessage.css('display', 'none');
        modalAlertMessage.find('ul').remove();
        formChangePassword.trigger('reset');
    }
}(jQuery);

/**
 * Pass
 */
+function($){
    'use strict';

    var parentNode = $('#adminPass');

    var durationFrom = parentNode.find('input[name=duration_from]');
    var durationTo = parentNode.find('input[name=duration_to]');

    durationFrom.datetimepicker(optionsDate);
    durationTo.datetimepicker(optionsDate);

    durationFrom.on("dp.change", function (e) {
        durationTo.data("DateTimePicker").minDate(e.date);
    });
    durationTo.on("dp.change", function (e) {
        durationFrom.data("DateTimePicker").maxDate(e.date);
    });
}(jQuery);


/**
 * Jump class
 */
+function($){
    'use strict';

    var parentNode = $('#adminJumpClass');

    // Duration date
    var durationFrom = parentNode.find('input[name=duration_from]');
    var durationTo = parentNode.find('input[name=duration_to]');

    durationFrom.datetimepicker(optionsDate);
    durationTo.datetimepicker(optionsDate);

    durationFrom.on("dp.change", function (e) {
        durationTo.data("DateTimePicker").minDate(e.date);
    });
    durationTo.on("dp.change", function (e) {
        durationFrom.data("DateTimePicker").maxDate(e.date);
    });


    // Duration time
    var timeFrom = parentNode.find('input[name=time_from]');
    var timeTo = parentNode.find('input[name=time_to]');

    timeFrom.datetimepicker(optionTime);
    timeTo.datetimepicker(optionTime);

    timeFrom.on("dp.change", function (e) {
        timeTo.data("DateTimePicker").minDate(e.date);
    });
    timeTo.on("dp.change", function (e) {
        timeFrom.data("DateTimePicker").maxDate(e.date);
    });


    /*** Add day time ***/
    var day = parentNode.find('select[name=day]');
    
    var tableDayTime = parentNode.find('#tableDayTime');
    var btnAddDayTime = tableDayTime.find('thead button');

    btnAddDayTime.on('click', function (e) {
        if(day.val() != '' && timeFrom.val() != '' && timeTo.val() != ''){
            createDayTimeRecord();
        }
    });

    tableDayTime.on('click', 'tbody i[role=button]', function (e) {
        e.preventDefault();

        var tableRow = $(this).parent().parent();
        tableRow.remove();
    });

    function createDayTimeRecord () {
        var rowId =  (new Date()).getTime();

        var tableRow = $('<tr>');
        tableRow.appendTo(tableDayTime.find('tbody'));
        $('<td>', { text: day.find('option:selected').text() }).appendTo(tableRow);
        $('<td>', { text: fillZeroTime(timeFrom.val()) + ' - ' + fillZeroTime(timeTo.val()) }).addClass('text-center').appendTo(tableRow);
        $('<td class="text-right">').appendTo(tableRow);
        $('<i class="fa fa-times text-danger" role="button">').css({ cursor: 'pointer' }).appendTo(tableRow.find('td:last'));

        $('<input>', { type: 'hidden', name: '_day[' + rowId + ']', value: day.val() }).appendTo(tableRow);
        $('<input>', { type: 'hidden', name: '_time_from[' + rowId + ']', value: timeFrom.val() }).appendTo(tableRow);
        $('<input>', { type: 'hidden', name: '_time_to[' + rowId + ']', value: timeTo.val() }).appendTo(tableRow);

        timeFrom.data("DateTimePicker").maxDate(false);
        timeTo.data("DateTimePicker").minDate(false);

        day.val('');
        timeFrom.val('');
        timeTo.val('');
    }


    /*** Add ticket type ***/
    var ticketName = parentNode.find('input[name=ticket_name]');
    var ticketTime = parentNode.find('input[name=ticket_time]');
    var ticketPrice = parentNode.find('input[name=ticket_price]');

    var tableTicketType = parentNode.find('#tableTicketType');
    var btnAddTicketType = tableTicketType.find('thead button');
    
    btnAddTicketType.on('click', function (e) {
        if(ticketName.val() != '' && ticketTime.val() != '' && ticketPrice.val() != ''){
            createTicketTypeRecord();
        }
    });

    tableTicketType.on('click', 'tbody i[role=button]', function (e) {
        e.preventDefault();

        var tableRow = $(this).parent().parent();
        tableRow.remove();
    });

    function createTicketTypeRecord () {
        var rowId =  (new Date()).getTime();

        var _ticketTimeNumber = parseFloat(ticketTime.val() || 0).toLocaleString();
        var _ticketPriceNumber = parseFloat(ticketPrice.val() || 0).toLocaleString();

        var tableRow = $('<tr>');
        tableRow.appendTo(tableTicketType.find('tbody'));var cellTicketName = $('<td>', { text: ticketName.val() }).appendTo(tableRow);
        $('<td>', { text: _ticketTimeNumber + ' MIN' }).css({ 'text-align': 'right' }).appendTo(tableRow);
        $('<td>').css({ 'text-align': 'right' }).append('฿' + _ticketPriceNumber).appendTo(tableRow);
        $('<td class="text-right">').appendTo(tableRow);
        $('<i class="fa fa-times text-danger" role="button">').css({ cursor: 'pointer' }).appendTo(tableRow.find('td:last'));

        $('<input>', { type: 'hidden', name: '_ticket_name[' + rowId + ']', value: ticketName.val() }).appendTo(tableRow);
        $('<input>', { type: 'hidden', name: '_ticket_time[' + rowId + ']', value: ticketTime.val() }).appendTo(tableRow);
        $('<input>', { type: 'hidden', name: '_ticket_price[' + rowId + ']', value: ticketPrice.val() }).appendTo(tableRow);

        ticketName.val('');
        ticketTime.val('');
        ticketPrice.val('');
    }


}(jQuery);