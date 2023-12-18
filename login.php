<?php
include_once '/includes/db_connect.php';
include_once '/includes/functions.php';

//sec_session_start();
session_destroy();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Installs: Log In</title>
        <!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
	<body class="grey darken-2">
		<!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
		
		<?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>
	<div class="row">
    <div class="col m6 l4 s10 offset-l4 offset-m3 offset-s1 z-depth-4 card-panel login">
      <form action="includes/process_login.php" method="post" name="login_form">
        <div class="row"><div class="input-field col m12 s12 l12 center"><img src="img/logo.png" alt="" class="responsive-img valign profile-image-login"></div></div>
        <div class="row"><div class="input-field col m12 s12 l12"><label for="email">Email</label><input id="email" type="text" name="email"></div></div>
        <div class="row"><div class="input-field col m12 s12 l12"><label for="password">Password</label><input id="password" type="password" name="password" value=" "></div></div>
		<div class="row"><div class="input-field col m6 s6 l6 offset-l3 offset-m3 offset-s3"><button type="submit" class="btn waves-effect waves-light grey darken-2 fill" onclick="formhash(this.form, this.form.password);">Login</button></div></div>
      </form>
    </div>
	</div>
  
		
		
		
    </body>
</html>