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
$specialty = $job_desc = $experience = $salary = $vacation = $call = $date_posted = $duration = $start_date = $supervision = "";

// Set variables from form input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input fields from form
    $specialty = $_POST['specialty'];

    $job_desc = $_POST['jobDescription'];

    $experience = $_POST['experience'];

    $salary = $_POST['salary'];

    $vacation = $_POST['vacation'];

    $call = $_POST['callNoCall'];

    $date_posted = $_POST['datePosted'];

    $duration = $_POST['duration'];

    $start_date = $_POST['startDate'];


    $supervision = $_POST['supervision'];

}

// Insert into job_posts table
$sql = "INSERT INTO job_posts (specialty, job_desc, experience, salary, vacation, call_nocall, date_posted, duration, start_date, supervision, employer_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  mysqli_stmt_bind_param($stmt, "sssssssssss", $param_specialty, $param_job_desc, $param_experience, $param_salary, $param_vacation, $param_call, $param_date_posted, $param_duration, $param_start_date, $param_supervision, $param_email);

  $param_specialty = $specialty;
  $param_job_desc = $job_desc;
  $param_experience = $experience;
  $param_salary = $salary;
  $param_vacation = $vacation;
  $param_call = $call;
  $param_date_posted = $date_posted;
  $param_duration = $duration;
  $param_start_date = $start_date;
  $param_supervision = $supervision;
  $param_email = $_SESSION["email"];

  /* execute query */
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post a Job</title>
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
      <a class="nav-item nav-link" href="../locum_website/browse-resumes.php/">Browse Resumes <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/messages.php/">Messages</a>
      <h3 class="nav-item nav-link greeting"> Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b> </h3>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/notifications.php">Notifications</a>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/logout.php">Logout</a>
      <a class="nav-item nav-link " href="http://db.cse.nd.edu/cse30246/locum/locum_website/reset-password.php">Reset</a>
    </div>
  </div>
</nav>

  <div class="card">
  <h5 class="card-header">Post a job</h5>
  <div class="card-body">
    <form action="" method="post">
     <label for="specialty">Specialty:</label>
     <input type="text" id="spec" name="specialty"><br>

     <label for="experience">Experience:</label>
     <input type="text" id="exp" name="experience"><br>

     <label for="salary">Salary (yearly):</label>
     <input type="number" id="sal" name="salary" min="0" step="1000" required><br>

     <label for="vacation">Vacation:</label>
     <input type="text" id="vac" name="vacation"><br>

     <label for="supervision">Supervision:</label>
     <input type="text" id="supervis" name="supervision"><br>

     <label for="callNoCall">Call or No Call:</label>
     <select name="callNoCall" id="call_no_call">
       <option value="Call">Call</option>
       <option value="NoCall">NoCall</option>
     </select><br>

     <label for="duration">Duration:</label>
     <select name="duration" id="dur">
       <option value="Full Time">Full Time</option>
       <option value="Locum">Locum</option>
       <option value="Part Time">Part Time</option>
     </select><br>

     <label for="datePosted">Date Posted:</label>
     <input type="date" id="date_posted" name="datePosted"
       value="2021-05-06"
       min="2021-05-06" max="2025-12-31"><br>

     <label for="startDate">Start Date:</label>
     <input type="date" id="start_date" name="startDate"
       value="2021-05-06"
       min="1910-01-01" max="2025-12-31"><br>

     <label for="jobDescription">Job Description:</label><br>
     <textarea id="job_desc" name="jobDescription" cols="50" rows="10" placeholder="Describe the job in max 250 characters"></textarea>
     <br><br>
     <input type="submit" class="btn btn-primary" value="Post Job"><br>

   </form>
  </div>
  </div>

</body>
</html>
