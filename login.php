<?php
session_start();
	include_once("connectdb.php");
	if (!$con) {
		die("Connection failed: " . $con->connect_error);
	}
	if(isset($_POST["uname"])){
		$username = $_POST["uname"];
		$password = $_POST["psw"];
	

	mysqli_select_db($con,"guest");
	$sql="SELECT * FROM guest WHERE Gst_username= '" . $username . "' AND Gst_password='" . $password . "'";
	$result = mysqli_query($con, $sql);

	$row = $result -> fetch_assoc() ;

	$url = parse_url ($_SERVER['REQUEST_URI']);

	if (mysqli_num_rows($result) > 0){
		$_SESSION['user'] = $username;
		$_SESSION['name'] = $row ['Gst_first_name'] . " " . $row ['Gst_last_name'];
		$_SESSION['madeby'] = $row ['Gst_first_name'] . " " . $row ['Gst_last_name'];
		$_SESSION['uid'] = intval($row['Gst_id']);
		
		header ("Location: " . $_SERVER['HTTP_REFERER']); // Redirect the user to the page they were on. 
	}else{
		header ("Location: " . $_SERVER['HTTP_REFERER'] . "?&invalidlogin=true");
	}


	
	$con->close();
}
?>