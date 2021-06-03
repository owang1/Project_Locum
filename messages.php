<?php
// Initialize the session
session_start();

require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$chat_id_clicked = "";

// Determine the account type by querying employers and employees table
$existing_account = "";

// Check if email is already in employer
$sql = "SELECT * from employers where employers.email = ?";

if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  $param_email = $_SESSION["email"];

  $var = mysqli_stmt_bind_param($stmt, "s", $param_email);

  /* execute query */
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  // Employer doesn't have email
  if(mysqli_stmt_num_rows($stmt) > 0){
    $existing_account = "employer";
    $_SESSION["account_type"] = "employer";
  }

  //mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

}

$sql = "SELECT * from employees where employees.email = ?";

if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  $param_email = $_SESSION["email"];

  $var = mysqli_stmt_bind_param($stmt, "s", $param_email);

  /* execute query */
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);

  // Employer doesn't have email
  if(mysqli_stmt_num_rows($stmt) > 0){
    $existing_account = "employee";
    $_SESSION["account_type"] = "employee";
  }

  mysqli_stmt_close($stmt);

}
// Find employees who the user (employer) is chatting with


if($existing_account == "employee"){
  $sql = "SELECT chat.employer, chat.id from chat where chat.employee = ?";
}elseif ($existing_account == "employer"){
  $sql = "SELECT chat.employee, chat.id from chat where chat.employer = ?";
}

// Update people table with entered phone number

if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  $param_email = $_SESSION["email"];
  //echo $param_email;
  $var = mysqli_stmt_bind_param($stmt, "s", $param_email);

  /* execute query */
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);

  mysqli_stmt_close($stmt);

}

if (isset($_POST["btn"])){
  echo "chat id = ";

  $chat_id_clicked = $_POST['btn'];
  $_SESSION["chat_id"] = $chat_id_clicked;
  echo $_SESSION["chat_id"];
  header("location: http://db.cse.nd.edu/cse30246/locum/locum_website/chat.php/");

}
// Closing connection
mysqli_close($link);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages</title>
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
    margin: 0px;
    width: 80%;
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
      <?php
      if($_SESSION["account_type"] == "employer") {
        echo "<a class='nav-item nav-link' href='http://db.cse.nd.edu/cse30246/locum/locum_website/browse-resumes.php/'>Browse Resumes <span class='sr-only'>(current)</span></a>";
      }else{
        echo "<a class='nav-item nav-link' href='http://db.cse.nd.edu/cse30246/locum/locum_website/browse-jobs.php/'>Browse Jobs <span class='sr-only'>(current)</span></a>";
      }
      ?>
      <a class="nav-item nav-link" href="#">Messages</a>
      <h3 class="nav-item nav-link greeting"> Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b> </h3>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/logout.php">Logout</a>
      <a class="nav-item nav-link " href="http://db.cse.nd.edu/cse30246/locum/locum_website/reset-password.php">Reset</a>
    </div>
  </div>
</nav>
<h2> Inbox </h1>
 <form action='#'  method='post'>
  <?php while($row = mysqli_fetch_array($result)) { // MYSQLI was missing an I here and on line 32
      // PHP to display HTML card elements
        if($existing_account == "employee"){

        echo "  <div class='card'>
                <div class='card-body'>
                  <h5 class='card-title'>$row[employer]</h5>
                  <button name='btn' class = 'btn btn-primary' type='submit' value=$row[id]>Message</button>
          </div>
          </div>";

      } elseif($existing_account == "employer"){
      echo "  <div class='card'>
              <div class='card-body'>
                <h5 class='card-title'>$row[employee]</h5>
                <button name='btn' class = 'btn btn-primary' type='submit' value=$row[id]>Message</button>
        </div>
        </div>";
      }

  }?>
  </form>

</div>

</body>
</html>
