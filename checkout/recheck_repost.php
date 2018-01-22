<?php

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lib/nusoap.php';

$url = "https://www.paysbuy.com/psb_ws/getTransaction.asmx?WSDL";
$client = new nusoap_client($url, true);

$psbID = "4406058375";

$biz = "contact@bangkok-rockinjump.com";

$secureCode = "E48248A02613F9AE009C5F9F0658C0BA";

$invoice = "1";

$flag = "B";

$params = array("psbID"=>$psbID,"biz"=>$biz,"secureCode"=>$secureCode,"invoice"=>$invoice,"flag"=>$flag);

echo '<pre>', print_r($params), '</pre>';
/*
$result = $client->call('getTransactionByInvoiceCheckPost',array('parameters' => $params),'http://tempuri.org/','http://tempuri.org/getTransactionByInvoiceCheckPost',false,true);

if ($client->getError()) {
    echo "<h2>Constructor error</h2><pre>" . $client->getError() . "</pre>";
} else {
    $result = $result["getTransactionByInvoiceCheckPostResult"];

    echo '<pre>',print_r(result),'</pre>';
}
*/
?>