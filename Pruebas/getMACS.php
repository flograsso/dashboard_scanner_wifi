<?php
//setting header to json
//header('Content-Type: application/json');

include("connection.php");



$METHOD=$_POST["method"];

switch ($METHOD)
{
	case "RSSIfromMAC":
		$MAC = trim($_POST["MAC"]);
		$fecha_desde=$_POST["fecha_desde"];
		$fecha_hasta=$_POST["fecha_hasta"];

		if ($fecha_desde!= "" && $fecha_hasta!= ""){
			//query to get data from the table
			$sql = "SELECT rssi,time FROM `data` WHERE MAC = '$MAC' AND (time BETWEEN '$fecha_desde' AND '$fecha_hasta')";
		}
		elseif  ($fecha_desde != ""){
			$sql = "SELECT rssi,time FROM `data` WHERE MAC = '$MAC' AND time >'$fecha_desde' ";
		}
		elseif ($fecha_hasta != ""){
			$sql = "SELECT rssi,time FROM `data` WHERE MAC = '$MAC' AND time <'$fecha_hasta'";
		}
		else{
			$sql = "SELECT rssi,time FROM `data` WHERE MAC = '$MAC' ";
		}
		

		//execute query
		$result = $conn->query($sql);
		$outp = array();
		$outp = $result->fetch_all(MYSQLI_ASSOC);
		//free memory associated with result
		$result->close();
		//close connection
		$conn->close();
		//now print the data
		echo json_encode($outp);
		
		break;
	case "getNumberofMACS":
		$sql = "SELECT COUNT(DISTINCT(MAC)) AS `count` FROM `data`";
		$result = $conn->query($sql);
		$outp = array();
		$row = $result->fetch_assoc();
		$result->close();
		$conn->close();
		echo $row['count'];
		break;
	case "getNumbersNews":
		$sql = "SELECT COUNT(DISTINCT(MAC)) AS `count` FROM `data` WHERE (TIMESTAMPDIFF(MINUTE,`time`,CURRENT_TIMESTAMP())<1) ";
		//SELECT TIMESTAMPDIFF(MINUTE,'2018-04-17 12:21:15',CURRENT_TIMESTAMP()); 
		$result = $conn->query($sql);
		$outp = array();
		$row = $result->fetch_assoc();
		$result->close();
		$conn->close();
		echo $row['count'];
		break;
	case "searchMAC":
		$MAC = $_POST["MAC"];
		$sql ="SELECT DISTINCT(MAC) FROM `data` WHERE MAC LIKE '%$MAC%'";
		//execute query
		$result = $conn->query($sql);
		$outp = array();
		$outp = $result->fetch_all(MYSQLI_ASSOC);
		//free memory associated with result
		$result->close();
		//close connection
		$conn->close();
		//now print the data
		echo json_encode($outp);
		break;
		
	case "getChannels":
		$sql="SELECT `channel`,COUNT(DISTINCT(MAC)) AS 'count' FROM `data` GROUP BY `channel`";
		//execute query
		$result = $conn->query($sql);
		$outp = array();
		$outp = $result->fetch_all(MYSQLI_ASSOC);
		//free memory associated with result
		$result->close();
		//close connection
		$conn->close();
		//now print the data
		echo json_encode($outp);
		break;

	default:
		break;

}



/*
************************************************
LISTAR MACS
************************************************
//query to get data from the table
$sql = "SELECT DISTINCT(MAC) FROM `data`";

//execute query
$result = $conn->query($sql);

$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

//free memory associated with result
$result->close();

//close connection
$conn->close();

//now print the data
echo json_encode($outp);


*/
?>


