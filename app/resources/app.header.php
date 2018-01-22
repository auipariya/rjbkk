<?php

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalFunction.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lang/lang.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/config/menus.php';

if(!isset($_SESSION['productOrder'])){ $_SESSION['productOrder'] = []; }
if(!isset($_SESSION['totalItem'])){ $_SESSION['totalItem'] = 0; }
if(!isset($_SESSION['totalPrice'])){ $_SESSION['totalPrice'] = 0; }

// remove prod
header('location: ' . $host);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Theme color -->
    <meta name="theme-color" content="#008d4c"><!-- Chrome, Firefox OS and Opera -->
    <meta name="msapplication-navbutton-color" content="#008d4c"><!-- Windows Phone -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#008d4c"><!-- iOS Safari -->

    <!-- Icon -->
    <link rel="icon" href="<?php echo $host ?>/images/logo/cropped-rj-logo-32x32.png" sizes="32x32" />
    <link rel="icon" href="<?php echo $host ?>/images/logo/cropped-rj-logo-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $host ?>/images/logo/cropped-rj-logo-180x180.png" />
    <meta name="msapplication-TileImage" content="<?php echo $host ?>/images/logo/cropped-rj-logo-270x270.png" />

    <title><?php echo $pageTitle ?></title>

    <!----------------------  Core CSS ---------------------->
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:400,700,700italic,500,500italic,400italic,300,300italic">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="<?php echo $host ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $host ?>/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo $host ?>/css/font-awesome.min.css">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" href="<?php echo $host ?>/css/ie10-viewport-bug-workaround.css">
    <!--main & override-->
    <link rel="stylesheet" href="<?php echo $host ?>/css/global.css">
    <link rel="stylesheet" href="<?php echo $host ?>/css/app.css">
    <link rel="stylesheet" href="<?php echo $host ?>/css/override.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!---------------------- Bootstrap core JavaScript ---------------------->
    <script src="<?php echo $host ?>/js/jquery.min.js"></script>
    <script src="<?php echo $host ?>/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $host ?>/plugins/datetimepicker/js/moment-with-locales.js"></script>
    <script src="<?php echo $host ?>/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
</head>

<body>

<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand">
                <img src="<?php echo $host ?>/images/rj-logo.png">
            </span>
        </div>

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php if ($activeMenu == 'viewcart') echo 'active' ?>">
                    <a href="<?php echo $host ?>/viewcart">
                        <?php echo $lang['nav']['viewcart'] ?>
                        <span class="pull-right visible-xs">
                            <?php echo $lang['viewcartCheckoutBox']['item'] ?>
                            <span class="label label-success" style="font-size: inherit;"><?php echo number_format($_SESSION['totalItem']) ?></span>
                        </span>
                    </a>
                </li>
                <?php if(count($_SESSION['productOrder']) > 0): ?>
                    <li class="<?php if ($activeMenu == 'checkout') echo 'active' ?>" id="navCheckOut">
                        <a href="#" data-toggle="modal" data-target="#modalContract">
                            <?php echo $lang['nav']['checkout'] ?>
                            <span class="pull-right visible-xs">
                                <?php echo $lang['viewcartCheckoutBox']['total'] ?>
                                <span class="label label-success" style="font-size: inherit;">฿<?php echo number_format($_SESSION['totalPrice']) ?></span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(isset($_SESSION['userInfo'])): ?>
                    <li title="<?=$_SESSION['userInfo']['name']?>">
                        <a href="<?php echo $host ?>/admin"><i class="fa fa-cogs" style="font-weight: normal;"></i></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Begin page content -->
<div class="container">
    <div class="page-header" style="position: relative;">
        <p class="visible-xs" style="position: absolute;">
            <button type="button" class="btn btn-default btn-xs" data-toggle="offcanvas">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </button>
        </p>
        <h4 class="text-center" id="headerTitle">&nbsp;</h4>
    </div>

    <div class="row row-offcanvas row-offcanvas-left">
        <div class="col-xs-6 col-sm-3 col-md-2 sidebar-offcanvas">
            <div class="list-group">
                <?php foreach($menus as $key => $item): ?>
                    <a class="list-group-item <?php if ($activeMenu == $key) echo 'active' ?>"
                       href="<?php echo ($item['internal'] == true ? $host . '/' : '') . $item['href'] ?>"
                       target="<?php echo $item['target'] ?>">
                        <?php echo $lang['canvas'][$key] ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <img src="<?php echo $host ?>/images/card-catalog.png">
            <div id="localization" class="text-center">
                <input type="hidden" name="locale" value="<?php echo $_SESSION['lang'] ?>">
                <input type="image" src="<?php echo $host ?>/images/flag-en.png" data-toggle="tooltip" data-placement="bottom" value="en" title="English">
                <input type="image" src="<?php echo $host ?>/images/flag-th.png" data-toggle="tooltip" data-placement="bottom" value="th" title="ภาษาไทย">
            </div>
        </div>

        <div id="divContentCenter" class="col-xs-12 col-sm-6 col-md-8">