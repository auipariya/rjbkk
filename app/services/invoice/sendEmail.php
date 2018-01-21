<?php

date_default_timezone_set('Etc/UTC');

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalFunction.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lib/PHPMailer/PHPMailerAutoload.php';

header('Content-Type: application/json');


$returnData = $returnDataPattern;

if(isset($_POST)){
    $query = 'SELECT * FROM st_invoice WHERE id=? LIMIT 1';
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $_POST['id']);
    if($stmt->execute()){
        $invoice = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $query = "SELECT * FROM st_invoice_item WHERE invoice_id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $_POST['id']);
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $invoiceItem = [];
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
                }
                array_push($invoiceItem, $row);
            }

            $message = '<b>Dear ' . $invoice['customer_name'] . '</b><br><br><br>';
            $message .= 'Your buy ticket has been processed successfully. You can check the information of this transaction from below:<br><br>';
            $message .= 'Transaction No.: <b>' . $_POST['id'] . '</b><br><br>';
            $message .= '<table>';
            $message .= '<tr>';
            $message .= '<th>No.</th>';
            $message .= '<th>Jump class/VIP pass</th>';
            $message .= '<th>Ticket</th>';
            $message .= '<th>Quantity</th>';
            $message .= '<th>Price</th>';
            $message .= '</tr>';
            for ($index = 0; $index < count($invoiceItem); $index++) {
                $message .= '<tr>';
                $message .= '<td style=\'text-align: center;\'>'.($index+1).'</td>';
                $message .= '<td>'.$invoiceItem[$index]['description'].'</td>';
                $message .= '<td>'.$invoiceItem[$index]['name'].'</td>';
                $message .= '<td style=\'text-align: right;\'>'.$invoiceItem[$index]['quantity'].'</td>';
                $message .= '<td style=\'text-align: right;\'>'.$invoiceItem[$index]['price'].'</td>';
                $message .= '</tr>';
            }
            $message .= '</table><br><br>';
            $message .= 'Yours Sincerely,<br>';
            $message .= "ROCKIN' JUMP Bangkok.";
        }

        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Set character code to support thai
        $mail->CharSet = 'UTF-8';
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
        //Set the hostname of the mail server
        $mail->Host = $email['mailServer'];
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 25;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = false;
    
        $mail->setFrom($email['sender'], $email['senderName']);
        $mail->addAddress($invoice['customer_email'], $invoice['customer_name']);
        $mail->AddCC($email['sender'], $email['senderName']);
        $mail->Subject = "Successful transaction no. " . $_POST['id'];
        $mail->msgHTML($message);
    
        //send the message, check for errors
        if (!$mail->send()) {
            $returnData['success'] = false;
        }
    } else {
        $returnData['success'] = false;
    }
}
else{
    $returnData['success'] = false;
}

echo json_encode($returnData);