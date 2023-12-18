<?php 
	
// Search installs
function search_installs($mysqli,$search){
	global $current;
			
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Install Queries
	$sql = "SELECT key_id, id, customer, address, phone, model, option1, option2, option3, option4 ,option5, option6, option7, option8, option9 ,option10, sales_rep, install_date, status, user, it_status, progress_finance, progress_it, progress_runup, progress_booked, progress_installed, paperwork_rec FROM installs WHERE id LIKE '%".$search."%' OR model LIKE '%".$search."%' OR customer LIKE '%".$search."%' OR serial LIKE '%".$search."%' OR address LIKE '%".$search."%' OR contact LIKE '%".$search."%' OR sales_rep LIKE '%".$search."%' OR it_contact LIKE '%".$search."%'";
	$result = $mysqli->query($sql);
	$current .= '<h2>Installs</h2>';
	$current .= '<table class="bordered hoverable">';
	
	// Get Install Rows
	if ($result->num_rows > 0) {
		// output data of each row
		$current .= '<tr><th class="hide_col">ID</th><th>Customer</th><th>Model</th><th class="hide_col">Sales Rep</th><th>Order Rcvd.</th><th>Install Date</th><th>Status</th><th>Received/<br>In Stock</th><th>IT Details</th><th>Runup</th><th>Booked</th><th class="hide_col">User</th></tr>';
		while($row = $result->fetch_assoc()) {
			$result_layout = do_current_installs_main($row["key_id"],$row["id"],$row["customer"],$row["phone"],$row["model"],$row["option1"],$row["option2"],$row["option3"],$row["option4"],$row["option5"],$row["option6"],$row["option7"],$row["option8"],$row["option9"],$row["option10"],$row["sales_rep"],$row["install_date"],$row["status"],$row["user"],$row["it_status"],$row["progress_finance"],$row["progress_it"],$row["progress_runup"],$row["progress_booked"],$row["progress_installed"],$row["paperwork_rec"]);
			$current .= '<tr>' . $result_layout . '</tr>';
		}
	} else {
		$current .= '<div class="center">No Installs Found</div>';
	}
	$current .= '</table>';
	$current .= '<button class="btn-floating waves-effect waves-light blue darken-2 left tooltipped" data-position="bottom" data-delay="50" data-tooltip="New Install" type="button" name="new_button" onclick="window.location.href=`installs.php?i=true`"><i class="material-icons">add</i></button>';
	
	$current .= '<br><br>';
		
	// Perform Relocation Queries
	$sql = "SELECT * FROM relocations WHERE company LIKE '%".$search."%' OR pickup_add LIKE '%".$search."%' OR delivery_add LIKE '%".$search."%' OR model LIKE '%".$search."%' OR serial LIKE '%".$search."%' OR contact LIKE '%".$search."%' OR comments LIKE '%".$search."%' OR install_date LIKE '%".$search."%'";
	$result = $mysqli->query($sql);
	$current .= '<h2>Relocations</h2>';
	$current .= '<table id="current_installs_main" class="bordered hoverable">';
	
	// Get Relocation Rows
	if ($result->num_rows > 0) {
		$current .= '<tr><th>Company</th><th>Contact</th><th>Phone</th><th>Model</th><th>Stand Alone</th><th>Relocation Date</th><th>Status</th><th>User</th></tr>';
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$result_layout = do_relocations_main($row["relocation_id"],$row["company"],$row["pickup_add"],$row["delivery_add"],$row["contact"],$row["phone"],$row["model"],$row["finisher"],$row["install_date"],$row["status"],$row["user"]);
			$current .= '<tr>' . $result_layout . '</tr>';
		}
	} else {
		$current .= '<div class="center">No Relocations Found</div>';
	}
	$current .= '</table>';
	$current .= '<button class="btn-floating waves-effect waves-light blue darken-2 left tooltipped" data-position="bottom" data-delay="50" data-tooltip="New Relocation" type="button" name="new_relocation" onclick="window.location.href=`relocation.php?r=true`"><i class="material-icons">add</i></button>';
	return $current;
}

