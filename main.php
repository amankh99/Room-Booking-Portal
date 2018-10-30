<?php
$path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 
$pageTitle = "IIT Mandi Room Booking Portal";
session_start();
include_once $path.'/common/header.php';?>
<?php include_once $path.'/common/navbar_w_login.php';?>
<div id="main">
<?php include_once $path.'/common/login.php';?>
<?php include_once $path.'/common/signup.php';?>
<?php include_once $path.'/carousel.php';?>
<br/>
</div>   

<?php include_once $path.'/common/footer.php';?>

