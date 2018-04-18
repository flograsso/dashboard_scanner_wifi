<?php


//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'db_wifi_scanner');

//get connection
//(MySQLi Object-Oriented)
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$conn){
	die("Connection failed: " . $conn->error);
}

?>