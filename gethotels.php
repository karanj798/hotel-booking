<!DOCTYPE html>
<html>
<head>
	<title>Index of Hotels</title>
	<script type="text/javascript" src="script.js"></script>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
</head>

<body>
	<div class="nav-bar">
		<a href="index.php"><img src="logo.jpg" alt="logo" id="logo"></a>
	  	<a href="#register" class="options" id="registerUser" onclick="registerUsr()">Register</a>	  	
		<a class="options" id="usrDetails" 
		<?php include_once ("login.php");if (!isset($_SESSION['user'])){echo"href='#sign-in' onclick='signIn()'";} ?>>Sign in</a>
		<a href="#sign-out" class="options" id="signOut" onclick = "signOut()">Sign out </a>
		<a href="index.php" class="options" id="homepage">Home</a>     
	  	
	</div>
	<style type="text/css">
		#signOut{
			display: none;
		}
	</style>
	<div id="login" class="modal">
		<form class="modal-content" method="POST" action="login.php">
			<?php 
			include_once ("login.php");
			if(isset($_SESSION['user'])){
				if (isset($_SESSION['name'])) {
				echo '
				<script type="text/javascript">
				document.getElementById("usrDetails").innerHTML = "' . $_SESSION['name'] .
				'"</script>';
				echo '	<style type="text/css">
						#signOut{
							display: block;
						}
						#registerUser{
							display: none;
						}
						</style>';
				}
			}
			else {
			}
			?>
			<div>
				<span onclick="document.getElementById('login').style.display='none'" class="close" title="Close Modal">×</span>
			</div>
			<div class="container">
      			<label><b>Username</b></label>
		      	<input type="text" placeholder="Enter Username" name="uname" class="format" required>
		      	<br>
		      	<label><b>Password</b></label>
		      	<input type="password" placeholder="Enter Password" name="psw" class="format" required>
		        <br>
		        <span class="noerror" id="errdisplay">* Incorrect Login.<br></span>		        
		      	<button type="submit" class="format">Login</button>
		      	<button type="button" class="format" onclick="document.getElementById('register').style.display='block';">Register</button>
		    </div>
		</form>	
	</div>
	<div id="register" class="modal">
		<form class="modal-content2" method="POST" action="register.php">
			<div>
				<span onclick="document.getElementById('register').style.display='none'" class="close" title="Close Modal">×</span>
			</div>
			<div class="container">
				<label><b>First Name</b></label>
				<input type="text" placeholder="Enter First Name" name="fname" class="format" required>
				<br>
				<label><b>Last Name</b></label>
				<input type="text" placeholder="Enter Last Name" name="lname" class="format" required>
      			<br>
      			<label><b>Username</b></label>
		      	<input type="text" placeholder="Enter Username" name="uname" class="format" required>
		      	<br>
		      	<label><b>Password</b></label>
		      	<input type="password" placeholder="Enter Password" name="psw" class="format" required>
		        <br>
		        <label><b>Email</b></label>
		      	<input type="email" placeholder="Enter Email" name="email" class="format" required>
		        <br>
		      	<button type="submit" class="format">Register</button>
		    </div>
		</form>	
	</div>
<form class="wide">
<table style="text-align: center">
<?php
	include_once("connectdb.php");
	if (!$con) {
		die("Connection failed: " . $con->connect_error);
	}
	$city_id = intval($_GET['city_id']);
	$din = $_GET['din'];
	$dout = $_GET['dout'];
	$today = $_GET['today'];

	mysqli_select_db($con,"hotel");
	$sql = "SELECT * FROM hotel WHERE Htl_city_id =" . $city_id;

	$result = mysqli_query($con,$sql);

	if ($result->num_rows > 0) {
       	// output data of each row
       	
        while($row = $result->fetch_assoc()) {
        	$htl_id = intval($row['Htl_id']); // this is the hotel id.....
        	$newsql = "SELECT * FROM pictures WHERE hotel_id ='" . $htl_id . "'";
        	$newvar = $con -> query ($newsql);
        	$newimgdata = $newvar -> fetch_assoc();
        	echo "<tr> ";
        	echo "<td><img src='data:image/jpeg;base64," . base64_encode($newimgdata['image']) . "'/></td>";
        	echo "<td value=" . $row["Htl_name"] .">" . "<span><b> ". $row['Htl_name'] . "</span>";
        	echo "<br>Rate: " . $row["Htl_Rate"];
        	echo "<br>Address: " . $row["Htl_address"] . $row["Htl_postalCode"] .  "</td>";
        	echo "<td><button type='button' name='view-deal'" . "id='" .  $row['Htl_id'] . "' onclick=\"viewDeal(this.id," . $city_id . ", '" . $din . "', '" . $dout . "', '" . $today . "', " . ")\">View Deal</button> </td>";
        	echo "</tr>";
          }
      } else {
        header('Location: index.php?&hotelfound=false');
      }

mysqli_close($con);
?>

</table>
</form>
	<?php
		$url = parse_url($_SERVER['REQUEST_URI']);
		
		if(isset($url['query'])){
			if((strpos ($url['query'], 'roomfound=false') !== false) || ($url['query'] === 'roomfound=false')){
					echo '<div id="norooms-msg" class="modal" style="display: block">';
			}
			else{
				echo '<div id="norooms-msg" class="modal">';
			}
		}
		else{
			echo '<div id="norooms-msg" class="modal">';
		}
	?>
		<form class="modal-content3">
			<span onclick="document.getElementById('norooms-msg').style.display='none'" class="close" title="Close Modal">×</span>
			There are no rooms in this hotel. 
			Please select a different hotel.

		</form>
	</div>
<?php
		$url = parse_url($_SERVER['REQUEST_URI']);
		
		if(isset($url['query'])){
			if((strpos ($url['query'], 'invalidlogin=true') !== false && !isset($_SESSION['user'])) || ($url['query'] === 'invalidlogin=true' && !isset($_SESSION['user']))){
				echo '<style type="text/css">
						#login{
							display: block;
						}
						#errdisplay{
							display: inline;
							font-size: 18pt;
							font-style: italic;
							color: red;
						}
						</style>';
			}
		}
	?>
	<script type="text/javascript">
		window.onclick = function(event) {
		    if (event.target == document.getElementById("norooms-msg")) {
		        document.getElementById("norooms-msg").style.display = "none";
		    }			
		    if (event.target == document.getElementById("invalidlogin-msg")) {
		    	document.getElementById("invalidlogin-msg").style.display = "none";
		    }
		    if (event.target == document.getElementById("login")) {
                document.getElementById("login").style.display = "none";
            }

		}	
	</script>
</body>
</html>