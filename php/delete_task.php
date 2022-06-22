<?php
	include("connection.php");

	$id = $_POST["taskID"];
	
	$request = "DELETE FROM tasks WHERE taskID = $id;";

	if(mysqli_query($conn,$request)){
		echo "<script>history.back();</script>";
	}
?>
