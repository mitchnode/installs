<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/installs_function.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['search'])) {
    $search = $_POST['search'];
	$result = search_installs($mysqli,$search);
	
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: ../search.php');
}
?>