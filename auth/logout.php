<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 10/7/2559
 * Time: 19:30
 */

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';

if(isset($_SESSION['userInfo'])){
    unset($_SESSION['userInfo']);
}
header('location: ' . $host);