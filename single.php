
<?php include('header.php'); ?>
	<div id="navigation">
		<?php echo do_main_nav($title,$url,$username); ?>
	</div>
	<div id="content">
		<div id="main">
			<?php echo $welcome; ?>
			<?php echo $content; ?>
			
		</div>
		
		<?php
			if (login_check($mysqli) == true) {
				echo '<div id="widgets">';
				include('rightbar.php');
				include('leftbar.php');
				include('middlebar.php');
				echo '</div>';
				
				
				
			}
		?>
		<?php echo $box;	?>
	</div>
<?php include('footer.php'); ?>