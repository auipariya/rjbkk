<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 11/7/2559
 * Time: 19:06
 */
$btnSubmitText = $_GET['mode'] == 'create' ? 'SAVE' : 'UPDATE';
?>

<div id="<?php echo $activeMenu ?>">

    <form name="formJumpClass" method="post" action="<?php echo $host; ?>/app/services/admin/jumpclass.php?mode=<?php echo $_GET['mode'] ?>" class="form-horizontal">
        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : "" ?>">

        <div class="alert alert-danger hidden" role="alert">
            <strong>Whoops!</strong> There were some problems with your input.
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">NAME <span class="text-danger">*</span></label>
            <div class="col-sm-6">
                <input type="text" name="name" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">DURATION</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <label class="input-group-addon">FROM</label>
                    <input type="text" name="duration_from" class="form-control">
                    <label class="input-group-addon">TO</label>
                    <input type="text" name="duration_to" class="form-control">
                </div>
            </div>
        </div>

        <!--ใช้เชคว่าสร้างใหม่หรือแก้ไข-->
        <div class="form-group">
            <label for="day" class="col-sm-2 control-label">DAY & TIME <span class="text-danger">*</span></label>
            <div class="col-sm-6">
                <table class="table table-hover table-condensed" style="margin-bottom: 0" id="tableDayTime">
                    <thead>
                    <tr>
                        <td style="width: 40%; padding-left: 0; padding-top: 0;">
                            <select name="day" class="form-control">
                                <?php foreach($admin['days'] as $key => $value): ?>
                                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td style="width: 60%; padding-top: 0;">
                            <div class="input-group">
                                <input type="text" name="time_from" class="form-control" placeholder="TIME FROM">
                                <label class="input-group-addon"> - </label>
                                <input type="text" name="time_to" class="form-control" placeholder="TIME TO">
                            </div>
                        </td>
                        <td style="width: 60px; padding-right: 0; padding-top: 0;">
                            <button type="button" class="btn btn-block btn-success"><i class="fa fa-plus"></i></button>
                        </td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="form-group">
            <label for="ticket_name" class="col-sm-2 control-label">TICKET TYPE <span class="text-danger">*</span></label>
            <div class="col-sm-6">
                <table class="table table-hover table-condensed" style="margin-bottom: 0" id="tableTicketType">
                    <thead>
                    <tr>
                        <td style="width: 40%; padding-left: 0; padding-top: 0;">
                            <input type="text" name="ticket_name" class="form-control" placeholder="TICKET NAME">
                        </td>
                        <td style="width: 30%; padding-top: 0;">
                            <div class="input-group">
                                <input type="number" name="ticket_time" class="form-control" placeholder="TIME" min="30">
                                <label class="input-group-addon hidden-xs">MIN</label>
                            </div>
                        </td>
                        <td style="width: 30%; padding-top: 0;">
                            <div class="input-group">
                                <label class="input-group-addon hidden-xs">&#3647;</label>
                                <input type="number" name="ticket_price" class="form-control" placeholder="PRICE" min="1">
                            </div>
                        </td>
                        <td style="width: 60px; padding-right: 0; padding-top: 0;">
                            <button type="button" class="btn btn-block btn-success"><i class="fa fa-plus"></i></button>
                        </td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-6">
                <label><input type="checkbox" name="ticket_time_inherit"> TICKET TIME INHERIT DAY & TIME</label>
            </div>
        </div>

        <div class="form-group">
            <label for="quota" class="col-sm-2 control-label">QUOTA NO <span class="text-danger">*</span></label>
            <div class="col-sm-6">
                <input type="number" name="quota" class="form-control" min="1">
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-2 control-label">STATUS <span class="text-danger">*</span></label>
            <div class="col-sm-6">
                <select name="status" class="form-control">
                    <?php foreach($admin['status'] as $key => $value): ?>
                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <hr>

        <div class="form-group">

            <div class="col-xs-4 col-sm-2">
                <?php if($_GET['mode'] == 'update'): ?>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete">DELETE</button>
                <?php endif; ?>
            </div>
            <div class="col-xs-8 col-sm-6 text-right">
                <button type="reset" class="btn btn-link">CLEAR</button>
                <button type="submit" class="btn btn-primary"><?php echo $btnSubmitText ?></button>
            </div>
        </div>
    </form>


    <!-- modal alert -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">System Message</h4>
                </div>
                <div class="modal-body">
                    Do you want to delete <strong></strong> from jump class?
                </div>
                <div class="modal-footer">
                    <form name="formJumpClassDelete" method="post" action="<?php echo $host; ?>/app/services/admin/jumpclass.php?mode=delete">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-danger">DELETE NOW</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        // create mode
        var formJumpClass = $('form[name=formJumpClass]');
        var formJumpClassDelete = $('form[name=formJumpClassDelete]');

        var divAlert = formJumpClass.find('div[role=alert]');
        formJumpClass.find('button[type=submit]').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url:  formJumpClass[0].action,
                method: formJumpClass[0].method,
                data: formJumpClass.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        location.href = '<?php echo $host ?>/admin/jumpclass';
                    }
                    else{
                        var uiContent = divAlert.find('ul');
                        if(uiContent.length == 0){
                            $('<ul>').appendTo(divAlert);
                        }
                        else{
                            uiContent.empty();
                        }

                        for(var i in response.data){
                            $('<li>', { text: response.data[i] }).appendTo(divAlert.find('ul'));
                        }

                        $(divAlert).removeClass('hidden');
                    }
                }
            });
        });
        formJumpClass.find('button[type=reset]').on('click', function (e) {
            location.reload();
        });

        // update and delete mode
        if('<?php echo $_GET['mode'] ?>' == 'update'){
            $('.page-header .btn').removeClass('hidden');

            $.ajax({
                url: '<?php echo $host ?>/app/services/admin/jumpclass.php?mode=retrieve',
                method: 'post',
                data: { id: '<?php echo (isset($_GET["id"]) ? $_GET['id'] : "") ?>' },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        var jumpclass = response.data['jumpclass'][0];
                        var dayTime = response.data['dayTime'];
                        var ticketType = response.data['ticketType'];

                        $('.modal-body > strong').text(jumpclass.name);
                        $('input[name=name]').val(jumpclass.name);
                        $('input[name=duration_from]').val(jumpclass.duration_from);
                        $('input[name=duration_to]').val(jumpclass.duration_to);
                        $('input[name=ticket_time_inherit]').prop('checked', jumpclass.ticket_time_inherit == 1 ? true : false);
                        $('input[name=quota]').val(jumpclass.quota);
                        $('select[name=status]').val(jumpclass.status);

                        // day and time
                        for(var i in dayTime){
                            formJumpClass.find('select[name=day]').val(dayTime[i].day);
                            formJumpClass.find('input[name=time_from]').val(dayTime[i].duration_from);
                            formJumpClass.find('input[name=time_to]').val(dayTime[i].duration_to);

                            $('#tableDayTime button').trigger('click');
                        }

                        // ticket type
                        for(var i in ticketType){
                            formJumpClass.find('input[name=ticket_name]').val(ticketType[i].name);
                            formJumpClass.find('input[name=ticket_time]').val(ticketType[i].minute);
                            formJumpClass.find('input[name=ticket_price]').val(ticketType[i].price);

                            $('#tableTicketType button').trigger('click');
                        }
                    }
                }
            });

            // delete jump class
            formJumpClassDelete.find('button[type=submit]').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url:  formJumpClassDelete[0].action,
                    method: formJumpClassDelete[0].method,
                    data: { id: '<?php echo (isset($_GET["id"]) ? $_GET['id'] : "") ?>' },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success == true) {
                            location.href = '<?php echo $host ?>/admin/jumpclass';
                        }
                    }
                });
            });
        }
    });
</script>