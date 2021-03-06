<?php

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lang/lang.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lib/omise-php/lib/Omise.php';

define('OMISE_API_VERSION', $omise['apiv']);
define('OMISE_PUBLIC_KEY', $omise['pkey']);
define('OMISE_SECRET_KEY', $omise['skey']);

$charge = OmiseCharge::retrieve($_SESSION['_chargeId']);
$fee = $charge['amount'] / 100;
$fee = $fee * 0.0365;           // ค่าบริการ Omise 3.65 %
$fee = $fee + ($fee * 0.07);    // VAT 7%
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="<?=$host;?>/bootstrap/css/bootstrap.min.css">
</head>


<div style="display: flex; justify-content: center; align-items: center; height: 60%;">
    <img src="<?=$host;?>/images/logo/cropped-rj-logo-180x180.png" style="border: 8px solid #4CAF50;border-radius: 50%;box-shadow: 8px 8px 32px -12px black; width: 128px;">
    <div style="padding: 0px 24px;">
        <h2>Transaction No.: <?=$_SESSION['_inv'];?></h2>
        <h4>
<?php
if ($charge['status'] == 'successful') {
    echo $lang['msg']['transaction']['success'];
} else {
    echo $lang['msg']['transaction']['fail'];
}
?>
        <h4>
        <a href="<?=$host;?>" class="btn btn-warning">Go to Home</a>
    </div>
</div>

<?php if ($charge['status'] == 'successful') { ?>
<script src="<?=$host?>/js/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        // Send mail to customer with transactions detail
        $.ajax({
            url:  '<?=$host?>/app/services/invoice/sendEmail.php',
            method: 'post',
            data: { id: '<?=$_SESSION['_inv']?>' },
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    // After send mail, update status and transaction
                    $.ajax({
                        url:  '<?=$host?>/app/services/invoice/updateInvoice.php',
                        method: 'post',
                        data: { 
                            id: '<?=$_SESSION['_inv']?>',
                            approveCode: '<?=$charge['id']?>',
                            amount: parseInt(<?=$charge['amount']?>) / 100,
                            fee: '<?=$fee?>',
                            status: 'a'
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success == true) {
                            }
                        }
                    });
                }
            }
        });
    });
</script>
<?php } ?>