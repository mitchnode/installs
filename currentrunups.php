<?php
include 'includes/global.php';

sec_session_start();
?>
        <?php if (login_check($mysqli) == true) : 	
					$username = htmlentities($_SESSION['username']);
					$email = htmlentities($_SESSION['email']);
					$title = 'Run-ups';
					$content = get_current_runups_main($mysqli);
        		else : 
					header('Location: login.php');
        		endif; ?>

<?php include('main.php'); ?>
