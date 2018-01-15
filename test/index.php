<?php

header('Content-Type: application/json');

include_once 'nusoap.php';

$client = new nusoap_client('https://www.paysbuy.com/psb_ws/getTransaction.asmx?WSDL', true);

$psbID = '4406058375';
$biz = 'contact@bangkok-rockinjump.com';
$secureCode = 'E48248A02613F9AE009C5F9F0658C0BA';
$invoice = '96';
$flag = 'B';

$params = array(
    'psbID' => $psbID,
    'biz' => $biz,
    'secureCode' => $secureCode,
    'invoice' => $invoice,
    'flag' => $flag
);
$result = $client->call('getTransactionByInvoiceCheckPost', $params);

echo json_encode($result['getTransactionByInvoiceCheckPostResult']['getTransactionByInvoiceReturn']);