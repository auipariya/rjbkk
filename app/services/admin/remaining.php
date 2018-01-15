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
            if(count($_POST) > 0){
                $reserveDate = dateToDB($_POST['reserveDate']);

                $query = "
                    SELECT
                      class.id AS class_id,
                      class.name AS name,
                      ticket.id AS ticket_id,
                      ticket.name AS ticket_name,
                      item_jump.reserve_date AS reserve_date,
                      item_jump.reserve_time AS reserve_time,
                      class.quota AS quota,
                      sum(inv_item.quantity) AS total_reserve
                    FROM st_invoice_item AS inv_item
                      JOIN st_invoice_item_jump AS item_jump ON item_jump.invoice_item_id = inv_item.id
                      JOIN st_class_ticket AS ticket ON ticket.id = item_jump.ticket_id
                      JOIN st_invoice AS inv ON inv.id = inv_item.invoice_id
                      JOIN st_class AS class ON class.id = ticket.class_id
                    WHERE inv_item.type='jump' AND class.id = ? AND ticket.id=? AND reserve_date = ?
                    GROUP BY item_jump.reserve_date, item_jump.reserve_time, item_jump.ticket_id
                    ORDER BY class_id ASC, reserve_date DESC, reserve_time ASC";
                $stmt = $db->prepare($query);
                $stmt->bind_param('iis', $_POST['classId'], $_POST['ticketId'], $reserveDate);
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()){
                        array_push($returnData['data'], $row);
                    }
                    $stmt->close();

                    echo json_encode($returnData);
                    return;
                }
            }
            break;
        }
        case 'actionTicket': {
            if(count($_POST) > 0){
                if(isset($_POST['id'])){
                    $query = "DELETE FROM st_remaining WHERE id=?";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('i', $_POST['id']);
                }
                else{
                    $lockedDate = dateToDB($_POST['lockedDate']);
                    $lockedTime = timeToDB($_POST['lockedTime']);

                    if($_POST['mode'] == 'lock'){
                        $query = "INSERT INTO st_remaining (class_id, ticket_id, locked_date, locked_time) VALUES (?, ?, ?, ?)";
                    }
                    else{
                        $query = "DELETE FROM st_remaining WHERE class_id=? AND ticket_id=? AND locked_date=? AND locked_time=?";
                    }
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('iiss', $_POST['classId'], $_POST['ticketId'], $lockedDate, $lockedTime);
                }

                if($stmt->execute()){
                    $stmt->close();
                    echo json_encode($returnData);
                    return;
                }
            }

            break;
        }
        case 'getBlocked': {
            if(count($_POST) > 0){
                $reserveDate = dateToDB($_POST['reserveDate']);
                $query = "SELECT * FROM st_remaining WHERE class_id=? AND ticket_id=? AND locked_date=?";
            }
            else{
                $query = "
                    SELECT
                      rem.id AS id,
                      class.name AS class_name,
                      ticket.name AS ticket_name,
                      rem.locked_date AS locked_date,
                      rem.locked_time AS locked_time
                    FROM st_remaining AS rem
                      JOIN st_class AS class ON class.id = rem.class_id
                      JOIN st_class_ticket AS ticket ON ticket.id = rem.ticket_id
                    WHERE  rem.locked_date >= NOW() ORDER BY class.id, ticket.id, rem.class_id, rem.ticket_id, rem.locked_date, rem.locked_time";
            }
            $stmt = $db->prepare($query);
            if(count($_POST) > 0){
                $stmt->bind_param('iis', $_POST['classId'], $_POST['ticketId'], $reserveDate);
            }
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
        case 'getCurrentBlocked': {
            if(count($_POST) > 0){
                $reserveDate = dateToDB($_POST['reserveDate']);
                $reserveTime = timeToDB($_POST['reserveTime']);

                $query = "SELECT * FROM st_remaining WHERE class_id=? AND locked_date=? AND locked_time=?";
                $stmt = $db->prepare($query);
                $stmt->bind_param('iss', $_POST['classId'], $reserveDate, $reserveTime);
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()){
                        array_push($returnData['data'], $row);
                    }
                    $stmt->close();

                    echo json_encode($returnData);
                    return;
                }
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