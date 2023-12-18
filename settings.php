<?php
include 'includes/global.php';

sec_session_start();
?>
        <?php if (login_check($mysqli) == true) : 	
				$box = '';
				$username = htmlentities($_SESSION['username']);
				$email = htmlentities($_SESSION['email']);
				$title = 'Settings';
				$content = do_settings($mysqli);
				if(ISSET($_GET['saved'])){
					if($_GET['saved']=true){
						$box = '<script>Materialize.toast("Successfully Saved Settings", 4000)</script>';
					} elseif($_GET['saved']=false){
						$box = '<script>Materialize.toast("Fail To Save Settings", 4000)</script>';
					}
				}else{
					$box = '';
				}
        else : 
				header('Location: login.php');
        endif; ?>

<?php include('main.php'); ?>
