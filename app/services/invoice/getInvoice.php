<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 18/7/2559
 * Time: 16:54
 */

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalFunction.php';

header('Content-Type: application/json');


$returnData = $returnDataPattern;

if(isset($_POST)){
    $query = 'SELECT * FROM st_invoice WHERE id=? LIMIT 1';
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $_POST['id']);
    if($stmt->execute()){
        $result = $stmt->get_result()->fetch_assoc();
        array_push($returnData['data'], $result);
        $stmt->close();
    }
    else{
        $returnData['success'] = false;
    }
}
else{
    $returnData['success'] = false;
}

echo json_encode($returnData);