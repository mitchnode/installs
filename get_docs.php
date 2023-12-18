<?php
include_once 'includes/db_connect.php';

$key_id = $_POST['key_id'];

	if(isset($_POST['id'])){
		$id = $_POST['id'];
	
		if(isset($_POST['view'])){
			//VIEW CODE
			//Check connection
			if ($mysqli->connect_errno){
				die("Failed to connect to MySQL: " . $mysqli->connect_error);
			}
			// Perform Queries
			$sql = "SELECT * FROM install_docs WHERE id = " . $id;
			$result = $mysqli->query($sql);
				// Output
			$row = $result->fetch_assoc();
			$pdf_doc1 = $row['content'];
			header("Content-Length: ". $row['size']);
			header("Content-Type: ".$row['type']);
			header("Content-Disposition: inline; filename=".$row['name'].".pdf");
			echo $pdf_doc1;
		} elseif(isset($_POST['delete'])){
			//DELETE CODE
			// Test connection to the database
			if ($mysqli->connect_errno){
				die("Failed to connect to MySQL: " . $mysqli->connect_error);
			}
			
			// Delete the record
			$sql = "DELETE from install_docs WHERE id=" .$id;
			$statement = $mysqli->prepare($sql);
			if($statement->execute()){
				$results = true;
			}else{
				die('Error : ('. $mysqli->errno .') '. $mysqli->error);
				$results = false;
			}
			header('Location: currentinstalls.php?pdf_docs=true&id='.$key_id);
		}
	} else {
		header('Location: currentinstalls.php?pdf_docs=true&id='.$key_id);
	}
	

?>