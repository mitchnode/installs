<?php
include 'includes/global.php';

$duplicate = '';
$relocate = '';
$request_it = '';
$get_pdf = '';
$welcome_email = '';


$key_id = $_POST['key_id'];
$id = $_POST['id'];
$model = $_POST['model'];
$serial = $_POST['serial'];
$option1 = $_POST['option1'];
$option2 = $_POST['option2'];
$option3 = $_POST['option3'];
$option4 = $_POST['option4'];
$option5 = $_POST['option5'];
$option6 = $_POST['option6'];
$option7 = $_POST['option7'];
$option8 = $_POST['option8'];
$option9 = $_POST['option9'];
$option10 = $_POST['option10'];
if(isset($_POST['option1check'])){$option1check = $_POST['option1check'];}else{$option1check ='';}
if(isset($_POST['option2check'])){$option2check = $_POST['option2check'];}else{$option2check ='';}
if(isset($_POST['option3check'])){$option3check = $_POST['option3check'];}else{$option3check ='';}
if(isset($_POST['option4check'])){$option4check = $_POST['option4check'];}else{$option4check ='';}
if(isset($_POST['option5check'])){$option5check = $_POST['option5check'];}else{$option5check ='';}
if(isset($_POST['option6check'])){$option6check = $_POST['option6check'];}else{$option6check ='';}
if(isset($_POST['option7check'])){$option7check = $_POST['option7check'];}else{$option7check ='';}
if(isset($_POST['option8check'])){$option8check = $_POST['option8check'];}else{$option8check ='';}
if(isset($_POST['option9check'])){$option9check = $_POST['option9check'];}else{$option9check ='';}
if(isset($_POST['option10check'])){$option10check = $_POST['option10check'];}else{$option10check ='';}
$customer = $_POST['customer'];
$address = $_POST['address'];
$contact = $_POST['contact'];
$phone = $_POST['phone'];
$fax = $_POST['fax'];
$sales_rep = $_POST['sales_rep'];
$ip = $_POST['ip'];
$sn = $_POST['sn'];
$gw = $_POST['gw'];
$dns = $_POST['dns'];
$smtp = $_POST['smtp'];
$smtp_user = $_POST['smtp_user'];
$smtp_pass = $_POST['smtp_pass'];
$email = $_POST['email'];
$scan_folder = $_POST['scan_folder'];
$scan_server = $_POST['scan_server'];
$scan_path = $_POST['scan_path'];
$scan_user = $_POST['scan_user'];
$scan_pass = $_POST['scan_pass'];
$it_contact = $_POST['it_contact'];
$it_phone = $_POST['it_phone'];
$comments = $_POST['comments'];
$install_date = $_POST['install_date'];
$reading_c = $_POST['reading_c'];
$reading_b = $_POST['reading_b'];
$status = $_POST['status'];
$paperwork_rec = $_POST['paperwork_rec'];
$it_status = $_POST['it_status'];
if(isset($_POST['progress_finance'])){$progress_finance = $_POST['progress_finance'];}else{$progress_finance ='';}
if(isset($_POST['progress_it'])){$progress_it = $_POST['progress_it'];}else{$progress_it ='';}
if(isset($_POST['progress_runup'])){$progress_runup = $_POST['progress_runup'];}else{$progress_runup ='';}
if(isset($_POST['progress_booked'])){$progress_booked = $_POST['progress_booked'];}else{$progress_booked ='';}
if(isset($_POST['progress_installed'])){$progress_installed = $_POST['progress_installed'];}else{$progress_installed ='';}
$user = $_POST['username'];
$optionfail = false;
if(isset($_POST['duplicate'])){$duplicate = true;}
if(isset($_POST['relocate'])){$relocate = $_POST['relocate'];}
if(isset($_POST['request_it'])){$request_it = $_POST['request_it'];}
if(isset($_POST['add_pdf'])){$add_pdf = $_POST['add_pdf'];}
if(isset($_POST['welcome'])){$welcome_email = true;}

