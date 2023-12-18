<?php
include_once 'includes/db_connect.php';
include 'includes/global.php';
include 'includes/fpdm.php';

$id = $_POST['id'];
$contact_name = $_POST['contact_name'];
$contact_email = $_POST['contact_email'];
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

	$pdf = new FPDM('includes/General Information.pdf');
	
	// email stuff (change data below)
	$to = $contact_email;
	$from = "demo@demo.com";
	$send_cc = $cc_email;
	$subject = "New Order Confirmation - " . $row['customer']; 
	
	$full_message = 'Hi '.$contact_name.','.$message;
	$new_message = nl2br($full_message);
	
	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	// carriage return type (we use a PHP end of line constant)
	$eol = PHP_EOL;

	// encode data (puts attachment in proper format)
	$pdfdoc = $pdf->Output("", "S");
	$attachment = 'includes/General Information.pdf';

	$body .= $new_message.$eol;

	// send message
	$result = send_mail($to, $subject, $body, $send_cc, $from,'');
	if($result == true){
		$updated = update_welcome($mysqli,$id);
		header('Location: currentinstalls.php?success=6');
	}
?>