<?php


//Create Full list of Relocations
function get_relocations_main($mysqli){
	global $current_rel;
			
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT *  FROM relocations WHERE status != 'Complete' AND status != 'Cancelled'";
	$result = $mysqli->query($sql);
	
	// Get Rows
	if ($result->num_rows > 0) {
		$current_rel .= '<table class="bordered hoverable">';
		$current_rel .= '<tr><th>Company</th>';
		$current_rel .= '<th class="hide_col">Contact</th><th class="hide_col">Phone</th><th>Model</th><th class="hide_col">Stand Alone</th><th>Relocation Date</th><th>Status</th><th class="hide_col">User</th></tr>';
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$result_layout = do_relocations_main($row["relocation_id"],$row["company"],$row["pickup_add"],$row["delivery_add"],$row["contact"],$row["phone"],$row["model"],$row["finisher"],$row["install_date"],$row["status"],$row["user"]);
			$current_rel .= '<tr>' . $result_layout . '</tr>';
		}
	} else {
		$current_rel .= '<div class="center">No Current Relocations</div>';
	}
	$current_rel .= '</table><br>';
	$current_rel .= '<button class="btn-floating btn-large waves-effect waves-light blue darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="New Relocation" type="button" name="new_button" onclick="window.location.href=`relocation.php?r=true`"><i class="material-icons">add</i></button><button class="btn-floating btn-large waves-effect waves-light yellow darken-2 right tooltipped" data-position="top" data-delay="50" data-tooltip="Send Relocation Form" type="button" name="request_button" onclick="window.location.href=`relocation.php?request=true`"><i class="material-icons">email</i></button>';
	return $current_rel;
}

