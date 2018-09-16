<!DOCTYPE html>
<html>
<head>
    <title>Index of Rooms</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
    <script type="text/javascript" src="script.js"></script>

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
            if((strpos ($url['query'], 'signedin=false') !== false && !isset($_SESSION['user'])) || ($url['query'] === 'signedin=false' && !isset($_SESSION['user']))){
                echo '<style type="text/css">
                        #login{
                            display: block;
                        }
                        </style>';
                        
            }
            if(strpos ($url['query'], 'signedin=false') || ($url['query'] === 'signedin=false')){
                if (isset($_SESSION['user'])){
                    echo '<div id="info-msg" class="modal" style="display: block">';
                }else{
                    echo '<div id="info-msg" class="modal">';
                }
            }else{
                echo '<div id="info-msg" class="modal">';
            }
        }
        else{
            echo '<div id="info-msg" class="modal">';
        }
    ?>

    <form class="modal-content3">
            <span onclick="document.getElementById('info-msg').style.display='none'" class="close" title="Close Modal">×</span>
            You can now reserve a room.
        </form>
    </div>
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
                echo '  <style type="text/css">
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
                <button type="submit" class="format" id="logbtn">Login</button>
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

      $hotel_id = intval($_GET['hotel_id']); 
      $city_id = intval($_GET['city_id']);
      $strdin = $_GET['din'];
      $strdout = $_GET['dout'];
      $today = $_GET['today'];

      $din = new DateTime($strdin);
      $dout = new DateTime($strdout);
      $dateDiff = $din->diff($dout);
      $numnight = $dateDiff->format('%a');
      if ($numnight == 0){$numnight = 1;}
      $weekendDays = 0;

    if ($strdin == $strdout){        
        $dsf = $din->format('D');
        if (($din->format('D') == "Sat" && $dout->format('D') == "Sat") || ($din->format('D') == "Sun" && $dout->format('D') == "Sun")){
            $weekendDays++;
        }
    }else{
      $period = new DatePeriod($din, new DateInterval('P1D'), $dout);
        foreach($period as $dt) {        
            $curr = $dt->format('D');
            if ($curr == 'Sat' || $curr == 'Sun') {
                $weekendDays++;
            }
        }
    }

    $weekDays = $numnight - $weekendDays;



    mysqli_select_db($con,"room");

    $sql = "SELECT * FROM room WHERE Rm_Hotel_id =" . $hotel_id;

    $result = mysqli_query($con,$sql);
    if ($result->num_rows > 0) {
       	// output data of each row
        $temp = "";
        while($row = $result->fetch_assoc()) {
            if($row['Rm_status'] === "0"){
            	$room_type_id = intval($row['room_type_id']);
            	$newsql = "SELECT * FROM room_type WHERE Typ_id =" . $room_type_id;
            	$newvar = $con -> query ($newsql);
            	$newimgdata = $newvar -> fetch_assoc();
            	echo "<tr>";
            	echo "<td value='rm_number'>" . $row['Rm_name'] . "</td>";
            	echo "<td>";
            	echo $newimgdata['Typ_description'] . " Room<br>";
            	$strSmoke = "No";
            	if($row['Rm_smoke'] == 1){
            		$strSmoke = "Yes";
            	}
            	echo "Smoking: " .$strSmoke;
            	echo "<br>";
            	
            	$strParking = "No";
            	if($row['Rm_free_barking'] == 1){
            		$strParking = "Yes";
            	}
            	echo "Free Parking: " .$strParking;
            	echo "<br>";

             $strInternet = "No";
             if($row['Rm_free_internet'] == 1){
              $strInternet = "Yes";
          }
          echo "Free Internet: " .$strInternet;
          echo "<br>";

          $strBreakfast = "No";
          if($row['Rm_free_breakfast'] == 1){
              $strBreakfast = "Yes";
          }
          echo "Free Breakfast: " .$strBreakfast;

          echo"<br>Number of Beds: " . $row['Rm_number_beds'];
          echo "</td>";
          $totalPrice = $row['Rm_price_weekend'] * $weekendDays + $row['Rm_price'] * $weekDays;                
          echo "<td>" . "Room price: $" . $totalPrice . "<br>" . "Week Days: " . $weekDays . " <br>Weekend Days: " . $weekendDays;
          echo "<br>" . "<button type='button' name='reserve'" . "id='" .  $row['Rm_id'] . "' onclick=\"showUsrMsg(" . "this.id" . ", " . $city_id . ", '" . $strdin . "', '" . $strdout . "', " . $numnight . ", '" . $today . "', " . $hotel_id . ")\">Reserve</button>";
          echo "</td>";
          echo "</tr>";
      }                      
      $temp .= $row['Rm_status'];

  }
    if(strpos($temp, '0') === false){
        header('Location: gethotels.php?&roomfound=false&city_id=' . $city_id . "&din=" . $strdin . "&dout=" . $strdout . "&today=" . $today);
    }

    }         
    else{            
        header('Location: gethotels.php?&roomfound=false&city_id=' . $city_id . "&din=" . $strdin . "&dout=" . $strdout . "&today=" . $today);
    }


    mysqli_close($con);



?>

</table>

</form>

    <script type="text/javascript">
        window.onclick = function(event) {
            if (event.target == document.getElementById("login")) {
                document.getElementById("login").style.display = "none";
            }
            if (event.target == document.getElementById("bookroom-msg")) {
                document.getElementById("bookroom-msg").style.display = "none";   
            }
            if (event.target == document.getElementById("info-msg")) {
                document.getElementById("info-msg").style.display = "none";   
            }                
        }
    </script>
</body>
</html>