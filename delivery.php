<?php
include 'includes/global.php';

$delivery_id_posted = $_POST['delivery_id'];
$key_id = $_POST['key_id'];
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
$tradein_check = $_POST['tradein_check'];
$tradein = $_POST['tradein'];
$tradein_return = $_POST['tradein_return'];
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


if ($delivery_id_posted == "0"){
	$result = new_delivery($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$tradein_check,$tradein,$tradein_return,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user,$mysqli,$key_id,$category);
	if ($result == false){
		echo 'Error!!!!!';
		echo "Delivery ID: " . $delivery_id_posted . "<br>";
		echo "Customer: " . $company;
	} else {
			header('Location: installs.php?success=4');
	}
} else{
	$result = update_delivery($key_id,$delivery_id_posted,$pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$tradein_check,$tradein,$tradein_return,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user,$mysqli,$category);
	if ($result == false){
		echo 'Error!!!!!';
		echo "Delivery ID: " . $delivery_id_posted . "<br>";
		echo "Customer: " . $company;
	} else {
		if($printpdf == true) {
			$pdf = create_delivery_pdf($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$tradein_check,$tradein,$tradein_return,$comments,$install_date,$install_time,$pickup_date,$pickup_time);
			$pdf->Output();
		} else {
		if($sendpdf == true){
			$pdf = create_delivery_pdf($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$tradein_check,$tradein,$tradein_return,$comments,$install_date,$install_time,$pickup_date,$pickup_time);
			$sendresult = send_delivery_pdf($company,$pdf,$send_to,$install_date,$install_time,$comments,$user);
			if($sendresult == true){
				header('Location: installs.php?success=3&send=1');
			} elseif($sendresult == false) {
				header('Location: installs.php?success=3&send=2');
			}
		}else{
			header('Location: installs.php?success=3&send=0');
		}
		}
	}
}


?>