function relocation($mysqli,$relocation_id,$username,$email,$iid){
	global $relocation;
	
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT * FROM relocations WHERE relocation_id = " . $relocation_id;
	$result = $mysqli->query($sql);
	$relocation .= '<form action="relocate.php" method="POST" id="relocation">';
	// Output
	$row = $result->fetch_assoc();
	
	
	
	if($iid != "0"){
		$sql = "SELECT * FROM installs WHERE key_id = " . $iid;
		$result = $mysqli->query($sql);
		// Output
		$install_row = $result->fetch_assoc();
		$row["pickup_add"] = $install_row["address"];
		$row["company"] = $install_row["customer"];
		$row["contact"] = $install_row["contact"];
		$row["phone"] = $install_row["phone"];
		$row["model"] = $install_row["model"];
		$row["serial"] = $install_row["serial"];
		$options = $install_row['option1'] . $install_row['option2'] . $install_row['option3'] . $install_row['option4'] . $install_row['option5'] . $install_row['option6'] . $install_row['option7'] . $install_row['option8'] . $install_row['option9'] . $install_row['option10'];
		if(strpos($options, 'FS') !== false){
			$row["finisher"] = "+ Finisher";
		} else {
			$row["finisher"] = "Yes";
		}
	}
		
	if ($relocation_id == "0"){
		$relocation .= '<h2>New Relocation Details</h2>';
		$category = '';
	} else {
		$relocation .= '<h2>Relocation Details</h2>';
		$sql = "SELECT * FROM calendar_events WHERE relocation_id = " . $relocation_id;
		$event_result = $mysqli->query($sql);
		// Output
		$event_row = $result->fetch_assoc();
		$category = $event_row['category'];
	}
	$relocation .= '<div class="row"><div class="input-field col s12"><label for="pickup_add">Pickup Address</label><input id="pickup_add" type="text" name="pickup_add" required Value="' . $row["pickup_add"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12"><label for="company">Company Name</label><input id="company" type="text" name="company" required Value="' . $row["company"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12"><label for="delivery_add">Delivery Address</label><input id="delivery_add" type="text" name="delivery_add" required Value="' . $row["delivery_add"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12"><label for="contact">Contact Name</label><input id="contact" type="text" name="contact" required Value="' . $row["contact"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12"><label for="phone">Contact Phone Number</label><input id="phone" type="text" name="phone" required Value="' . $row["phone"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12"><label for="level">Level? (eg. 1st Floor)</label><input id="level" type="text" name="level" Value="' . $row["level"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12"><label for="steps">How Many Steps?</label><input id="steps" type="text" name="steps" Value="' . $row["steps"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12"><label for="site_details">Other Site Details:</label><input id="site_details" type="text" name="site_details" Value="' . $row["site_details"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12 l4"><label for="model">Model</label><input id="model" type="text" name="model" Value="' . $row["model"] . '"></div>';
	$relocation .= '<div class="input-field col s12 l4"><label for="serial">Serial No.</label><input id="serial" type="text" name="serial" Value="' . $row["serial"] . '"></div>';
	$relocation .= '<div class="input-field col s12 l4"><label for="finisher">Stand Alone</label><input id="finisher" type="text" name="finisher" Value="' . $row["finisher"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12"><label for="comments">Comments - This will appear in the email</label><input id="comments" type="text" name="comments" Value="' . $row["comments"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12 l6"><label class="active" for="install_date">Install Date</label><input id="install_date" type="date" name="install_date" Value="' . $row["install_date"] . '"></div>';
	$relocation .= '<div class="input-field col s12 l6"><label class="active" for="install_time">Install Time</label><input id="install_time" type="time" name="install_time" Value="' . $row["install_time"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12 l6"><label class="active" for="pickup_date">Pickup Date</label><input id="pickup_date" type="date" name="pickup_date" Value="' . $row["pickup_date"] . '"></div>';
	$relocation .= '<div class="input-field col s12 l6"><label class="active" for="pickup_time">Pickup Time</label><input id="pickup_time" type="time" name="pickup_time" Value="' . $row["pickup_time"] . '"></div></div>';
	$relocation .= '<div class="row"><div class="input-field col s12 l6"><label for="status">Status</label><input id="status" type="text" name="status" list="status_list" Value="' . $row["status"] . '"><datalist id="status_list"><option value="Pending"><option value="Booked"><option value="Cancelled"><option value="Complete"></datalist></div>';
	$relocation .= '<div class="input-field col s12 l6"><label for="category">Tech to Attend Relocation</label><input id="category" type="text" name="category" list="category_list" Value="'.$category.'"><datalist id="category_list"><option value="No_Tech"><option value="Matt"><option value="Mitch"><option value="Peter"></datalist></div></div>';
	$relocation .= '<input type="hidden" name="relocation_id" value="'. $relocation_id .'"><input type="hidden" name="user" value="' . $username . '"><input type="hidden" name="email" value="' . $email . '"><br>';
	if($relocation_id != "0"){
		$relocation .= '
						<button form="relocation" class="btn-floating btn-large waves-effect waves-light yellow darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Send to Courier" name="delivery_button" value="true" type="submit"><i class="material-icons">email</i></button>
						<button form="relocation" class="btn-floating btn-large waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Print" formtarget="_blank" name="print_pdf" value="true" type="submit"><i class="material-icons">print</i></button>';
	}
	$relocation .= '<button class="btn-floating btn-large waves-effect waves-light green left tooltipped" data-position="top" data-delay="50" data-tooltip="Save" type="submit" value="true" name="save_button"><i class="material-icons">check</i></button><button class="btn-floating btn-large waves-effect waves-light red right tooltipped" data-position="top" data-delay="50" data-tooltip="Close" type="button" name="close_button" onclick="window.location.href=`relocations.php`"><i class="material-icons">close</i></button></form>';
	//mysqli_close($mysqli);
	return $relocation;
}

function new_relocation($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user,$mysqli,$category){
			
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
		$results = false;
	}
	else {
	// Perform INSERT
	$sql = "INSERT INTO relocations (pickup_add,delivery_add,company,contact,phone,level,steps,site_details,model,serial,finisher,comments,install_date,install_time,pickup_date,pickup_time,status,user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$statement = $mysqli->prepare($sql);
	$statement->bind_param('ssssssssssssssssss',$pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user);
	if($statement->execute()){
		$relocation_id = $mysqli->insert_id;
		$event_comments = 'Relocation from '.$pickup_add.' to '.$delivery_add.'&#13;&#10;'.$model. ' - '.$serial.'&#13;&#10;'. $category. ' To Attend.&#13;&#10;Status: '.$status.'&#13;&#10;Comments: '.$comments.'&#13;&#10;Updated By: '.$user;
		$endtime = strtotime($pickup_time) + 3600;
		$end = date('H:i:s',$endtime);
		$allday=0;
		$results = add_relocation_event($mysqli,$company,$delivery_add,$comments,$pickup_time,$end,$pickup_date,$allday,$category,$relocation_id,$user);		
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}

	//$statement->close;
	}
	return $results;
}

function update_relocation($relocation_id,$pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user,$mysqli,$category){
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
		$results = false;
	}
	else {
	// Perform INSERT
	$sql = "UPDATE `relocations` SET pickup_add = ?,
	delivery_add = ?,
	company = ?,
	contact = ?,
	phone = ?,
	level = ?,
	steps = ?,
	site_details = ?,
	model = ?,
	serial = ?,
	finisher = ?,
	comments = ?,
	install_date = ?,
	install_time = ?,
	pickup_date = ?,
	pickup_time = ?,
	status = ?,
	user = ?
	WHERE relocation_id=" . $relocation_id;

	$statement = $mysqli->prepare($sql);
	$statement->bind_param('ssssssssssssssssss',$pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user);
	if($statement->execute()){
		$event_comments = 'Relocation from '.$pickup_add.' to '.$delivery_add.'&#13;&#10;'.$model. ' - '.$serial.'&#13;&#10;'. $category. ' To Attend.&#13;&#10;Status: '.$status.'&#13;&#10;Comments: '.$comments.'&#13;&#10;Updated By: '.$user;
		$endtime = strtotime($pickup_time) + 3600;
		$end = date('H:i:s',$endtime);
		$allday=0;
		$results = add_relocation_event($mysqli,$company,$delivery_add,$event_comments,$pickup_time,$end,$pickup_date,$allday,$category,$relocation_id,$user);
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	}
	return $results;
}



?>