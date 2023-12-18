<?php
include_once 'includes/db_connect.php';
include_once 'includes/installs_function.php';

$key_id = $_POST['key_id'];

$sql = "SELECT delivery_id FROM deliveries WHERE key_id = " . $key_id;
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$delivery_id = $row['delivery_id'];
} else {
	$delivery_id = "0";
}
header('Location: installs.php?id='.$key_id.'&did='.$delivery_id);
?>