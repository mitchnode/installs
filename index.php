<?php
	include 'includes/global.php';
	
	sec_session_start();
	if (login_check($mysqli) == true){
	include('header.php'); 
	//Insert Pages here
	include('home.php');
	include('footer.php'); }
	else {
		header('Location: login.php');
	}
?>