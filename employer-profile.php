<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
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
.topnav a {
  float: left;
  color: #4f5d75;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
  margin: 20px;
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
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #4f5d75;
  color: white;
}

.greeting{
    width: 100%;
    display: contents;
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

.employ-button{
  background-color: #E0E0E0;
  margin: 20px;
  width: 400px;
  height: 100px;
  text-align: center;
  line-height: 75px;
  font-size: 25px;
  font-weight: bold;
  box-shadow: 0px 11px 15px -8px #000000;
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
<div class="topnav">
  <h3 class = "project-title"> Locum Project </h3>
  <a href="#contact">Browse Jobs</a>
  <a href="#contact">Messages</a>
  <!-- <a class="active" href="#home">Home</a>
  <a href="#news">About</a> -->
  <h3 class="greeting"> Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b> </h3>
  <a href="logout.php" class="sign-out btn ml-3">Sign Out of Your Account</a>
  <a href="reset-password.php" class="reset btn">Reset Your Password</a>
</div>

  <div class="card">
  <h5 class="card-header">Please fill out your employee profile</h5>
  <div class="card-body">
    <form>
     <label for="fname">First name:</label>
     <input type="text" id="fname" name="fname" required><br>
     <label for="lname">Last name:</label>
     <input type="text" id="lname" name="lname" required><br>
     <label for="phone">Phone number:</label>
     <input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required> <br>
     <label for="hospital">Hospital:</label>
     <input type="text" id="hospital" name="hospital"><br>
     <br><br>
     <label for="address">Address:</label><br>
     <input type="text" id="address" name="adress"><br>
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

   </form>
  </div>
  </div>

</body>
</html>
