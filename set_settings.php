<?php
include_once 'includes/db_connect.php';
include_once 'includes/installs_function.php';
include_once 'includes/pdf_functions.php';

$company = $_POST['company'];
$phone = $_POST['phone'];
$it_email = $_POST['it_email'];

if (isset($_POST['save_button'])){
	$result = set_settings($mysqli,$company,$phone,$it_email);
	header('Location: settings.php?saved='.$result);
} elseif (isset($_POST['close_button'])) {
	header('Location: index.php');
}

?>