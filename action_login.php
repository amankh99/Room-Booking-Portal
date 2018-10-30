<?php
    $path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal";; 
    include_once $path."/common/base.php";
    $pageTitle = "Login";
    include_once $path."/common/header.php";
    include_once $path."/common/navbar_w_login.php";
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])):
?>
 
        <p>You are currently <strong>logged in.</strong></p>
        <p><a href="/logout.php">Log out</a></p>
<?php
    elseif(!empty($_POST['uname']) && !empty($_POST['psw'])):
        include_once $path.'/inc/class.users.inc.php';
        $users = new RoomBookingUsers($db);
        if($users->accountLogin()===TRUE):
            echo "<h1> You Have Successfully Logged In";
        ?>
        <meta http-equiv='refresh' content='0; url=new_booking1.php'>
        <?php
            exit;
        else:
?>
 
        <h1>Login Failed</h1>
        <meta http-equiv='refresh' content='3; url=main.php'>

<?php
    endif;
    endif;
    include_once $path."/common/footer.php";
?>
