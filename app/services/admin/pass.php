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

function validate(){
    $errors = [];

    if($_POST['name'] == null){
        array_push($errors, 'The name field is required.');
    }
    if($_POST['duration_from'] == null){
        array_push($errors, 'The duration from field is required.');
    }
    if($_POST['duration_to'] == null){
        array_push($errors, 'The duration to field is required.');
    }
    if($_POST['price'] == null){
        array_push($errors, 'The price field is required.');
    }
    if($_POST['status']== null){
        array_push($errors, 'The status field is required.');
    }

    return $errors;
}


$returnData = $returnDataPattern;

if(isset($_GET['mode'])){
    switch($_GET['mode']){
        case 'all': {
            $query = 'SELECT * FROM st_pass';
            if(isset($_POST['status'])){
                $query .= ' WHERE status="' . $_POST['status'] . '"';
            }
            $stmt = $db->prepare($query);
            if($stmt->execute()){
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    //$row['price'] = number_format($row['price']);
                    array_push($returnData['data'], $row);
                }
                echo json_encode($returnData);
                return;
            }

            break;
        }
        case 'create': {
            $errors = validate();
            if(count($errors) == 0){
                $dateFrom = dateToDB($_POST['duration_from']);
                $dateTo = dateToDB($_POST['duration_to']);

                $query = 'INSERT INTO st_pass (name, duration_from, duration_to, price, status) VALUES (?, ?, ?, ?, ?)';
                $stmt = $db->prepare($query);
                $stmt->bind_param('sssis', $_POST['name'], $dateFrom, $dateTo, $_POST['price'], $_POST['status']);
                if($stmt->execute()){
                    $stmt->close();
                    echo json_encode($returnData);
                    return;
                }
            }

            break;
        }
        case 'retrieve': {
            $query = 'SELECT * FROM st_pass WHERE id=? LIMIT 1';
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $_POST['id']);
            if($stmt->execute()){
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    $row['duration_from'] = dateFromDB($row['duration_from']);
                    $row['duration_to'] = dateFromDB($row['duration_to']);
                    //$row['price'] = number_format($row['price']);
                    array_push($returnData['data'], $row);
                }
                $stmt->close();

                echo json_encode($returnData);
                return;
            }

            break;
        }
        case 'update': {
            $errors = validate();
            if(count($errors) == 0){
                $dateFrom = dateToDB($_POST['duration_from']);
                $dateTo = dateToDB($_POST['duration_to']);

                $query = 'UPDATE st_pass SET name=?, duration_from=?, duration_to=?, price=?, status=? WHERE id=?';
                $stmt = $db->prepare($query);
                $stmt->bind_param('sssisi', $_POST['name'], $dateFrom, $dateTo, $_POST['price'], $_POST['status'], $_POST['id']);
                if($stmt->execute()){
                    $stmt->close();

                    echo json_encode($returnData);
                    return;
                }
            }
            break;
        }
        case 'delete': {
            $query = 'DELETE FROM st_pass WHERE id=?';
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $_POST['id']);
            $stmt->execute();
            $stmt->close();

            echo json_encode($returnData);
            return;

            break;
        }
        default: {
            array_push($errors, 'Not found this action.');
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