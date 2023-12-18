<!DOCTYPE html>

<?php
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
	include_once 'includes/functions_theme.php';
	include_once 'includes/installs_function.php';
	sec_session_start();
		
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
	  <title>Installs</title>
    </head>

    <body>
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>  
  <nav>
		<div class="nav-wrapper">
			<form action="result.php" method="post" name="search_form">
				<div style="width:95%" class="left input-field">
					
					<input id="search" type="search" name="search" required autofocus>
					
					<label for="search"><i class="material-icons">search</i></label>						
				</div>
				<div class="right">
					<a href="index.php"><i class="material-icons">close</i></a>
				</div>
			</form>
			
		</div>
	</nav>
</body>
</html>

	