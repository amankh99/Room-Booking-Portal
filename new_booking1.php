<?php
    $path=$_SERVER['DOCUMENT_ROOT']."/ids/Room-Booking-Portal"; 
    $pageTitle = "Book A Hostel";
    include_once $path."/common/base.php";
    include_once $path.'/common/navbar_w_login.php';
    include_once $path.'/common/header.php';
    include_once $path."/inc/class.users.inc.php";  
    $users = new populate($db);
    // if(isset($_GET['q'])){
    //     $q = intval($_GET['q']);
    //     echo "calling";
    //     echo $users->date($q);
    // }
    if(empty($_SESSION['LoggedIn']) && empty($_SESSION['Username'])):
?>
        <p>You are not <strong>logged in.</strong></p>
<?php
        else :

        $smt = $db->prepare('SELECT * From HostelBookings where User_id="' . $_SESSION["Userid"] . '"');
        $smt->execute();
        $data = $smt->fetchAll();
        if(count($data) > 0) {
            echo "<strong>You've already booked your room.</strong><a href='cancel.php'>Click here</a> to cancel";
            exit;
        }
?>
         <style>
        .dp-highlight .ui-state-default {
            background: #484;
            color: #FFF;
        }
        .ui-datepicker.ui-datepicker-multi {
            width: 100% !important;
        }
        .ui-datepicker-multi .ui-datepicker-group {
            float:none;
        }
        #datepicker {
            height: 300px;
        }
        .ui-widget {
            font-size: 100%
        }
        .selected {
            background: #1795bd !important;
        }
        .classA {
            background-color: red;
        }
        .classB {
            background-color: Green;
        }</style>
        <link href="css/seat_booking.css" rel="stylesheet" type="text/css"/>
<div id="main">
<div id="form-div1">
<h1 style="text-align:center;font-family:Helvetica, Arial, sans-serif;color:white;">Book A Hostel</h1>

<div id="rooms">
    <form action="<?php $a="#"; echo htmlspecialchars($a);?>" method="post">        

    <button type="submit" id="button-blue2" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '1' ? 'selected' : '') ?>" name="hostel" value="1">B1</button>
    <button type="submit" value="2" id="button-blue2" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '2' ? 'selected' : '') ?>" name="hostel">B2</button>
    <button type="submit" value="3" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '3' ? 'selected' : '') ?>" id="button-blue2" name="hostel">B3</button>
    <button type="submit" value="4" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '4' ? 'selected' : '') ?>" id="button-blue2" name="hostel">B4</button>
    <button type="submit" value="5" id="button-blue2" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '5' ? 'selected' : '') ?>" name="hostel">B5</button>
    <button type="submit" value="6" id="button-blue2" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '6' ? 'selected' : '') ?>" name="hostel">B6</button>
    <button type="submit" value="7" id="button-blue2" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '7' ? 'selected' : '') ?>" name="hostel">B7</button><br />
    <button type="submit" value="8" id="button-blue2" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '8' ? 'selected' : '') ?>" name="hostel">G2</button>
    <button type="submit" value="9" id="button-blue2" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '9' ? 'selected' : '') ?>" name="hostel">G3</button>
    <button type="submit" value="10" id="button-blue2" class="<?php echo (isset($_POST['hostel']) && $_POST['hostel'] == '10' ? 'selected' : '') ?>" name="hostel">G4</button><br />
    </form>
    <?php if(isset($_POST['hostel'])){?>
<form id="hostelform" action="<?php $a="booking_submit.php"; echo htmlspecialchars($a);?>" method="post">
    <input type="hidden" id="hostelname" name="hostel" value="<?php echo $_POST['hostel'];?>">
    <div class="plane" id="appender">
  <div class="cockpit">
    <h1>Please select a floor</h1>
  </div>
  <select name="floor" id="floor" class="styled-select">
    <option value="-1">Select the floor</option>
    <?php
        $smt = $db->prepare('SELECT * From HostelBookings where Hostel_Id="'. $_POST['hostel'] .'"');
        $smt->execute();
        $data = $smt->fetchAll();
        // var_dump($d);
        $gr = 0;
        $fr = 0;
        $sc = 0;
        foreach ($data as $row):
            $row['room'][0] == '0' ? $gr += 1 : $gr;
            $row['room'][0] == '1' ? $fr += 1 : $fr;
            $row['room'][0] == '2' ? $sc += 1 : $sc;
        endforeach ;
        $smt = $db->prepare('SELECT * From Hostel where HostelId="'. $_POST['hostel'] .'"');
        $smt->execute();
        $data2 = $smt->fetchAll();
        // var_dump($data);
        if($data2[0]['NumRooms'] > $gr) {
            echo "<option value='0'>0</option>";
        }
        if($data2[0]['NumRooms'] > $fr) {
            echo "<option value='1'>1</option>";
        }
        if($data2[0]['NumRooms'] > $sc) {
            echo "<option value='2'>2</option>";
        }
    ?>
  </select>
<?php }?>
</div>
</form>
</div>
</div>

