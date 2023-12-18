<?php
include 'includes/global.php';

sec_session_start();
?>
        <?php if (login_check($mysqli) == true) : 
				if (isset($_GET['year'])){
					$year = $_GET['year'];
				} else {
					$date = time();
					$year = date('Y', $date);
				} 
				if (isset($_GET['day'])){
					$day = $_GET['day'];
				} else {
					$date = time();
					$day = date('d', $date);
				}
				if(isset($_GET['month'])){
					$month = $_GET['month'];
				} else {
					$date = time() ;
					$month = date('m', $date);
				}
				$username = htmlentities($_SESSION['username']);
				$url = 'home.php';
				$title = 'Calendar';
				$welcome = '<br>';
				if (isset($_GET['d'])){
					$content = get_day_layout($mysqli,$month, $day, $year);
				} elseif (isset($_GET['w'])) {
					$content = get_week_layout($mysqli,$month, $day, $year);
				} else {
					$content = get_calendar_layout($mysqli,$month,$year);
				}
				$box = '';
				if (isset($_GET['id'])) {
					$id = $_GET['id'];
					if (isset($_GET['date'])) {
						$date = $_GET['date'];
					} else {
						$date="0";
					}
					$content = get_event($mysqli,$id,$date,$username);
				} else {
				}
				
				if (isset($_GET['success'])) {
					$box = event_success_box($_GET['success']);
				} else {
					
				}
        else : 
				header('Location: login.php');
        endif; ?>

<?php include('main.php');?>