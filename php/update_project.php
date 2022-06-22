<?php
	include("connection.php");

	$project_id = $_POST["projectID"];
	$project_name = $_POST["projectName"];

	$request = "UPDATE projects SET title = '$project_name' WHERE projectID = $project_id";
	if(mysqli_query($conn,$request)){
		header("Location: ../user_panel.php?id=$project_id");
	}
?>
