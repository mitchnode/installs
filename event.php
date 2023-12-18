<?php
include_once 'includes/db_connect.php';
include_once 'includes/installs_function.php';
include_once 'includes/pdf_functions.php';
include_once 'includes/calendar_function.php';

$allday = null;
$id = $_POST['id'];
$title = $_POST['title'];
$location = $_POST['location'];
$start = $_POST['start'];
$end = $_POST['end'];
$date = $_POST['date'];
$event_comments = $_POST['comments'];
$allday = $_POST['allday'];
$category = $_POST['category'];
$username = $_POST['username'];

if(isset($_POST['delete'])){
	delete_calendar_event($mysqli,$id);
	header('Location: calendar.php?success=2');
} else {
	$result = manual_event($mysqli,$title,$location,$event_comments,$start,$end,$date,$allday,$category,$id,$username);
	if ($result == false){
		echo 'Error!!!!!';
	} else {
		header('Location: calendar.php?success=1');
	}
}
?>