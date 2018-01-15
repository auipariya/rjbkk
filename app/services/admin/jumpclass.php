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
    if(!isset($_POST['_day'])){
        array_push($errors, 'The day and time is required.');
    }
    if(!isset($_POST['_ticket_name'])){
        array_push($errors, 'The ticket type is required.');
    }
    if($_POST['quota'] == null){
        array_push($errors, 'The quota field is required.');
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
            $query = 'SELECT * FROM st_class';
            if(isset($_POST['status'])){
                $query .= ' WHERE status="' . $_POST['status'] . '"';
            }
            $stmt = $db->prepare($query);
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
        case 'create': {
            $errors = validate();
            if(count($errors) == 0){
                $dateFrom = $_POST['duration_from'] != null ? dateToDB($_POST['duration_from']) : null;
                $dateTo = $_POST['duration_to'] != null ? dateToDB($_POST['duration_to']) : null;
                $ticketTimeInherit = isset($_POST['ticket_time_inherit']) ? 1 : 0;

                $query = 'INSERT INTO st_class (name, duration_from, duration_to, ticket_time_inherit, quota, status) VALUES (?, ?, ?, ?, ?, ?)';
                $stmt = $db->prepare($query);
                $stmt->bind_param('sssiis',
                    $_POST['name'],
                    $dateFrom,
                    $dateTo,
                    $ticketTimeInherit,
                    $_POST['quota'],
                    $_POST['status']
                );
                if($stmt->execute()){
                    $id = $stmt->insert_id;
                    $stmt->close();

                    // store day and time
                    foreach($_POST['_day'] as $key => $value){
                        $timeFrom = date('H:i:s', strtotime($_POST['_time_from'][$key]));
                        $timeTo = date('H:i:s', strtotime($_POST['_time_to'][$key]));

                        $query = 'INSERT INTO st_class_daytime (class_id, day, duration_from, duration_to) VALUES (?, ?, ?, ?)';
                        $stmt = $db->prepare($query);
                        $stmt->bind_param('isss',
                            $id,
                            $_POST['_day'][$key],
                            $timeFrom,
                            $timeTo
                        );
                        $stmt->execute();
                        $stmt->close();
                    }

                    // store ticket type
                    foreach($_POST['_ticket_name'] as $key => $value){
                        $query = 'INSERT INTO st_class_ticket (class_id, name, minute, price) VALUES (?, ?, ?, ?)';
                        $stmt = $db->prepare($query);
                        $stmt->bind_param('isid',
                            $id,
                            $_POST['_ticket_name'][$key],
                            $_POST['_ticket_time'][$key],
                            $_POST['_ticket_price'][$key]
                        );
                        $stmt->execute();
                        $stmt->close();
                    }

                    echo json_encode($returnData);
                    return;
                }
            }

            break;
        }
        case 'retrieve': {
            $returnData['data'] = [
                'jumpclass' => [],
                'dayTime' => [],
                'ticketType' => []
            ];

            $query = 'SELECT * FROM st_class WHERE id=? LIMIT 1';
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $_POST['id']);
            if($stmt->execute()){
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    $row['duration_from'] = $row['duration_from'] != '0000-00-00' ? dateFromDB($row['duration_from']) : null;
                    $row['duration_to'] = $row['duration_to'] != '0000-00-00' ? dateFromDB($row['duration_to']) : null;
                    array_push($returnData['data']['jumpclass'], $row);
                }
                $stmt->close();

                // day and time
                $query = 'SELECT * FROM st_class_daytime WHERE class_id=? AND status="a" ORDER BY day, duration_from';
                $stmt = $db->prepare($query);
                $stmt->bind_param('i', $_POST['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    $row['duration_from'] = date('h:i A', strtotime($row['duration_from']));
                    $row['duration_to'] = date('h:i A', strtotime($row['duration_to']));
                    array_push($returnData['data']['dayTime'], $row);
                }
                $stmt->close();

                // ticket type
                $query = 'SELECT * FROM st_class_ticket WHERE class_id=? AND status="a" ORDER BY minute, price';
                $stmt = $db->prepare($query);
                $stmt->bind_param('i', $_POST['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    array_push($returnData['data']['ticketType'], $row);
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
                $dateFrom = $_POST['duration_from'] != null ? dateToDB($_POST['duration_from']) : null;
                $dateTo = $_POST['duration_to'] != null ? dateToDB($_POST['duration_to']) : null;
                $ticketTimeInherit = isset($_POST['ticket_time_inherit']) ? 1 : 0;

                $query = 'UPDATE st_class SET name=?, duration_from=?, duration_to=?, ticket_time_inherit=?, quota=?, status=? WHERE id=?';
                $stmt = $db->prepare($query);
                $stmt->bind_param('sssiisi',
                    $_POST['name'],
                    $dateFrom,
                    $dateTo,
                    $ticketTimeInherit,
                    $_POST['quota'],
                    $_POST['status'],
                    $_POST['id']
                );
                if($stmt->execute()){
                    $stmt->close();

                    // store day and time
                    $query = 'UPDATE st_class_daytime set status="i" WHERE class_id=?';
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('i', $_POST['id']);
                    $stmt->execute();
                    $stmt->close();

                    foreach($_POST['_day'] as $key => $value){
                        $timeFrom = date('H:i:s', strtotime($_POST['_time_from'][$key]));
                        $timeTo = date('H:i:s', strtotime($_POST['_time_to'][$key]));

                        $query = 'INSERT INTO st_class_daytime (class_id, day, duration_from, duration_to) VALUES (?, ?, ?, ?)';
                        $stmt = $db->prepare($query);
                        $stmt->bind_param('isss',
                            $_POST['id'],
                            $_POST['_day'][$key],
                            $timeFrom,
                            $timeTo
                        );
                        $stmt->execute();
                        $stmt->close();
                    }

                    // store ticket type
                    $query = 'UPDATE st_class_ticket set status="i" WHERE class_id=?';
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('i', $_POST['id']);
                    $stmt->execute();
                    $stmt->close();

                    foreach($_POST['_ticket_name'] as $key => $value){
                        $query = 'INSERT INTO st_class_ticket (class_id, name, minute, price) VALUES (?, ?, ?, ?)';
                        $stmt = $db->prepare($query);
                        $stmt->bind_param('isid',
                            $_POST['id'],
                            $_POST['_ticket_name'][$key],
                            $_POST['_ticket_time'][$key],
                            $_POST['_ticket_price'][$key]
                        );
                        $stmt->execute();
                        $stmt->close();
                    }

                    echo json_encode($returnData);
                    return;
                }
            }
            break;
        }
        case 'delete': {
            $query = 'DELETE FROM st_class WHERE id=?';
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