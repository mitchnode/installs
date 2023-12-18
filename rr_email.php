<?php
//include_once 'includes/db_connect.php';
include 'includes/global.php';
include 'includes/fpdm.php';

$name = $_POST['name'];
$email = $_POST['email'];
$user = $_POST['user'];

	$pdf = new FPDM('includes/Relocation request.pdf');
	
	// email stuff (change data below)
	$to = $email;
	$from = "demo@demo.com";
	$send_cc ='';
	$subject = "Machine Relocation Request Form"; 
	$message = 'Hi ' . $name . ',<br><br>';
	$message .= 'Please fill out the attached form and return to <a href="mailto:demo@demo.com">demo@demo.com</a> as soon as possible so we can correctly quote you for the relocation of your device.<br><br>'; 
	$message .= "Regards<br>";
	$message .= "<table style='FONT-SIZE: 10pt; COLOR: #505050; FONT-FAMILY: 'Calibri' '> <tr><td style='border-right: 1px solid black; background-color:#FFFFFF;'></td></tr></table>";
 
	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	// carriage return type (we use a PHP end of line constant)
	$eol = PHP_EOL;

	// encode data (puts attachment in proper format)
	$pdfdoc = $pdf->Output("", "S");
	$attachment = 'includes/Relocation request.pdf';
	$body = $message.$eol;

	// send message
	$result = send_mail($to, $subject, $body, $send_cc, $from, $attachment);

	if($result == true){
		header('Location: relocations.php?success=3');
	} else{
		header('Location: relocations.php?fail=1');
	}


?>