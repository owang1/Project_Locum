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

.search-group{
    margin: auto;
    width: fit-content;
}
.search-group input{
    width: 500px !important;
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
      <a class="nav-item nav-link" href="../browse-jobs.php/">Browse Jobs <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="#">Messages</a>
      <h5 class="nav-item nav-link greeting"> Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b> </h5>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
      <a class="nav-item nav-link " href="reset-password.php">Reset</a>
    </div>
  </div>
</nav>

<div>
<h2 class="my-5">Browse Candidates</h2>
<form class="form-inline my-lg-0 search-group">
      <input class="form-control" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>
<div class="card-list">
    <div class="card">
    <h5 class="card-header">Resume #1</h5>
    <div class="card-body">
        <h5 class="card-title">John Doe</h5>
        <p class="card-text">A quick summary of interests, experience, etc.</p>
        <a href="#" class="btn btn-primary">View</a>
    </div>
    </div>
    <div class="card">
    <h5 class="card-header">Resume #2</h5>
    <div class="card-body">
        <h5 class="card-title">Jane Doe</h5>
        <p class="card-text">A quick summary of interests, experience, etc.</p>
        <a href="#" class="btn btn-primary">View</a>
    </div>
    </div>
    <div class="card">
    <h5 class="card-header">Resume #3</h5>
    <div class="card-body">
        <h5 class="card-title">John Doe</h5>
        <p class="card-text">A quick summary of interests, experience, etc.</p>
        <a href="#" class="btn btn-primary">View</a>
    </div>
    </div>
    <div class="card">
    <h5 class="card-header">Resume #4</h5>
    <div class="card-body">
        <h5 class="card-title">John Doe</h5>
        <p class="card-text">A quick summary of interests, experience, etc.</p>
        <a href="#" class="btn btn-primary">View</a>
    </div>
    </div>
    <div class="card">
    <h5 class="card-header">Resume #5</h5>
    <div class="card-body">
        <h5 class="card-title">Jane Doe</h5>
        <p class="card-text">A quick summary of interests, experience, etc.</p>
        <a href="#" class="btn btn-primary">View</a>
    </div>
    </div>
</div>
</div>
    
</body>
</html>
