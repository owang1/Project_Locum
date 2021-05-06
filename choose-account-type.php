<?php
// Initialize the session
session_start();

require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$account_type = "";
echo $_SESSION["email"];
if (isset($_POST["btn"])){
  echo "account type = ";

  $account_type = $_POST['btn'];
  echo $account_type;
}else{
  echo "account type not set";
}

if($account_type == "employer"){
  // Add entry to employer table
  $sql = "INSERT INTO employers (email) VALUES (?)";
  if($stmt = mysqli_prepare($link, $sql)){

  /* bind parameters for markers */
  mysqli_stmt_bind_param($stmt, "s", $_SESSION["email"]);

  /* execute query */
  mysqli_stmt_execute($stmt);
  if(mysqli_stmt_execute($stmt)){
      // Redirect to employer-profile page to fill out form
      header("location: employer-profile.php");
  } else{
      echo "Oops! Something went wrong. Please try again later.";
      header("location: employer-profile.php");

  }
  /* close statement */
  mysqli_stmt_close($stmt);
  }
mysqli_close($link);
}

else if($account_type == "employee"){
  // Add entry to employee table
  $sql = "INSERT INTO employees (email) VALUES (?)";
  if($stmt = mysqli_prepare($link, $sql)){

  /* bind parameters for markers */
  mysqli_stmt_bind_param($stmt, "s", $_SESSION["email"]);

  /* execute query */
  mysqli_stmt_execute($stmt);
  /*
  if(mysqli_stmt_execute($stmt)){
      // Redirect to employee-profile page to fill out form
      header("location: employee-profile.php");
  } else{
      echo "Oops! Something went wrong. Please try again later.";
      header("location: employee-profile.php");

  }*/
  /* close statement */
  mysqli_stmt_close($stmt);
  }

  // Also create a new entry in cv table
  $sql = "INSERT INTO cv (email) VALUES (?)";
  if($stmt = mysqli_prepare($link, $sql)){

  /* bind parameters for markers */
  mysqli_stmt_bind_param($stmt, "s", $_SESSION["email"]);

  /* execute query */
  //mysqli_stmt_execute($stmt);
  if(mysqli_stmt_execute($stmt)){
      // Redirect to employee-profile page to fill out form
      header("location: employee-profile.php");
  } else{
      echo "Oops! Something went wrong. Please try again later.";
      header("location: employee-profile.php");

  }
  /* close statement */
  mysqli_stmt_close($stmt);
  }

  mysqli_close($link);

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
<h2> Choose your account type </h1>
<form action=""  method="post">
    <input type="submit" class="btn employ-button" name="btn" value="employer">
    <input type="submit" class="btn employ-button" name="btn" value="employee">
</form>
</div>

</body>
</html>
