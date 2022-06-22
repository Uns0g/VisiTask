<?php
	include("connection.php");	

	$id = $_POST["taskID"];
	$title = $_POST["title"];
	$content = $_POST["content"];
	$position = $_POST["position"];
	$deadline = $_POST["deadline"];
	$status = $_POST["status"];

	$position = explode(',',$position);

	$deadline = date("Y-m-d",strtotime($deadline));

	$status = $_POST["status"];
	$request = "SELECT * FROM status WHERE name = '$status';";

	$response = mysqli_query($conn,$request);
	$register = $response->fetch_row();
	$status = $register[0];

	$request = "UPDATE tasks SET title='$title', content='$content', xPos='$position[0]', yPos='$position[1]', deadline='$deadline', status_ID=$status WHERE taskID=$id;";
	if(mysqli_query($conn,$request)){
		echo "<script>history.back();</script>";
	}
?>
