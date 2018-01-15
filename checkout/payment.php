<?php if(isset($_POST) && count($_POST) > 0): ?>

<?php

$activeMenu = 'checkout';

include '../app/resources/app.header.php';

// received result from paysbuy with data result,apCode,amt,fee,methos,confirm_cs
$result = isset($_POST['result']) ? $_POST['result'] : '003';
$paymentStatus = substr($result, 0,2);
$invoiceId = substr($result, 2, strlen($result) - 2);
$approveCode = isset($_POST['apCode']) ? $_POST['apCode'] : 123456;
$amount = isset($_POST['amt']) ? $_POST['amt'] : 1000;
$fee = isset($_POST['fee']) ? $_POST['fee'] : 3;
$method = isset($_POST['method']) ? $_POST['method'] : '01';

if ($paymentStatus == '00') {
    if ($method == '06') {
        $confirm_cs = strtolower(trim(isset($_POST['confirm_cs']) ? $_POST['confirm_cs'] : null));
        if ($confirm_cs == 'true') {
            $paymentStatus = '00';
        }
        else if ($confirm_cs == 'false') {
            $paymentStatus = '99';
        }
        else {
            $paymentStatus = '02';
        }
    }
}
?>

<div class="panel panel-<?=$paymentStatus == '00'? 'success': ($paymentStatus == '02' ? 'info' : 'danger')?>">
    <div class="panel-heading"><?=$lang['label']['statusPayment']?>: <?=$lang['paysbuy']['status'][$paymentStatus]?></div>
    <div class="panel-body">
        <?php if($paymentStatus == '02') echo '*'.$lang['msg']['paymentDueDate'].'<br>';?>
        *<?=$lang['msg']['informMessage']?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <tbody>
            <tr style="font-weight: bold;"><td style="width: 40%"><?=$lang['label']['invoiceNo']?></td><td aria-label="invoiceNo"></td></tr>
            <tr><td style="width: 40%"><?=$lang['label']['customerName']?></td><td aria-label="customerName"></td></tr>
            <tr><td style="width: 40%"><?=$lang['label']['telephone']?></td><td aria-label="telephone"></td></tr>
            <tr><td style="width: 40%"><?=$lang['label']['email']?></td><td aria-label="email"></td></tr>
            <tr><td style="width: 40%"><?=$lang['paysbuy']['approveCode']?></td><td aria-label="approveCode"></td></tr>
            <tr><td style="width: 40%"><?=$lang['paysbuy']['amount']?></td><td aria-label="amount"></td></tr>
            <tr><td style="width: 40%"><?=$lang['paysbuy']['fee']?></td><td aria-label="fee"></td></tr>
            <tr><td style="width: 40%"><?=$lang['label']['paymentMethod']?></td><td aria-label="method"></td></tr>
            <tr><td style="width: 40%"><?=$lang['label']['createAt']?></td><td aria-label="createdAt"></td></tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#headerTitle').text('<?=$lang['label']['invoiceNo']?> <?=$invoiceId?>');
        $('head > title').prepend('Invoice No. <?=$invoiceId?>');
        $('#divContentRight').addClass('hidden');
        $('#divContentCenter').removeClass('col-sm-6 col-md-8').addClass('col-sm-9 col-md-10');
        $('#localization').addClass('hidden');

        $.ajax({
            url:  '<?=$host?>/app/services/invoice/updateInvoice.php',
            method: 'post',
            data: {
                id: <?=$invoiceId?>,
                approveCode: '<?=$approveCode?>',
                amount: <?=$amount?>,
                fee: <?=$fee?>,
                method: '<?=$method?>',
                status: '<?=$paymentStatus == "00" ? 'a' : 'i'?>'
            },
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                }
            }
        });

        $.ajax({
            url:  '<?=$host?>/app/services/invoice/getInvoice.php',
            method: 'post',
            data: { id: <?=$invoiceId?> },
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    var inv = response.data[0];
                    $('td[aria-label="invoiceNo"]').text(inv.id);
                    $('td[aria-label="customerName"]').text(inv.customer_name);
                    $('td[aria-label="telephone"]').text(inv.customer_tel);
                    $('td[aria-label="email"]').text(inv.customer_email);
                    $('td[aria-label="approveCode"]').text(inv.approve_code);
                    var amount = '฿' + parseFloat(inv.amount).toLocaleString();
                    $('td[aria-label="amount"]').text(amount);
                    var fee = '฿' + parseFloat(inv.fee).toLocaleString();
                    $('td[aria-label="fee"]').text(fee);
                    var method = <?=json_encode($lang['paysbuy']['method'])?>;
                    $('td[aria-label="method"]').text(method[inv.method]);
                    $('td[aria-label="createdAt"]').text(new Date(inv.created_at).toLocaleString());
                }
            }
        });
    });
</script>

<?php include '../app/resources/app.footer.php'; ?>

<?php endif; ?>