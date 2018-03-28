<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 8/7/2559
 * Time: 12:21
 */

session_start();

/**
 * application name
 */
$appName = 'webstore';

/**
 * host name
 */
$host = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $appName;


/**
 * virtual directory path
 */
$virtualDir = $_SERVER['DOCUMENT_ROOT'] . '/' . $appName;


/**
 * MySQL
 */
if ($_SERVER['SERVER_NAME'] == 'www.bangkok-rockinjump.com') {
    // $hostName = 'wh-db51.csloxinfo.com';    // host name
    // $hostUser = 'bangkok';         			// user
    // $hostPass = 'a3Q23FN9CW';             	// password
    // $database = 'bangkokdb';    			// database name
    $hostName = 'localhost';                // host name
    $hostUser = 'bangkok';         			// user
    $hostPass = 'Bud85#7c';             	// password
    $database = 'bangkokdb';    			// database name
} else {
    $hostName = 'localhost';                // host name
    $hostUser = 'root';         			// user
    $hostPass = '';             	        // password
    $database = 'bangkokdb';    			// database name
}
$db = new mysqli($hostName, $hostUser, $hostPass, $database);
$db->query('SET NAMES UTF8');

/**
 * initialize locale
 */
$locale = 'en';


/**
 * locales app
 */
$locales = ['en', 'th'];


/**
 * page title
 */
$pageTitle = ' | Rockin\' Jump Bangkok Web Store';


/**
 * store error list
 */
$errors = [];


/**
 * return data pattern
 */
$returnDataPattern = [
    'success' => true,
    'data' => []
];


/**
 * admin setting
 */
$admin = [
    'menus' => [
        /*[
            'id'        => 'adminHome',
            'text'      => 'DASHBOARD',
            'href'      => $host . '/admin',
            'enable'    => true
        ],*/ [
            'id'        => 'adminJumpClass',
            'text'      => 'JUMP CLASS',
            'href'      => $host . '/admin/jumpclass',
            'enable'    => true
        ], [
            'id'        => 'adminPass',
            'text'      => 'PASS',
            'href'      => $host . '/admin/pass',
            'enable'    => true
        ], [
            'id'        => 'adminRemaining',
            'text'      => 'REMAINING',
            'href'      => $host . '/admin/remaining',
            'enable'    => true
        ], [
            'id'        => 'adminTransaction',
            'text'      => 'TRANSACTION',
            'href'      => $host . '/admin/transaction',
            'enable'    => true
        ]
    ],

    'status' => [
        'a' => 'Active',
        'i' => 'Inactive',
    ],

    'days' => [
        '' => 'Select a day',
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
        '0' => 'Sunday'
    ]
];

/**
 * Omise account
 */
$omise = [
    'pkey' => 'pkey_test_5a7aigtfk8mrzkqms1q',
    'skey' => 'skey_test_5a7aigtg5thdjbp7ez4',
    // 'pkey' => 'pkey_5b45qvpl05vdd0kp815',
    // 'skey' => 'skey_5bf7g8mkw7648ptolrv',
    'apiv' => '2017-11-02'
];

/**
 * Email config
 */
$email = [
    'mailServer' => 'mail.bangkok-rockinjump.com',
    'senderPrimary' => 'pariya.kam@mail.kmutt.ac.th',
    'senderSecond' => 'pariya-dream@hotmail.com',
    // 'senderPrimary' => 'contact@bangkok-rockinjump.com',
    // 'senderSecond' => 'areerat@bangkok-rockinjump.com',
    'senderName' => "ROCKIN' JUMP Bangkok"
];