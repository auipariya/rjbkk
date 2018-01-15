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
    $query = 'UPDATE st_invoice SET approve_code=?, amount=?, fee=?, method=?, status=? WHERE id=?';
    $stmt = $db->prepare($query);
    $stmt->bind_param('sddssi', $_POST['approveCode'], $_POST['amount'], $_POST['fee'], $_POST['method'], $_POST['status'], $_POST['id']);
    if($stmt->execute()){
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