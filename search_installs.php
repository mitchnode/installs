<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/functions_theme.php';
include_once 'includes/installs_function.php';
include_once 'includes/relocations_function.php';

sec_session_start();
?>
<?php 
		if (login_check($mysqli) == true) { 	
				$box = '';
				$search = $_POST['search'];
				$username = htmlentities($_SESSION['username']);
				$email = htmlentities($_SESSION['email']);
				$url = 'home.php';
				$title = 'Search Installs';
				$welcome = '<br>';
				// Get Installs Table
				if (isset($_POST['search_installs'])){
					$content = search_installs($mysqli,$search);
				}
				if (isset($_POST['search_relocations'])){
					$content = search_relocations($mysqli,$search);
				}
       } else { 
				$username = '';
				$url = 'login.php';
				$title = 'Unauthorized';
				$welcome = '<p><span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.</p>';
				$content = '';
				$box = '';
        } 
?>

<?php include('double.php'); ?>