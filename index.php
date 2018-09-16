<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<script type="text/javascript" src="script.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
</head>
<body>
	<div class="nav-bar">
		<a href="index.php"><img src="logo.jpg" alt="logo" id="logo"></a>
	  	<a href="#register" class="options" id="registerUser" onclick="registerUsr()">Register</a>	  	
		<a class="options" id="usrDetails" 
		<?php include_once ("login.php");if (!isset($_SESSION['user'])){echo"href='#sign-in' onclick='signIn()'";}?>>Sign in</a>
		<a href="#sign-out" class="options" id="signOut" onclick = "signOut()">Sign out </a>	  		  	
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

	<?php
	$url = parse_url($_SERVER['REQUEST_URI']);
	
	if(isset($url['query'])){
		if(($url['query'] === "registered=true" && !isset($_SESSION['user'])) || (strpos($url['query'], "registered=true") && !isset($_SESSION['user']))){	
			echo '<div id="conf-msg" class="modal" style="display: block">';
		}
		else{
			echo '<div id="conf-msg" class="modal">';
		}		
	}
	else{
		echo '<div id="conf-msg" class="modal">';
	}	
	?>
		<form class="modal-content3">
			<span onclick="document.getElementById('conf-msg').style.display='none'" class="close" title="Close Modal">×</span>
			Your Account has been created.
		</form>	
	</div>

	<?php
	$url = parse_url($_SERVER['REQUEST_URI']);
	
	if(isset($url['query'])){
		if(($url['query'] === "noaccounts=true" && !isset($_SESSION['user'])) || (strpos($url['query'], "noaccounts=true") && !isset($_SESSION['user'])) ){	
			echo '<div id="noaccounts-msg" class="modal" style="display: block">';
		}
		else{
			echo '<div id="noaccounts-msg" class="modal">';
		}			
	}
	else{
		echo '<div id="noaccounts-msg" class="modal">';
	}	
	?>
		<form class="modal-content3">
			<span onclick="document.getElementById('noaccounts-msg').style.display='none'" class="close" title="Close Modal">×</span>
			No accounts are registered in the database.
			Please register for an account.			
		</form>	
	</div>

	<form method="GET" autocomplete="off">
		<label>Province: </label> <br>
		<!-- Opening main php file to display the list of province & cities -->
		<?php 
			include "main.php";
		?>
		<br>
		<br>
		<label>Check in: </label><br>
		<input type="date" name="cal1" required="" id="check-in">
		<span class="noerror" id="check-in-s">This field is required</span>
		<br><br>

		<label>Check out: </label><br>
		<input type="date" name="cal2" id="check-out">
		<span class="noerror" id="check-out-s">This field is required</span>
		<br><br>

		<script type="text/javascript">
				/* Setting Min Date */
				var today = new Date ();
				var date = today.getDate().toString();
				var month = (today.getMonth()+1).toString();
				var year = today.getFullYear().toString();
				if (date.length < 2){
					date = "0" + date;
				}
				if(month.length < 2){
					month = "0" + month;
				}
				today = year + "-" + month + "-" + date;
				document.getElementById("check-in").setAttribute("min", today);
				document.getElementById("check-out").setAttribute("min",today);			
		</script>

		<label>Adults: </label>
		 <select id="adults">
		 	<option>1</option>
		 	<option>2</option>
		 	<option>3</option>
		 	<option>4</option>
		 	<option>5</option>
		 </select>	
		<span class="noerror" id="adultss">This field is required</span>
	<br><br>
		<label>Children: </label>
		 <select id="children">
		 	<option>0</option>
		 	<option>1</option>
		 	<option>2</option>
		 	<option>3</option>
		 	<option>4</option>
		 	<option>5</option>
		 </select>
		 <br><br>
		 
		 <button type="button" name="search" onclick="getUsrSelectedCity()" class="right-flow">Search</button>
	</form>	

	<?php
		$url = parse_url($_SERVER['REQUEST_URI']);
		
		if(isset($url['query'])){
			if(strpos ($url['query'], 'hotelfound=false') !== false || $url['query'] === 'hotelfound=false'){
				echo '<div id="nohotels-msg" class="modal" style="display: block">';
			}
			else{
				echo '<div id="nohotels-msg" class="modal">';
			}
		}
		else{
			echo '<div id="nohotels-msg" class="modal">';
		}
	?>
		<form class="modal-content3">
			<span onclick="document.getElementById('nohotels-msg').style.display='none'" class="close" title="Close Modal">×</span>
			There are no hotels in this city. 
			Please select a different city.						
		</form>
	</div>

	<?php
		$url = parse_url($_SERVER['REQUEST_URI']);
		
		if(isset($url['query'])){
			if(strpos ($url['query'], 'nocities=true') !== false || $url['query'] === 'nocities=true'){
				echo '<div id="nocities-msg" class="modal" style="display: block">';
			}
			else{
				echo '<div id="nocities-msg" class="modal">';
			}
		}
		else{
			echo '<div id="nocities-msg" class="modal">';
		}
	?>
	<form class="modal-content4">
			<span onclick="document.getElementById('nocities-msg').style.display='none'" class="close" title="Close Modal">×</span>
			There are no cities in this province. 
			Please select a different province.					
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

<?php
	$url = parse_url($_SERVER['REQUEST_URI']);
	
	if(isset($url['query'])){
		if(strpos($url['query'], "roombooked=true") || $url['query'] === "roombooked=true"){	
			echo '<div id="roombooked-msg" class="modal" style="display: block">';
		}
		else{
			echo '<div id="roombooked-msg" class="modal">';
		}			
	}
	else{
		echo '<div id="roombooked-msg" class="modal">';
	}	
	?>
		<form class="modal-content3">
			<span onclick="location.href = 'index.php'" class="close" title="Close Modal">×</span>
			Your room been has been booked. 
		</form>	
	</div>

<?php
	$url = parse_url($_SERVER['REQUEST_URI']);
	
	if(isset($url['query'])){
		if((strpos($url['query'], "accountexists=true") && !isset($_SESSION['user'])) || ($url['query'] === "accountexists=true" && !isset($_SESSION['user']))){	
			echo '<div id="accountexists-msg" class="modal" style="display: block">';
		}
		else{
			echo '<div id="accountexists-msg" class="modal">';
		}			
	}
	else{
		echo '<div id="accountexists-msg" class="modal">';
	}	
	?>
		<form class="modal-content3">
			<span onclick="document.getElementById('accountexists-msg').style.display='none'" class="close" title="Close Modal">×</span>
			Duplicate entry of account found! <br>
			Please choose a unique username. 
		</form>	
	</div>

	<script type="text/javascript">

		window.onclick = function(event) {
		    if (event.target == document.getElementById("nocities-msg")) {
		    	document.getElementById("nocities-msg").style.display = "none";
		    }
		    if(event.target == document.getElementById("nohotels-msg")){
		    	document.getElementById("nohotels-msg").style.display = "none";
		    }
			if(event.target == document.getElementById("noaccounts-msg")){
				document.getElementById("noaccounts-msg").style.display = "none";				
			}
			if(event.target == document.getElementById("conf-msg")){
				document.getElementById("conf-msg").style.display = "none";
			}
			if (event.target == document.getElementById("login")) {
		    	document.getElementById("login").style.display = "none";
		    }
		    if (event.target == document.getElementById("roombooked-msg")) {
				location.href = 'index.php';
			}
			if (event.target == document.getElementById("accountexists-msg")) {
				document.getElementById("accountexists-msg").style.display = "none";
			}
		}
  
	</script>
</body>
</html>