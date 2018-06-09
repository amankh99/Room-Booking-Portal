<?php
 
    session_start();
    unset($_SESSION['LoggedIn']);
    unset($_SESSION['Username']);
    unset($_SESSION['Admin']);
 
?>
 <!--<h1> You have Been Logged Out</h1>-->
<meta http-equiv="refresh" content="0; main.php">