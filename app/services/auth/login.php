<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 8/7/2559
 * Time: 14:44
 */

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';

$returnData = $returnDataPattern;

if($_POST['email'] == ''){
    array_push($errors, 'The email field is required.');
}
if($_POST['password'] == ''){
    array_push($errors, 'The password field is required.');
}


if(count($errors ) == 0){
    $query = 'SELECT * FROM st_users WHERE email=? AND password=? LIMIT 1';
    $stmt = $db->prepare($query);
    if($stmt){
        $stmt->bind_param('ss', $_POST['email'], $_POST['password']);
        if($stmt->execute()){
            $result = $stmt->get_result()->fetch_assoc();

            if($result != null){
                $_SESSION['userInfo'] = $result;
                $returnData['data'] = [$result];
                echo json_encode($returnData);
                return;
            }
            else{
                array_push($errors, 'This user credential could not found.');
            }
        }
    }

    $returnData['success'] = false;
    $returnData['data'] = $errors;
    $errors = [];
}
else{
    $returnData['success'] = false;
    $returnData['data'] = $errors;
    $errors = [];
}

echo json_encode($returnData);