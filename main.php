<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="script.js"></script>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 

</head>
<body>
	<select name="Province" id="select_province" onchange="showCity(this.value)">

	<option value="" disabled selected>Choose Province</option>
	<?php
		include_once("connectdb.php");

		// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $con->connect_error);
		}

		$sql = "SELECT prv_id, prv_name FROM province;";

		$result = $con->query($sql);

		if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
		echo "<option value=". $row["prv_id"].">" . $row['prv_name'] . "</option>";
		}
		} else {
		echo "0 results";
		}

		$con->close();
	?>
	</select>
	<span class="noerror" id="province">This field is required.</span>
	<span id="resultProvinceValue"></span>
</body>
</html>
