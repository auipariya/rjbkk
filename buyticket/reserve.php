<form method="post" action="<?php echo $host ?>/viewcart/" class="form-horizontal" style="margin-top: -20px;">
    <input type="hidden" name="orderId" value="">
    <input type="hidden" name="type" value="jump">
    <input type="hidden" name="description">

    <div class="panel-group" id="accordion">
        <div class="panel panel-info" id="panelSelectDate">
            <div class="panel-heading" style="padding: 0;">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSelectDate" class="btn btn-block btn-link" style="text-align: left;">
                        1. <?=$lang['label']['selectDate']?>
                        <span class="pull-right" style="position: absolute; right: 30px;" aria-label="reserveDate"></span>
                    </a>
                </h4>
            </div>
            <div id="collapseSelectDate" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 control-label"><?=$lang['label']['selectDate']?></label>
                        <div class="col-xs-12 col-sm-4">
                            <div class="input-group date" id="reserveDate">
                                <input type="text" name="reserveDate" class="form-control">
                                <label class="input-group-addon"><i class="fa fa-calendar"></i></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default" id="panelSelectTime">
            <div class="panel-heading" style="padding: 0;">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSelectTime" class="btn btn-block btn-link disabled" style="text-align: left;">
                        2. <?=$lang['label']['selectTime']?>
                        <span class="pull-right" style="position: absolute; right: 30px;" aria-label="reserveTime"></span>
                        <input type="hidden" name="reserveTime">
                    </a>
                </h4>
            </div>
            <div id="collapseSelectTime" class="panel-collapse collapse">
                <div class="panel-body">
                    <div>
                        <?=$lang['label']['selectTimeOn']?> <b><span aria-label="reserveDate"></span></b>
                    </div>
                    <div class="row"></div>
                </div>
            </div>
        </div>
        <div class="panel panel-default" id="panelSelectTicket">
            <div class="panel-heading" style="padding: 0;">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSelectTicket" class="btn btn-block btn-link disabled" style="text-align: left;">
                        3. <?=$lang['label']['selectTicket']?>
                    </a>
                </h4>
            </div>
            <div id="collapseSelectTicket" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table table-condensed table-strip" id="tableTicket">
                            <thead>
                            <tr>
                                <th style="width: 40%"><?=$lang['label']['ticketType']?></th>
                                <th style="width: 20%" class="text-right"><?=$lang['label']['minute']?></th>
                                <th style="width: 20%" class="text-right"><?=$lang['label']['price']?></th>
                                <th style="width: 20%" class="text-right"><?=$lang['label']['quantity']?></th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-warning"><?php echo $lang['button']['addToCart'] ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function () {
        var reserveDate = $('#reserveDate');
        var jumpclass = {};
        var dayTime = [];
        var ticketType = [];
        var classId = '<?php echo (isset($_GET["id"]) ? $_GET['id'] : "") ?>';

        $.ajax({
            url: '<?php echo $host ?>/app/services/admin/jumpclass.php?mode=retrieve',
            method: 'post',
            data: { id: classId },
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    jumpclass = response.data['jumpclass'][0];
                    dayTime = response.data['dayTime'];
                    ticketType = response.data['ticketType'];

                    $('#headerTitle').text(jumpclass.name);
                    $('head > title').prepend(jumpclass.name);
                    $('input[name=description]').val(jumpclass.name);

                    // set option calendar control
                    var dayId = [0, 1, 2, 3, 4, 5, 6];
                    var dayIdEnable = [];
                    var dayIdDisable = [];
                    $.each(dayTime, function (i, item) { dayIdEnable.push(parseInt(item.day)); });
                    dayId.filter(function (j) { if(dayIdEnable.indexOf(j) == -1){ dayIdDisable.push(j); } });

                    var currentDate = new Date();
                    currentDate.setDate(currentDate.getDate() - 1);

                    optionsDate.daysOfWeekDisabled = dayIdDisable;
                    optionsDate.minDate = currentDate;
                    reserveDate.datetimepicker(optionsDate);

                    //createTableTicket();
                }
            }
        });

        // on select date change
        reserveDate.on("dp.change", function (e) {
            $('span[aria-label=reserveDate]').text($(this).find('input[name=reserveDate]').val());
            var timeContainerNode = $('#collapseSelectTime .row').empty();
            var btnCollapseSelectTime = $('a[href=#collapseSelectTime]');
            btnCollapseSelectTime.trigger('click');
            btnCollapseSelectTime.removeClass('disabled');
            $('#panelSelectTime').removeClass('panel-default').addClass('panel-info');

            var currentDay = dayTime.filter(function (item) { return parseInt(item.day) == e.date.day(); });
            $.each(currentDay, function (i, item) {
                //console.log(item);

                if(jumpclass.ticket_time_inherit == 1){
                    var currentDate = new Date();
                    var selectDate = new Date(e.date.toDate().toDateString() + ' ' + item.duration_from);
                    if(currentDate < selectDate){
                        var timeNode =  $('<div>').addClass('col-xs-6').appendTo(timeContainerNode);
                        var btnTimeNode = $('<a>', { text: item.duration_from }).css('cursor', 'pointer').appendTo(timeNode);
                        btnTimeNode.on('click', timeNodeClick);
                    }
                }
                else{
                    var timeFrom = new Date(e.date.toDate().toDateString() + ' ' + item.duration_from);
                    if (timeFrom.toDateString() == new Date().toDateString()){
                        if(new Date().getMinutes() > 30){
                            timeFrom.setHours(new Date().getHours() + 1);
                            timeFrom.setMinutes(0);
                        }
                        else{
                            timeFrom.setHours(new Date().getHours());
                            timeFrom.setMinutes(30);
                        }
                    }
                    var timeTo = new Date(e.date.toDate().toDateString() + ' ' + item.duration_to);

                    while(timeFrom < timeTo){
                        var timeStr = timeFrom.formatTimeUS();

                        var timeNode =  $('<div>').addClass('col-xs-6').appendTo(timeContainerNode);
                        var btnTimeNode = $('<a>', { text:timeStr }).css('cursor', 'pointer').appendTo(timeNode);
                        btnTimeNode.on('click', timeNodeClick);

                        var newDate = timeFrom.setMinutes(timeFrom.getMinutes() + 30);
                        timeFrom = new Date(newDate);
                    }
                }
            });
        });

        function timeNodeClick(e){
            $('span[aria-label=reserveTime]').text($(e.target).text());
            $('input[name=reserveTime]').val($(e.target).text());
            var btnCollapseSelectTicket = $('a[href=#collapseSelectTicket]');
            btnCollapseSelectTicket.trigger('click');
            btnCollapseSelectTicket.removeClass('disabled');
            $('#panelSelectTicket').removeClass('panel-default').addClass('panel-info');
            $('#tableTicket > tbody').empty();
            createTableTicket();
        }

        // create table ticket method
        function createTableTicket(){
            $('form button[type=submit]').addClass('hidden');
            if(ticketType.length > 0){
                $.ajax({
                    url:  '<?php echo $host; ?>/app/services/admin/remaining.php?mode=getCurrentBlocked',
                    method: 'post',
                    data: {
                        classId: classId,
                        reserveDate: $('input[name="reserveDate"]').val(),
                        reserveTime: $('input[name="reserveTime"]').val()
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success == true) {
                            $.each(ticketType, function (i, item) {
                                var blockedTicket = response.data.filter(function (block) {
                                    return block.ticket_id == item.id;
                                })[0];

                                if(blockedTicket == null){
                                    $.ajax({
                                        url:  '<?php echo $host; ?>/app/services/admin/remaining.php?mode=all',
                                        method: 'post',
                                        data: {
                                            classId: classId,
                                            ticketId: item.id,
                                            reserveDate: $('input[name="reserveDate"]').val()
                                        },
                                        dataType: 'json',
                                        success: function (response) {
                                            if (response.success == true) {
                                                var reserveFull = response.data.filter(function (reserve) {
                                                    return reserve.ticket_id == item.id;
                                                })[0];

                                                var currentDay = reserveDate.data('DateTimePicker').date().day();
                                                var dayDisable30Min = [0, 6]; // sun, sat
                                                var disabled30Min = (dayDisable30Min.indexOf(currentDay) != -1) ? true : false;
                                                if(disabled30Min == true && item.minute == 30){
                                                    return true;
                                                }

                                                if(reserveFull == undefined || new Date(reserveFull.reserve_date + ' ' + reserveFull.reserve_time).formatTimeUS() != $('input[name="reserveTime"]').val()){
                                                    $('form button[type=submit]').removeClass('hidden');

                                                    var idArr = new Date().getTime();
                                                    var tableRow = $('<tr>').appendTo('#tableTicket > tbody');
                                                    $('<td>', { text: item.name }).css('vertical-align', 'middle').appendTo(tableRow);
                                                    $('<td>', { text: item.minute }).addClass('text-right').css('vertical-align', 'middle').appendTo(tableRow);
                                                    $('<td>', { text: '฿'+parseFloat(item.price).toLocaleString() }).addClass('text-right').css('vertical-align', 'middle').appendTo(tableRow);
                                                    var cellQuantity = $('<td>').appendTo(tableRow);
                                                    $('<input>', {
                                                        type: 'number', name: 'quantity['+ idArr +']', min: 0, max: 50, value: 0
                                                    }).addClass('form-control').appendTo(cellQuantity);
                                                    $('<input>', {
                                                        type: 'hidden', name: 'id[' + idArr + ']', value: item.id
                                                    }).appendTo(cellQuantity);
                                                    $('<input>', {
                                                        type: 'hidden', name: 'name[' + idArr + ']', value: item.name
                                                    }).appendTo(cellQuantity);
                                                    $('<input>', {
                                                        type: 'hidden', name: 'price[' + idArr + ']', value: item.price
                                                    }).appendTo(cellQuantity);
                                                }
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    }
                });
            }
        }
    });
</script>