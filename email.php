<?php
include_once 'includes/db_connect.php';
include 'includes/global.php';

$id = $_POST['id'];
$it_name = $_POST['it_name'];
$it_email = $_POST['it_email'];
$user = $_POST['user'];
$message = $_POST['message'];
$cc_email = $_POST['cc_email'];

//Check connection
if ($mysqli->connect_errno){
	die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
// Perform Queries
$sql = "SELECT * FROM installs WHERE key_id = " . $id;
$result = $mysqli->query($sql);
// Output
$row = $result->fetch_assoc();

	// email stuff (change data below)
	$to = $it_email;
	$from = "demo@demo.com";
	$send_cc = $cc_email;
	$subject = "Request for IT  Information - " . $row['customer']; 
	
	$full_message = 'Hi '.$it_name.','.$message;
	$new_message = nl2br($full_message);
	
	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	// carriage return type (we use a PHP end of line constant)
	$eol = PHP_EOL;
	$body .= $new_message.$eol;
	// send message
	$result = send_mail($to, $subject, $body, $send_cc, $from,'');
	if($result == true){
		header('Location: currentinstalls.php?success=5');
	}
?>