<?php
include 'db_connect.php';

if (isset($_GET['delete'])) {
	if (isset($_GET['id'])){
		$id = $_GET['id'];
		// Check connection
		if ($mysqli->connect_errno){
			die("Failed to connect to MySQL: " . $mysqli->connect_error);
			$results = false;
		}
		else {
		$status = 'Complete';
		// Perform UPDATE
		$sql = "UPDATE `todo` SET status = ? WHERE id=". $id;
		echo $sql;
		$statement = $mysqli->prepare($sql);
		$statement->bind_param('s',$status);
		if($statement->execute()){
			$results = true;
			echo "done";
		}else{
			die('Error : ('. $mysqli->errno .') '. $mysqli->error);
			$results = false;
		}}}
	
} else {
	$user = $_POST['user'];
	$task = $_POST['task'];
	
		// Check connection
		if ($mysqli->connect_errno){
			die("Failed to connect to MySQL: " . $mysqli->connect_error);
			$results = false;
		}
		else {
		// Perform INSERT
		$sql = "INSERT INTO todo (task,user) VALUES (?, ?)";
		
		$statement = $mysqli->prepare($sql);
		echo $sql;
		$statement->bind_param('ss',$task,$user);
		if($statement->execute()){
			$results = true;
		}else{
			die('Error : ('. $mysqli->errno .') '. $mysqli->error);
			$results = false;
		}
		}
}
header('Location: ../home.php?TODO=1');
?>