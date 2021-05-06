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
$name = $phonenumber = $employee_desc = $education = "";

$phonenumber = mysqli_real_escape_string($link, $_REQUEST['phone_number']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input fields from form
    $name = $_POST['fullName'];
    if (empty($name)) {
        echo "Name is empty";
    } else {
        echo $name;
    }

    $phonenumber = $_POST['phone'];
    if (empty($phonenumber)) {
        echo "Phone number is empty";
    }else if(strlen($phonenumber)!=10 || !(is_numeric($phonenumber))){
       echo "Enter 10 digit phone number";
    }
    else {
        echo $phonenumber;
    }

    $employee_desc = $_POST['employeeDesc'];
    if (empty($employee_desc)) {
        echo "Employee description is empty";
    } else {
        echo $employee_desc;
    }

    $education = $_POST['education'];
    if (empty($education)) {
        echo "Education is empty";
    } else {
        echo $education;
    }
    $education_school = $_POST['educationSchool'];
    if (empty($education_school)) {
        echo "Education school is empty";
    } else {
        echo $education_school;
    }
    $education_date = $_POST['graduationDate'];
    if (empty($education_date)) {
        echo "Education date is empty";
    } else {
        echo $education_date;
    }
    $cert = $_POST['certification'];
    if (empty($cert)) {
        echo "Certification is empty";
    } else {
        echo $cert;
    }
    $cert_expr = $_POST['certificationDate'];
    if (empty($cert_expr)) {
        echo "Certification date is empty";
    } else {
        echo $cert_expr;
    }
    $life_support = $_POST['lifeSupportCert'];
    if (empty($life_support)) {
        echo "Life support cert is empty";
    } else {
        echo $life_support;
    }


}
// Update employees table with name
$sql = "UPDATE employees SET name = ?, employee_desc = ? where email = ?";

if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_desc, $param_email);
  $param_name = $name;
  $param_desc = $employee_desc;
  $param_email = $_SESSION["email"];
  echo "here 2";

  /* execute query */
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

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

// Update cv table for the given email
$sql = "UPDATE cv SET education = ?, education_school = ?, education_date = ?, cert = ?, cert_expr_date = ?, life_support_card = ? where email = ?";

if($stmt = mysqli_prepare($link, $sql)){
  mysqli_stmt_bind_param($stmt, "sssssss", $param_education, $param_education_school, $param_education_date, $param_cert, $param_cert_expr, $param_life_support, $param_email);
  $param_education = $education;
  $param_education_school = $education_school;
  $param_education_date = $education_date;
  $param_cert = $cert;
  $param_cert_expr = $cert_expr;
  $param_life_support = $life_support;
  $param_email = $_SESSION["email"];
  echo "updating cv with education";

  /* execute query */
  mysqli_stmt_execute($stmt);

  /* close statement */
  mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($link);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fill Employee Profile</title>
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

  <div class="card">
  <h5 class="card-header">Please fill out your employee profile</h5>
  <div class="card-body">
    <form action="" method="post">
     <label for="fullName">Full name:</label>
     <input type="text" id="full_name" name="fullName" placeholder="Firstname Lastname" required><br>
     <label for="phone">Phone number:</label>
     <input type="text" id="phone_number" name="phone" placeholder="1231231234" required> <br>
     <label for="employeeDesc">Self Description:</label><br>
     <textarea id="employee_desc" name="employeeDesc" cols="50" rows="5" placeholder="Tell the employer about yourself in max 250 characters"></textarea>
     <br><br>
     <strong> CV </strong> <br>
     <label for="education">Education:</label>
     <input type="text" id="edu" name="education" placeholder="B.S. Nursing"><br>
     <label for="educationSchool">School:</label>
     <input type="text" id="education_school" name="educationSchool" placeholder="University of Notre Dame"><br>
     <label for="graduationDate">Graduation Date:</label>
     <input type="date" id="garduation_date" name="graduationDate"
       value="2021-05-22"
       min="1910-01-01" max="2030-12-31">
     <br>
     <label for="certification">Certification:</label>
     <input type="text" id="cert" name="certification" placeholder="Certified Registered Nurse Anesthetist"><br>
     <label for="certificationDate">Certification Expiration Date:</label>
     <input type="date" id="certification_date" name="certificationDate"
       value="2021-05-22"
       min="2021-01-01" max="2050-12-31">
     <br>
     <label for="lifeSupportCert">Life Support Certification:</label>
     <input type="text" id="life_suport_cert" name="lifeSupportCert" placeholder="Pediatric Life Support"><br>
     <input type="submit" class="btn btn-primary" value="Submit">
   </form>
  </div>
  </div>

</body>
</html>
