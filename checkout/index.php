<?php

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';

$psbId = $paysbuyAcc['psbID'];
$account = $paysbuyAcc['biz'];
$price = $_SESSION['totalPrice'];
$postURL = $host . "/checkout/payment.php";
$description = $_POST['name'];
if($_POST['telephone'] != '' && $_POST['email'] != '') {
    $description .= ', Contact: ' . $_POST['telephone'] . '(' . $_POST['email'] . ')';
}
else if ($_POST['telephone'] != '') {
    $description .= ', Contact: ' . $_POST['telephone'];
}
else if ($_POST['email'] != '') {
    $description .= ', Contact: ' . $_POST['email'];
}
?>
<!--
DEMO: http://demo.paysbuy.com/paynow.aspx
PROD: https://www.paysbuy.com/paynow.aspx
-->
<form method="post" action="https://www.paysbuy.com/paynow.aspx">
    <input type="hidden" name="psb" value="<?=$psbId?>"/>
    <input type="hidden" name="biz" value="<?=$account?>"/>
    <input type="hidden" name="inv" value=""/>
    <input type="hidden" name="itm" value="<?=$description?>"/>
    <input type="hidden" name="amt" value="<?=$price?>"/>
    <input type="hidden" name="postURL" value="<?=$postURL?>"/>
</form >

<script src="<?=$host?>/js/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $.ajax({
            url:  '<?=$host?>/app/services/invoice/addInvoice.php',
            method: 'post',
            data: <?=json_encode($_POST)?>,
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    $('input[name=inv]').val(response.data[0]['invoiceNo']);
                    $('form').trigger('submit');
                }
            }
        });
    });
</script>