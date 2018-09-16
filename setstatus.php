<?php
	include_once("connectdb.php");
	if (!$con) {
		die("Connection failed: " . $con->connect_error);
	}
	$Bok_room_id = intval($_GET['roomid']);
	$sql = "UPDATE room SET Rm_status='1' WHERE Rm_id=" . $Bok_room_id;
	if ($con->query($sql) === TRUE) {
    	header("Location: index.php?roombooked=true");
	} else {
	    echo "Error: " . $sql . "<br>" . $con -> error;
	}
?>