<?php
    $path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 
    include_once $path."/common/base.php";
    $pageTitle = "Submit Details";
    include_once $path."/common/header.php";
    include_once $path."/common/navbar.php";
    include $path.'/inc/csrf.class.php';
    $csrf = new csrf();
    // if(!empty($_POST[$_SESSION['user']]) && $_SESSION['token_id']==):
        // echo $_SESSION['user'];
        if(isset($_POST[$_SESSION['user']], $_POST[$_SESSION['email']] , $_POST[$_SESSION['text']])){
            if($csrf->check_valid('post')) {
                    $user = $_POST[$_SESSION['user']];
                    $email = $_POST[$_SESSION['email']];
                    $text = $_POST[$_SESSION['text']]; 
                    include_once $path."/inc/class.users.inc.php";
                    $users = new bug($db);
                    echo $users->bugSubmit();
            }
            $_SESSION = $csrf->form_names(array('user', 'email' , 'text'), true);
    }
    else{

?>
<h1 style="text-align:center;"> You are Not Authorized To visit this page</h1>
<meta http-equiv='refresh' content='0; url=main.php'>
<?php
}
    include_once $path."/common/footer.php";
?>