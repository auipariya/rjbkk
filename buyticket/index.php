<?php
$activeMenu = 'buyticket';

include '../app/resources/app.header.php';
if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'reserve':{
            include 'reserve.php';
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