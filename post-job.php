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
//$specialty = $location = $job_desc = $experience = $salary = $education_benefits = $vacation = $in_out_patient = $date_posted = "";
$specialty = $location = $job_desc = $experience = $salary = $education_benefits = $vacation = $in_out_patient = $call = $date_posted = $duration = $start_date = $shifts = $supervision = "";

// Set variables from form input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input fields from form
    $specialty = $_POST['specialty'];
    if (empty($specialty)) {
        echo "Specialty is empty";
    } else {
        echo $specialty;
    }

    $location = $_POST['location'];
    if (empty($location)) {
        echo "Location is empty";
    } else {
        echo $location;
    }

    $job_desc = $_POST['jobDescription'];
    if (empty($job_desc)) {
        echo "Job Description is empty";
    } else {
        echo $job_desc;
    }

    $experience = $_POST['experience'];
    if (empty($experience)) {
        echo "Experience is empty";
    } else {
        echo $experience;
    }

    $salary = $_POST['salary'];
    if (empty($salary)) {
        echo "Salary is empty";
    } else {
        echo $salary;
    }

    $education_benefits = $_POST['educationBenefits'];
    if (empty($education_benefits)) {
        echo "Education benefits is empty";
    } else {
        echo $education_benefits;
    }

    $vacation = $_POST['vacation'];
    if (empty($vacation)) {
        echo "Vacation  is empty";
    } else {
        echo $vacation;
    }

    $in_out_patient = $_POST['inOutPatient'];
    if (empty($in_out_patient)) {
        echo "In/out patient is empty";
    } else {
        echo $in_out_patient;
    }

    $call = $_POST['callNoCall'];
    if (empty($call)) {
        echo "Call/nocall is empty";
    } else {
        echo $call;
    }

    $date_posted = $_POST['datePosted'];
    if (empty($date_posted)) {
        echo "Date posted is empty";
    } else {
        echo $date_posted;
    }

    $duration = $_POST['duration'];
    if (empty($duration)) {
        echo "Duration is empty";
    } else {
        echo $duration;
    }

    $start_date = $_POST['startDate'];
    if (empty($start_date)) {
        echo "Start date is empty";
    } else {
        echo $start_date;
    }

    $shifts = $_POST['shifts'];
    if (empty($shifts)) {
        echo "Shifts is empty";
    } else {
        echo $shifts;
    }

    $supervision = $_POST['supervision'];
    if (empty($supervision)) {
        echo "Supervision is empty";
    } else {
        echo $supervision;
    }
}

// Insert into job_posts table
$sql = "INSERT INTO job_posts (specialty, location, job_desc, experience, salary, education_benefits, vacation, inpatient_or_outpatient, call_nocall, date_posted, duration, start_date, shifts, supervision, employer_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
//$sql = "INSERT INTO job_posts (specialty, location, job_desc, experience, salary, education_benefits, vacation, inpatient_or_outpatient) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  mysqli_stmt_bind_param($stmt, "sssssssssssssss", $param_specialty, $param_location, $param_job_desc, $param_experience, $param_salary, $param_education_benefits, $param_vacation, $param_in_out_patient, $param_call, $param_date_posted, $param_duration, $param_start_date, $param_shifts, $param_supervision, $param_email);
  //mysqli_stmt_bind_param($stmt, "ssssisss", $param_specialty, $param_location, $param_job_desc, $param_experience, $param_salary, $param_education_benefits, $param_vacation, $param_in_out_patient);

  $param_specialty = $specialty;
  $param_location = $location;
  $param_job_desc = $job_desc;
  $param_experience = $experience;
  $param_salary = $salary;
  $param_education_benefits = $education_benefits;
  $param_vacation = $vacation;
  $param_in_out_patient = $in_out_patient;
  $param_call = $call;
  $param_date_posted = $date_posted;
  $param_duration = $duration;
  $param_start_date = $start_date;
  $param_shifts = $shifts;
  $param_supervision = $supervision;
  $param_email = $_SESSION["email"];
  echo "updating job posts table";

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
  <h5 class="card-header">Post a job</h5>
  <div class="card-body">
    <form action="" method="post">
     <label for="specialty">Specialty:</label>
     <input type="text" id="spec" name="specialty"><br>

     <label for="location">Location:</label>
     <input type="text" id="locat" name="location"><br>

     <label for="experience">Experience:</label>
     <input type="text" id="exp" name="experience"><br>

     <label for="salary">Salary (yearly):</label>
     <input type="number" id="sal" name="salary" min="0" step="1000" required><br>

     <label for="educationBenefits">Education Benefits:</label>
     <input type="text" id="edu_benefits" name="educationBenefits"><br>

     <label for="vacation">Vacation:</label>
     <input type="text" id="vac" name="vacation"><br>

     <label for="shifts">Shifts:</label>
     <input type="text" id="shift" name="shifts"><br>

     <label for="supervision">Supervision:</label>
     <input type="text" id="supervis" name="supervision"><br>

     <label for="inOutPatient">Inpatient or Outpatient:</label>
     <select name="inOutPatient" id="in_out_patient">
       <option value="Inpatient">Inpatient</option>
       <option value="Outpatient">Outpatient</option>
     </select><br>

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
