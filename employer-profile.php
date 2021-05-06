<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";
$name = $phonenumber = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $phonenumber = $_POST['phone'];
  if (empty($phonenumber)) {
      echo "Phone number is empty";
  }else if(strlen($phonenumber)!=10 || !(is_numeric($phonenumber))){
     echo "Enter 10 digit phone number";
  }
  else {
      echo "Phone number is";
      echo $phonenumber;
  }

  $hospital_name = $_POST['hospital'];
  if (empty($hospital_name)) {
      echo "Name is empty";
  } else {
      echo $hospital_name;
  }

  $hospital_addr = $_POST['address'];
  if (empty($hospital_addr)) {
      echo "Address is empty";
  } else {
      echo $hospital_addr;
  }

  $hospital_city = $_POST['city'];
  if (empty($hospital_city)) {
      echo "City is empty";
  } else {
      echo $hospital_city;
  }

  $hospital_state = $_POST['state'];
  if (empty($hospital_state)) {
      echo "State is empty";
  } else {
      echo $hospital_state;
  }

  $hospital_zip = $_POST['zip'];
  if (empty($hospital_zip)) {
      echo "Zip is empty";
  } else {
      echo $hospital_zip;
  }
}

// Update people table with entered phone number
$sql = "UPDATE people SET phone_number = ? where email = ?";

if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  mysqli_stmt_bind_param($stmt, "ss", $param_phone, $param_email);
  $param_phone = $phonenumber;
  $param_email = $_SESSION["email"];
  echo "updating people with phone number";

  /* execute query */
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

$temp_hosp_id = -1;

// Insert to hospital table, update on duplicate value
// Note: hosp_id autoincrements
$sql = "INSERT INTO hospital (hosp_name, hosp_address, hosp_city, hosp_state, hosp_zipcode) VALUES( ?, ?, ?, ?, ? ) ON DUPLICATE KEY UPDATE hosp_name=VALUES(hosp_name), hosp_address=VALUES(hosp_address),  hosp_city=VALUES(hosp_city),  hosp_state=VALUES(hosp_state),  hosp_zipcode=VALUES(hosp_zipcode)";

if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  mysqli_stmt_bind_param($stmt, "sssss", $param_hosp_name, $param_hosp_addr, $param_hosp_city, $param_hosp_state, $param_hosp_zip);
  $param_hosp_name = $hospital_name;
  $param_hosp_addr = $hospital_addr;
  $param_hosp_city = $hospital_city;
  $param_hosp_state = $hospital_state;
  $param_hosp_zip = $hospital_zip;
  echo "updating hospital table";

  /* execute query */
  mysqli_stmt_execute($stmt);

  // Save the autoincremented id to insert into employers later
  $temp_hosp_id = mysqli_insert_id($link);

  mysqli_stmt_close($stmt);
}

if($temp_hosp_id != -1){
  // Update employers table with hosp_id
  $sql = "UPDATE employers SET hosp_id = ? where email = ?";
  if($stmt = mysqli_prepare($link, $sql)){
    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "ss", $param_hosp_id, $param_email);
    $param_hosp_id = $temp_hosp_id;
    $param_email = $_SESSION["email"];
    echo "updating employers with hosp_id";

    /* execute query */
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
}
// Close connection
mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fill Employer Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .topnav {
  background-color: #C7DBFF;
  overflow: hidden;
  padding: 15px;
}

/* Style the links inside the navigation bar */
.topnav .nav-link {
  float: left;
  color: #4f5d75;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
  margin: 20px;
}

.navbar-brand{
    margin: 0px;
    font-size: x-large;
    margin-top: -70px;
    position: absolute;
    height: fit-content;
}

/* .nav-link {
    padding-right: 4rem !important;
    padding-left: 4rem !important;
} */

.navbar{
    box-shadow: 0px 3px 7px -5px #000000;
}

.navbar-nav{
    justify-content: space-evenly;
    width: 100%;
    margin-left: -55px;
}

.btn{
    background-color: #4f5d75;
}

.sign-out{
    float: right !important;
    height: 48px;
    background-color: #4f5d75;
    color: white !important;
    cursor: pointer;
}

.project-title{
    float: left;
    margin: 20px;
}

.reset{
    float: right !important;
    height: 48px;
    background-color: #4f5d75;
    color: white !important;
    cursor: pointer
}

/* Change the color of links on hover */
.topnav .nav-link:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.topnav .nav-link.active {
  background-color: #4f5d75;
  color: white;
}

.greeting{
    height: fit-content;
    margin-top: 23px;
}

.card{
    margin: 20px;
    width: 650px;
    text-align: left;
}

