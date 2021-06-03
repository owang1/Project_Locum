<?php
// Initialize the session
session_start();

require_once "config.php";
require_once "database.php";
require_once "notifs.php";
require_once "user.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$notification = new Notification($db);
$user = new User($db);

// SQl to display messages from chat and chat message given stored chat id
$sql = "SELECT * from applied_to, job_posts where applied_to.job_id = job_posts.job_id and applied_to.job_match = 1 and applied_to.employee_email = 'jorgeg0528@hotmail.com'";

if($stmt = mysqli_prepare($link, $sql)){
  /* bind parameters for markers */
  $param_email = $_SESSION["email"];

  $var = mysqli_stmt_bind_param($stmt, "s", $param_email);

  /* execute query */
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
//   echo $result;

  mysqli_stmt_close($stmt);

}
// Closing connection
  mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
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

.container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}
.text {
  text-align: left;
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
<h2> Notifications & Matches </h1>
</div>
<div class="container">		
	<hr>
	<div class="row">
		<div class="col-sm-6">
			<h3>Add New Notification:</h3>
			<form method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">										
				<table class="table borderless">
					<tr>
						<td>Title</td>
						<td><input type="text" name="title" class="form-control" required></td>
					</tr>	
					<tr>
						<td>Message</td>
						<td><textarea name="message" cols="50" rows="4" class="form-control" required></textarea></td>
					</tr>			
					<tr>
						<td>Broadcast time</td>
						<td><select name="ntime" class="form-control"><option>Now</option></select> </td>
					</tr>
					<tr>
						<td>Loop (time)</td>
						<td><select name="loops" class="form-control">
						<?php 
							for ($i=1; $i<=5 ; $i++) { ?>
								<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td>Loop Every (Minute)</td>
						<td><select name="loop_every" class="form-control">
						<?php 
						for ($i=1; $i<=60 ; $i++) { ?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
						</select> </td>
					</tr>
					<tr>
						<td>For</td>
						<td><select name="user" class="form-control">
						<?php 		
						$allUser = $user->listAll(); 							
						while ($user = $allUser->fetch_assoc()) { 	
						?>
						<option value="<?php echo $user['email'] ?>"><?php echo $user['email'] ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td colspan=1></td>
						<td colspan=1></td>
					</tr>					
					<tr>
						<td colspan=1></td>
						<td><button name="submit" type="submit" class="btn btn-info">Add Message</button></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<?php 
	if (isset($_POST['submit'])) { 
		if(isset($_POST['message']) and isset($_POST['ntime']) and isset($_POST['loops']) and isset($_POST['loop_every']) and isset($_POST['user'])) {
			$notification->title = $_POST['title'];
			$notification->message = $_POST['message'];
			$notification->ntime = date('Y-m-d H:i:s'); 
			$notification->repeat = $_POST['loops']; 
			$notification->nloop = $_POST['loop_every']; 
			$notification->username = $_POST['user'];	
			if($notification->saveNotification()) {
				echo '* save new notification success';
			} else {
				echo 'error save data';
			}
		} else {
			echo '* completed the parameter above';
		}
	} 
	?>
	<h3>Notifications List:</h3>
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Next Schedule</th>
				<th>Title</th>
				<th>Message</th>
				<th>Remains</th>
				<th>User</th>
			</tr>
		</thead>
		<tbody>
			<?php $notificationCount =1; 
			$notificationList = $notification->listNotification(); 
			// $notificationList = $notification->getNotificationByUser(); 						
			while ($notif = $notificationList->fetch_assoc()) { 	
			?>
			<tr>
				<td><?php echo $notificationCount ?></td>
				<td><?php echo $notif['ntime'] ?></td>
				<td><?php echo $notif['title'] ?></td>
				<td><?php echo $notif['message'] ?></td>
				<td><?php echo $notif['nloop']; ?></td>
				<td><?php echo $notif['username'] ?></td>
			</tr>
			<?php $notificationCount++; } ?>
		</tbody>
	</table>
	<h3> Matched Jobs: </h3>
	<?php while($row = mysqli_fetch_array($result)) {
		if($_SESSION["account_type"] == "employee") {
			echo "
			<div class='container'>
			<p class = 'p text'><strong>Job ID:</strong> $row[job_id], <strong>Employee Email:</strong> $row[employee_email], <strong>Specialty:</strong> $row[specialty], <strong>Job Description:</strong> $row[job_desc], <strong>Salary:</strong> $row[salary], <strong>Employer Email to Contact:</strong> $row[employer_email]</p>
			</div>";
		}
	}
		// echo $sql;
		// echo $result; 
		// $row = mysqli_fetch_array($result);
		// echo $row;
	?>
</div>	

</body>
</html>