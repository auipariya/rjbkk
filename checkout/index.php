<?php

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
?>

<form method="POST" action="payment.php">
    <input type="hidden" name="totalPrice" value="">
    <input type="hidden" name="inv" value="">
    <!-- Create your own button -->
    <button type="submit" id="btnCheckout" style="display: none;">Checkout</button>
</form>


<script src="<?=$host?>/js/jquery.min.js"></script>
<!-- Include card.js library -->
<script type="text/javascript" src="https://cdn.omise.co/omise.js"></script>
<!-- Config the card.js library -->
<script type="text/javascript">
    $(function () {
        // Set default parameters
        OmiseCard.configure({
            publicKey: '<?=$omise['pkey']?>',
            image: '<?php echo $host ?>/images/logo/cropped-rj-logo-192x192.png',
            amount: '<?=$_SESSION['totalPrice']?>00',
            currency: 'thb',
        });
        // Configuring your own custom button
        OmiseCard.configureButton('#btnCheckout', {
            frameLabel: "ROCKIN' JUMP",
            frameDescription: 'Bangkok, Thailand'
        });
        // Then, attach all of the config and initiate it by 'OmiseCard.attach();' method
        OmiseCard.attach();

        $('input[name=totalPrice]').val('<?=$_SESSION['totalPrice']?>00');

        $.ajax({
            url:  '<?=$host?>/app/services/invoice/addInvoice.php',
            method: 'post',
            data: <?=json_encode($_POST)?>,
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    $('input[name=inv]').val(response.data[0]['invoiceNo']);
                    $('form > button').click();
                }
            }
        });
    });
</script>