<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 11/7/2559
 * Time: 21:09
 */

function dateFromDB($date) {
    if(isset($date) && $date != ''){
        $date = (new \DateTime($date))->format('d/m/Y');
    }

    return $date;
}

function dateToDB($date) {
    if(isset($date) && $date != ''){
        $date = str_replace('/', '-', $date);
        $date = date('Y-m-d', strtotime($date));
    }

    return $date;
}

function timeToDB($time) {
    if(isset($time) && $time != ''){
        $time = date('H:i:s', strtotime($time));
    }

    return $time;
}

// calculate item & price
function calculateItemAndPrice(){
    if(isset($_SESSION['productOrder'])){
        $_SESSION['totalItem'] = 0;
        $_SESSION['totalPrice'] = 0;
        foreach($_SESSION['productOrder'] as $value){
            if(count($value) > 0){
                $_SESSION['totalItem'] += $value['quantity'];
                $_SESSION['totalPrice'] += ($value['price'] * $value['quantity']);
            }
        }
    }
}
