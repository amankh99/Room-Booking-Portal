<?php
$path=$_SERVER['DOCUMENT_ROOT']; 
$pageTitle = "Book A Room";
include_once $path."/common/base.php";
include_once $path.'/common/header.php';
        include_once $path."/inc/class.users.inc.php";
        $users = new populate($db);
        include_once $path.'/common/navbar_w_login.php';
         if(empty($_SESSION['LoggedIn']) && empty($_SESSION['Username'])):
?>
        <p>You are not <strong>logged in.</strong></p>
        <?php else :
        $a = date('Y-m-d',strtotime($_POST['date1']));
        $b = date('Y-m-d',strtotime($_POST['date2']));
        echo $users->book($a,$b); 
        ?>
<div id = "main">
</div>
<?php 
endif;
include_once $path.'/common/footer.php';?>