<?php
session_start();

require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

class Notification {     
    private $conn;
    private $notificationTable = "notifications";     
	private $peopleTable = "people";
	private $jobTable = "job_posts";
	private $appliedTable = "applied_to";
	public $email;	
    public $id;
    public $title;
    public $message;
    public $ntime;
    public $repeat;
    public $nloop;
    public $publish_date; 
	public $username; 
    
    public function __construct($db){
        $this->conn = $db;
    }	
	
	// function listNotification(){
	// 	$stmt = $this->conn->prepare("
	// 		SELECT * 
	// 		FROM ".$this->appliedTable, .$this->jobTable."
	// 		WHERE username= ?");
	// 	// $notificatonTable
	// 	// $stmt->bind_param("s", $this->username);
	// 	$stmt->bind_param("s", $_SESSION["email"]);
	// 	$stmt->execute();			
	// 	$result = $stmt->get_result();
			
	// 	return $result;	
	// }

	// function listNotification(){
	// $sql = "SELECT * from applied_to, job_posts where applied_to.job_id = job_posts.job_id and applied_to.job_match = 1";


	// if($stmt = mysqli_prepare($link, $sql)){
	// /* bind parameters for markers */
	// $param_user = $_SESSION["email"];

	// //$var = mysqli_stmt_bind_param($stmt, "s", $param_user);

	// /* execute query */
	// mysqli_stmt_execute($stmt);

	// $result = mysqli_stmt_get_result($stmt);	

	// mysqli_stmt_close($stmt);

	// // Closing connection
	// //smysqli_close($link);
	
	// return $result;

	// echo $result;

	// }}
	
	function listNotification(){
		$stmt = $this->conn->prepare("
			SELECT * 
			FROM ".$this->notificationTable."
			WHERE username= ?");
		// $notificatonTable
		// $stmt->bind_param("s", $this->username);
		$stmt->bind_param("s", $_SESSION["email"]);
		$stmt->execute();			
		$result = $stmt->get_result();
			
		return $result;	
	}

	function getNotificationByUser(){
		$query = "
			SELECT *
			FROM ".$this->notificationTable." 
			WHERE username= ? AND nloop > 0 AND ntime <= CURRENT_TIMESTAMP()";
		$stmt = $this->conn->prepare($query);				
		$stmt->bind_param("s", $this->username);	
		$stmt->execute();		
		$result = $stmt->get_result();		
		return $result;	
		echo $result;
	}	
	
	function saveNotification(){	
		$insertQuery = "
			INSERT INTO ".$this->notificationTable."( `title`, `message`, `ntime`, `repeat`, `nloop`, `username`)
			VALUES(?,?,?,?,?,?)";
		$stmt = $this->conn->prepare($insertQuery);			
		$stmt->bind_param("sssiis",$this->title, $this->message, $this->ntime, $this->repeat, $this->nloop, $this->username);
		if($stmt->execute()){
			return true;
		}	 
		return false;				
	}		
	
	function updateNotification() {		
		$updateQuery = "
			UPDATE ".$this->notificationTable." 
			SET ntime= ?, publish_date=CURRENT_TIMESTAMP(), nloop = nloop-1 
			WHERE id= ? ";		
		$stmt = $this->conn->prepare($updateQuery);	 		 
		$stmt->bind_param("si", $this->nexttime, $this->id);		
		if($stmt->execute()){
			return true;
		}	 
		return false;		
	}		
}

	// Closing connection
	// mysqli_close($link);
?>