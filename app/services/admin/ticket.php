<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 10/7/2559
 * Time: 22:35
 */

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalFunction.php';

header('Content-Type: application/json');

$returnData = $returnDataPattern;

if(isset($_GET['mode'])){
    switch($_GET['mode']){
        case 'all': {
            $query = "SELECT * FROM st_class_ticket WHERE status='a' AND class_id=?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $_POST['classId']);
            if($stmt->execute()){
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    array_push($returnData['data'], $row);
                }
                echo json_encode($returnData);
                return;
            }

            break;
        }
        case 'retrieve': {
            break;
        }
    };

    $returnData['success'] = false;
    $returnData['data'] = $errors;
    $errors = [];
}
else{
    $returnData['success'] = false;
}

echo json_encode($returnData);