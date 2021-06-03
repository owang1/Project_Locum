<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";
$clicked_name = $_SESSION['clicked_name'];
$sql = "SELECT * FROM cv where cv.email = ?";

// $result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_error());

if($stmt = mysqli_prepare($link, $sql)){
    /* bind parameters for markers */
    $param_input = $_SESSION["clicked_email"];
    $var = mysqli_stmt_bind_param($stmt, "s", $param_input);

    /* execute query */
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
}


if (isset($_POST["btn"])){


  $sql = "UPDATE applied_to set job_match = 1 where job_id = ? and employee_email = ?";

    if($stmt = mysqli_prepare($link, $sql)){
      /* bind parameters for markers */
      mysqli_stmt_bind_param($stmt, "ss", $param_job_id, $param_employee);

      $param_job_id = $_SESSION["clicked_job_id"];
      $param_employee = $_SESSION["clicked_email"];
      /* execute query */
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }



$sql = "INSERT INTO chat (employer, employee) VALUES (?, ?)";

  if($stmt = mysqli_prepare($link, $sql)){
    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "ss", $param_employer, $param_employee);
    $param_employer = $_SESSION["email"];
    $param_employee = $_SESSION["clicked_email"];
    /* execute query */
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

  }
  echo "<script>alert('Match Request Sent! We will let you know if the candidate is interested.'); window.location.href=' http://db.cse.nd.edu/cse30246/locum/locum_website/browse-resumes.php/';</script>";

}
mysqli_close($link);


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

.apply-button{
  appearance: button;
  background-color: #4f5d75;
  cursor: pointer;
  color: white;
  height: 40px;
  width: 100px;
  padding-top: 10px;
}

.apply-button:hover{
  appearance: button;
  background-color: #4f5d87;
  cursor: pointer;
  color: white;
  height: 40px;
  width: 100px;
  padding-top: 10px;
}
    </style>

  <script>


  </script>
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
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/messages.php/">Messages</a>
      <h3 class="nav-item nav-link greeting"> Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b> </h3>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/logout.php">Logout</a>
      <a class="nav-item nav-link " href="http://db.cse.nd.edu/cse30246/locum/locum_website/reset-password.php">Reset</a>
    </div>
  </div>
</nav>


<div class="card full-job-info">
  <?php while($row = mysqli_fetch_array($result)) {

      echo "
      <h5 for='jobname'>Name:</h5>
      <p>   $clicked_name </p><br><hr>
      <h5>Education:</h5>
      <p> $row[education]</p><hr>
      <h5>Education School:</h5>
      <p>$row[education_date] </p><br><hr>
      <h5>Education Date:</h5>
      <h5>Salary (yearly):</h5>
      <p> $row[cert] </p><br><hr>
      <h5>Time frame:</h5>
      <p>$row[cert_expr_date]</p><br><hr>
      <h5>Job Description:</h5><br>
      <p> $row[life_support_card]</p>";
  } ?>

</div>

<div class="upload_cv">
<form action=""  method="post">
    <input type="submit" class="btn apply-button" name="btn" value="match">
</form>
</div>


</body>
</html>
