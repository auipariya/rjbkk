<?php

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/lang/en.php';

if(!isset($_SESSION['userInfo'])){
    header('location: ' . $host . '/auth');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Theme color -->
    <meta name="theme-color" content="#222222"><!-- Chrome, Firefox OS and Opera -->
    <meta name="msapplication-navbutton-color" content="#222222"><!-- Windows Phone -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#222222"><!-- iOS Safari -->

    <!-- Icon -->
    <link rel="icon" href="<?php echo $host ?>/images/logo/cropped-rj-logo-32x32.png" sizes="32x32" />
    <link rel="icon" href="<?php echo $host ?>/images/logo/cropped-rj-logo-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $host ?>/images/logo/cropped-rj-logo-180x180.png" />
    <meta name="msapplication-TileImage" content="<?php echo $host ?>/images/logo/cropped-rj-logo-270x270.png" />

    <title>Management <?php echo $pageTitle ?></title>

    <!----------------------  Core CSS ---------------------->
    <!-- Bootstrap -->
    <!--<link rel="stylesheet" type="text/css" href="<?php echo $host ?>/bootstrap/css/bootstrap.css">-->
    <link rel="stylesheet" type="text/css" href="<?php echo $host ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $host ?>/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo $host ?>/css/font-awesome.min.css">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" href="<?php echo $host ?>/css/ie10-viewport-bug-workaround.css">
    <!--main & override-->
    <link rel="stylesheet" href="<?php echo $host ?>/css/global.css">
    <link rel="stylesheet" href="<?php echo $host ?>/css/admin.css">

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

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $host ?>">
                <img src="<?php echo $host ?>/images/rj-logo.png">
            </a>
        </div>

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php foreach($admin['menus'] as $item): ?>
                    <?php if($item['enable'] == true): ?>
                        <li class="<?php if($activeMenu == $item['id']) echo 'active'; ?>">
                            <a href="<?php echo $item['href'] ?>"><?php echo $item['text'] ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['userInfo']['name'] ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!--<li><a href="#change-password" data-toggle="modal" data-target="#modalChangePassword"><i class="glyphicon glyphicon-cog"></i> Change password</a></li>
                        <li role="separator" class="divider"></li>-->
                        <li><a href="<?php echo $host ?>/auth/logout.php"><i class="glyphicon glyphicon-log-out"></i> Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Begin page content -->
<div class="container">
    <div class="page-header" style="margin-top: 10px;">
        <span class="h3"><?php  echo $adminPageTitle ?></span>
        <a class="pull-right btn btn-primary hidden" style="margin-top: -5px;"
           href="<?php echo str_replace('index.php', '', $_SERVER['PHP_SELF']) ?>?mode=create">
            <i class="fa fa-plus"></i> ADD <?php echo $adminPageTitle ?>
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">