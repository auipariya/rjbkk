<?php
$activeMenu = 'pass';

include '../app/resources/app.header.php';
if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'reserve':{
            include 'passinfo.php';
            break;
        }
        default:{
            break;
        }
    }
}
else{
    include 'list.php';
}

include '../app/resources/app.footer.php';