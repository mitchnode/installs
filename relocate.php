<?php
include 'includes/global.php';

$relocation_id = $_POST['relocation_id'];
$pickup_add = $_POST['pickup_add'];
$delivery_add = $_POST['delivery_add'];
$company = $_POST['company'];
$contact = $_POST['contact'];
$phone = $_POST['phone'];
$level = $_POST['level'];
$steps = $_POST['steps'];
$site_details = $_POST['site_details'];
$model = $_POST['model'];
$serial = $_POST['serial'];
$finisher = $_POST['finisher'];
$comments = $_POST['comments'];
$install_date = $_POST['install_date'];
$install_time = $_POST['install_time'];
$pickup_date = $_POST['pickup_date'];
$pickup_time = $_POST['pickup_time'];
$sendpdf = $_POST['delivery_button'];
$status = $_POST['status'];
$user = $_POST['user'];
$send_to = $_POST['email'];
$printpdf = $_POST['print_pdf'];
$category = $_POST['category'];

if ($relocation_id == "0"){
	$result = new_relocation($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user,$mysqli,$category);
	if ($result == false){
		echo 'Error!!!!!';
	} else {
		header('Location: relocations.php?success=2');
	}
} else{
	$result = update_relocation($relocation_id,$pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user,$mysqli,$category);
	if ($result == false){
		echo 'Error!!!!!';
	} else {
		if($printpdf == true) {
			$pdf = create_relocation_pdf($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$comments,$install_date,$install_time,$pickup_date,$pickup_time);
			$pdf->Output();
		}		
		if($sendpdf == true){
			$pdf = create_relocation_pdf($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$comments,$install_date,$install_time,$pickup_date,$pickup_time);
			$sendresult = send_relocation_pdf($company,$pdf,$send_to,$pickup_date,$pickup_time,$comments,$user);
			if($sendresult == true){
				header('Location: relocations.php?success=1&send=1');
			} elseif($sendresult == false) {
				header('Location: relocations.php?success=1&send=2');
			}
			
		}else{
			header('Location: relocations.php?success=1&send=0');
		}
		
	}
}


?>