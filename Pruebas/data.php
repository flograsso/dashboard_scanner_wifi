<?php
//setting header to json
include("connection.php");
$sql ="SELECT * FROM `data` WHERE `device`=1 LIMIT 5;SELECT * FROM `data` WHERE `device`=2 LIMIT 5;";
//execute query
$json="";
if (!$result = $conn->multi_query($sql))
	echo "Falló la multiconsulta: (" . $mysqli->errno . ") " . $mysqli->error;

	do {
		if ($resultado = $conn->store_result()) {
			$outp = $resultado->fetch_all(MYSQLI_ASSOC);
			$json=$json.json_encode($outp);
		}
	} while ($conn->more_results() && $conn->next_result());



echo $json;
?>