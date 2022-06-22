<?php
	include("connection.php");

	$user_id = '0';
	$user = $_POST["user"];
	$project_name = $_POST["projectName"];

	$request = "SELECT userID FROM users WHERE login = '$user';";
	$response = mysqli_query($conn,$request);

	while($register = mysqli_fetch_row($response)){
		$user_id = $register[0];
	}

	$request = "INSERT INTO projects (title, user_ID) VALUES('$project_name',$user_id);";
	if(mysqli_query($conn,$request)){
		echo "<script>history.back();</script>";
	} 
?>
