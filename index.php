<?php
$path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 
$pageTitle = "IIIT Room Booking Portal";
session_start();
 if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) &&($_SESSION['Admin'] == 'yes')):
 ?><meta http-equiv="refresh" content="0;/query.php"><?php
endif;
include_once $path.'/common/header.php';?>
<?php include_once $path.'/common/navbar_w_login.php';?>
<div id="main">
<?php include_once $path.'/common/login.php';?>
<?php include_once $path.'/common/signup.php';?>
<?php include_once $path.'/carousel.php';?>
<br/>
</div>   

<?php include_once $path.'/common/footer.php';?>