</div> 
      <script src="./js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript">
    $(document).on('change', 'input[type=checkbox]', function() {
      // alert($(this).attr("id"));
      $('input[type=checkbox]').not(this).prop('checked', false);  
    });

    $("#floor").on("change", function(){
        $.post( "available_seats.php", { hostel: $("#hostelname").val(), floor: $(this).val() })
          .done(function( data ) {
            // alert(data);
            data = JSON.parse(data);
            // alert(data["disabled"]);
            data3 = $.map(data["disabled"], function(value, index) {
                return [value];
            });
            if($("#appended").length) $("#appended").remove();
            // $("#appender").append(data);
            $("#appender").append("<div id='appended'></div>");
            $("#appended").append('<div class="cockpit"><h1>Please select a Room</h1></div>');
            $("#appended").append('<ol style="width: 500px;" id="ol_selector" class="cabin fuselage"></ol>');
            // alert(Object.keys(data));
            $("#appended").append('<div class="submit"><input type="submit" id="button-blue"></div>');
            for($i=1; $i<=data["max"]; ++$i) {
    console.log($i);
    if($i<10){
        if(("disabled" in data) && $.inArray($i, data3) != -1)
        $("#ol_selector").append('\
            <li class="row" >\
                <ol class="seats" type="A">\
                    <li class="seat" style="height:40px;">\
                        <input type="checkbox" disabled id="check_0' + $i + '" value="0' + $i + '" name="room_no"/>\
                        <label for="check_0' + $i + '">0' + $i + '</label>\
                    </li>\
                </ol>\
            </li>\
        ');
        else
        $("#ol_selector").append('\
            <li class="row" >\
                <ol class="seats" type="A">\
                    <li class="seat" style="height:40px;">\
                        <input type="checkbox" id="check_0' + $i + '" value="0' + $i + '" name="room_no"/>\
                        <label for="check_0' + $i + '">0' + $i + '</label>\
                    </li>\
                </ol>\
            </li>\
        ');
    } else {
        if("disabled" in data && $.inArray($i, data3) != -1)
        $("#ol_selector").append('\
            <li class="row" >\
                <ol class="seats" type="A">\
                    <li class="seat" style="height:40px;">\
                        <input type="checkbox" disabled id="check_' + $i + '" value="' + $i + '" name="room_no"/>\
                        <label for="check_' + $i + '">' + $i + '</label>\
                    </li>\
                </ol>\
            </li>\
        ');
        else
        $("#ol_selector").append('\
            <li class="row" >\
                <ol class="seats" type="A">\
                    <li class="seat" style="height:40px;">\
                        <input type="checkbox" id="check_' + $i + '" value="' + $i + '" name="room_no"/>\
                        <label for="check_' + $i + '">' + $i + '</label>\
                    </li>\
                </ol>\
            </li>\
        ');
    }
        }
    });
      });
  </script>
<?php
endif;
include_once $path.'/common/footer.php';?>
