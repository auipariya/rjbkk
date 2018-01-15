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

if(isset($_POST) && $_POST['orderId'] != null){
    unset($_SESSION['productOrder'][$_POST['orderId']]);
    //$_SESSION['productOrder'] = array_values($_SESSION['productOrder']);
    calculateItemAndPrice();
}
else{
    $returnData['success'] = false;
}

echo json_encode($returnData);