//Create Full list of current installs
function get_current_installs_main($mysqli, $tv = false){
	global $current;
			
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT key_id, id, customer, address, phone, model, option1, option2, option3, option4 ,option5, option6, option7, option8, option9 ,option10, sales_rep, install_date, status, user, it_status, progress_finance, progress_it, progress_runup, progress_booked, progress_installed, paperwork_rec FROM installs WHERE (status != 'Complete' AND status != 'Cancelled') ORDER BY install_date";
	$result = $mysqli->query($sql);
	
	$current .= '<table class="bordered hoverable">';
	// Get Rows
	if ($result->num_rows > 0) {
		
		$current .= '<tr><th class=';
		if ($tv == true){
			$current .= '"always_hide_col"';
		} else {
			$current .= '"hide_col"';
		}
		$current .= '>ID</th><th>Customer</th><th>Model</th><th class=';
		if ($tv == true){
			$current .= '"always_hide_col"';
		} else {
			$current .= '"hide_col"';
		}
		$current .= '>Sales Rep</th><th>Order Rcvd.</th><th>Install Date</th><th>Status</th><th>Received/<br>In Stock</th><th>IT Details</th><th>Runup</th><th>Booked</th><th class=';
		if ($tv == true){
			$current .= '"always_hide_col"';
		} else {
			$current .= '"hide_col"';
		}
		$current .= '>User</th></tr>';
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$result_layout = do_current_installs_main($row["key_id"],$row["id"],$row["customer"],$row["phone"],$row["model"],$row["option1"],$row["option2"],$row["option3"],$row["option4"],$row["option5"],$row["option6"],$row["option7"],$row["option8"],$row["option9"],$row["option10"],$row["sales_rep"],$row["install_date"],$row["status"],$row["user"],$row["it_status"],$row["progress_finance"],$row["progress_it"],$row["progress_runup"],$row["progress_booked"],$row["progress_installed"],$row["paperwork_rec"],$tv);
			$current .= '<tr';
			if($row["install_date"]=="0001-01-01"){
				$current .= ' class="pending"';}
			if($row["progress_booked"]=="Yes"){
				$current .= ' class="booked"';}
			$current .= '>' . $result_layout . '</tr>';
		}
	} else {
		$current .= '<div class="center-block">No Current Installs</div>';
	}
	$current .= '</table><br>';
	$current .= '<button class="btn-floating btn-large waves-effect waves-light blue darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="New Install" type="button" name="new_button" onclick="window.location.href=`installs.php?i=true`"><i class="material-icons">add</i></button>';
	return $current;
}

function get_current_runups_main($mysqli){
	global $current;
			
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT * FROM installs WHERE (status != 'Complete' AND status != 'Cancelled' AND progress_runup != 'Yes') ORDER BY install_date";
	$result = $mysqli->query($sql);
	
	$current .= '<table class="bordered hoverable">';
	// Get Rows
	if ($result->num_rows > 0) {
		
		$current .= '<tr><th class="hide_col">ID</th><th>Customer</th><th>Model</th><th>Serial</th><th class="hide_col">Sales Rep</th><th>Install Date</th><th>Status</th><th>Received/<br>In Stock</th><th>IT Details</th><th>Booked</th><th class="hide_col">User</th></tr>';
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$result_layout = do_current_runups_main($row["key_id"],$row["id"],$row["serial"],$row["customer"],$row["phone"],$row["model"],$row["option1"],$row["option2"],$row["option3"],$row["option4"],$row["option5"],$row["option6"],$row["option7"],$row["option8"],$row["option9"],$row["option10"],$row["sales_rep"],$row["install_date"],$row["status"],$row["user"],$row["it_status"],$row["progress_finance"],$row["progress_it"],$row["progress_runup"],$row["progress_booked"],$row["progress_installed"]);
			$current .= '<tr';
			if($row["progress_booked"]=="Yes"){
				$current .= ' class="booked"';}
			$current .= '>' . $result_layout . '</tr>';
		}
	} else {
		$current .= '<div class="center-block">No Current Run-ups</div>';
	}
	$current .= '</table><br>';
	return $current;
}

