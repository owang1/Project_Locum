<?php
// Initialize the session
session_start();

require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// SQl to display messages from chat and chat message given stored chat id
$sql = "SELECT message, user, time_stamp from chat, chat_message where chat.id = chat_message.id and chat.id = ? order by time_stamp";


if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  $param_chat_id = $_SESSION["chat_id"];

  $var = mysqli_stmt_bind_param($stmt, "s", $param_chat_id);

  /* execute query */
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);

  mysqli_stmt_close($stmt);

}

$new_message = "";

// Get the message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input fields from form
    $new_message = $_POST['enterMessage'];
    if (empty($new_message)) {
        echo "New message is empty";
        unset($new_message);
    } else {
        echo "The new message is:";
        echo $new_message;

        $sql = "INSERT INTO chat_message (user, id, message) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
          /* bind parameters for markers */
          mysqli_stmt_bind_param($stmt, "sss", $param_user, $param_id, $param_message);
          $param_user = $_SESSION["email"];
          $param_id = $_SESSION["chat_id"];
          $param_message= $new_message;
          echo "inserting into chat message";
          /* execute query */
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);

        }
    }
    // refresh the page to show
    echo "<meta http-equiv='refresh' content='0'>";
}


$new_message = "";

// Closing connection
mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" http-equiv="refresh" content="10"; url="<?php echo $_SERVER['PHP_SELF']; ?>">
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

.container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
}

.container::after {
  content: "";
  clear: both;
  display: table;
}

.container img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.container img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
}

.text {
  text-align: left;
}

.message {
  width: 80%;
  align: left;
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
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/messages.php/">Messages</a>
      <h3 class="nav-item nav-link greeting"> Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b> </h3>
      <a class="nav-item nav-link" href="http://db.cse.nd.edu/cse30246/locum/locum_website/logout.php">Logout</a>
      <a class="nav-item nav-link " href="http://db.cse.nd.edu/cse30246/locum/locum_website/http://db.cse.nd.edu/cse30246/locum/locum_website/reset-password.php">Reset</a>
    </div>
  </div>
</nav>
<h2> Messages </h1>

  <?php while($row = mysqli_fetch_array($result)) { // MYSQLI was missing an I here and on line 32
    if($_SESSION["account_type"] == "employer") {
      if(strcmp($row[user], $_SESSION["email"]) !== 0){
      echo "
      <div class='container'>
        <img src='http://db.cse.nd.edu/cse30246/locum/locum_website/images/profile.jpg' alt='profile pic' style='width:100%;''>
        <p class = 'p text'>$row[message]</p>
        <span class='time-right'>$row[time_stamp]</span>
      </div>
      ";
    }else {
      echo "
      <div class='container darker'>
        <img src='http://db.cse.nd.edu/cse30246/locum/locum_website/images/hospital.jpg' alt='hospital'  class='right' style='width:100%;''>
        <p class = 'p text'>$row[message]</p>
        <span class='time-right'>$row[time_stamp]</span>
      </div>
      ";
    }
  }elseif($_SESSION["account_type"] == "employee") {
    if(strcmp($row[user], $_SESSION["email"]) !== 0){
    echo "
    <div class='container'>
      <img src='http://db.cse.nd.edu/cse30246/locum/locum_website/images/hospital.jpg' alt='hospital' style='width:100%;''>
      <p class = 'p text'>$row[message]</p>
      <span class='time-right'>$row[time_stamp]</span>
    </div>
    ";
  }else {
    echo "
    <div class='container darker'>
      <img src='http://db.cse.nd.edu/cse30246/locum/locum_website/images/profile.jpg' alt='profile pic' class='right' style='width:100%;''>
      <p class = 'p text'>$row[message]</p>
      <span class='time-right'>$row[time_stamp]</span>
    </div>
    ";
  }
  }
  }?>

<form action="#"  method="post">
  <textarea class = "message" id="enter_message" name="enterMessage" rows="5"></textarea>
  <input type="submit" class="btn btn-primary" value="Submit">
</form>
</div>

</body>
</html>
