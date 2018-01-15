<?php
$activeMenu = 'adminJumpClass';
$adminPageTitle = 'JUMP CLASS';
?>

<?php include '../../app/resources/admin.header.php'; ?>
<div class="admin">
    <?php
    if(isset($_GET['mode']) && ($_GET['mode'] == 'create' || $_GET['mode'] == 'update')){
        include '_form.php';
    }
    else{
        include 'list.php';
    }
    ?>
</div>
<?php include '../../app/resources/admin.footer.php'; ?>