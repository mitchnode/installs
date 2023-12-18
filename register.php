<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Registration Form</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" href="login.css" />
    </head>
    <body>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
		<div id="wrap_register">
		<div id="logo"></div>
        <h1>Register New User</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters, spaces and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
                <ul>
                    <li>At least one upper case letter (A..Z)</li>
                    <li>At least one lower case letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>
        <table class="center"><form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" 
                method="post" 
                name="registration_form">
            <tr><td>Username: </td><td><input type='text' 
                name='username' 
                id='username' /></td></tr>
            <tr><td>Email: </td><td><input type="text" name="email" id="email" /></td></tr>
			<tr><td>Group: </td><td><input type="text" list="group" name="group"><datalist id="group"><option value="full"><option value="sales"></datalist></td></tr>
            <tr><td>Password: </td><td><input type="password"
                             name="password" 
                             id="password"/></td></tr>
            <tr><td>Confirm password: </td><td><input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" /></td></tr>
            <tr><td><input id="button" type="button" 
                   value="Register" 
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
								   this.form.group,
                                   this.form.password,
                                   this.form.confirmpwd);"./></td><td><input id="button" type="button" value="Cancel" onclick="javascript:window.location='login.php';"></td></tr>
        </form></table>
		</div>
    </body>
</html>