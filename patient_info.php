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
    <title>Welcome</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="mystyle.module.css">
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
.full-job-info{
  height: fit-content;
  margin: auto;
  margin-top: 20px;
  background-color: #f7f7f7;
  padding: 20px;
}
.upload_cv{
    margin: 30px;
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg  topnav">
  <a class="navbar-brand" href="http://db.cse.nd.edu/cse30246/locum/locum_website/welcome.php">Locum</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/browse-resumes.php/">Browse Resumes <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="#">Messages</a>
      <h3 class="nav-item nav-link greeting"> Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b> </h3>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/notifications.php">Notifications</a>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/logout.php">Logout</a>
      <a class="nav-item nav-link " href="http://db.cse.nd.edu/cse30246/locum/locum_website/reset-password.php">Reset</a>
    </div>
  </div>
</nav>

<div class="card full-job-info">
<h5 for="jobname">Job name:</h5>
     <p> Lorem ipsum . </p><br><hr>
     <h5 for="qualifications">Qualifications:</h5>
     <p> incididunt ut labore et dolore magna aliqua. </p><hr>
    <h5 for="hospital">Hospital:</h5>
    <p>labore et dolore magna aliqua.</p><br><hr>
     <h5 for="deadline">Deadline:</h5>
     <p>dolore magna aliqua. </p><br><hr>
     <h5 for="salary-min">Minimum salary (yearly):</h5>
     <p> aliqua. </p><br><hr>
     <h5 for="salary-max">Maximum salary (yearly):</h5>
     <p> aliqua. </p><br><hr>
     <h5 for="timeframe">Time frame:</h5>
     <p>dolore magna aliqua.</p><br><hr>
     <h5 for="job-description">Job Description:</h5><br>
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
</div>
<div class="upload_cv">
<form action="/action_page.php">
<label for="myFile">Upload CV:</label>
  <input type="file" id="myFile" name="filename">
  <input type="submit">
</form>
</div>


</body>
</html>
