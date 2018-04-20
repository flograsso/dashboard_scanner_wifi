<?php
	include("connection.php");
	$query = "SELECT DISTINCT MAC FROM data";
	$result = $conn->query($query);
    $data = array();
    
?>

<select style= "height:35px;" class="form-control" name="MAC" id="macSelect">
    <?php
		if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
		    {
                ?>
                <option value="
                    <?php echo $row["MAC"];?> ">
                    <?php echo $row["MAC"]?></option>

                <?php
		    }
		}       $result->close();
				?>
</select>

