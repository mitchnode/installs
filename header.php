<!DOCTYPE html>
<?php
			
	if (login_check($mysqli) == true){
		$login_type = htmlentities($_SESSION['group']);
		$username = htmlentities($_SESSION['username']);
	} else {
		header('Location: login.php');
	}
?>
  <html>
    <head>
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	  <title><?php echo get_company($mysqli);?> Installs</title>
	  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    </head>
    <body>
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
	  
	  <nav>
			<div class="nav-wrapper">
				<a href="#!" class="brand-logo center"><?php echo get_company($mysqli);?> Installs</a>
				<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
				<ul class="left hide-on-med-and-down">
					<?php 
						if($login_type!='sales'){
							if($login_type=='runups'){
								echo '<li><a href="index.php"><i class="material-icons">home</i></a></li><li><a href="currentrunups.php">Run-ups</a></li>';
							} else {
								echo '<li><a href="search.php"><i class="material-icons">search</i></a></li><li><a href="index.php"><i class="material-icons">home</i></a></li><li><a href="currentinstalls.php?tv"><i class="material-icons">tv</i></a></li><li><a href="currentinstalls.php">Installs</a></li><li><a href="relocations.php">Relocations</a></li><li><a href="currentrunups.php">Run-ups</a></li>';
							}
						} else {
							echo '<li><a href="index.php"><i class="material-icons">home</i></a></li>';
						}
					?>
					<li><a href="calendar.php">Calendar</a></li>
				</ul>
				<?php echo '<ul class="right"><li><a href="login.php"><i class="material-icons left">person</i>'.$username.'</a></li>';
					  if($login_type=='admin'){
						echo '<li><a href="settings.php"><i class="material-icons">settings</i></a></li><li><a href="register.php"><i class="material-icons">add</i></a></li>';
					  }
					  echo '</ul>'; ?>
				<ul class="side-nav" id="mobile-demo">
					<?php 
						if($login_type!='sales'){
							if($login_type=='runups'){
								echo '<li><a href="index.php"><i class="material-icons">home</i></a></li><li><a href="currentrunups.php">Run-ups</a></li>';
							} else {
								echo '<li><a href="search.php"><i class="material-icons">search</i></a></li><li><a href="index.php"><i class="material-icons">home</i></a></li><li><a href="currentinstalls.php">Installs</a></li><li><a href="relocations.php">Relocations</a></li><li><a href="currentrunups.php">Run-ups</a></li>';
							}
						} else {
							echo '<li><a href="index.php"><i class="material-icons">home</i></a></li>';
						}
					?>
					<li><a href="calendar.php">Calendar</a></li>
				<?php echo '<ul class="right"><li><a href="login.php"><i class="material-icons left">person</i>'.$username.'</a></li>';
					  if($login_type=='admin'){
						echo '<li><a href="settings.php"><i class="material-icons">settings</i></a></li><li><a href="register.php"><i class="material-icons">add</i></a></li>';
					  }
					  echo '</ul>'; ?>
				</ul>
			</div>
		</nav>
		<script type="text/javascript">$(".button-collapse").sideNav();</script>