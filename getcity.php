<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="script.js"></script>
<link rel="stylesheet" type="text/css" href="main.css">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 


</head>
<body>

<br><br><label> City </label><br>
<select name="city" id="select_city" required="">

<?php

$q = intval($_GET['q']);
'<br>';

include_once("connectdb.php");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"city");
$sql="SELECT * FROM city WHERE Cty_province_id = '" .$q."'";
$result = mysqli_query($con,$sql);


      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              echo "<option value=". $row["Cty_id"].">" . $row['Cty_Name'] . "</option>";
          }
      } else {
          echo "0 results";
      }

mysqli_close($con);

?>



</select>

</body>
</html>




