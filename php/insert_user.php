<?php
	session_start();
	include("connection.php");

	$username = $_POST["user-input"];
	$password = $_POST["password-input"];

	$request = "SELECT * FROM users WHERE login = '$username';";

	$response = mysqli_query($conn,$request);
	if($response->num_rows > 0){
		$_SESSION["existing_user"] = true;
		header('Location: ../index.php');
	}
	else{
		$insert = "INSERT INTO users (login,password) VALUES('$username','$password');";
		mysqli_query($conn,$insert);

		$_SESSION["user"] = $username;
		header("Location: ../user_panel.php");
	}
?>