.card-list{
    margin: auto;
    height: 90vh;
    overflow: scroll;
    width: fit-content;
}

.circle{
    border: 1px solid #aaa;
    box-shadow: inset 1px 1px 3px #fff;
    width: 30px;
    height: 30px;
    border-radius: 100%;
    position: relative;
    margin: 4px;
    margin-left: 500px;
    display: inline-block;
    vertical-align: middle;
    background: #aaaaaa4f;
}
.circle:hover{
    background: #6363634f;
}
.circle:active{
    background: radial-gradient(#aaa, #fff);
}
.circle:before,
.circle:after{
    content:'';position:absolute;top:0;left:0;right:0;bottom:0;
}
/* PLUS */
.circle.plus:before,
.circle.plus:after {
    background:#4f5d75;
    box-shadow: 1px 1px 1px #ffffff9e;
}
.circle.plus:before{
    width: 2px;
    margin: 3px auto;
}
.circle.plus:after{
    margin: auto 3px;
    height: 2px;
    box-shadow: none;
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg  topnav">
  <a class="navbar-brand" href="#">Locum</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="../locum_website/browse-resumes.php/">Browse Resumes <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="#">Messages</a>
      <h3 class="nav-item nav-link greeting"> Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b> </h3>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
      <a class="nav-item nav-link " href="reset-password.php">Reset</a>
    </div>
  </div>
</nav>

  <div class="card">
  <h5 class="card-header">Please fill out your employer profile</h5>
  <div class="card-body">
    <form action="" method="post">
     <label for="phone">Phone number:</label>
     <input type="text" id="phone_number" name="phone" placeholder="1112223333" required> <br><br>
     <strong> Please fill out your Hospital Information </strong> <br>
     <label for="hospital">Hospital:</label><br>
     <input type="text" id="hosp" name="hospital"><br>
     <label for="address">Address:</label><br>
     <input type="text" id="addr" name="address"><br>
     <label for="city">City:</label><br>
     <input type="text" id="city" name="city"><br>
     <label for="state">State:</label><br>
     <select id="state" name="state">
      	<option value="AL">Alabama</option>
      	<option value="AK">Alaska</option>
      	<option value="AZ">Arizona</option>
      	<option value="AR">Arkansas</option>
      	<option value="CA">California</option>
      	<option value="CO">Colorado</option>
      	<option value="CT">Connecticut</option>
      	<option value="DE">Delaware</option>
      	<option value="DC">District Of Columbia</option>
      	<option value="FL">Florida</option>
      	<option value="GA">Georgia</option>
      	<option value="HI">Hawaii</option>
      	<option value="ID">Idaho</option>
      	<option value="IL">Illinois</option>
      	<option value="IN">Indiana</option>
      	<option value="IA">Iowa</option>
      	<option value="KS">Kansas</option>
      	<option value="KY">Kentucky</option>
      	<option value="LA">Louisiana</option>
      	<option value="ME">Maine</option>
      	<option value="MD">Maryland</option>
      	<option value="MA">Massachusetts</option>
      	<option value="MI">Michigan</option>
      	<option value="MN">Minnesota</option>
      	<option value="MS">Mississippi</option>
      	<option value="MO">Missouri</option>
      	<option value="MT">Montana</option>
      	<option value="NE">Nebraska</option>
      	<option value="NV">Nevada</option>
      	<option value="NH">New Hampshire</option>
      	<option value="NJ">New Jersey</option>
      	<option value="NM">New Mexico</option>
      	<option value="NY">New York</option>
      	<option value="NC">North Carolina</option>
      	<option value="ND">North Dakota</option>
      	<option value="OH">Ohio</option>
      	<option value="OK">Oklahoma</option>
      	<option value="OR">Oregon</option>
      	<option value="PA">Pennsylvania</option>
      	<option value="RI">Rhode Island</option>
      	<option value="SC">South Carolina</option>
      	<option value="SD">South Dakota</option>
      	<option value="TN">Tennessee</option>
      	<option value="TX">Texas</option>
      	<option value="UT">Utah</option>
      	<option value="VT">Vermont</option>
      	<option value="VA">Virginia</option>
      	<option value="WA">Washington</option>
      	<option value="WV">West Virginia</option>
      	<option value="WI">Wisconsin</option>
      	<option value="WY">Wyoming</option>
     </select><br>
     <label for="zip">Zip code:</label><br>
     <input type="text" id="zip" name="zip" placeholder = "46556"><br>
     <br>
     <input type="submit" class="btn btn-primary" value="Submit"><br>
     <button class="circle plus"></button>
     <a href="post-job.php">Post a Job </a>

   </form>
  </div>
  </div>

</body>
</html>
