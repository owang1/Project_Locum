<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
//define('DB_SERVER', 'localhost');
//define('DM_EMAIL', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'demo');

/* Attempt to connect to MySQL database */
/* $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); */

$link = mysqli_connect('localhost', 'jgarci22', 'jgarci22', 'jgarci22')
    or die('Could not connect: ' . mysql_error());
echo 'Connected successfully';
mysqli_select_db($link, 'jgarci22') or die('Could not select database');


// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
