<?php
include_once 'includes/functions.php';
sec_session_start();
echo '1';
// Unset all session values 
$_SESSION = array();
echo '2'; 
// get session parameters 
$params = session_get_cookie_params();
echo '3';
// Delete the actual cookie. 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
echo '4';
// Destroy session 
session_destroy();
echo '5';
header('Location: login.php');
?>