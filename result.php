<?php
include 'includes/global.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['search'])) {
    $search = $_POST['search'];
	$result = search_installs($mysqli,$search);
	include('header.php');
?>
	<div class="page_container">
		<?php echo $result; ?>
	</div>
<?php
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: ../search.php');
}
?>