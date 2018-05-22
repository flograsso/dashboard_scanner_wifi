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
		//query to get data from the table
		$sql = "SELECT COUNT(DISTINCT(MAC)) AS `count` FROM `data` WHERE `device` LIKE '$device' AND TIMESTAMPDIFF(MINUTE,time,CURRENT_TIMESTAMP())<3";
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
		$fecha_desde=$_POST["fecha_desde"];
		$fecha_hasta=$_POST["fecha_hasta"];


		if ($fecha_desde!= "" && $fecha_hasta!= ""){
			//query to get data from the table
			$sql="SELECT `channel`,COUNT(DISTINCT(MAC)) AS 'count' FROM `data` WHERE  `device` LIKE '$device' AND (time BETWEEN '$fecha_desde' AND '$fecha_hasta') GROUP BY `channel`";

		}
		elseif  ($fecha_desde != ""){
			$sql="SELECT `channel`,COUNT(DISTINCT(MAC)) AS 'count' FROM `data` WHERE  `device` LIKE '$device' AND time >'$fecha_desde' GROUP BY `channel`";

		}
		elseif ($fecha_hasta != ""){
			$sql="SELECT `channel`,COUNT(DISTINCT(MAC)) AS 'count' FROM `data` WHERE  `device` LIKE '$device' AND time <'$fecha_hasta' GROUP BY `channel`";

	
		}
		else{
			$sql="SELECT `channel`,COUNT(DISTINCT(MAC)) AS 'count' FROM `data` WHERE  `device` LIKE '$device' GROUP BY `channel`";
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

	case "getStatsVendors":
		$device=$_POST["device"];
		$fecha_desde=$_POST["fecha_desde"];
		$fecha_hasta=$_POST["fecha_hasta"];

		if ($fecha_desde!= "" && $fecha_hasta!= ""){
			//query to get data from the table
			$sql="SELECT `mac_vendor`,COUNT(DISTINCT(MAC)) AS `count` FROM `data` WHERE `device` LIKE '$device' AND (time BETWEEN '$fecha_desde' AND '$fecha_hasta') GROUP BY `mac_vendor` ORDER BY `count` DESC ";

		}
		elseif  ($fecha_desde != ""){
			$sql="SELECT `mac_vendor`,COUNT(DISTINCT(MAC)) AS `count` FROM `data` WHERE `device` LIKE '$device' AND time >'$fecha_desde' GROUP BY `mac_vendor` ORDER BY `count` DESC ";

		}
		elseif ($fecha_hasta != ""){
			$sql="SELECT `mac_vendor`,COUNT(DISTINCT(MAC)) AS `count` FROM `data` WHERE `device` LIKE '$device' AND time <'$fecha_hasta' GROUP BY `mac_vendor` ORDER BY `count` DESC ";

	
		}
		else{

			$sql="SELECT `mac_vendor`,COUNT(DISTINCT(MAC)) AS `count` FROM `data` WHERE `device` LIKE '$device' GROUP BY `mac_vendor` ORDER BY `count` DESC ";
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

	case "getVendorFromMAC":
		$device=$_POST["device"];
		$MAC = trim($_POST["MAC"]);
		$sql ="SELECT `mac_vendor` FROM `data` WHERE MAC='$MAC' AND device='$device' LIMIT 1";
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

		

	case "getlastChannelFromMAC":
		$device=$_POST["device"];
		$MAC = trim($_POST["MAC"]);
		$sql ="SELECT time AS fecha,`channel` FROM `data` WHERE MAC='$MAC' AND device='$device' GROUP BY fecha DESC LIMIT 1";
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
	
	case "congelarEntorno":
		//Elimino datos de DB
		$sql="DELETE FROM `entorno` WHERE 1";
		$conn->query($sql);

		$sql ="SELECT DISTINCT(`MAC`) FROM `data` WHERE TIMESTAMPDIFF(MINUTE,`time`,CURRENT_TIMESTAMP())<10";
		$result = $conn->query($sql);
		//echo "Numero de filas" . $result->num_rows;
		$agregados = 0;
		if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
		    {
					$sql = "INSERT INTO entorno (MAC) VALUES (\"". $row["MAC"]."\")";
					if ($conn->query($sql) === TRUE) {
						$agregados=$agregados+1;
					} 
		    }
		}       
				
		//free memory associated with result

		$result->close();
		//close connection
		$conn->close();
		//now print the data
		echo $agregados;

		break;

	case "agregarEntorno":

		$sql ="SELECT DISTINCT(`MAC`) FROM `data` WHERE TIMESTAMPDIFF(MINUTE,`time`,CURRENT_TIMESTAMP())<10";
		$result = $conn->query($sql);
		//echo "Numero de filas" . $result->num_rows;

		$contador = new \stdClass(); //Omito una alerta de objeto no creado
		$contador->agregados = 0;
		$contador->repetidos = 0;

		if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
		    {
					$sql = "INSERT INTO entorno (MAC) VALUES (\"". $row["MAC"]."\")";
                        if ($conn->query($sql) === TRUE) {
							$contador->agregados=($contador->agregados)+1;
                    } else {
						$contador->repetidos=($contador->repetidos)+1;
                    }
		    }
		}       
				
		//free memory associated with result

		$result->close();
		//close connection
		$conn->close();
		//now print the data
		echo json_encode($contador);
		break;


	case "checkNewsNotFreeze":
		$sql ="SELECT DISTINCT(t1.MAC) FROM `data` t1 LEFT OUTER JOIN `entorno` t2 ON t1.MAC=t2.MAC WHERE t2.MAC IS NULL;";
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


