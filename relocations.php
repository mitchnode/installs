<?php
include 'includes/global.php';

sec_session_start();
?>
<?php if (login_check($mysqli) == true) : 
				$box = '';
				$username = htmlentities($_SESSION['username']);
				$email = htmlentities($_SESSION['email']);
				$title = 'Relocations';
				// Get Relocations Table
				$content = get_relocations_main($mysqli);
				//Get ID of Relocation
				if (isset($_GET['id'])) {
					$id = $_GET['id'];
				} else {
					$id = "0";
				}
				if (isset($_GET['iid'])) {
					$iid = $_GET['iid'];
				} else {
					$iid = "0";
				}
				// GET r to display Relocation Box
				if (isset($_GET['r'])) {
					$box = relocation($mysqli,$id,$username,$email,$iid);
				} else {
					$r = false;
					$box = '';
				}
				// Get success to display success box
				if (isset($_GET['success'])) {
					if(isset($_GET['send'])) {
						$box = success_box_relocation($_GET['success'],$_GET['send']);
					}else{
						$box = success_box_relocation($_GET['success'],0);
					}
				} else {
					
				}
				if (isset($_GET['request'])) {
					$box = request_relocation($username);
				} else{
				
				}
				if(isset($_GET['fail'])) {
					$box = fail_box($_GET['fail']);
				} else {
				
				}
        else : 
				header('Location: login.php');
        endif; ?>

<?php include('main.php'); ?>