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

if(isset($_POST) && isset($_SESSION['productOrder'])){
    $query = 'INSERT INTO st_invoice (customer_name, customer_tel, customer_email) VALUES (?, ?, ?)';
    $stmt = $db->prepare($query);
    $stmt->bind_param('sss', $_POST['name'], $_POST['telephone'], $_POST['email']);
    if($stmt->execute()){
        $invoiceId = $stmt->insert_id;
        array_push($returnData['data'], ['invoiceNo' => $invoiceId]);
        $stmt->close();

        foreach($_SESSION['productOrder'] as $value){
            $query = 'INSERT INTO st_invoice_item (invoice_id, type, name, price, quantity) VALUES (?, ?, ?, ?, ?)';
            $stmt = $db->prepare($query);
            $stmt->bind_param('issdi', $invoiceId, $value['type'], $value['name'], $value['price'], $value['quantity']);
            if($stmt->execute()) {
                $invoiceItemId = $stmt->insert_id;
                $stmt->close();

                if($value['type'] == 'pass'){
                    $query = 'INSERT INTO st_invoice_item_pass (invoice_item_id, pass_id, first_name, last_name, telephone, email) VALUES (?, ?, ?, ?, ?, ?)';
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('iissss', $invoiceItemId, $value['id'], $value['firstname'], $value['lastname'], $value['telephone'], $value['email']);
                    if($stmt->execute()) {
                        $stmt->close();
                    }
                }
                else{
                    $dateDB = dateToDB($value['reserveDate']);
                    $timeDB = date('H:i:s', strtotime($value['reserveTime']));
                    $query = 'INSERT INTO st_invoice_item_jump (invoice_item_id, ticket_id, description, reserve_date, reserve_time) VALUES (?, ?, ?, ?, ?)';
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('iisss', $invoiceItemId, $value['id'], $value['description'], $dateDB, $timeDB);
                    if($stmt->execute()) {
                        $stmt->close();
                    }
                }
            }
        }

        // clear session product order
        unset($_SESSION['productOrder']);
        unset($_SESSION['totalItem']);
        unset($_SESSION['totalPrice']);
    }
    else{
        $returnData['success'] = false;
    }
}
else{
    $returnData['success'] = false;
}

echo json_encode($returnData);