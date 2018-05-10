<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>

<?php
include("connection.php");
$sql ="SELECT DISTINCT(`MAC`) FROM `data` WHERE TIMESTAMPDIFF(MINUTE,time,CURRENT_TIMESTAMP())>5";
$result = $conn->query($sql);
//echo "Numero de filas" . $result->num_rows;

if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
		    {
                    $sql = "INSERT INTO entorno (MAC) VALUES (\"". $row["MAC"]."\")";
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

		    }
		}       
        echo $result->num_rows;
		//free memory associated with result

		$result->close();
		//close connection
		$conn->close();
		//now print the data
		
?>
</body>
</html>