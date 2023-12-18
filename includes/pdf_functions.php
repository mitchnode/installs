<?php

function create_relocation_pdf($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$comments,$install_date,$install_time,$pickup_date,$pickup_time){

require('fpdm.php');


// Convert Date Format
$install_date = date('d/m/Y', strtotime($install_date));
$pickup_date = date('d/m/Y', strtotime($pickup_date));
$install_time = date('g:i a', strtotime($install_time));
$pickup_time = date('g:i a', strtotime($pickup_time));

$fields = array(
    'pickup_add'    => $pickup_add,
    'delivery_add' => $delivery_add,
    'company'    => $company,
	'contact' => $contact,
    'phone'   => $phone,
	'level'   => $level,
	'steps'   => $steps,
	'site_details'   => $site_details,
	'model'   => $model,
	'serial'   => $serial,
	'finisher'   => $finisher,
	'comments'   => $comments,
	'install_date'   => $install_date,
	'install_time'   => $install_time,
	'pickup_date'   => $pickup_date,
	'pickup_time'   => $pickup_time
);
$pdf_output = 'relocation_flatten.pdf';
$pdf_url = 'includes/export/cache/relocation.pdf';
$pdf = new FPDM('includes/relocatetemp.pdf');
$pdf->Load($fields, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
$pdf->Merge();
$pdf->Output($pdf_url, 'F');
$pdf->flatten();
$pdf->Output($pdf_url, 'F', $fields,$pdf_output);
$pdf_new = new FPDM($pdf_url);

return $pdf_new;
}

function send_relocation_pdf($company,$pdf,$send_cc,$pickup_date,$pickup_time,$comments,$user){
	$pickup_date = date('d/m/Y', strtotime($pickup_date));
	$pickup_time = date('g:i a', strtotime($pickup_time));
	// email stuff (change data below)
	$to = "courier@courier.com";
	$from = "demo@demo.com"; 
	$send_cc = 'courier2@courier.com';
	$subject = "Machine Relocation - " . $company; 
	$message = "Hi<br><br>Attached are the details for a machine we require to be Relocated " . $pickup_date . " at " . $pickup_time."<br><br>";
	$message .= $comments;
	$message .= "<br><br>If any more info is required please let me know.<br><br>";
	$message .= "Regards<br>";
	$message .= "<table style='FONT-SIZE: 10pt; COLOR: #505050; FONT-FAMILY: 'Calibri' '> <tr><td style='border-right: 1px solid black; background-color:#FFFFFF;'></td></tr></table>";

	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	// carriage return type (we use a PHP end of line constant)
	$eol = PHP_EOL;

	// encode data (puts attachment in proper format)
	$pdfdoc = $pdf->Output("", "S");
	$attachment = 'includes/export/cache/relocation.pdf';
		
	$body .= $message.$eol;

	// send message
	$result = send_mail($to, $subject, $body, $send_cc, $from, $attachment);
	return $result;
}

//
//INSTALL DELIVERY PDF
//

function create_delivery_pdf($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$tradein_check,$tradein,$tradein_return,$comments,$install_date,$install_time,$pickup_date,$pickup_time){

require('fpdm.php');


// Convert Date Format
$install_date = date('d/m/Y', strtotime($install_date));
$pickup_date = date('d/m/Y', strtotime($pickup_date));
$install_time = date('g:i a', strtotime($install_time));
$pickup_time = date('g:i a', strtotime($pickup_time));

$fields = array(
    'pickup_add'    => $pickup_add,
    'delivery_add' => $delivery_add,
    'company'    => $company,
	'contact' => $contact,
    'phone'   => $phone,
	'level'   => $level,
	'steps'   => $steps,
	'site_details'   => $site_details,
	'model'   => $model,
	'serial'   => $serial,
	'finisher'   => $finisher,
	'CheckBox1' => $tradein_check,
	'trade-in' => $tradein,
	'trade-in-return' => $tradein_return,
	'comments'   => $comments,
	'install_date'   => $install_date,
	'install_time'   => $install_time,
	'pickup_date'   => $pickup_date,
	'pickup_time'   => $pickup_time
);

$pdf_output = 'delivery_flatten.pdf';
$pdf_url = 'includes/export/cache/delivery.pdf';
$pdf = new FPDM('includes/deliverytemp.pdf');
$pdf->Load($fields, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
$pdf->Merge();
$pdf->Output($pdf_url, 'F');
$pdf->flatten();
$pdf->Output($pdf_url, 'F', $fields,$pdf_output);
$pdf_new = new FPDM($pdf_url);

return $pdf_new;
}

function send_delivery_pdf($company,$pdf,$send_cc,$install_date,$install_time,$comments,$user){
	$install_date = date('d/m/Y', strtotime($install_date));
	$install_time = date('g:i a', strtotime($install_time));
	// email stuff (change data below)
	$to = "courier@courier.com";
	$from = "demo@demo.com";
	$send_cc = 'courier2@courier.com';
	$subject = "Machine Delivery - " . $company; 
	$message = "Hi<br><br>Attached are the details for a machine we require to be Delivered " . $install_date . " at " . $install_time."<br><br>";
	$message .= $comments;
	$message .= "<br><br>If any more info is required please let me know.<br><br>";
	$message .= "Regards<br>";
	$message .= "<table style='FONT-SIZE: 10pt; COLOR: #505050; FONT-FAMILY: 'Calibri' '> <tr><td style='border-right: 1px solid black; background-color:#FFFFFF;'></td></tr></table>";

	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	// carriage return type (we use a PHP end of line constant)
	$eol = PHP_EOL;

	// encode data (puts attachment in proper format)
	$pdfdoc = $pdf->Output("", "S");
	$attachment = 'includes/export/cache/delivery.pdf';

	
	$body .= $message.$eol;

	// send message
	$result = send_mail($to, $subject, $body, $send_cc, $from, $attachment);
	return $result;
}

// NETWORK DATA SHEET PDF

function create_install_pdf($id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$install_date,$reading_c,$reading_b,$comments){

require('fpdm.php');


// Convert Date Format
$install_date = date('d/m/Y', strtotime($install_date));

$fields = array(
	'id' => $id,
	'model' => $model.' - '.$option1.' '.$option2.' '.$option3.' '.$option4.' '.$option5.' '.$option6.' '.$option7.' '.$option8.' '.$option9.' '.$option10,
	'serial' => $serial,
	'customer' => $customer,
	'address' => $address,
	'contact' => $contact,
	'phone' => $phone,
	'fax' => $fax,
	'sales_rep' => $sales_rep,
	'ip' => $ip,
	'sn' => $sn,
	'gw' => $gw,
	'dns' => $dns,
	'smtp' => $smtp,
	'smtp_user' => $smtp_user,
	'smtp_pass' => $smtp_pass,
	'email' => $email,
	'scan_folder' => $scan_folder,
	'scan_server' => $scan_server,
	'scan_path' => $scan_path,
	'scan_user' => $scan_user,
	'scan_pass' => $scan_pass,
	'it_contact' => $it_contact,
	'it_phone' => $it_phone,
	'install_date' => $install_date,
	'reading_c' => $reading_c,
	'reading_b' => $reading_b,
	'comments' => $comments
);
$pdf_output = 'install_flatten.pdf';
$pdf_url = 'includes/export/cache/install.pdf';
$pdf = new FPDM('includes/installtemp.pdf');
$pdf->Load($fields, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
$pdf->Merge();
$pdf->Output($pdf_url, 'F');
$pdf->flatten();
$pdf->Output($pdf_url, 'F', $fields,$pdf_output);
$pdf_new = new FPDM($pdf_url);

return $pdf_new;
}

function get_pdf($key_id,$mysqli){
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT * FROM installs WHERE key_id = " . $key_id;
	$result = $mysqli->query($sql);
		// Output
	$row = $result->fetch_assoc();
	$pdf_doc1 = $row['pdf_docs'];
	header("Content-type: application/pdf");
	header("Content-Disposition: inline; filename=".$row['id']."install.pdf");
	echo $pdf_doc1;
}

function get_docs($id,$mysqli){
	$docs = '';
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT * FROM install_docs WHERE key_id = " . $id;
	$result = $mysqli->query($sql);
		// Output
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$docs .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
	} else {
		$docs .= '<option disabled>No Documents Available</option>';
	}
	return $docs;
}
?>
