<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 11/7/2559
 * Time: 19:06
 */

?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <!--<li role="presentation"><a href="#soldOut" aria-controls="soldOut" role="tab" data-toggle="tab">SOLD OUT</a></li>-->
    <li role="presentation" class="active"><a href="#blockClass" aria-controls="blockClass" role="tab" data-toggle="tab">BLOCK CLASS</a></li>
    <li role="presentation"><a href="#search" aria-controls="search" role="tab" data-toggle="tab">SEARCH</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <!--<div role="tabpanel" class="tab-pane fade" id="soldOut">
        1
    </div>-->
    <div role="tabpanel" class="tab-pane fade in active" id="blockClass" style="padding: 10px 0 0;">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-condensed" id="tableTickedBlocked">
                <thead>
                <tr>
                    <th style="width: 25%">CLASS</th>
                    <th style="width: 25%;">TICKET</th>
                    <th style="width: 25%;">DATE</th>
                    <th style="width: 25%;">TIME</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <td><p class="text-muted">No blocked jump class.</p></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="search" style="padding: 10px 0 0;">
        <form class="form-horizontal" method="post">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">CLASS<i style="color: red;">*</i></label>
                        <div class="col-sm-8">
                            <select type="text" name="jumpClass" class="form-control" required>
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">TICKET<i style="color: red;">*</i></label>
                        <div class="col-sm-8">
                            <select type="text" name="ticket" class="form-control" required>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">DATE<i style="color: red;">*</i></label>
                        <div class="col-sm-8">
                            <div class="input-group date" id="reserveDate">
                                <input type="text" name="reserveDate" class="form-control" required>
                                <label class="input-group-addon"><i class="fa fa-calendar"></i></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-condensed" id="tableRemaining">
                <thead>
                <tr>
                    <th style="width: 25%">TIME</th>
                    <th style="width: 25%;">QUOTA</th>
                    <th style="width: 25%;">RESERVED</th>
                    <th style="width: 25%;">AVAILABLE</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.page-header .btn').addClass('hidden');

        var blockedTime = [];
        var classList = [];
        var classInfo = [];
        var classRemain = [];
        var jumpclass = {};
        var dayTime = [];
        var ticketType = [];

        // add option class to select control
        var selJumpClass = $('select[name=jumpClass]');
        var selTicket = $('select[name=ticket]');
        var reserveDate = $('#reserveDate');

        reserveDate.datetimepicker(optionsDate);

        $.ajax({
            url:  '<?php echo $host; ?>/app/services/admin/jumpclass.php?mode=all',
            method: 'post',
            data: { status: 'a' },
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    classList = response.data;
                    $.each(classList, function (i, item) {
                        $('<option>', { value: item.id, text: item.name }).appendTo(selJumpClass);
                    });
                }
            }
        });

        getBlockedClass()
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var ariaControl = $(e.target).attr('aria-controls');
            if(ariaControl == 'soldOut'){
                console.log(1);
            }
            else if(ariaControl == 'blockClass'){
                getBlockedClass();
            }
        });

        selJumpClass.on('change', function () {
            // clear table body
            $('#tableRemaining > tbody').empty();
            reserveDate.find('input').val('');
            selTicket.empty();

            // append option node to select
            $.ajax({
                url:  '<?php echo $host; ?>/app/services/admin/ticket.php?mode=all',
                method: 'post',
                data: { classId: $(this).val() },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        $('<option>').appendTo(selTicket);
                        $.each(response.data, function (i, item) {
                            $('<option>', { value: item.id, text: item.name }).appendTo(selTicket);
                        });
                    }
                }
            });
        });

        selTicket.on('change', function () {
            // clear table body
            $('#tableRemaining > tbody').empty();

            // set calendar disabled day
            $.ajax({
                url: '<?php echo $host ?>/app/services/admin/jumpclass.php?mode=retrieve',
                method: 'post',
                data: { id: selJumpClass.val() },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        jumpclass = response.data['jumpclass'][0];
                        dayTime = response.data['dayTime'];
                        ticketType = response.data['ticketType'];

                        // set option calendar control
                        var dayId = [0, 1, 2, 3, 4, 5, 6];
                        var dayIdEnable = [];
                        $.each(dayTime, function (i, item) { dayIdEnable.push(parseInt(item.day)); });
                        var dayIdDisable = dayId.filter(function (j) { return dayIdEnable.indexOf(j) == -1 });

                        var currentDate = new Date();
                        currentDate.setDate(currentDate.getDate() - 1);

                        reserveDate.find('input').val('');
                        reserveDate.data("DateTimePicker").date(null);
                        reserveDate.data("DateTimePicker").minDate(currentDate);
                        reserveDate.data("DateTimePicker").daysOfWeekDisabled(dayIdDisable);
                    }
                }
            });
        });

        reserveDate.on("dp.change", function (e) {
            var _classId = selJumpClass.val();
            var _ticketId = selTicket.val();
            var _reserveDate = reserveDate.find('input').val();
            classInfo = classList.filter(function (item) { return item.id == _classId; })[0];

            // get blocked list with class ticket and date
            $.ajax({
                url:  '<?php echo $host; ?>/app/services/admin/remaining.php?mode=getBlocked',
                method: 'post',
                data: { classId: _classId, ticketId: _ticketId, reserveDate: _reserveDate },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        blockedTime = response.data;
                    }
                }
            });
            // create table ticket date list
            $.ajax({
                url:  '<?php echo $host; ?>/app/services/admin/remaining.php?mode=all',
                method: 'post',
                data: { classId: _classId, ticketId: _ticketId, reserveDate: _reserveDate },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        classRemain = response.data;
                        generateTimeTable(e);
                    }
                }
            });
        });

        function generateTimeTable(e){
            var currentDay = dayTime.filter(function (item) { return parseInt(item.day) == e.date.day(); });
            $('#tableRemaining > tbody').empty();
            $.each(currentDay, function (i, item) {
                if(jumpclass.ticket_time_inherit == 1){
                    var currentDate = new Date();
                    var selectDate = new Date(e.date.toDate().toDateString() + ' ' + item.duration_from);
                    if(currentDate < selectDate){
                        createTableTime(item.duration_from);
                    }
                }
                else{
                    var timeFrom = new Date(e.date.toDate().toDateString() + ' ' + item.duration_from);
                    if (timeFrom.toDateString() == new Date().toDateString()){
                        timeFrom.setHours(new Date().getHours());
                    }
                    var timeTo = new Date(e.date.toDate().toDateString() + ' ' + item.duration_to);

                    while(timeFrom < timeTo){
                        createTableTime(timeFrom.formatTimeUS());

                        var newDate = timeFrom.setMinutes(timeFrom.getMinutes() + 30);
                        timeFrom = new Date(newDate);
                    }
                }
            });
        }

        function createTableTime(time){
            var remainingClass = classRemain.filter(function (item) {
                return time == new Date(item.reserve_date + ' ' + item.reserve_time).formatTimeUS();
            });
            var _blockTime = blockedTime.filter(function (item) {
                return time == new Date(item.locked_date + ' ' + item.locked_time).formatTimeUS();
            })[0];
            var addClass = (_blockTime == undefined) ? 'fa fa-unlock-alt text-success' : 'fa fa-lock text-danger';
            var titleIcon = (_blockTime == undefined) ? 'Lock now' : 'Unlock';
            remainingClass = (remainingClass.length == 0) ? { total_reserve: 0 } : remainingClass[0];
            var tableRow = $('<tr>').appendTo('#tableRemaining > tbody');
            $('<td>').append(time).appendTo(tableRow);
            $('<td>').append(classInfo.quota).appendTo(tableRow);
            $('<td>').append(remainingClass.total_reserve).appendTo(tableRow);
            $('<td>').append(classInfo.quota - remainingClass.total_reserve).appendTo(tableRow);
            $('<td>').addClass('text-center').appendTo(tableRow);
            $('<i>').addClass(addClass)
                .attr('title', titleIcon)
                .css('cursor', 'pointer')
                .appendTo(tableRow.find('td:last'))
                .on('click', actionReserveJump);
        }

        function actionReserveJump(e) {
            var mode = $(e.target).attr('class').split(' ').indexOf('fa-lock') != -1 ? 'unlock' : 'lock';
            var addClass = (mode == 'unlock') ? 'fa fa-unlock-alt text-success' : 'fa fa-lock text-danger';

            $.ajax({
                url:  '<?php echo $host; ?>/app/services/admin/remaining.php?mode=actionTicket',
                method: 'post',
                data: {
                    mode: mode,
                    classId: selJumpClass.val(),
                    ticketId: selTicket.val(),
                    lockedDate: reserveDate.find('input').val(),
                    lockedTime: $($(e.target).parent().parent()).find('td:first-child').text()
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true){
                        $(e.target).removeClass();
                        $(e.target).addClass(addClass);
                    }
                }
            });
        }


        function getBlockedClass(){
            $.ajax({
                url:  '<?php echo $host; ?>/app/services/admin/remaining.php?mode=getBlocked',
                method: 'post',
                //data: { classId: _classId, ticketId: _ticketId, reserveDate: _reserveDate },
                //dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        var tableTickedBlocked = $('#tableTickedBlocked');

                        tableTickedBlocked.find('tbody').empty();
                        if(response.data.length > 0){
                            tableTickedBlocked.find('tfoot > tr').addClass('hidden');
                            $.each(response.data, function (i, item) {
                                var tableRow = $('<tr>').appendTo(tableTickedBlocked.find('tbody'));
                                $('<td>').append(item.class_name).appendTo(tableRow);
                                $('<td>').append(item.ticket_name).appendTo(tableRow);
                                $('<td>').append(new Date(item.locked_date).toLocaleDateString()).appendTo(tableRow);
                                $('<td>').append(new Date(item.locked_date + ' ' + item.locked_time).formatTimeUS()).appendTo(tableRow);
                                $('<td>').append(
                                    $('<i>').addClass('fa fa-lock text-danger')
                                        .css('cursor', 'pointer')
                                        .on('click', function (e) {
                                            $.ajax({
                                                url:  '<?php echo $host; ?>/app/services/admin/remaining.php?mode=actionTicket',
                                                method: 'post',
                                                data: { id: item.id },
                                                dataType: 'json',
                                                success: function (response) {
                                                    if (response.success == true){
                                                        tableRow.remove();
                                                    }
                                                }
                                            });
                                        })
                                    
                                ).appendTo(tableRow);
                            });
                        }
                        else{
                            tableTickedBlocked.find('tfoot > tr').removeClass('hidden');
                        }

                    }
                }
            });
        }
    });
</script>