function install($mysqli,$key_id,$username,$login_type,$duplicate=false){
	global $install;
	
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT * FROM installs WHERE key_id = " . $key_id;
	$result = $mysqli->query($sql);
	$install .= '<form action="install.php" method="POST">';
	// Output
	$row = $result->fetch_assoc();
	if ($duplicate == true){
		$key_id = "0";
	}
	
	if ($key_id == "0"){
		$install .= '<h2>New Install Details</h2>';
	} else {
		$install .= '<h2>Install Details</h2>';
	}
	$install .= '<h5>Customer Details</h5>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="customer">Customer Name</label><input id="customer" type="text" name="customer" required Value="' . $row["customer"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="address">Address</label><input id="address" type="text" name="address" required Value="' . $row["address"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="contact">Contact</label><input id="contact" type="text" name="contact" required Value="' . $row["contact"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="phone">Phone No.</label><input id="phone" type="text" name="phone" required Value="' . $row["phone"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="fax">Fax No.</label><input id="fax" type="text" name="fax" class="validate" Value="' . $row["fax"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="sales_rep">Sales Rep</label><input id="sales_rep" type="text" name="sales_rep" list="sales_rep_list" required Value="' . $row["sales_rep"] . '"><datalist id="sales_rep_list"><option value="Andrew Garrard"><option value="Jason Allen"><option value="Jayney Rees"><option value="KM"><option value="Michael Cheetham"></datalist></div></div>';
	
	
	$install .= '<h5>Machine Details</h5>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="id">Machine ID</label><input id="id" type="text" name="id" required Value="' . $row["id"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="model">Model</label><input id="model" type="text" name="model" required Value="' . $row["model"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="serial">Serial No.</label><input id="serial" type="text" name="serial" required Value="' . $row["serial"] . '"></div></div>';
		
	$install .= '<div class="row"><div class="input-field col s10 l5"><label for="option1">Options</label><input id="option1" type="text" name="option1" Value="' . $row["option1"] . '"></div><div class="input-field col s1"><input type="checkbox" id="option1check" name="option1check" value="Yes"';
	if($row["option1check"]=="Yes"){
		$install .= ' checked';
	}
	$install .=' /><label for="option1check"></label></div>';
	$install .= '<div class="input-field col s10 l5"><label for="option2">Options</label><input id="option2" type="text" name="option2" Value="' . $row["option2"] . '"></div><div class="input-field col s1"><input type="checkbox"  id="option2check" name="option2check" value="Yes"';
	if($row["option2check"]=="Yes"){
		$install .= ' checked';
	}
	$install .='><label for="option2check"></label></div>';
	$install .= '</div>';
	$install .= '<div class="row"><div class="input-field col s10 l5"><label for="option3">Options</label><input id="option3" type="text" name="option3" Value="' . $row["option3"] . '"></div><div class="input-field col s1"><input type="checkbox" id="option3check" name="option3check" value="Yes"';
	if($row["option3check"]=="Yes"){
		$install .= ' checked';
	}
	$install .='><label for="option3check"></label></div>';
	$install .= '<div class="input-field col s10 l5"><label for="option4">Options</label><input id="option4" type="text" name="option4" Value="' . $row["option4"] . '"></div> <div class="input-field col s1"><input type="checkbox" id="option4check" name="option4check" value="Yes"';
	if($row["option4check"]=="Yes"){
		$install .= ' checked';
	}
	$install .='><label for="option4check"></label></div></div>';
	$install .= '<div class="row"><div class="input-field col s10 l5"><label for="option5">Options</label><input id="option5" type="text" name="option5" Value="' . $row["option5"] . '"></div> <div class="input-field col s1"><input type="checkbox" id="option5check" name="option5check" value="Yes"';
	if($row["option5check"]=="Yes"){
		$install .= ' checked';
	}
	$install .='><label for="option5check"></label></div>';
	$install .= '<div class="input-field col s10 l5"><label for="option6">Options</label><input id="option6" type="text" name="option6" Value="' . $row["option6"] . '"></div> <div class="input-field col s1"><input type="checkbox" id="option6check" name="option6check" value="Yes"';
	if($row["option6check"]=="Yes"){
		$install .= ' checked';
	}
	$install .='><label for="option6check"></label></div>';
	$install .= '</div>';
	$install .= '<div class="row"><div class="input-field col s10 l5"><label for="option7">Options</label><input id="option7" type="text" name="option7" Value="' . $row["option7"] . '"></div> <div class="input-field col s1"><input type="checkbox" id="option7check" name="option7check" value="Yes"';
	if($row["option7check"]=="Yes"){
		$install .= ' checked';
	}
	$install .='><label for="option7check"></label></div>';
	$install .= '<div class="input-field col s10 l5"><label for="option8">Options</label><input id="option8" type="text" name="option8" Value="' . $row["option8"] . '"></div> <div class="input-field col s1"><input type="checkbox" id="option8check" name="option8check" value="Yes"';
	if($row["option8check"]=="Yes"){
		$install .= ' checked';
	}
	$install .='><label for="option8check"></label></div></div>';
	$install .= '<div class="row"><div class="input-field col s10 l5"><label for="option9">Options</label><input id="option9" type="text" name="option9" Value="' . $row["option9"] . '"></div> <div class="input-field col s1"><input type="checkbox" id="option9check" name="option9check" value="Yes"';
	if($row["option9check"]=="Yes"){
		$install .= ' checked';
	}
	$install .='><label for="option9check"></label></div>';
	$install .= '<div class="input-field col s10 l5"><label for="option10">Options</label><input id="option10" type="text" name="option10" Value="' . $row["option10"] . '"></div> <div class="input-field col s1"><input type="checkbox" id="option10check" name="option10check" value="Yes"';
	if($row["option10check"]=="Yes"){
		$install .= ' checked';
	}
	$install .='><label for="option10check"></label></div></div>';
	
	$install .= '<h5>Network Details</h5>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="ip">IP Address</label><input id="ip" type="text" name="ip" Value="' . $row["ip"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="sn">Subnet Mask</label><input id="sn" type="text" name="sn" Value="' . $row["sn"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="gw">Gateway</label><input id="gw" type="text" name="gw" Value="' . $row["gw"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for="dns">DNS Server</label><input id="dns" type="text" name="dns" Value="' . $row["dns"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12 l6"><label for="email">Machine Email Address</label><input id="email" type="email" name="email" Value="' . $row["email"] . '"></div>';
	$install .= '<div class="input-field col s12 l6"><label for="smtp">SMTP Server</label><input id="smtp" type="text" name="smtp" Value="' . $row["smtp"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12 l6"><label for="smtp_user">SMTP Username</label><input id="smtp_user" type="text" name="smtp_user" Value="' . $row["smtp_user"] . '"></div>';
	$install .= '<div class="input-field col s12 l6"><label for="smtp_pass">SMTP Password</label><input id="smtp_pass" type="text" name="smtp_pass" Value="' . $row["smtp_pass"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12 l2"><label for="scan_folder">Scan Folder Type</label><input id="scan_folder" type="text" name="scan_folder" list="scan" Value="' . $row["scan_folder"] . '"><datalist id="scan"><option value="SMB"><option value="FTP"></datalist></div>';
	$install .= '<div class="input-field col s12 l4"><label for="scan_server">Scan Server</label><input id="scan_server" type="text" name="scan_server" Value="' . $row["scan_server"] . '"></div>';
	$install .= '<div class="input-field col s12 l6"><label for="scan_path">Scan Path</label><input id="scan_path" type="text" name="scan_path" Value="' . $row["scan_path"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12 l6"><label for="scan_user">Scan Username</label><input id="scan_user" type="text" name="scan_user" Value="' . $row["scan_user"] . '"></div>';
	$install .= '<div class="input-field col s12 l6"><label for="scan_pass">Scan Password</label><input id="scan_pass" type="text" name="scan_pass" Value="' . $row["scan_pass"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12 l6"><label for="it_contact">IT Contact Name</label><input id="it_contact" type="text" name="it_contact" Value="' . $row["it_contact"] . '"></div>';
	$install .= '<div class="input-field col s12 l6"><label for="it_phone">IT Phone No.</label><input id="it_phone" type="text" name="it_phone" Value="' . $row["it_phone"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12"><label for"comments">Comments</label><input id="comments" type="text" name="comments" Value="' . $row["comments"] . '"></div></div>';
	
	$install .= '<br>';
	
	$install .= '<div class="row"><div class="input-field col s12 l6"><label for="reading_c">Start Colour Counter</label><input id="readin_c" type="text" name="reading_c" Value="' . $row["reading_c"] . '"></div>';
	$install .= '<div class="input-field col s12 l6"><label for="reading_b">Start Black Counter</label><input id="reading_b" type="text" name="reading_b" Value="' . $row["reading_b"] . '"></div></div>';
	$install .= '<div class="row"><div class="input-field col s12 l6"><label class="active" for="install_date">Install Date</label><input id="install_date" type="date" name="install_date" required Value="' . $row["install_date"] . '"></div>';
	$install .= '<div class="input-field col s12 l3"><label for="status">Install Status</label><input id="status" type="text" name="status" list="status_list" required Value="' . $row["status"] . '"><datalist id="status_list"><option value="On Order"><option value="Waiting on Option"><option value="Ready to Install"><option value="Booked"><option value="Installed"><option value="Complete"><option value="Cancelled"></datalist></div>';
	$install .= '<div class="input-field col s12 l3"><label for="it_status">IT Status</label><input id="it_status" type="text" name="it_status" list="it_status_list" required Value="'; 
	if($row["it_status"] == null){
		$install .= 'Not Sent';
	}else{
		$install .= $row["it_status"];
	} 
	$install .= '"><datalist id="it_status_list"><option value="Not Sent"><option value="Waiting on IT"><option value="IT Details Complete"></datalist></div></div>';
	$install .= '<input type="hidden" name="key_id" value="'. $key_id .'"><input type="hidden" name="username" value="' . $username . '">';
	$install .= '<div class="row"><div class="input-field col l1"><label class="active" for="paperwork_rec">Order Received</label><input id="paperwork_rec" type="date" name="paperwork_rec" required Value="' . $row["paperwork_rec"] . '"></div>';
	$install .= '<div class="input-field col l2"><input type="checkbox" id="progress_finance" name="progress_finance" value="Yes"';
	if($row["progress_finance"]=="Yes"){$install .= ' checked';}
	$install .='><label for="progress_finance">Received/In Stock</label></div>';
	$install .= '<div class="input-field col l2"><input type="checkbox" id="progress_it" name="progress_it" value="Yes"';
	if($row["progress_it"]=="Yes"){$install .= ' checked';}
	$install .='><label for="progress_it">IT Details Collected</label></div>';
	$install .= '<div class="input-field col l2"><input type="checkbox" id="progress_runup" name="progress_runup" value="Yes"';
	if($row["progress_runup"]=="Yes"){$install .= ' checked';}
	$install .='><label for="progress_runup">Runup Complete</label></div>';
	$install .= '<div class="input-field col l2"><input type="checkbox" id="progress_booked" name="progress_booked" value="Yes"';
	if($row["progress_booked"]=="Yes"){$install .= ' checked';}
	$install .='><label for="progress_booked">Booked</label></div>';
	$install .= '<div class="input-field col l2"><input type="checkbox" id="progress_installed" name="progress_installed" value="Yes"';
	if($row["progress_installed"]=="Yes"){$install .= ' checked';}
	$install .='><label for="progress_installed">Installed</label></div></div>';
	
	
	
	if ($key_id !="0"){
		if($login_type!='runups'){
			if($row['welcome_sent']==false) {
				$install .= '<button class="btn waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Welcome" name="welcome" type="submit" value="true">Send Welcome Email</button>';
			} else {
				$install .= '<button class="btn waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Welcome email sent" name="welcome" type="submit" value="true" disabled>Welcome email sent</button>';
			}	
			$install .= '
					 <button class="btn waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Request IT Info" name="request_it" type="submit" value="true">Request IT Info</button>
					 <button class="btn waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Delivery"  name="delivery_button" type="submit" value="true">Delivery</button>
					 <button class="btn waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Print" name="print_pdf" formtarget="_blank" type="submit" value="true">Print</button>
					 <button class="btn waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Relocate" name="relocate" type="submit" value="true">Relocate</button>
					 <button class="btn waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Duplicate" name="duplicate" type="submit" value="true">Duplicate</button>';
		} else {
			$install .= '<button class="btn waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Print" name="print_pdf" formtarget="_blank" type="submit" value="true">Print</button>';
		}
	}
	$install .= '<button class="btn-floating btn-large waves-effect waves-light green darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="Save" name="save_button" type="submit" value="true"><i class="material-icons">check</i></button> <button class="btn-floating btn-large waves-effect waves-light red darken-2 right tooltipped" data-position="top" data-delay="50" data-tooltip="Close" type="button" name="close_button" onclick="window.location.href=`currentinstalls.php`"><i class="material-icons">close</i></button></form>';
	return $install;
}

function new_install($id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$option1check,$option2check,$option3check,$option4check,$option5check,$option6check,$option7check,$option8check,$option9check,$option10check,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$comments,$install_date,$reading_c,$reading_b,$status,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed,$paperwork_rec,$user,$mysqli){

	if ($install_date == ''){
		$install_date = null;
	}
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
		$results = false;
	}
	else {
	// Perform INSERT
	$sql = "INSERT INTO installs (id,model,serial,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,option1check,option2check,option3check,option4check,option5check,option6check,option7check,option8check,option9check,option10check,customer,address,contact,phone,fax,sales_rep,ip,sn,gw,dns,smtp,smtp_user,smtp_pass,email,scan_folder,scan_server,scan_path,scan_user,scan_pass,it_contact,it_phone,comments,install_date,reading_c,reading_b,status,it_status,progress_finance,progress_it,progress_runup,progress_booked,progress_installed,paperwork_rec,user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$statement = $mysqli->prepare($sql);
	$statement->bind_param('isssssssssssssssssssssssssssssssssssssssssssssiisssssssss',$id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$option1check,$option2check,$option3check,$option4check,$option5check,$option6check,$option7check,$option8check,$option9check,$option10check,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$comments,$install_date,$reading_c,$reading_b,$status,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed,$paperwork_rec,$user);
	if($statement->execute()){
		$results = true;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	
	$sql = "SELECT key_id FROM installs WHERE id = " . $id;
	$install_result = $mysqli->query($sql);
	$install_row = $install_result->fetch_assoc();
	$key_id = $install_row['key_id'];
	
	$options = $option1 . $option2 . $option3 . $option4 . $option5 . $option6 . $option7 . $option8 . $option9 . $option10;
	if(strpos($options, 'FS') !== false){
		$finisher = "+ Finisher";
	} else {
		$finisher = "Yes";
	}
	
	
	$sql = "INSERT INTO deliveries (key_id,delivery_add,company,contact,phone,model,serial,finisher,install_date,user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$statement = $mysqli->prepare($sql);
	$statement->bind_param('isssssssss',$key_id,$address,$customer,$contact,$phone,$model,$serial,$finisher,$install_date,$user);
	if($statement->execute()){
		$event_comments = 'Install '.$model.' - '. $serial;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	
	}
	
	return $results;
}

function update_install($key_id,$id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$option1check,$option2check,$option3check,$option4check,$option5check,$option6check,$option7check,$option8check,$option9check,$option10check,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$comments,$install_date,$reading_c,$reading_b,$status,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed,$paperwork_rec,$user,$mysqli){
	if ($install_date == ''){
		$install_date = null;
	}
	
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
		$results = false;
	}
	else {
	// Perform INSERT
	$sql = "UPDATE `installs` SET id = ?,
	model = ?,
	serial = ?,
	option1 = ?,
	option2 = ?,
	option3 = ?,
	option4 = ?,
	option5 = ?,
	option6 = ?,
	option7 = ?,
	option8 = ?,
	option9 = ?,
	option10 = ?,
	option1check = ?,
	option2check = ?,
	option3check = ?,
	option4check = ?,
	option5check = ?,
	option6check = ?,
	option7check = ?,
	option8check = ?,
	option9check = ?,
	option10check = ?,
	customer = ?,
	address = ?,
	contact = ?,
	phone = ?,
	fax = ?,
	sales_rep = ?,
	ip = ?,
	sn = ?,
	gw = ?,
	dns = ?,
	smtp = ?,
	smtp_user = ?,
	smtp_pass = ?,
	email = ?,
	scan_folder = ?,
	scan_server = ?,
	scan_path = ?,
	scan_user = ?,
	scan_pass = ?,
	it_contact = ?,
	it_phone = ?,
	comments = ?,
	install_date = ?,
	reading_c = ?,
	reading_b = ?,
	status = ?,
	it_status = ?,
	progress_finance = ?,
	progress_it = ?,
	progress_runup = ?,
	progress_booked = ?,
	progress_installed = ?,
	paperwork_rec = ?,
	user = ?
	WHERE key_id=" . $key_id;

	$statement = $mysqli->prepare($sql);
	$statement->bind_param('isssssssssssssssssssssssssssssssssssssssssssssiisssssssss',$id,$model,$serial,$option1,$option2,$option3,$option4,$option5,$option6,$option7,$option8,$option9,$option10,$option1check,$option2check,$option3check,$option4check,$option5check,$option6check,$option7check,$option8check,$option9check,$option10check,$customer,$address,$contact,$phone,$fax,$sales_rep,$ip,$sn,$gw,$dns,$smtp,$smtp_user,$smtp_pass,$email,$scan_folder,$scan_server,$scan_path,$scan_user,$scan_pass,$it_contact,$it_phone,$comments,$install_date,$reading_c,$reading_b,$status,$it_status,$progress_finance,$progress_it,$progress_runup,$progress_booked,$progress_installed,$paperwork_rec,$user);
	if($statement->execute()){
		$results = true;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	$results = update_install_date($mysqli,$key_id,$install_date);
	}
	return $results;
}


//
//Change to delivery instead of relocations
//

function delivery($mysqli,$delivery_id,$username,$email,$key_id){
	
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	
	
	// Perform Queries
	$sql = "SELECT * FROM deliveries WHERE key_id = " . $key_id;
	$result = $mysqli->query($sql);
	$delivery = '<form action="delivery.php" method="POST" id="delivery">';
	
	// Output
	$row = $result->fetch_assoc();
	
	$sql = "SELECT * FROM calendar_events WHERE delivery_id = " . $delivery_id;
	$event_result = $mysqli->query($sql);
	// Output
	$event_row = $event_result->fetch_assoc();
	
	$sql = "SELECT * FROM installs WHERE key_id = " . $key_id;
	$install_result = $mysqli->query($sql);
	$install_row = $install_result->fetch_assoc();
	
	if($row["finisher"] == ""){
		$options = $install_row['option1'] . $install_row['option2'] . $install_row['option3'] . $install_row['option4'] . $install_row['option5'] . $install_row['option6'] . $install_row['option7'] . $install_row['option8'] . $install_row['option9'] . $install_row['option10'];
		if(strpos($options, 'FS') !== false){
			$row["finisher"] = "+ Finisher";
		} else {
			$row["finisher"] = "Yes";
		}
	}
	
	if($row["model"] == ""){
		$row["company"] = $install_row["customer"];
		$row["delivery_add"] = $install_row["address"];
		$row["contact"] = $install_row["contact"];
		$row["phone"] = $install_row["phone"];
		$row["model"] = $install_row["model"];
		$row["serial"] = $install_row["serial"];
		$row["install_date"] = $install_row["install_date"];
	}
	
	$delivery .= '<h2>Delivery Details</h2>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="pickup_add">Pickup Address</label><input id="pickup_add" type="text" name="pickup_add" required list="pickup" Value="' . $row["pickup_add"] . '"><datalist id="pickup"><option value="46 The Avenue Maryville NSW 2293"></datalist></div></div>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="company">Company Name</label><input id="company" type="text" name="company" required Value="' . $row["company"] . '"></div></div>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="delivery_add">Delivery Address</label><input id="delivery_add" type="text" name="delivery_add" required Value="' . $row["delivery_add"] . '"></div></div>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="contact">Contact Name</label><input id="contact" type="text" name="contact" required Value="' . $row["contact"] . '"></div></div>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="phone">Contact Phone</label><input id="phone" type="text" name="phone" required Value="' . $row["phone"] . '"></div></div>';
	$delivery .= '<br>';
	$delivery .= '<h5>Site Details:</h5>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="level">Level</label><input id="level" type="text" name="level" Value="' . $row["level"] . '"></div></div>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="steps">Steps</label><input id="steps" type="text" name="steps" Value="' . $row["steps"] . '"></div></div>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="site_details">Site Details</label><input id="site_details" type="text" name="site_details" Value="' . $row["site_details"] . '"></div></div>';
	$delivery .= '<br>';
	$delivery .= '<div class="row"><div class="input-field col s12 l4"><label for="model">Model</label><input id="model" type="text" name="model" Value="' . $row["model"] . '"></div>';
	$delivery .= '<div class="input-field col s12 l4"><label for="serial">Serial No.</label><input id="serial" type="text" name="serial" Value="' . $row["serial"] . '"></div>';
	$delivery .= '<div class="row"><div class="input-field col s12 l4"><label for="finisher">Stand Alone</label><input id="finisher" type="text" name="finisher" Value="' . $row["finisher"] . '"></div></div>';
	$delivery .= '<br>';
	$delivery .= '<div class="row"><div class="input-field col s1 l1"><input type="checkbox" name="tradein_check" value="Yes" id="tradein_check"';
	if($row["tradein_check"]=="Yes"){
		$delivery .= ' checked';
	}
	$delivery .= '><label for="tradein_check">Trade-in</label></div><div class="input-field col s11 l11"><label for="tradein">Trade-in Model</label><input id="tradein" type="text" name="tradein" value="'.$row["tradein"].'"></div></div>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="tradein_return">Return Trade-in to</label><input id="tradein_return" type="text" name="tradein_return" list="return" value="'.$row["tradein_return"].'"><datalist id="return"><option value="46 The Avenue Maryville NSW 2293"></datalist></div></div>';
	$delivery .= '<br>';
	$delivery .= '<div class="row"><div class="input-field col s12"><label for="comments">Comments</label><input id="comments" type="text" name="comments" Value="' . $row["comments"] . '"></div></div>';
	$delivery .= '<br>';
	$delivery .= '<div class="row"><div class="input-field col s12 l6"><label class="active" for="install_date">Install Date</label><input id="install_date" type="date" name="install_date" Value="' . $row["install_date"] . '"></div>';
	$delivery .= '<div class="input-field col s12 l6"><label class="active" for="install_time">Install Time</label><input id="install_time" type="time" name="install_time" Value="' . $row["install_time"] . '"></div></div>';
	$delivery .= '<div class="row"><div class="input-field col s12 l6"><label class="active" for="pickup_date">Pickup Date</label><input id="pickup_date" type="date" name="pickup_date" Value="' . $row["pickup_date"] . '"></div>';
	$delivery .= '<div class="input-field col s12 l6"><label class="active" for="pickup_time">Pickup Time</label><input id="pickup_time" type="time" name="pickup_time" Value="' . $row["pickup_time"] . '"></div></div>';
	$delivery .= '<div class="row"><div class="input-field col s12 l6"><label for="status">Status</label><input id="status" type="text" name="status" list="status_list" Value="' . $row["status"] . '"><datalist id="status_list"><option value="Booked"><option value="Complete"></datalist></div>';
	$delivery .= '<div class="input-field col s12 l6"><label for="category">Tech to Attend</label><input id="category" type="text" name="category" list="category_list" Value="'.$event_row['category'].'"><datalist id="category_list"><option value="No_Tech"><option value="Matt"><option value="Mitch"><option value="Peter"></datalist></div></div>';
	$delivery .= '<input type="hidden" name="delivery_id" value="'. $delivery_id .'"><input type="hidden" name="key_id" value="'. $key_id .'"><input type="hidden" name="user" value="' . $username . '"><input type="hidden" name="email" value="' . $email . '"><br>';
	if($delivery_id != "0"){
		$delivery .= '
					  <button form="delivery" class="btn-floating btn-large waves-effect waves-light yellow darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Send to Courier" name="delivery_button" value="true" type="submit"><i class="material-icons">email</i></button>
					  <button form="delivery" class="btn-floating btn-large waves-effect waves-light grey darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="Print" formtarget="_blank" name="print_pdf" value="true" type="submit"><i class="material-icons">print</i></button>';
	}
	$delivery .= '<button class="btn-floating btn-large waves-effect waves-light green darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="Save" name="save_button" type="submit" value="true"><i class="material-icons">check</i></button> <button class="btn-floating btn-large waves-effect waves-light red darken-2 right tooltipped" data-position="top" data-delay="50" data-tooltip="Close" type="button" name="close_button" onclick="window.location.href=`installs.php?i=true&id='.$key_id.'`"><i class="material-icons">close</i></button></form>';
	//mysqli_close($mysqli);
	return $delivery;
}

function new_delivery($pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$tradein_check,$tradein,$tradein_return,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user,$mysqli,$key_id,$category){
			
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
		$results = false;
	}
	else {
	// Perform INSERT
	$sql = "INSERT INTO deliveries (key_id,pickup_add,delivery_add,company,contact,phone,level,steps,site_details,model,serial,finisher,tradein_check,tradein,tradein_return,comments,install_date,install_time,pickup_date,pickup_time,status,user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$statement = $mysqli->prepare($sql);
	$statement->bind_param('isssssssssssssssssssss',$key_id,$pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$tradein_check,$tradein,$tradein_return,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user);
	if($statement->execute()){
		$event_comments = 'Install '.$model.'&#13;&#10;Trade-in: '.$tradein.'&#13;&#10;'. $category. ' To Attend.&#13;&#10;Status: '.$status.'&#13;&#10;Comments: '.$comments.'&#13;&#10;Updated By: '.$user;
		$endtime = strtotime($install_time) + 3600;
		$end = date('H:i:s',$endtime);
		$allday=0;
		$results = add_delivery_event($mysqli,$company,$delivery_add,$event_comments,$install_time,$end,$install_date,$allday,$category,$key_id,$user);		
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	
	//$statement->close;
	}
	return $results;
}

function update_delivery($key_id,$delivery_id,$pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$tradein_check,$tradein,$tradein_return,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user,$mysqli,$category){		
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
		$results = false;
	}
	else {
	// Perform INSERT
	$sql = "UPDATE `deliveries` SET pickup_add = ?,
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
	tradein_check = ?,
	tradein = ?,
	tradein_return = ?,
	comments = ?,
	install_date = ?,
	install_time = ?,
	pickup_date = ?,
	pickup_time = ?,
	status = ?,
	user = ?
	WHERE delivery_id=" . $delivery_id;

	$statement = $mysqli->prepare($sql);
	$statement->bind_param('sssssssssssssssssssss',$pickup_add,$delivery_add,$company,$contact,$phone,$level,$steps,$site_details,$model,$serial,$finisher,$tradein_check,$tradein,$tradein_return,$comments,$install_date,$install_time,$pickup_date,$pickup_time,$status,$user);
	if($statement->execute()){
		$event_comments = '&#13;&#10;Install '.$model.'&#13;&#10;Trade-in: '.$tradein.'&#13;&#10;'. $category. ' To Attend.&#13;&#10;Status: '.$status.'&#13;&#10;Comments: '.$comments.'&#13;&#10;Updated By: '.$user;
		$endtime = strtotime($install_time) + 3600;
		$end = date('H:i:s',$endtime);
		$allday=0;
		
		$results = add_delivery_event($mysqli,$company,$delivery_add,$event_comments,$install_time,$end,$install_date,$allday,$category,$key_id,$user);
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}

	}
	return $results;
}

//
// Update Install Date
//

function update_install_date($mysqli,$key_id,$install_date){
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Delivery Update
	$sql = "UPDATE `deliveries` SET `install_date` = ? WHERE key_id = ".$key_id;
	$statement = $mysqli->prepare($sql);
	$statement->bind_param('s',$install_date);
	if($statement->execute()){
		$results = true;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	
	// Get delivery_id 
	$sql = "SELECT delivery_id FROM deliveries WHERE key_id = " . $key_id;
	$id_result = $mysqli->query($sql);
	$id_row = $id_result->fetch_assoc();
	$delivery_id = $id_row['delivery_id'];
	
	if($delivery_id != ''){
		// Perform Event Update
		$sql = "UPDATE calendar_events SET date = ? WHERE delivery_id = " .$delivery_id;
		$statement_event = $mysqli->prepare($sql);
		$statement_event->bind_param('s',$install_date);
		if($statement_event->execute()){
			$results = true;
		}else{
			die('Error : ('. $mysqli->errno .') '. $mysqli->error);
			$results = false;
		}
	}
	
	return $results;
}


//
// Settings GET and SET
//

function set_settings($mysqli,$company,$phone,$it_email) {
	
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "UPDATE `settings` SET `company` = ?, `phone` = ?, `it_email` = ?  WHERE settings_id = 0";
	
	$statement = $mysqli->prepare($sql);
	$statement->bind_param('sss',$company,$phone,$it_email);
	if($statement->execute()){
		$result = true;
	}else{
		$result = false;
	}
	return $result;
}

function get_it_email($mysqli) {
	
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT * FROM settings WHERE settings_id = 0";
	$result = $mysqli->query($sql);
	// Output
	$row = $result->fetch_assoc();

	$it_email = $row['it_email'];
	return $it_email;
}

function get_company($mysqli) {
	
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT * FROM settings WHERE settings_id = 0";
	$result = $mysqli->query($sql);
	// Output
	$row = $result->fetch_assoc();

	$company = $row['company'];
	return $company;
}

function get_phone($mysqli) {
	
	//Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT * FROM settings WHERE settings_id = 0";
	$result = $mysqli->query($sql);
	// Output
	$row = $result->fetch_assoc();

	$phone = $row['phone'];
	return $phone;
}


function update_welcome($mysqli,$key_id){
	$welcome_sent = 'Yes';	
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
		$results = false;
	}
	else {
	// Perform INSERT
	$sql = "UPDATE `installs` SET welcome_sent = ?
	WHERE key_id=" . $key_id;

	$statement = $mysqli->prepare($sql);
	$statement->bind_param('s',$welcome_sent);
	if($statement->execute()){
		$results = true;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	}
	return $results;
}


//
// END Settings
//
?>