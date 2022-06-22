<?php
	session_start();
	include("connection.php");

	$username = $_POST["user-input"];
	$password = $_POST["password-input"];

	$request = "SELECT * FROM users WHERE login = '$username';";
	$response = mysqli_query($conn,$request);
	if($response->num_rows < 1){
		$_SESSION["unexisting_user"] = true;
		header('Location: ../login.php');
	}
	else{
		$request = "SELECT * FROM users WHERE login = '$username' AND password = '$password';";

		$response = mysqli_query($conn,$request);
		if($response->num_rows < 1){
			$_SESSION["wrong_password"] = true;
			header('Location: ../login.php');
		}
		else{ 
			$_SESSION["user"] = $username;
			header("Location: ../user_panel.php");	
		}
	}
?>
