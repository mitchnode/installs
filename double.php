
<?php include('header.php'); ?>
	<div id="navigation">
		<?php /* echo do_main_nav($title,$url,$username); */ ?>
	</div>
	<div id="content">
		<div id="main_double">
			<?php echo $welcome; ?>
			<?php echo '<h2>'.$title.'</h2><br>'; ?>
			<?php echo $content; ?>
			<?php echo $box;	?>
		</div>
	</div>
<?php include('footer.php'); ?>