<?php
    $path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 
    include_once $path."/common/base.php";
    $pageTitle = "Admin Login";
    include_once $path."/common/header.php";
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) &&($_SESSION['Admin'] == 'yes')):
    include_once $path."/common/admin_navbar.php";
?>
        
        <p>You are currently <strong>logged in.</strong></p>
        <p><a href="/logout.php">Log out</a></p>
<?php
    elseif(!empty($_POST['uname']) && !empty($_POST['psw'])):
        include_once $path.'/inc/class.users.inc.php';
        $users = new RoomBookingAdmin($db);
        if($users->accountLogin()===TRUE):
            include_once $path."/common/admin_navbar.php";
            echo "<meta http-equiv='refresh' content='0; url=query.php'>";
            echo "<h1> You Have Successfully Logged In";
            exit;
        else:
?>
 
        <h1>Login Failed</h1>
        <meta http-equiv='refresh' content='3; url=main.php'>

<?php
    endif;
    else:
    echo"<h1> You are not Authorized to be here </h1>";
    endif;
    include_once $path."/common/footer_admin.php";
?>
