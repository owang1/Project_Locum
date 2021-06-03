<?php

session_start();

require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

class User { 
    
    private $conn;
    // private $userTable = "notification_user"; 
    private $userTable = "people"; 
	public $email;
	public $phone_number;
	// public $id;
    // public $username;
    public $password;   
    
    public function __construct($db){
        $this->conn = $db;
    }	
	// WHERE username != 'admin'");

	function listAll(){		
		$stmt = $this->conn->prepare("
			SELECT * FROM ".$this->userTable." 
			WHERE email != 'admin'");
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}	
	
	// function login (){		
	// 	$stmt = $this->conn->prepare("
	// 		SELECT id as userid, username, password 
	// 		FROM ".$this->userTable." 
	// 		WHERE username = ? AND password = ? ");
	// 	$stmt->bind_param("ss", $this->username, $this->password);	
	// 	$stmt->execute();
	// 	$result = $stmt->get_result();		
	// 	return $result;			
	// }

	function login (){		
		$stmt = $this->conn->prepare("
			SELECT email as email, phone_number, password 
			FROM ".$this->userTable." 
			WHERE email = ? AND password = ? ");
		$stmt->bind_param("ss", $this->email, $this->password);	
		$stmt->execute();
		$result = $stmt->get_result();		
		return $result;			
	}
}
?>