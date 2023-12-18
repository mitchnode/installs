<?php
		
	//Create Schedule Widget for Sidebar
	function do_schedule($id,$title,$location,$date,$time,$category){
		
		//Convert Date to display format
		$date = date('d/m/Y', strtotime($date));
		$time = date('h:ia', strtotime($time));
		
		$items_array = 		'<td><a href="calendar.php?id=' . $id . '">' . $title . '</a></td>' .
							'<td><a href="calendar.php?id=' . $id . '">' . $location . '</a></td>' .
							'<td><a href="calendar.php?id=' . $id . '">' . $date . '</a></td>' .
							'<td><a href="calendar.php?id=' . $id . '">' . $time . '</a></td>' .
							'<td class="hide_col"><a href="calendar.php?id=' . $id . '">' . $category . '</a></td>'
							;
							
		return $items_array;
	}
	
	//Create Main Installs Table
	function do_current_installs_main($key_id,$id,$customer,$phone,$model,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$sales_rep,$install_date,$status,$user,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed,$paperwork_rec, $tv = false){
		
		//Convert Install Date to display format
		if($install_date != null){
			$install_date = date('d/m/Y', strtotime($install_date));
		}
		if($paperwork_rec != null){
			$paperwork_rec = date('d/m/Y', strtotime($paperwork_rec));
		}
				
		$items_array = 		'<td class=';
		if ($tv == true){
			$items_array .= '"always_hide_col"';
		} else {
			$items_array .= '"hide_col"';
		}
		$items_array .= '><a href="installs.php?i=true&id=' . $key_id . '">' . $id . '</a></td>' .
							'<td><a href="installs.php?i=true&id=' . $key_id . '">' . $customer . '</a></td>' .
							'<td><a href="installs.php?i=true&id=' . $key_id . '">' . $model;
		$items_array .= '</a></td>' .
							'<td class=';
		if ($tv == true){
			$items_array .= '"always_hide_col"';
		} else {
			$items_array .= '"hide_col"';
		}
		$items_array .= '><a href="installs.php?i=true&id=' . $key_id . '">' . $sales_rep . '</a></td>' .
							'<td><a href="installs.php?i=true&id=' . $key_id . '">' . $paperwork_rec . '</a></td>' .
							'<td><a href="installs.php?i=true&id=' . $key_id . '">' . $install_date . '</a></td>' .
							'<td><a href="installs.php?i=true&id=' . $key_id . '">' . $status . '</a></td>' .
							'<td id="progress"><a href="installs.php?i=true&id=' . $key_id . '">'; 
							if($progress_finance=="Yes")
								{$items_array .= '<img src="img/tick.png" width=auto>';} 
							$items_array .= '</a></td>' .
							'<td id="progress"><a href="installs.php?i=true&id=' . $key_id . '">'; 
							if($progress_it=="Yes")
								{$items_array .= '<img src="img/tick.png" width=auto>';} 
							$items_array .= '</a></td>' .
							'<td id="progress"><a href="installs.php?i=true&id=' . $key_id . '">'; 
							if($progress_runup=="Yes")
								{$items_array .= '<img src="img/tick.png" width=auto>';} 
							$items_array .= '</a></td>' .
							'<td id="progress"><a href="installs.php?i=true&id=' . $key_id . '">'; 
							if($progress_booked=="Yes")
								{$items_array .= '<img src="img/tick.png" width=auto>';} 
							$items_array .= '</a></td>' .
							'<td class=';
		if ($tv == true){
			$items_array .= '"always_hide_col"';
		} else {
			$items_array .= '"hide_col"';
		}
		$items_array .= '><a href="installs.php?i=true&id=' . $key_id . '">' . get_initials($user) . '</a></td>';
							
		return $items_array;
	}
	
	//Create Main Run-ups Table
	function do_current_runups_main($key_id,$id,$serial,$customer,$phone,$model,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$sales_rep,$install_date,$status,$user,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed){
		
		//Convert Install Date to display format
		if($install_date != null){
			$install_date = date('d/m/Y', strtotime($install_date));
		}
		
		$items_array = 		'<td class="hide_col"><a href="installs.php?i=true&id=' . $key_id . '">' . $id . '</a></td>' .
							'<td><a href="installs.php?i=true&id=' . $key_id . '">' . $customer . '</a></td>' .
							'<td><a href="installs.php?i=true&id=' . $key_id . '">' . $model;
		$items_array .= '</a></td>' .
							'<td><a href="installs.php?i=ture&id=' . $key_id . '">' . $serial . '</a></td>' .
							'<td class="hide_col"><a href="installs.php?i=true&id=' . $key_id . '">' . $sales_rep . '</a></td>' .
							'<td><a href="installs.php?i=true&id=' . $key_id . '">' . $install_date . '</a></td>' .
							'<td><a href="installs.php?i=true&id=' . $key_id . '">' . $status . '</a></td>' .
							'<td id="progress"><a href="installs.php?i=true&id=' . $key_id . '">'; 
							if($progress_finance=="Yes")
								{$items_array .= '<img src="img/tick.png" width=auto>';} 
							$items_array .= '</a></td>' . 
							'<td id="progress"><a href="installs.php?i=true&id=' . $key_id . '">'; 
							if($progress_it=="Yes")
								{$items_array .= '<img src="img/tick.png" width=auto>';} 
							$items_array .= '</a></td>' .
							'<td id="progress"><a href="installs.php?i=true&id=' . $key_id . '">'; 
							'<td id="progress"><a href="installs.php?i=true&id=' . $key_id . '">'; 
							if($progress_booked=="Yes")
								{$items_array .= '<img src="img/tick.png" width=auto>';} 
							$items_array .= '</a></td>' .
							'<td class="hide_col"><a href="installs.php?i=true&id=' . $key_id . '">' . get_initials($user) . '</a></td>';
							
		return $items_array;
	}
	
	function do_relocations_main($relocation_id,$company,$pickup_add,$delivery_add,$contact,$phone,$model,$finisher,$install_date,$status,$user){
		
		//Convert Install Date to display format
		$install_date = date('d/m/Y', strtotime($install_date));
			
		$items_array = 		'<td><a href="relocation.php?r=true&id=' . $relocation_id . '">' . $company . '</a></td>' .
							'<td class="hide_col"><a href="relocation.php?r=true&id=' . $relocation_id . '">' . $contact . '</a></td>' .
							'<td class="hide_col"><a href="relocation.php?r=true&id=' . $relocation_id . '">' . $phone . '</a></td>' .
							'<td><a href="relocation.php?r=true&id=' . $relocation_id . '">' . $model . '</a></td>' .
							'<td class="hide_col"><a href="relocation.php?r=true&id=' . $relocation_id . '">' . $finisher . '</a></td>' .
							'<td><a href="relocation.php?r=true&id=' . $relocation_id . '">' . $install_date . '</a></td>' .
							'<td><a href="relocation.php?r=true&id=' . $relocation_id . '">' . $status . '</a></td>' .
							'<td class="hide_col"><a href="relocation.php?r=true&id=' . $relocation_id . '">' . get_initials($user) . '</a></td>'
							;
							
		return $items_array;
	}
			
	function event_success_box($success) {
		$box .= '<div>Event Successfully ';
		if ($success == 1){
			$box .= 'Saved';
		}elseif ($success == 2){
			$box .= 'Deleted';
		}
		$box .= '<br><br><a class="btn waves-effect waves-light grey darken-2" href="calendar.php">OK</a></div>';
		return $box;
	}
		
	function todo($mysqli,$user){
		$script = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';";
		$script_close = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';";
		
		//Check connection
		if ($mysqli->connect_errno){
			die("Failed to connect to MySQL: " . $mysqli->connect_error);
		}
		// Perform Queries
		$sql = "SELECT * FROM `todo` WHERE `status` is NULL";
		$result = $mysqli->query($sql);
		// Output
		if ($result->num_rows > 0) {
			
			
			while($row = $result->fetch_assoc()) {
				$todo .= $row['task']." <a href='includes/todo.php?id=".$row['id']."&delete=1'><img src='img/x.png' width='12px'></a><br>";
			}
			
		}
		else {
			$todo = "No Tasks to Complete";
		}
		$box = '<div id="light" class="white_content">';
		$box .= 'TODO List: <br><br>';
		$box .= '<form action="includes/todo.php" method="POST">'.$todo;
		$box .= '<br><table><tr><td><textarea cols="100" rows="3" id="task" name="task"></textarea></td></tr></table>';
		$box .= '<input type="hidden" name="user" value="'.$user.'">';
		$box .= '<input type="submit" id="button" name="add_task" value="Add Task"> ';
		$box .= '<input type="button" value="Close" onclick="'. $script_close .'"></form></div><script>'. $script .'</script>';
		return $box;
	}
	
	function request_relocation($user){
		$box .= 'Please Enter the Name and Email Address to send the Relocation Request Form to: <br>';
		$box .= '<form action="rr_email.php" method="POST"><div class="row"><div class="input-field col s12"><label for="name">Name of Contact</label><input name="name" type="text" id="name"></div></div>';
		$box .= '<div class="row"><div class="input-field col s12"><label for="email">Email to Send Request Form</label><input type="email" name="email" id="email"></div></div>';
		$box .= '<input type="hidden" name="user" value="'.$user.'">';
		$box .= '<button class="btn-floating btn-large waves-effect waves-light green darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="Send" name="request" type="submit" value="true"><i class="material-icons">email</i></button> ';
		$box .= '<button class="btn-floating btn-large waves-effect waves-light red darken-2 right tooltipped" data-position="top" data-delay="50" data-tooltip="Close" type="button" name="close_button" onclick="window.location.href=`relocations.php`"><i class="material-icons">close</i></button></form>';
		return $box;
	}
	
	function fail_box($fail){
		$script = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';";
		$script_close = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';";
		$box = '<div id="light" class="white_content">Failed ';
		if ($fail == 1) {
			$box .= 'To Send Email.<br>Please contact your Administrator.';
		} elseif($fail == 2){
			$box .= 'To Upload PDF to Database';
		} elseif($fail == 3){
			$box .= '- Not a Document Valid'; 
		}
		$box .= '<br><br><input type="button" value="Close" onclick="'. $script_close .'"></form></div><script>'. $script .'</script>';
		return $box;	
	}
	
	function pdf_docs($id,$username,$mysqli){
		$script = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';";
		$script_close = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';";
		$box = '<div id="light" class="white_content">';
		
		$box .= '<form method="post" action="get_docs.php">';
		$box .= 'Select Document to view<br><br>';
		$box .= '<select name="id" size="5" class="docs">';
		$box .= get_docs($id,$mysqli);
		$box .= '</select><br>';
		$box .= '<input type="hidden" name="key_id" value="'.$id.'"><input type="submit" name="view" id="button" value="View" formtarget="_blank"> <input type="submit" name="delete" id="button" value="Delete"></form>';
		$box .= '<hr>';
		
		$box .= 'Add PDF Document to Install<br>Please Select PDF File and Click Upload<br><br>';
		$box .= '<form method="post" action="pdf_doc.php" enctype="multipart/form-data"><input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="username" value="'.$username.'"><input type="hidden" name="MAX_FILE_SIZE" value="2000000">Name: <input type="text" name="name" value="Salesdoc"><br><input type="file" name="pdf_doc" accept="application/pdf"><br><br><input type="submit" id="button" name="upload" value="Upload"> ';
		$box .= '<input type="button" value="Close" onclick="'. $script_close .'"></form></div><script>'. $script .'</script>';
		return $box;
	}
	
	//
	// Create Settings Form
	//
	function do_settings($mysqli){
		
		$box = '<form action="set_settings.php" method="POST">';
		$box .= '<div class="row"><div class="input-field col s12"><label for="company">Company Name</label><input id="company" type="text" name="company" required value="' . get_company($mysqli) . '"></div></div>';
		$box .= '<div class="row"><div class="input-field col s12"><label for="phone">Company Phone Number</label><input id="phone" type="text" name="phone" required value="' . get_phone($mysqli) . '"></div></div><br>';
		$box .= '<div class="row"><div class="input-field col s12"><label for="it_email">IT Email Template</label><textarea class="materialize-textarea" cols="104" rows="28" id="it_email" type="text" name="it_email" required>' . get_it_email($mysqli) . '</textarea></div></div>';
		$box .= '<button class="btn-floating btn-large waves-effect waves-light green darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="Save" name="save_button" type="submit" value="true"><i class="material-icons">check</i></button> <button class="btn-floating btn-large waves-effect waves-light red darken-2 right tooltipped" data-position="top" data-delay="50" data-tooltip="Close" type="button" name="close_button" onclick="window.location.href=`index.php`"><i class="material-icons">close</i></button>';
		return $box;
	}
	
	//
	// Create Request IT Form
	//
	function request_it_box($mysqli,$id,$user){
		
		//Check connection
		if ($mysqli->connect_errno){
			die("Failed to connect to MySQL: " . $mysqli->connect_error);
		}
		// Perform Queries
		$sql = "SELECT * FROM installs WHERE key_id = " . $id;
		$result = $mysqli->query($sql);
		// Output
		$row = $result->fetch_assoc();
		$model = $row['model'];
		$customer = $row['customer'];
		$address = $row['address'];
		$install_date = date("l jS F Y", strtotime($row['install_date']));
		
		$message = '&#13;&#13;Thanks for your time today.&#13;&#13;';
	 
		$message .= 'As discussed, we are installing a '. $row['model'] .' at ' . $row['customer'] . ' at ' . $row['address'] . ' on ' . $install_date . '&#13;and require the following information to enable printing and scanning.&#13;'; 
				
		$message .= get_it_email($mysqli);
		
		$message .= "Regards&#13;";
		$message .= "<table style='FONT-SIZE: 10pt; COLOR: #505050; FONT-FAMILY: 'Calibri' '> <tr><td style='border-right: 1px solid black; background-color:#FFFFFF;'></td></tr></table>";
		
		$box = '<h2>Request IT Info</h2>';
		$box .= 'Please Enter the Name and Email Address to send the IT Info request to: <br><br>';
		$box .= '<form action="email.php" method="POST"><div class="row"><div class="input-field col s12"><label for="it_name">Name</label><input name="it_name" type="text" id="it_name"></div></div>';
		$box .= '<div class="row"><div class="input-field col s12"><label for="it_email">Email</label><input type="email" name="it_email" id="it_email"></div></div>';
		$box .= '<div class="row"><div class="input-field col s12"><label for="cc_email">CC</label><input type="email" name="cc_email" id="cc_email"></div></div>';
		$box .= '<div class="row"><div class="input-field col s12"><label for="message">Message</label><textarea class="materialize-textarea" cols="104" rows="28" id="message" name="message">'.$message.'</textarea></div></div>';
		$box .= '<input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="user" value="'.$user.'">';
		$box .= '<button class="btn-floating btn-large waves-effect waves-light yellow darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="Send" name="request" type="submit" value="true"><i class="material-icons">email</i></button> <button class="btn-floating btn-large waves-effect waves-light red darken-2 right tooltipped" data-position="top" data-delay="50" data-tooltip="Close" type="button" name="close_button" onclick="window.location.href=`installs.php?i=true&id='.$id.'`"><i class="material-icons">close</i></button>';
		return $box;
	}
	
	//
	// Welcome Email Form
	//
	function welcome_box($mysqli,$id,$user){
		
		//Check connection
		if ($mysqli->connect_errno){
			die("Failed to connect to MySQL: " . $mysqli->connect_error);
		}
		// Perform Queries
		$sql = "SELECT * FROM installs WHERE key_id = " . $id;
		$result = $mysqli->query($sql);
		// Output
		$row = $result->fetch_assoc();
		
		$message = '&#13;&#13;Thank you for your order for the '. $row['model'] .' to be delivered to the following address:&#13;&#13;';
	 
		$message .= $row['customer'] . '&#13;' . $row['address'] . '&#13;&#13;';
		
		$message .= '<b>If details are incorrect for the above delivery address please reply to this email and advise the correct details.</b>&#13;&#13;';
		
		$message .= 'It has been entered into our system. Our installation team will be in contact with you, in the coming days, to confirm a day for installation once your new device is ready for delivery.&#13;&#13;';
					
		$message .= "Regards&#13;";
		$message .= "<table style='FONT-SIZE: 10pt; COLOR: #505050; FONT-FAMILY: 'Calibri' '> <tr><td style='border-right: 1px solid black; background-color:#FFFFFF;'></td></tr></table>";
		
		$box = '<h2>Welcome Email</h2>';
		$box .= 'Please Enter the Name and Email Address to send the welcome email to: <br><br>';
		$box .= '<form action="welcome-email.php" method="POST"><div class="row"><div class="input-field col s12"><label for="contact_name">Name</label><input name="contact_name" type="text" id="contact_name" value="'. $row['contact'] .'"></div></div>';
		$box .= '<div class="row"><div class="input-field col s12"><label for="contact_email">Email</label><input type="email" name="contact_email" id="contact_email"></div></div>';
		$box .= '<div class="row"><div class="input-field col s12"><label for="cc_email">CC</label><input type="email" name="cc_email" id="cc_email"></div></div>';
		$box .= '<div class="row"><div class="input-field col s12"><label for="message">Message</label><textarea class="materialize-textarea" cols="104" rows="28" id="message" name="message">'.$message.'</textarea></div></div>';
		$box .= '<input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="user" value="'.$user.'">';
		$box .= '<button class="btn-floating btn-large waves-effect waves-light yellow darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="Send" name="request" type="submit" value="true"><i class="material-icons">email</i></button> <button class="btn-floating btn-large waves-effect waves-light red darken-2 right tooltipped" data-position="top" data-delay="50" data-tooltip="Close" type="button" name="close_button" onclick="window.location.href=`installs.php?i=true&id='.$id.'`"><i class="material-icons">close</i></button>';
		return $box;
	}
	
	
	//
	// Create Relocation Success Toast
	//
	function success_box_relocation($success,$send) {
		$box = '<script>Materialize.toast("Successfully ';
		if ($success == 1) {
			$box .= 'Updated Relocation<br>';
		} elseif ($success == 2){
			$box .= 'Added New Relocation<br>';
		} elseif ($success == 3){
			$box .= 'Sent Request Form<br>';
		} else {
		}
		
		if($send == 1){
			$box .= 'Form Sent to Courier<br>';
		} elseif($send == 2) {
			$box .= 'Form Failed to Send to Courier<br>';
		} else{
		}
		
		$box .= '", 4000)</script>';
		return $box;
	}
	
	//
	// Create Install Success Toast
	//
	function success_box($success,$send) {
		$box = '<script>Materialize.toast("Successfully ';
		if ($success == 1) {
			$box .= 'Updated Install';
		} elseif ($success == 2){
			$box .= 'Added New Install';
		} elseif ($success == 3){
			$box .= 'Updated Delivery';
		} elseif ($success == 4){
			$box .= 'Added New Delivery';
		} elseif ($success == 5){
			$box .= 'Sent IT Request Email';
		} elseif ($success == 6){
			$box .= 'Sent Welcome Email';
		}
		$box .= '", 4000)</script>';
		$box .= '<div id="modal1" class="modal">
					<div class="modal-content">
    
						<div class="error">';
		if ($send == 1) {
			$box .= 'Form Sent to Courier Sucessfully!';
		} elseif ($send == 2){
			$box .= 'Form Failed to Send to Courier, Try Again!';
		}
		$box .=			'</div>
						<div class="modal-footer">
							<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
						</div>
					</div>
				</div>';
		
		
		
		
		return $box;
	}
	
	//
	// Create Option Success Toast
	//
	function option_box() {
		$box = '<script>Materialize.toast("';
		$box .= 'Delivery not available until Options have been checked.';
		$box .= '", 4000)</script>';
		return $box;
	}
	
	// Get initials from username
	function get_initials($user){
		$initials = $user; // Disabled until full username populates user column
		return $initials;
	}
?>