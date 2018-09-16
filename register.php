<?php

	include_once("connectdb.php");
	if (!$con) {
		die("Connection failed: " . $con->connect_error);
	}


	$username = $_POST["uname"];
	$password = $_POST["psw"];
	$email = $_POST["email"];
	$Gst_first_name = $_POST["fname"];
	$Gst_last_name = $_POST["lname"];
	$Gst_member_since = date("Y-m-d");

	mysqli_select_db($con,"guest");

	$sqll = "SELECT Gst_id FROM guest;";
	$result = $con->query($sqll);
	if($result->num_rows <= 0){
		$Gst_id = 1;
	}
	else{
		$Gst_id = 1 + $result->num_rows;
	}
	$duplicateFlag = false;
	$result = mysqli_query($con,"SELECT * FROM guest");
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($row['Gst_username'] === $username){
				header('Location: index.php?&accountexists=true');
				$duplicateFlag = true;
				break;
			}else{
				$duplicateFlag = false;
			}
		}
	}

	if ($duplicateFlag === false){
		$sql = "INSERT INTO guest (Gst_id, Gst_first_name, Gst_last_name, Gst_member_since, Gst_username, Gst_password, Gst_email) 
		VALUES ($Gst_id, '$Gst_first_name', '$Gst_last_name', '$Gst_member_since','$username', '$password', '$email')";

		if ($con->query($sql) === TRUE) {
	    	echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $con -> error;
		}
		$con->close();
		
		header('Location: index.php?&registered=true');
	}
?>

