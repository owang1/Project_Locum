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
    <title>Choose Account Type</title>
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
<h2> Choose your account type </h1>

    <a href="#" class="btn employ-button">Employer</a>
    <a href="#" class="btn employ-button">Employee</a>

</div>

</body>
</html>
