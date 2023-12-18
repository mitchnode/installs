<?php
include 'includes/global.php';

sec_session_start();
?>
        <?php if (login_check($mysqli) == true) : 	
				$box = '';
				$username = htmlentities($_SESSION['username']);
				$email = htmlentities($_SESSION['email']);
				$login_type = htmlentities($_SESSION['group']);
				$title = 'Installs';
				if (isset($_GET['tv'])) {
					$tv = true;
				} else {
					$tv = false;
				}
				$content = get_current_installs_main($mysqli,$tv);
				if($login_type=='runups'){
					header('Location: currentrunups.php');
				}
				if (isset($_GET['id'])) {
					$id = $_GET['id'];
				} else {
					$id = "0";
				}
				if (isset($_GET['did'])) {
					$did = $_GET['did'];
					$box = delivery($mysqli,$did,$username,$email,$id);
				} else {
					$did = "0";
				}
				
				if (isset($_GET['i'])) {
					$box = install($mysqli,$id,$username);
				} else {
				}
				if (isset($_GET['d'])) {
					$box = install($mysqli,$id,$username,true);
				}
				// Get success to display success box
				if(isset($_GET['send'])) {
					$send = $_GET['send'];
				} else {
					$send = "0";
				}
								
				if (isset($_GET['success'])) {
					$box = success_box($_GET['success'],$send);
				} else {
					
				}
				if(isset($_GET['o'])) {
					$box = option_box($id);
				} else {}
				if(isset($_GET['it'])) {
					$box = request_it_box($mysqli,$id,$username);
				} else {}
				if(isset($_GET['pdf_docs'])){
					$box = pdf_docs($id,$username,$mysqli);
				} else {}
        else : 
				header('Location: login.php');
        endif; ?>

<?php include('main.php'); ?>