if (isset($_POST['delivery_button'])) {
	$result = update_install($key_id,$id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$option1check,$option2check,$option3check,$option4check,$option5check,$option6check,$option7check,$option8check,$option9check,$option10check,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$comments,$install_date,$reading_c,$reading_b,$status,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed,$paperwork_rec,$user,$mysqli);
	if ($result == false){
		echo 'Error!!!!!';
	} else {
		if($option1 !== "" and $option1check !== "Yes"){
			$optionfail = true;
		}
		if($option2 !== "" and $option2check !== "Yes"){
			$optionfail = true;
		}
		if($option3 !== "" and $option3check !== "Yes"){
			$optionfail = true;
		}
		if($option4 !== "" and $option4check !== "Yes"){
			$optionfail = true;
		}
		if($option5 !== "" and $option5check !== "Yes"){
			$optionfail = true;
		}
		if($option6 !== "" and $option6check !== "Yes"){
			$optionfail = true;	
		}
		if($option7 !== "" and $option7check !== "Yes"){
			$optionfail = true;
		}
		if($option8 !== "" and $option8check !== "Yes"){
			$optionfail = true;
		}
		if($option9 !== "" and $option9check !== "Yes"){
			$optionfail = true;	
		}
		if($option10 !== "" and $option10check !== "Yes"){
			$optionfail = true;
		}
		if ($optionfail == true){
			header('Location: installs.php?i=true&o=true&id='.$key_id);	
		}else{	
			$sql = "SELECT delivery_id FROM deliveries WHERE key_id = " . $key_id;
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$delivery_id = $row['delivery_id'];
			} else {
				$delivery_id = "0";
			}
			header('Location: installs.php?id='.$key_id.'&did='.$delivery_id);
		}
	}	
}else if (isset($_POST['save_button'])){
	if ($key_id == "0"){
		$result = new_install($id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$option1check,$option2check,$option3check,$option4check,$option5check,$option6check,$option7check,$option8check,$option9check,$option10check,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$comments,$install_date,$reading_c,$reading_b,$status,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed,$paperwork_rec,$user,$mysqli);
		if ($result == false){
			echo 'Error!!!!!';
		} else {
			header('Location: currentinstalls.php?success=2');
		}
	} else{
		$result = update_install($key_id,$id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$option1check,$option2check,$option3check,$option4check,$option5check,$option6check,$option7check,$option8check,$option9check,$option10check,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$comments,$install_date,$reading_c,$reading_b,$status,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed,$paperwork_rec,$user,$mysqli);
		if ($result == false){
			echo 'Error!!!!!';
		} else {
			header('Location: currentinstalls.php?success=1');
		}
	}
} elseif (isset($_POST['print_pdf'])) {
	$result = update_install($key_id,$id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$option1check,$option2check,$option3check,$option4check,$option5check,$option6check,$option7check,$option8check,$option9check,$option10check,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$comments,$install_date,$reading_c,$reading_b,$status,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed,$paperwork_rec,$user,$mysqli);
	if ($result == false){
		echo 'Error!!!!!';
	} else {
		$pdf = create_install_pdf($id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$install_date,$reading_c,$reading_b,$comments);
		$pdf->Output();
	}


} elseif(isset($_POST['close_button'])){
	header('Location: currentinstalls.php');
} elseif ($duplicate == true){
	header('Location: installs.php?d=true&id='.$key_id);
} elseif ($relocate == true) {
	header('Location: relocation.php?r=true&iid='.$key_id);
} elseif ($request_it == true){
	header('Location: installs.php?it=true&id='.$key_id);
} elseif ($add_pdf == true) {
	header('Location: installs.php?pdf_docs=true&id='.$key_id);
} elseif ($welcome_email == true) {
	header('Location: installs.php?welcome=true&id='.$key_id);
} else {echo 'Something went wrong';}


?>