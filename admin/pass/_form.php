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

    <form name="formPass" method="post" action="<?php echo $host; ?>/app/services/admin/pass.php?mode=<?php echo $_GET['mode'] ?>" class="form-horizontal">
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
            <label class="col-sm-2 control-label">DURATION <span class="text-danger">*</span></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <label class="input-group-addon">FROM</label>
                    <input type="text" name="duration_from" class="form-control">
                    <label class="input-group-addon">TO</label>
                    <input type="text" name="duration_to" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">PRICE <span class="text-danger">*</span></label>
            <div class="col-sm-6">
                <input type="number" name="price" class="form-control" min="1">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">STATUS <span class="text-danger">*</span></label>
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
                    Do you want to delete <strong></strong> from pass?
                </div>
                <div class="modal-footer">
                    <form name="formPassDelete" method="post" action="<?php echo $host; ?>/app/services/admin/pass.php?mode=delete">
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
        var formPass = $('form[name=formPass]');
        var formPassDelete = $('form[name=formPassDelete]');

        var divAlert = formPass.find('div[role=alert]');
        formPass.find('button[type=submit]').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url:  formPass[0].action,
                method: formPass[0].method,
                data: formPass.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        location.href = '<?php echo $host ?>/admin/pass';
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
        formPass.find('button[type=reset]').on('click', function (e) {
            location.reload();
        });

        // update and delete mode
        if('<?php echo $_GET['mode'] ?>' == 'update'){
            $('.page-header .btn').removeClass('hidden');

            $.ajax({
                url: '<?php echo $host ?>/app/services/admin/pass.php?mode=retrieve',
                method: 'post',
                data: { id: '<?php echo (isset($_GET["id"]) ? $_GET['id'] : "") ?>' },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        var pass = response.data[0];

                        $('.modal-body > strong').text(pass.name);
                        $('input[name=name]').val(pass.name);
                        $('input[name=duration_from]').val(pass.duration_from);
                        $('input[name=duration_to]').val(pass.duration_to);
                        $('input[name=price]').val(pass.price.replace(',', ''));
                        $('select[name=status]').val(pass.status);
                    }
                }
            });

            // delete pass
            formPassDelete.find('button[type=submit]').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url:  formPassDelete[0].action,
                    method: formPassDelete[0].method,
                    data: { id: '<?php echo (isset($_GET["id"]) ? $_GET['id'] : "") ?>' },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success == true) {
                            location.href = '<?php echo $host ?>/admin/pass';
                        }
                    }
                });
            });
        }
    });
</script>