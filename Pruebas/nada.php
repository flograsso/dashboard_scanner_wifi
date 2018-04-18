<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php 
 include("connection.php");
 $sql = "SELECT COUNT(DISTINCT(MAC)) AS `count` FROM `data`";
 $result = $conn->query($sql);
 $outp = array();
 $row = $result->fetch_assoc();
 echo $row['count'];

 $result->close();
 $conn->close();


 
 
 
 ?> 
	<div id="chart-container">
			<canvas id="mycanvas"></canvas>
		</div>
 		<!-- javascript -->
		<script language="JavaScript" type="text/javascript" src="../vendor/jquery/jquery.min.js"></script>
		<script language="JavaScript" type="text/javascript" src="../vendor/chart.js/Chart.min.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/app.js"></script>
 </body>
</html>