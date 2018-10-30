
<?php
class RoomBookingUsers
{
	private $_db;

	public function __construct($db=NULL)
	{
		if(is_object($db))
		{
			$this->_db = $db;
		}
		else
		{
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
			$this->_db = new PDO($dsn, DB_USER, DB_PASS);
		}
	}
	public function createAccount()
    {
        // echo "dfghdfg";
		$path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 

        $u = $this->test_input($_POST['uname']);
		$e = $this->test_input($_POST['email']);
		$p = MD5($this->test_input($_POST['psw']));
		$p1 = MD5($this->test_input($_POST['psw1']));
        if($p1 != $p){
            echo "<h1>Password Don't Match.</h1>";
            echo "1";
             return;
        }

        //$v = sha1(time());
 
        $sql = "SELECT COUNT(Username) AS theCount
                FROM User
                WHERE Username=:uname";
        if($stmt = $this->_db->prepare($sql)) {
            $stmt->bindParam(":uname", $u, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if($row['theCount']!=0) {
                  $err =  "Sorry, that User Name is already in use. ";
					// include_once $path."/common/footer.php";
					// echo "<meta http-equiv='refresh' content='3; url=main.php'>";
					// echo "2";
                    return;
            }
            /*if(!$this->sendVerificationEmail($u, $v)) {
                return "<h2> Error </h2>"
                    . "<p> There was an error sending your"
                    . " verification email. Please "
                   // . "<a href="mailto:help@coloredlists.com">contact "
                    . "us</a> for support. We apologize for the "
                    . "inconvenience. </p>";
            }*/
            //$stmt->closeCursor();
        }
		$temp="user";
        $sql = "INSERT INTO User(Username, Password , Email )
                VALUES(:uname, :psw, :email)";
        if($stmt = $this->_db->prepare($sql)) {
            $stmt->bindParam(":uname", $u, PDO::PARAM_STR);
            $stmt->bindParam(":psw", $p, PDO::PARAM_STR);
            $stmt->bindParam(":email", $e, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
 
              // echo "<h2> Success! </h2>"
                    // . "<p> Your account was successfully "
                    // . "created with the username <strong>$u</strong>."
                    // . " Check your email!";
					// include_once $path."/common/footer.php";
					// echo "<meta http-equiv='refresh' content='3; url=main.php'>";
				return TRUE;
            
        } else {
            echo "<h2> Error </h2><p> Couldn't insert the "
                . "user information into the database. </p>";
				// include_once $path."/common/footer.php";
				// echo "<meta http-equiv='refresh' content='3; url=main.php'>";
				return;
		}
		        
    }
	private function sendVerificationEmail($email, $ver)
    {
        $e = sha1($email); // For verification purposes
        $to = trim($email);
 
        $subject = "[Colored Lists] Please Verify Your Account";
 
        $headers = <<<MESSAGE
		From: IIT Mandi Booking Portal
		Content-Type: text/plain;
MESSAGE;

		        $msg = <<<EMAIL
		You have a new account.

		To get started, please activate your account and choose a
		password by following the link below.

		Your Username: $email

		Activate your account: http://coloredlists.com/accountverify.php?v=$ver&e=$e

		If you have any questions, please contact help@coloredlists.com.

		--
		Thanks!

EMAIL;
 
        return mail($to, $subject, $msg, $headers);
    }

	public function accountLogin(){
    $sql = "SELECT *
            FROM User
            WHERE Username=:uname
            AND Password=MD5(:psw)
            LIMIT 1";
    try
    {
        $u = $this->test_input($_POST['uname']) ;
        $p = $this->test_input($_POST['psw']) ;
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':uname', $u, PDO::PARAM_STR);
        $stmt->bindParam(':psw', $p, PDO::PARAM_STR);
        $stmt->execute();
        // $data = mysql_query($sql);
        // $data=$stmt->fetch();
        // foreach ($data as $row) {
            // echo $data ;
        // while ($row = mysql_fetch_array($data)) {
    // echo '<pre>';
    // print_r ($row);
    // echo '</pre>';
// }
        // }
        if($stmt->rowCount()==1){
            $_SESSION['Username'] = htmlentities($this->test_input($_POST['uname']), ENT_QUOTES);
            $_SESSION['Admin'] = 'no' ;
            $_SESSION['LoggedIn'] = 1;
            $_SESSION['token'] = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,16);
            $data = $stmt->fetchAll();
            $_SESSION['Userid'] = $data[0]["UserID"];
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    catch(PDOException $e)
    {
        return FALSE;
    }
}

public function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
}
class contact{
    private $_db;

	public function __construct($db=NULL)
	{
		if(is_object($db))
		{
			$this->_db = $db;
		}
		else
		{
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
			$this->_db = new PDO($dsn, DB_USER, DB_PASS);
		}
	}
    public function contactSubmit()
    {
		$path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 
        $u = $this->test_input($_POST[$_SESSION['user']]);
		$e = $this->test_input($_POST[$_SESSION['email']]);
		$t = $this->test_input($_POST[$_SESSION['text']]);
		$temp="user";
        $sql = "INSERT INTO Contact_Us(Name, Description , Email )
                VALUES(:name, :txt, :email)";
        if($stmt = $this->_db->prepare($sql)) {
            $stmt->bindParam(":name", $u, PDO::PARAM_STR);
            $stmt->bindParam(":txt", $t, PDO::PARAM_STR);
            $stmt->bindParam(":email", $e, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
 
              echo "<h2> ThankYou For Contacting Us </h2>"
                    . "<p> We would get back to you shortly .</p>";
					include_once $path."/common/footer.php";
					//echo "<meta http-equiv='refresh' content='3; url=main.php'>";
				return;
            
        } else {
            echo "<h2> Error </h2><p> Couldn't insert the "
                . "user information into the database. </p>";
				include_once $path."/common/footer.php";
				echo "<meta http-equiv='refresh' content='3; url=main.php'>";
				return;
		}
		        
    }
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
}
class bug{
    private $_db;

	public function __construct($db=NULL)
	{
		if(is_object($db))
		{
			$this->_db = $db;
		}
		else
		{
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
			$this->_db = new PDO($dsn, DB_USER, DB_PASS);
		}
	}
    public function bugSubmit()
    {
		$path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 
        $u = $this->test_input($_POST[$_SESSION['user']]);
		$e = $this->test_input($_POST[$_SESSION['email']]);
		$t = $this->test_input($_POST[$_SESSION['text']]);
		$temp="user";
        $sql = "INSERT INTO Bug_Report(Name, Bug , Email )
                VALUES(:name, :txt, :email)";
        if($stmt = $this->_db->prepare($sql)) {
            $stmt->bindParam(":name", $u, PDO::PARAM_STR);
            $stmt->bindParam(":txt", $t, PDO::PARAM_STR);
            $stmt->bindParam(":email", $e, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
 
              echo "<h2> ThankYou For Reporting Us </h2>"
                    . "<p> We would get back to you shortly .</p>";
					include_once $path."/common/footer.php";
					//echo "<meta http-equiv='refresh' content='3; url=main.php'>";
				return;
            
        } else {
            echo "<h2> Error </h2><p> Couldn't insert the "
                . "user information into the database. </p>";
				include_once $path."/common/footer.php";
				echo "<meta http-equiv='refresh' content='3; url=main.php'>";
				return;
		}
		        
    }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
}
class RoomBookingAdmin{
    	private $_db;

	public function __construct($db=NULL)
	{
		if(is_object($db))
		{
			$this->_db = $db;
		}
		else
		{
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
			$this->_db = new PDO($dsn, DB_USER, DB_PASS);
		}
	}
public function accountLogin()
{
    $sql = "SELECT Username
            FROM User
            WHERE Username=:uname
            AND Password=MD5(:psw)
            AND Status='admin'
            LIMIT 1";
            $u=$this->test_input($_POST['uname']);
            $p=$this->test_input($_POST['psw']);
    try
    {
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':uname',$u , PDO::PARAM_STR);
        $stmt->bindParam(':psw',$p , PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount()==1)
        {
            $_SESSION['Username'] = htmlentities($this->test_input($_POST['uname']), ENT_QUOTES);
            $_SESSION['LoggedIn'] = 1;
            $_SESSION['Admin'] = 'yes' ;
            $_SESSION['token'] = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,16);
            $data = $stmt->fetchAll();
            $_SESSION['Userid'] = $data[0]["UserID"];
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    catch(PDOException $e)
    {
        return FALSE;
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
}
class populate{
    	private $_db;

	public function __construct($db=NULL)
	{
		if(is_object($db))
		{
			$this->_db = $db;
		}
		else
		{
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
			$this->_db = new PDO($dsn, DB_USER, DB_PASS);
		}
	}
    public function room(){
        $connection = $this->_db;
        $smt = $connection->prepare('SELECT Room_name From Room');
        $smt->execute();
        $data = $smt->fetchAll();
        echo "<select name='room'> <option value='0'>Select A Room</option>";
        $a = 1 ;
        foreach ($data as $row):?>
            <option value="<?php echo $a ?>"><?php echo $row["Room_name"]?></option>
            <?php 
            $a = $a + 1;
        endforeach ; ?>
        </select>
        <?php
    }
    public function book($a,$b){
        $connection = $this->_db;
        $r = $this->test_input($_POST['room']);
        // echo $r.$a.$b;
        $user = $connection->prepare('SELECT * FROM User');
        $user->execute();
        $user_row = $user->fetchAll();
        foreach ($user_row as $user_name) {
            if($_SESSION['Username'] == $user_name['Username']){
                $name = $user_name['UserID'];
                // echo $name;
                break;
            }
        }

        $sql = "INSERT INTO Bookings(Room_id, Booking_start_date , Booking_end_date,User_id )
                VALUES(:id, :start, :end1 , :uid)";
        if($stmt = $this->_db->prepare($sql)) {
            $stmt->bindParam(":uid", $name, PDO::PARAM_STR);
            $stmt->bindParam(":start", $a, PDO::PARAM_STR);
            $stmt->bindParam(":end1", $b, PDO::PARAM_STR);
            $stmt->bindParam(":id", $r, PDO::PARAM_STR);
            $stmt->execute();
            echo "Success";
        }
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = "ssl://smtp.gmail.com";
//$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'iiitroombook@gmail.com';                 // SMTP username
$mail->Password = 'saksham9';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to
echo !extension_loaded('openssl')?"Not Available":"Available";
$mail->setFrom('from@example.com', 'IItmandi booking portal');
$mail->addAddress('b16060@students.iitmandi.ac.in', 'Lakshay arora');     // Add a recipient
$mail->addCC('b16007@students.iitmandi.ac.in');
$mail->addCC('b16037@students.iitmandi.ac.in');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Room Booking Conformation';
$mail->Body    = 'There is a Room Booking by '.$_SESSION['Username'].' from '.$a.' to '.$b.' for Room id'.$r;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    //echo 'Message has been sent';
}

}

public function bookHostel(){
        $connection = $this->_db;
        $r = $this->test_input($_POST['hostel']);
        $user = $connection->prepare('SELECT * FROM User');
        $user->execute();
        $user_row = $user->fetchAll();
        foreach ($user_row as $user_name) {
            if($_SESSION['Username'] == $user_name['Username']){
                $name = $user_name['UserID'];
                // echo $name;
                break;
            }
        }

        $sql = "INSERT INTO HostelBookings(Hostel_id, room, User_id)
                VALUES(:id, :room, :uid)";
        $room_no = ($_POST['floor'] . $_POST['room_no']);
        if($stmt = $this->_db->prepare($sql)) {
            $stmt->bindParam(":uid", $name, PDO::PARAM_STR);
            $stmt->bindParam(":room", $room_no, PDO::PARAM_STR);
            $stmt->bindParam(":id", $r, PDO::PARAM_STR);
            $stmt->execute();
            echo "Success";
        }
        require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = "ssl://smtp.gmail.com";
//$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'iiitroombook@gmail.com';                 // SMTP username
$mail->Password = 'saksham9';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to
echo !extension_loaded('openssl')?"Not Available":"Available";
$mail->setFrom('iitmandibooking@iitmandi.ac.in', 'IItmandi Booking Portal');
$mail->addAddress('b16060@students.iitmandi.ac.in', 'Lakshay arora');     // Add a recipient
$mail->addCC('b16007@students.iitmandi.ac.in');
$mail->addCC('b16037@students.iitmandi.ac.in');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Room Booking Conformation';
$mail->Body    = 'You have successfully booked hostel ' . $room_no . ' for current session';
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    //echo 'Message has been sent';
}
}
    public function date($q){
        // $q = 1;
        $id = $q;
        $connection = $this->_db;
        $smt = $connection->prepare('SELECT * FROM Bookings');
        $smt->execute();
        // echo $q;
        $data = $smt->fetchAll();
        $temp = 0;       
        foreach ($data as $row):
        if($row['Room_id'] == $id){
            $date=$row['Booking_start_date'];
            $end = $row['Booking_end_date'];
            while (strtotime($date) <= strtotime($end)) {
            $start = date_parse($date);
            $tmp = $start['month']-1;
        ?>
        <script>var temp = <?php echo "new Date(".$start['year'].",".$tmp.",".$start['day'].")";?> ;disabledDatesArray.push(temp);</script><?php       
        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));	        
        }}
        endforeach;
        ?>
<?php
    }
       
    public function bookings(){
        $connection = $this->_db;
        $smt = $connection->prepare('SELECT * FROM Bookings');   
        $smt->execute();
        $data = $smt->fetchAll();
        $room_details = $connection->prepare('SELECT * FROM Room');
        $room_details->execute();
        $room1 = $room_details->fetchAll();
        $user = $connection->prepare('SELECT * FROM User');
        $user->execute();
        $user_row = $user->fetchAll();
        foreach ($user_row as $user_name) {
            if($_SESSION['Username'] == $user_name['Username'])
                $name = $user_name['UserID'];
            // echo $user_name['Username'] ;
            // echo $_SESSION['Username'];
        }
        $temp =1 ;
        // echo $name;
        foreach ($data as $row) {
            // var_dump($row);
            if($row['User_id'] == $name){
                // echo "Yes";
                $start=$row['Booking_start_date'];
                $end=$row['Booking_end_date'];
                $room = $row['Room_id'];
                // echo $start . $end  .$room;
                foreach ($room1 as $row_room) {
                    if($row_room['RoomId'] == $room){
                        $room_name = $row_room['RoomName'];
                        break;
                    }
                }
                echo "<tr><td>".$temp."</td><td>".date('d-m-Y',strtotime($start))."</td><td>" . date('d-m-Y',strtotime($end)) ."</td><td>" . $room_name . "</td></tr>";
                $temp = $temp+1;
            }
        }
    }
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
}
class admin_portal
{
    private $_db;

    public function __construct($db=NULL)
    {
        if(is_object($db))
        {
            $this->_db = $db;
        }
        else
        {
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
            $this->_db = new PDO($dsn, DB_USER, DB_PASS);
        }
    }
    public function query(){
        $connection = $this->_db;
        $smt = $connection->prepare('SELECT * FROM Contact_Us');   
        $smt->execute();
        $data = $smt->fetchAll();
        foreach ($data as $row) {
            echo "<tr><td>".$row['Token_no']."</td><td>".$row['Name']."</td><td>" . $row['Email'] ."</td><td>" . $row['Description'] . "</td></tr>"; 
        }
    }

    public function bug(){
        $connection = $this->_db;
        $smt = $connection->prepare('SELECT * FROM Bug_Report');   
        $smt->execute();
        $data = $smt->fetchAll();
        foreach ($data as $row) {
            echo "<tr><td>".$row['Token_no']."</td><td>".$row['Name']."</td><td>" . $row['Email'] ."</td><td>" . $row['Bug'] . "</td></tr>"; 
        }
    }
    public function room(){
        $connection = $this->_db;
        $smt = $connection->prepare('SELECT Room_name From Room');
        $smt->execute();
        $data = $smt->fetchAll();
        echo "<select name='room'> <option value=''>Select A Room</option>";
        $a = 1 ;
        foreach ($data as $row):?>
            <option value="<?php echo $a ?>"><?php echo $row["Room_name"]?></option>
            <?php 
            $a = $a + 1;
        endforeach ; ?>
        </select>
        <?php
    }

    public function user(){
        $connection = $this->_db;
        $smt = $connection->prepare('SELECT * From User');
        $smt->execute();
        $data = $smt->fetchAll();
        echo "<select name='user'> <option value=''>Select A User</option>";
        // $a = 1 ;
        foreach ($data as $row):?>
            <option value="<?php echo $row['UserID'] ?>"><?php echo $row["Username"]?></option>
            <?php 
            // $a = $a + 1;
        endforeach ; ?>
        </select>
        <?php
    }
    public function booking($room_id,$id){
        // echo "Works";
        $connection = $this->_db;
        $smt = $connection->prepare('SELECT * FROM Bookings');   
        $smt->execute();
        $data = $smt->fetchAll();
        $room_details = $connection->prepare('SELECT * FROM Room');
        $room_details->execute();
        $room1 = $room_details->fetchAll();
        $user_details = $connection->prepare('SELECT * FROM User');
        $user_details->execute();
        $user1 = $user_details->fetchAll();
        $temp =1 ;
        $room_name="";$user_name="";
        // echo $name;
        foreach ($data as $row) {
            if($room_id == "" && $id == "" ){
                $user = $row['User_id'];
                $start=$row['Booking_start_date'];
                $end=$row['Booking_end_date'];
                $room = $row['Room_id'];
                // echo $start . $end  .$room;
                foreach ($room1 as $row_room) {
                    if($row_room['Room_id'] == $room){
                        $room_name = $row_room['Room_name'];
                        break;
                    }
                }

                foreach ($user1 as $row_user) {
                    if($row_user['UserID'] == $user){
                        $user_name = $row_user['Username'];
                        break;
                    }
                }
                echo "<tr><td>".$room_name."</td><td>".$user_name."</td><td>".date('d-m-Y',strtotime($start))."</td><td>" . date('d-m-Y',strtotime($end)) ."</td></tr>";
                $temp = $temp+1;
            }
            if($room_id != "" && $id == "" ){
                if($room_id != $row['Room_id'])
                    continue;
                $user = $row['User_id'];
                $start=$row['Booking_start_date'];
                $end=$row['Booking_end_date'];
                $room = $row['Room_id'];
                // echo $start . $end  .$room;
                foreach ($room1 as $row_room) {
                    if($row_room['Room_id'] == $room){
                        $room_name = $row_room['Room_name'];
                        break;
                    }
                }

                foreach ($user1 as $row_user) {
                    if($row_user['UserID'] == $user){
                        $user_name = $row_user['Username'];
                        break;
                    }
                }
                echo "<tr><td>".$room_name."</td><td>".$user_name."</td><td>".date('d-m-Y',strtotime($start))."</td><td>" . date('d-m-Y',strtotime($end)) ."</td></tr>";
                $temp = $temp+1;
            }
            if($room_id == "" && $id != "" ){
                if($id != $row['User_id'])
                    continue;
                $user = $row['User_id'];
                $start=$row['Booking_start_date'];
                $end=$row['Booking_end_date'];
                $room = $row['Room_id'];
                // echo $start . $end  .$room;
                foreach ($room1 as $row_room) {
                    if($row_room['Room_id'] == $room){
                        $room_name = $row_room['Room_name'];
                        break;
                    }
                }

                foreach ($user1 as $row_user) {
                    if($row_user['UserID'] == $user){
                        $user_name = $row_user['Username'];
                        break;
                    }
                }
                echo "<tr><td>".$room_name."</td><td>".$user_name."</td><td>".date('d-m-Y',strtotime($start))."</td><td>" . date('d-m-Y',strtotime($end)) ."</td></tr>";
                $temp = $temp+1;
            }
            if($room_id != "" && $id != "" ){
                if($room_id != $row['Room_id'] || $id != $row['User_id'])
                    continue;
                $user = $row['User_id'];
                $start=$row['Booking_start_date'];
                $end=$row['Booking_end_date'];
                $room = $row['Room_id'];
                // echo $start . $end  .$room;
                foreach ($room1 as $row_room) {
                    if($row_room['Room_id'] == $room){
                        $room_name = $row_room['Room_name'];
                        break;
                    }
                }

                foreach ($user1 as $row_user) {
                    if($row_user['UserID'] == $user){
                        $user_name = $row_user['Username'];
                        break;
                    }
                }
                echo "<tr><td>".$room_name."</td><td>".$user_name."</td><td>".date('d-m-Y',strtotime($start))."</td><td>" . date('d-m-Y',strtotime($end)) ."</td></tr>";
                $temp = $temp+1;
            }

        }
    }
}