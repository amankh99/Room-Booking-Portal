<ul>
    <li><a id="nav1" href="./main.php">HOME</a></li>

    <?php
    if(isset($_SESSION['LoggedIn']) && isset($_SESSION['Username'])
        && $_SESSION['LoggedIn']==1):
    ?>
  	<li><a id="nav1" href="./bookings.php">MY BOOKINGS</a></li>    
  	<li><a id="nav1" href="./new_booking_room.php">NEW ROOM BOOKING</a></li>    
    <li><a id="nav1" href="./new_booking1.php">NEW HOSTEL BOOKING</a></li>
  	<li><a id="nav1" href="./contact.php">CONTACT US</a></li>
  	<li><a id="nav1" href="./bug.php">REPORT A BUG</a></li>
    <li style="float:right;"><a id="nav1" href="./my_account.php"><?php echo strtoupper($_SESSION['Username']); ?> </a></li>
  	<li style="float:right;"><a id="nav1" href="./logout.php">LOG OUT</a></li>
    <?php else: ?>
      	<li><a id="nav1" href="./contact.php">CONTACT US</a></li>
  	<li><a id="nav1" href="./bug.php">REPORT A BUG</a></li>
    <li style="float:right;"><a id="nav1" href="#" onclick="document.getElementById('id01').style.display='block'" > LOGIN </a></li>
    
    <li style="float:right;"><a id="nav1" href="#" onclick="document.getElementById('id03').style.display='block'" > SIGN UP </a></li>
    <?php endif; ?>
</ul>
