<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 8/7/2559
 * Time: 12:15
 */

include $_SERVER['DOCUMENT_ROOT'] . '/webstore/app/GlobalVariable.php';
if(isset($_SESSION['userInfo'])){
    header('location: ' . $host . '/admin');
}

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

    <!-- Icon -->
    <link rel="icon" href="<?php echo $host ?>/images/logo/cropped-rj-logo-32x32.png" sizes="32x32" />
    <link rel="icon" href="<?php echo $host ?>/images/logo/cropped-rj-logo-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $host ?>/images/logo/cropped-rj-logo-180x180.png" />
    <meta name="msapplication-TileImage" content="<?php echo $host ?>/images/logo/cropped-rj-logo-270x270.png" />

    <title>Log in <?php echo $pageTitle ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $host ?>/bootstrap/css/bootstrap.css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" type="text/css" href="<?php echo $host ?>/css/ie10-viewport-bug-workaround.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="<?php echo $host ?>/css/signin.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">

    <form class="form-signin" role="form" method="post" id="formLogin">

        <h2 class="form-signin-heading">Please log in</h2>

        <div class="alert alert-danger hidden" role="alert">
            <strong>Whoops!</strong> There were some problems with your input.
        </div>

        <label for="email" class="sr-only">Email address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Email address" autofocus
            value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : null ?>">

        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password">

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-lg btn-success btn-block">Log in</button>
            </div>
        </div>

        <!--<div class="text-right">
            <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
        </div>-->

    </form>

</div>

<!---------------------- Bootstrap core JavaScript ---------------------->
<script src="<?php echo $host ?>/js/jquery.min.js"></script>
<script src="<?php echo $host ?>/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('button[type=submit]').on('click', function (e) {
            e.preventDefault();

            var formLogin = $('#formLogin');
            var divAlert = formLogin.find('div[role=alert]');

            $.ajax({
                url:  '<?php echo $host; ?>/app/services/auth/login.php',
                method: formLogin[0].method,
                data: formLogin.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        $(divAlert).addClass('hidden');
                        location.href = '<?php echo $host ?>/admin';
                    }
                    else {
                        var uiContent = divAlert.find('ul');
                        if(uiContent.length == 0){
                            $('<ul>').appendTo(divAlert);
                        }
                        else{
                            uiContent.empty();
                        }

                        for(var i in response.data){
                            $('<li>', { text: response.data[i] }).appendTo(divAlert.find('ul'));
                        }

                        $(divAlert).removeClass('hidden');
                    }
                }
            });
        });
    });
</script>

</body>
</html>