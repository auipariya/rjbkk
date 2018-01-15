<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 16/7/2559
 * Time: 23:25
 */

header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalFunction.php';

$returnData = $returnDataPattern;

if($_POST['orderId'] != null && $_POST['quantity'] != null){
    $_SESSION['productOrder'][$_POST['orderId']]['quantity'] = $_POST['quantity'];
    calculateItemAndPrice();
}
else{
    $returnData['success'] = false;
}

echo json_encode($returnData);