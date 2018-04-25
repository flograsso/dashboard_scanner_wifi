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
		$device=$_POST["device"];

		if ($fecha_desde!= "" && $fecha_hasta!= ""){
			//query to get data from the table
			$sql = "SELECT rssi,time FROM `data` WHERE MAC = '$MAC' AND (time BETWEEN '$fecha_desde' AND '$fecha_hasta') AND `device` LIKE '$device'";
		}
		elseif  ($fecha_desde != ""){
			$sql = "SELECT rssi,time FROM `data` WHERE MAC = '$MAC' AND time >'$fecha_desde' AND `device` LIKE '$device' ";
		}
		elseif ($fecha_hasta != ""){
			$sql = "SELECT rssi,time FROM `data` WHERE MAC = '$MAC' AND time <'$fecha_hasta' AND `device` LIKE '$device'";
		}
		else{
			$sql = "SELECT rssi,time FROM `data` WHERE MAC = '$MAC' AND `device` LIKE '$device' ";
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
		$device=$_POST["device"];
		$sql = "SELECT COUNT(DISTINCT(MAC)) AS `count` FROM `data` WHERE `device` LIKE '$device'";
		$result = $conn->query($sql);
		$outp = array();
		$row = $result->fetch_assoc();
		$result->close();
		$conn->close();
		echo $row['count'];
		break;
	case "getNumbersNews":
		$device=$_POST["device"];
		$sql = "SELECT COUNT(DISTINCT(MAC)) AS `count` FROM `data` WHERE (TIMESTAMPDIFF(MINUTE,`time`,CURRENT_TIMESTAMP())<1) AND `device` LIKE '$device'";
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
		$device=$_POST["device"];
		$sql="SELECT `channel`,COUNT(DISTINCT(MAC)) AS 'count' FROM `data` WHERE  `device` LIKE '$device' GROUP BY `channel`";
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

	case "getStatsVendors":
		$device=$_POST["device"];
		$sql="SELECT `mac_vendor`,COUNT(DISTINCT(MAC)) AS `count` FROM `data` WHERE `device` LIKE '$device' GROUP BY `mac_vendor` ORDER BY `count` DESC ";
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


