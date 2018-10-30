<?php
$path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 
$pageTitle = "Queries";
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
<table>
	<tr>
		<th>Token ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Description</th>
	</tr>
<?php echo $users->query(); ?>
</table>
</div>   

<?php 
else:
        echo "<meta http-equiv='refresh' content='0; url=main.php'>";
	endif;
include_once $path.'/common/footer_admin.php';?>
