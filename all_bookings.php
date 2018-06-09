<?php
$path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 
$pageTitle = "All Bookings";
// session_start();
include_once $path."/common/base.php";
include_once $path."/inc/class.users.inc.php";
$users = new admin_portal($db);
include_once $path.'/common/header.php';?>
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && ($_SESSION['Admin']=='yes')):
 include_once $path.'/common/admin_navbar.php';?>
 	<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #30aed6;
    color: white;
}
</style>
<div id="main">
<form action="<?php $a="#"; echo htmlspecialchars($a);?>" method="post">        
<?php
        echo "<br/>";
        echo $users->room();
        echo $users->user();
?>
<input type="submit"></input>
</form>
<table>
	<tr>
		<th>Room Name</th>
		<th>User Name</th>
		<th>Booking Start Date</th>
		<th>Booking Stop Date</th>
	</tr>
<?php if(isset($_POST['room']) || isset($_POST['user'])){echo $users->booking($_POST['room'],$_POST['user']);} ?>
</table>
</div>   

<?php 
else:
        echo "<meta http-equiv='refresh' content='0; url=main.php'>";
	endif;
include_once $path.'/common/footer_admin.php';?>
