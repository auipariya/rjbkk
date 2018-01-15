<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 14/7/2559
 * Time: 0:46
 */

if(isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
    header('location: ' . $_SERVER['HTTP_REFERER']);
}

$_SESSION['lang'] = isset($_SESSION['lang']) ? $_SESSION['lang'] : $locale;

include $_SESSION['lang'] . '.php';