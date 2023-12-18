<?php
include_once 'includes/db_connect.php';
require('includes/fpdm.php');

$id = $_POST['id'];
$name = $_POST['name'];
$username = $_POST['username'];
	
	if(isset($_POST['upload']) && $_FILES['pdf_doc']['size'] > 0){
		$fileName = $_FILES['pdf_doc']['name'];
		$tmpName  = $_FILES['pdf_doc']['tmp_name'];
		$fileSize = $_FILES['pdf_doc']['size'];
		$fileType = $_FILES['pdf_doc']['type'];
		$content = file_get_contents($_FILES['pdf_doc']['tmp_name']);

		$sql = "INSERT INTO `install_docs` (key_id, name, size, type, content) VALUES (?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($sql);
		$statement->bind_param('isiss', $id, $name, $fileSize, $fileType, $content);
		if($statement->execute()){
			$results = true;
			header('Location: currentinstalls.php?pdf_docs=true&id='.$id);
		}else{
			die('Error : ('. $mysqli->errno .') '. $mysqli->error);
			$results = false;
			header('Location: currentinstalls.php?fail=2');
		}
	} else {
		header('Location: currentinstalls.php?fail=3');
	}
	
	

?>