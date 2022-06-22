<?php
	include("connection.php");

	$project_id = $_POST["projectID"];

	$request = "DELETE FROM projects WHERE projectID = $project_id;";
	if(mysqli_query($conn,$request)){
		echo "<script>history.back();</script>";
	}
?>
