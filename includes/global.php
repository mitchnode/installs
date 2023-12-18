<?php

//
// Global Variables
//
$content = '';
$box = '';

//
//Global Includes
//
include 'includes/db_connect.php';
include 'includes/functions.php';
include 'includes/pdf_functions.php';
include 'includes/functions_theme.php';
include 'includes/calendar_function.php';
include 'includes/installs_function.php';
include 'includes/relocations_function.php';
include 'includes/phpmailer/class.phpmailer.php';
include 'includes/phpmailer/class.smtp.php';


//
// Global PHP Settings
//
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(1);

?>