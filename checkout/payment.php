<?php

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lib/omise-php/lib/Omise.php';

define('OMISE_API_VERSION', $omise['apiv']);
define('OMISE_PUBLIC_KEY', $omise['pkey']);
define('OMISE_SECRET_KEY', $omise['skey']);

$charge = OmiseCharge::create(array(
    'amount' => $_POST['totalPrice'],
    'currency' => 'thb',
    'card' => $_POST['omiseToken'],
    'description' => 'Transaction No.: ' . $_POST['inv'],
    'return_uri' => $host . '/checkout/summary.php'
));

$_SESSION['_chargeId'] = $charge['id'];
$_SESSION['_inv'] = $_POST['inv'];

header('Location: ' . $charge['authorize_uri']);