<?php
include_once("connectdb.php");
if (!$con) {
	die("Connection failed: " . $con->connect_error);
}
$Bok_date_in = $_GET ['din'];
$Bok_date_out = $_GET ['dout'];
$Bok_number_of_nights = intval($_GET['numnight']);
$Bok_Booking_date = $_GET['today'];	
$Bok_room_id = intval($_GET['room_id']);
$city_id = intval($_GET['city_id']);
$hotel_id = intval($_GET['hotel_id']);

include_once ("login.php");

if (isset($_SESSION['user'])){	
	$Bok_made_by = $_SESSION['madeby'];
	$Bok_guest_id = $_SESSION['uid'];
	$Bok_id = $_SESSION['uid'];

	mysqli_select_db($con, "booking");
	$sqll = "SELECT Bok_id FROM booking;"; 
	$result = $con->query($sqll);
	if($result->num_rows <= 0){
		$Bok_id = 1;
	}
	else{
		$Bok_id = 1 + $result->num_rows;
	}

	$sql = "INSERT INTO booking (Bok_id, Bok_date_in, Bok_date_out, Bok_made_by, Bok_guest_id, Bok_number_of_nights, Bok_Booking_date, Bok_room_id) VALUES ($Bok_id, '$Bok_date_in', '$Bok_date_out', '$Bok_made_by', $Bok_guest_id, $Bok_number_of_nights, '$Bok_Booking_date', $Bok_room_id)";
	if ($con->query($sql) === TRUE) {
		echo "New record created successfully";
		header ("Location: setstatus.php?roomid=" . $Bok_room_id);
	} else {
		echo "Error: " . $sql . "<br>" . $con -> error;
	}
}else {
	header ("Location: " . $_SERVER['HTTP_REFERER'] . "&signedin=false");
	if (isset($_SESSION['user'])){header ("Location: " . $_SERVER['HTTP_REFERER']);}
	//header('Location: getrooms.php?signed=false&din=' . $Bok_date_in . "&dout=" . $Bok_date_out . "&numnight=" . $Bok_number_of_nights . "&today=" . $Bok_Booking_date . "&hotel_id=" . $hotel_id . "&city_id=" . $city_id);
}

$con->close();
?>