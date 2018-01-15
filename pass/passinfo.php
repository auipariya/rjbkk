<?php
$orderId = isset($_POST['orderId']) ? $_POST['orderId'] : '';
$firstname = isset($_POST['orderId']) ? $_SESSION['productOrder'][$orderId]['firstname'] : '';
$lastname = isset($_POST['orderId']) ? $_SESSION['productOrder'][$orderId]['lastname'] : '';
$telephone = isset($_POST['orderId']) ? $_SESSION['productOrder'][$orderId]['telephone'] : '';
$email = isset($_POST['orderId']) ? $_SESSION['productOrder'][$orderId]['email'] : '';
?>

<div class="main-title" style="font-weight: bold;"></div>
<p class="subtitle text-muted"></p>

<form name="formPassInfo" action="<?php echo $host ?>/viewcart/" method="post" class="form-horizontal">
    <input type="hidden" name="orderId" value="<?php echo $orderId ?>">
    <input type="hidden" name="type" value="pass">
    <input type="hidden" name="id">
    <input type="hidden" name="name">
    <input type="hidden" name="price">
    <input type="hidden" name="quantity" value="1">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-4 control-label"><?php echo $lang['label']['firstname'] ?><i style="color: red;">*</i></label>
                <div class="col-md-8"><input type="text" name="firstname" class="form-control" required="true" autofocus="true" value="<?php echo $firstname ?>"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-4 control-label"><?php echo $lang['label']['lastname'] ?><i style="color: red;">*</i></label>
                <div class="col-md-8"><input type="text" name="lastname" class="form-control" required="true" value="<?php echo $lastname ?>"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-4 control-label"><?php echo $lang['label']['telephone'] ?></label>
                <div class="col-md-8"><input type="tel" name="telephone" class="form-control" value="<?php echo $telephone ?>"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-4 control-label"><?php echo $lang['label']['email'] ?></label>
                <div class="col-md-8"><input type="email" name="email" class="form-control" value="<?php echo $email ?>"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-right">
            <button type="button" class="btn btn-link"><?php echo $lang['button']['cancel'] ?></button>
            <button type="submit" class="btn btn-warning">
                <?php echo $orderId == '' ? $lang['button']['addToCart'] : $lang['button']['update'] ?>
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function () {
        $('#headerTitle').text('<?php echo $lang['passPage']['contentTitle']['passInfo'] ?>');
        $('head > title').prepend('<?php echo $lang['passPage']['contentTitle']['passInfo'] ?>');
        $('#divContentRight').addClass('hidden');
        $('#divContentCenter').removeClass('col-sm-6 col-md-8').addClass('col-sm-9 col-md-10');

        var formPassInfo = $('form[name=formPassInfo]');

        $.ajax({
            url: '<?php echo $host ?>/app/services/admin/pass.php?mode=retrieve',
            method: 'post',
            data: { id: '<?php echo (isset($_GET["id"]) ? $_GET['id'] : "") ?>' },
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    var pass = response.data[0];
                    $('.main-title').text(pass.name);
                    $('.subtitle').text(pass.duration_from + ' - ' + pass.duration_to);
                    formPassInfo.find('input[name=id]').val(pass.id);
                    formPassInfo.find('input[name=name]').val(pass.name);
                    formPassInfo.find('input[name=price]').val(pass.price);
                }
            }
        });

        formPassInfo.find('button[type=button]').on('click', function () {
            history.back();
        });
    });
</script>