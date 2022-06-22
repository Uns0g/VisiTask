<?php
	include("connection.php");

	$project_id = $_POST["project_ID"];

	$position = $_POST["position"];
	$position = explode(',',$position);

	$request = "INSERT INTO tasks(xPos,yPos,project_ID,status_ID) VALUES('$position[0]','$position[1]',$project_id,1);";
	echo $request;

	if(mysqli_query($conn,$request)){
		echo "<script>history.back();</script>";
	}
	else{
		echo "HOUVE UM ERRO";
	}
?>
