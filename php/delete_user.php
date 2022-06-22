<?php 
	session_start();
	include("connection.php");

	$usr = $_SESSION["user"];

	$request = "SELECT userID FROM users WHERE login='$usr'";
	
	$usr = mysqli_query($conn,$request)->fetch_row();
	
	$request = "SELECT * FROM projects WHERE user_ID=$usr[0]";
	$response = mysqli_query($conn,$request);
	while($field = mysqli_fetch_assoc($response)){
		$request = "DELETE FROM tasks WHERE project_ID={$field["projectID"]}";
		mysqli_query($conn,$request);
	
		$request = "DELETE FROM projects WHERE projectID={$field["projectID"]}";
		mysqli_query($conn,$request);
	}

	$request = "DELETE FROM users WHERE userID=$usr[0]";
	if(mysqli_query($conn,$request)){
		session_destroy();
		header('Location: ../index.php');
	}
?>