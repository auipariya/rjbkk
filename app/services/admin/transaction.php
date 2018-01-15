<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 10/7/2559
 * Time: 22:35
 */

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalFunction.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lib/nusoap.php';

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$returnData = $returnDataPattern;

if(isset($_GET['mode'])){
    switch($_GET['mode']){
        case 'all': {
            $query = 'SELECT * FROM st_invoice WHERE 1=1 ';

            if(count($_POST) > 0){
                $keyword = $_POST['keyword'];
                if($keyword != ''){
                    $query .= "AND (id LIKE '%$keyword%' ";
                    $query .= "OR customer_name LIKE '%$keyword%' ";
                    $query .= "OR customer_tel LIKE '%$keyword%' ";
                    $query .= "OR customer_email LIKE '%$keyword%') ";
                }

                $dateFrom = dateToDB($_POST['durationFrom']);
                $dateTo = dateToDB($_POST['durationTo']);
                if($dateFrom == ''){
                    $dateFrom = $dateTo != '' ? $dateTo : '';
                }
                if($dateTo == ''){
                    $dateTo = $dateFrom != '' ? $dateFrom : '';
                }

                if($dateFrom != '' && $dateTo != ''){
                    if($dateFrom == $dateTo){
                        $dateFrom = $dateFrom . ' 00:00:01';
                        $dateTo = $dateTo . ' 23:59:59';
                    }
                    else{
                        $dateFrom = $dateFrom . ' 00:00:01';
                        $dateTo = $dateTo . ' 23:59:59';
                    }
                    $query .= "AND (created_at >= '$dateFrom' AND created_at <= '$dateTo') ";
                }
            }
            $query .= 'ORDER BY id DESC';

            $stmt = $db->prepare($query);
            if($stmt->execute()){
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    array_push($returnData['data'], $row);
                }
                $stmt->close();

                echo json_encode($returnData);
                return;
            }

            break;
        }
        case 'retrieve': {
            $returnData['data'] = [
                'invoice' => [],
                'invoiceItem' => []
            ];

            $query = "SELECT * FROM st_invoice WHERE id=? LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $_POST['invoiceId']);
            if($stmt->execute()){
                $result = $stmt->get_result();
                $returnData['data']['invoice'] = $result->fetch_assoc();
                $stmt->close();

                $query = "SELECT * FROM st_invoice_item WHERE invoice_id=?";
                $stmt = $db->prepare($query);
                $stmt->bind_param('i', $_POST['invoiceId']);
                if($stmt->execute()) {
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()){
                        if($row['type'] == 'jump') {
                            $query2 = "SELECT description, reserve_date, reserve_time FROM st_invoice_item_jump WHERE invoice_item_id=?";
                        }
                        else if($row['type'] == 'pass'){
                            $query2 = "SELECT first_name, last_name, telephone, email FROM st_invoice_item_pass WHERE invoice_item_id=?";
                        }

                        $stmt2 = $db->prepare($query2);
                        $stmt2->bind_param('i', $row['id']);
                        if($stmt2->execute()) {
                            $result2 = $stmt2->get_result()->fetch_assoc();
                            $stmt2->close();

                            $row = array_merge($row, $result2);
                            array_push($returnData['data']['invoiceItem'], $row);
                        }
                    }
                    $stmt->close();
                }
                $db->close();

                echo json_encode($returnData);
                return;
            }

            break;
        }
        case 'inactive': {
            $query = "SELECT * FROM st_invoice WHERE status='i'";
            $stmt = $db->prepare($query);
            if($stmt->execute()){
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    array_push($returnData['data'], $row);
                }
                $stmt->close();

                echo json_encode($returnData);
                return;
            }

            break;
        }
        case 'updateStatus': {
            $query = "UPDATE st_invoice SET approve_code=?, amount=?, fee=?, method=?, status=? WHERE id=?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('iddssi', 
                $_POST["apCode"],
                $_POST["amt"],
                $_POST["fee"],
                $_POST["method"],
                $_POST['status'],
                $_POST['Invoice']
            );
            if($stmt->execute()){
                $stmt->close();
                echo json_encode($returnData);
                return;
            }
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