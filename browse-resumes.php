<?php
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$isEmpty = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_input = $_POST['search'];
    if (empty($search_input)) {
    } else {
        $isEmpty = false;
    }

}
if($isEmpty == true){
    $sql = "SELECT employees.name, employees.email, cv.education, cv.cert, cv.education_school, job_id FROM employees, cv, (select employee_email, job_posts.job_id from job_posts, applied_to, employers where employers.email = job_posts.employer_email and job_posts.job_id = applied_to.job_id and employer_email = ? and job_match = 0) A where employees.email = A.employee_email and employees.email = cv.email";
    if($stmt = mysqli_prepare($link, $sql)){
        /* bind parameters for markers */
        $param_email = $_SESSION["email"];
        $var = mysqli_stmt_bind_param($stmt, "s", $param_email);

        /* execute query */
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
    }
}
else{
  $sql = "SELECT employees.name, employees.email, cv.education, cv.cert, cv.education_school, job_id FROM employees, cv, (select employee_email, job_posts.job_id from job_posts, applied_to, employers where employers.email = job_posts.employer_email and job_posts.job_id = applied_to.job_id and employer_email = ? and job_match = 0) A where employees.email = A.employee_email and employees.email = cv.email and employees.name = ?";
  if($stmt = mysqli_prepare($link, $sql)){
      /* bind parameters for markers */
      $param_input = $search_input;
      $param_email = $_SESSION["email"];

      //echo $param_email;
      $var = mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_input);

      /* execute query */
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
  }
}

if (isset($_POST["view"])){
  $full_string = $_POST["view"];


  $array = preg_split("/,/", $full_string);

  $job_id_clicked = $array[0];
  $email_clicked = $array[1];
  $name_clicked = $array[2];

    $_SESSION["clicked_email"] = $email_clicked;
    $_SESSION["clicked_job_id"] = $job_id_clicked;
    $_SESSION["clicked_name"] = $name_clicked;

    header("location: http://db.cse.nd.edu/cse30246/locum/locum_website/view_candidate.php/");

  }

mysqli_stmt_close($stmt);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Resumes</title>
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
    color: lightblue;
    border: none;
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
.search-button:hover{
    background-color: #4f5d75 !important;
    color: lightblue;
    border: none;
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
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/messages.php/">Messages</a>
      <h5 class="nav-item nav-link greeting"> Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b> </h5>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/notifications.php">Notifications</a>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/logout.php">Logout</a>
      <a class="nav-item nav-link " href="http://db.cse.nd.edu/cse30246/locum/locum_website/reset-password.php">Reset</a>
    </div>
  </div>
</nav>

<div>
<h2 class="my-5">Browse Candidates</h2>
<form class="form-inline my-lg-0 search-group" action="" method="post">
      <input class="form-control" id="searchbar" type="text"
        name="search" placeholder="Search candidates..">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>
<div class="card-list">
<form action='#'  method='post'>
    <?php while($row = mysqli_fetch_array($result)) {
        echo "<div class='card'>
        <h5 class='card-header'>$row[name]</h5>
        <div class='card-body'>
            <h5 class='card-title'>$row[education]</h5>
            <p class='card-text'>$row[education_school]</p>
            <button name='view' value = $row[job_id],$row[email],$row[name] class='btn btn-primary'>View</button>
        </div>
        </div>";
    } ?>
</form>
</div>
</div>

</body>
</html>
