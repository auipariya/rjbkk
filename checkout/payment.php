<?php

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lang/lang.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lib/omise-php/lib/Omise.php';

define('OMISE_API_VERSION', $omise['apiv']);
define('OMISE_PUBLIC_KEY', $omise['pkey']);
define('OMISE_SECRET_KEY', $omise['skey']);

$charge = OmiseCharge::create(array(
    'amount' => $_POST["totalPrice"],
    'currency' => 'thb',
    'card' => $_POST["omiseToken"],
    'description' => 'Transaction No.: ' . $_POST['inv']
));

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
        <h2>Transaction No.: <?=$_POST['inv'];?></h2>
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