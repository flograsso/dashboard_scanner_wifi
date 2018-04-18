<?php
//setting header to json
header('Content-Type: application/json');

include("connection.php");

//query to get data from the table
$query = sprintf("SELECT MAC, rssi FROM data WHERE channel=4");

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);

?>