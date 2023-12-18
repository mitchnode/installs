<?php

function get_schedule($mysqli){
	global $schedule;
	// Check connection
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Perform Queries
	$sql = "SELECT * FROM calendar_events WHERE date >= CURDATE() ORDER BY date, start";
	$result = $mysqli->query($sql);
	
	// Get Rows
	if ($result->num_rows > 0) {
		$schedule .= '<table class="schedule bordered hoverable">';
		$schedule .= '<tr><th>Title</th><th>Location</th><th>Date</th><th>Time</th><th class="hide_col">Tech</th></tr>';
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$result_layout = do_schedule($row['id'],$row["title"],$row["location"],$row["date"],$row["start"],$row["category"]);
			$schedule .= '<tr class="'. $row['category'] .'_s">' . $result_layout . '</tr>';
		}
		$schedule .= '</table>';
	} else {
		$schedule .= '<div class="center-block">No Current Events</div>';
	}
	
	//mysqli_close($mysqli);
	return $schedule;
}

function get_calendar_layout($mysqli,$month,$year){
	//This gets today's date
	$date =time () ;

	//This puts the day, month, and year in seperate variables
	$day = date('d', $date) ;
	//$year = date($year) ;
	

	//Here we generate the first day of the month
	$first_day = mktime(0,0,0,$month, 1, $year) ;

	//This gets us the month name
	$title = date('F', $first_day) ;

	//Here we find out what day of the week the first day of the month falls on 
	$day_of_week = date('D', $first_day) ; 

	//Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero 
	switch($day_of_week){ 
		case "Sun": 
			$blank = 0;
			break; 
		case "Mon": 
			$blank = 1; 
			break; 
		case "Tue": 
			$blank = 2; 
			break; 
		case "Wed": 
			$blank = 3; 
			break; 
		case "Thu": 
			$blank = 4; 
			break; 
		case "Fri": 
			$blank = 5; 
			break; 
		case "Sat": 
			$blank = 6; 
			break; 
	} 

	//We then determine how many days are in the current month 
	$days_in_month = cal_days_in_month(0, $month, $year) ;
	
	//$new_year = $year;
	if ($month == 12){
		$next_month = 1;
		$next_year = ($year+1);
	} else {
		$next_month = ($month+1);
		$next_year = ($year);
	}
	
	if ($month == 1){
		$prev_month = 12;
		$prev_year = ($year-1);
	} else {
		$prev_month = ($month-1);
		$prev_year = ($year);
	}
	//Here we start building the table heads
	
	$calendar_layout .= "<div class='row'><div class='col s2'><a class='left' href='calendar.php?year=$prev_year&month=$prev_month'>< Prev Month</a></div><div class='col s8 center'> $title $year </div><div class='col s2 right'><a class='right' href='calendar.php?year=$next_year&month=$next_month'>Next Month ></a></div></div>"; 
	$calendar_layout .= "<div class='row'><div class='col s1_7 center'>SUN</div><div class='col s1_7 center'>MON</div><div class='col s1_7 center'>TUE</div><div class='col s1_7 center'>WED</div><div class='col s1_7 center'>THU</div><div class='col s1_7 center'>FRI</div><div class='col s1_7 center'>SAT</div></div>"; 
	
	//This counts the days in the week, up to 7 
	$day_count = 1; 
	$calendar_layout .= "<div class='row'>"; 

	//first we take care of those blank days 
	while ( $blank > 0 ) { 
		$calendar_layout .= "<div class='col s1_7 center cal'> </div>"; 
		$blank = $blank-1; 
		$day_count++; 
	}

	//sets the first day of the month to 1 
	$day_num = 1; 

	//count up the days, until we've done all of them in the month 
	while ( $day_num <= $days_in_month ) {
		$date_of = date('Y-m-d',mktime(0, 0, 0, $month, $day_num, $year));
		$calendar_layout .= "<div class='col s1_7 center cal";
		$today = date('Y-m-d',$date);
		if($date_of == $today){
			$calendar_layout .= " grey lighten-1";
			}
		$calendar_layout .= "'><div class='cal_day'>" . $day_num . "</div>" . get_calendar_events($mysqli,$date_of) ."</div>"; 
		$day_num++;
		$day_count++; 
		//Make sure we start a new row every week 
		if ($day_count > 7) { 
			$calendar_layout .= "</div><div class='row'>"; 
			$day_count = 1; 
		} 
	}

	//Finaly we finish out the table with some blank details if needed  
	while ( $day_count >1 && $day_count <=7 )   {   
		$calendar_layout .= "<div class='col s1_7 center cal'> </div>";   
		$day_count++;   
	}    
	$calendar_layout .= "</div>";
	
	$calendar_layout .= '<div class="fixed-action-btn left"><a class="btn-floating btn-large waves-effect waves-light blue darken-2 tooltipped" data-position="top" data-delay="50" data-tooltip="New Event" name="new_event" href="calendar.php?id=0&date='.$date_of.'"><i class="material-icons">add</i></a></div>';
	
	return $calendar_layout;
}


function get_calendar_events($mysqli,$date_of){
	// List of events
	$events = '';

	// Test connection to the database
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	 
	// Query that retrieves events
	$sql = "SELECT * FROM calendar_events WHERE date = '". $date_of . "' ORDER by start";

	// Execute the query
	$result = $mysqli->query($sql);
	
	// sending the result to success page
	while($row = $result->fetch_assoc()) {
			$events .= '<div class="light-blue lighten-3"><a href="calendar.php?id='.$row['id'].'" class="'.$row['category'].'" title="'. date('h:ia', strtotime($row['start'])).'-'. date('h:ia', strtotime($row['end'])).': '.$row['title'].' - '. $row['location'] .'">'.$row['title'].'</a></div>';
	}
	
	return $events;
}

function get_event($mysqli,$id,$date,$username){
	global $event;
		
	// Test connection to the database
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	// Query that retrieves events
	$sql = "SELECT * FROM calendar_events WHERE id = '". $id . "'";
	// Execute the query
	$result = $mysqli->query($sql);
	// Output
	$row = $result->fetch_assoc();
	
	if ($date != "0"){
		$row['date'] = $date;
	}
	
	$event .= '<form name="event" action="event.php" method="POST">';
	
	if ($id == "0"){
		$event .= '<h2>New Event Details</h2>';
	} else {
		$event .= '<div class="row"><div class="input-field col s12"><h2>Event Details</h2></div></div>';
	}
	$event .= '<div class="row"><div class="input-field col s12"><label for="title">Event Title</label><input id="title" type="text" name="title" required Value="' . $row["title"] . '"></div></div>';
	$event .= '<div class="row"><div class="input-field col s12"><label for="location">Location</label><input id="location" type="text" name="location" required Value="' . $row["location"] . '"></div></div>';
	$event .= '<div class="row"><div class="input-field col s12 l4"><label class="active" for="date">Date</label><input id="date" type="date" name="date" required Value="' . $row["date"] . '"></div><div class="input-field col s12 l4"><label class="active" for="start">Start Time</label><input id="start" type="time" name="start" Value="' . $row["start"] . '"></div>';
	$event .= '<div class="input-field col s12 l4"><label class="active" for="end">End Time</label><input id="end" type="time" name="end" Value="' . $row["end"] . '"></div></div>';
	$event .= '<div class="row"><div class="input-field col s12"><label for="comments">Comments</label><textarea class="materialize-textarea" id="comments" rows="auto" cols="50" name="comments">'.$row['comments'].'</textarea></div></div>';
	$event .= '<div class="row"><div class="input-field col s12 l6"><label for="category">Tech to Attend</label><input id="category" type="text" name="category" list="category_list" Value="'.$row['category'].'"><datalist id="category_list"><option value="Unallocated"><option value="No_Tech"><option value="Matt"><option value="Mitch"><option value="Peter"><option value="Other"></datalist></div><div class="input-field col s12 l6"><label for="user">Update by</label><input id="user" type="text" disabled="true" name="user" Value="' . $row["username"] . '"></div></div>';
	$event .= '<input type="hidden" name="id" value="'. $id .'">';
	$event .= '<input type="hidden" name="username" value="' . $username . '">';
	
	$event .= '<button class="btn-floating btn-large waves-effect waves-light green darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="Save" name="save_button" type="submit" value="true"><i class="material-icons">check</i></button> <button class="btn-floating btn-large waves-effect waves-light yellow darken-2 left tooltipped" data-position="top" data-delay="50" data-tooltip="Delete" name="delete" type="submit" value="Delete"><i class="material-icons">delete</i></button> <button class="btn-floating btn-large waves-effect waves-light red darken-2 right tooltipped" data-position="top" data-delay="50" data-tooltip="Close" type="button" name="close_button" onclick="window.location.href=`calendar.php`"><i class="material-icons">close</i></button></form>';
	return $event;
	
}

function new_install_event($mysqli,$customer,$address,$comments,$install_date,$key_id,$username){

	// Test connection to the database
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	//Get delivery_id
	$sql = "SELECT delivery_id FROM deliveries WHERE key_id = " . $key_id;
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$delivery_id = $row['delivery_id'];
	
	$sql = "SELECT * FROM calendar_events WHERE delivery_id = " . $delivery_id;
	$cal = $mysqli->query($sql);
	if($cal->num_rows > 0){
		$results = true;
	}else{
		// Insert the records
		$sql = "INSERT INTO calendar_events (delivery_id, title, location, comments, date, username) VALUES (?, ?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($sql);
		$statement->bind_param('isssss',$delivery_id,$customer,$address,$comments,$install_date,$username);
			if($statement->execute()){
		$results = true;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	}
	return $results;
}


function add_delivery_event($mysqli,$title,$location,$event_comments,$start,$end,$date,$allday,$category,$key_id,$username){

	// Test connection to the database
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	if ($category == null){
		$category = 'Unallocated';
	}
	//Get delivery_id
	$sql = "SELECT delivery_id FROM deliveries WHERE key_id = " . $key_id;
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$delivery_id = $row['delivery_id'];
	
	$sql = "SELECT * FROM calendar_events WHERE delivery_id = " . $delivery_id;
	$cal = $mysqli->query($sql);
	if($cal->num_rows > 0){
		$cal_row = $cal->fetch_assoc();
		 // Update the records
		$comments = $cal_row['comments'].'&#13;&#10;'.$event_comments.' '.date('d/m/y H:ia');
		$sql = "UPDATE calendar_events SET title=?, location=?, comments=?, start=?, end=?, date=?, allDay=?, category=?, username=? WHERE delivery_id=" .$delivery_id;
		$statement = $mysqli->prepare($sql);
		$statement->bind_param('sssssssss',$title,$location,$comments,$start,$end,$date,$allday,$category,$username);
	}else{
		// Insert the records
		$sql = "INSERT INTO calendar_events (delivery_id, title, location, comments, start, end, date, allDay, category, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($sql);
		$statement->bind_param('isssssssss',$delivery_id,$title,$location,$event_comments,$start,$end,$date,$allday,$category,$username);
	}
	if($statement->execute()){
		$results = true;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	return $results;
}

function manual_event($mysqli,$title,$location,$event_comments,$start,$end,$date,$allday,$category,$id,$username){
	
	// Test connection to the database
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	if ($category == null){
		$category = 'Unallocated';
	}
	echo 'Username: '.$username;
	if($id == 0){
		// Insert the records
		$sql = "INSERT INTO calendar_events (title, location, comments, start, end, date, allDay, category, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($sql);
		$statement->bind_param('sssssssss',$title,$location,$event_comments,$start,$end,$date,$allday,$category,$username);
	} else {
		// Update the records
		$sql = "UPDATE calendar_events SET title=?, location=?, comments=?, start=?, end=?, date=?, allDay=?, category=?, username=? WHERE id=" .$id;
		$statement = $mysqli->prepare($sql);
		$statement->bind_param('sssssssss',$title,$location,$event_comments,$start,$end,$date,$allday,$category,$username);
	}
	if($statement->execute()){
		$results = true;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	return $results;
}

function add_relocation_event($mysqli,$title,$location,$event_comments,$start,$end,$date,$allday,$category,$relocation_id,$username){
 
	// Test connection to the database
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	if ($category == null){
		$category = 'Unallocated';
	}
	
	$sql = "SELECT * FROM calendar_events WHERE relocation_id = " . $relocation_id;
	$cal = $mysqli->query($sql);
	if($cal->num_rows > 0){
		$cal_row = $cal->fetch_assoc();
		 // Update the records
		$comments = $cal_row['comments'].'&#13;&#10;'.$event_comments.' '.date('d/m/y H:ia');
		$sql = "UPDATE calendar_events SET title=?, location=?, comments=?, start=?, end=?, date=?, allDay=?, category=?, username=? WHERE relocation_id=" .$relocation_id;
		$statement = $mysqli->prepare($sql);
		$statement->bind_param('sssssssss',$title,$location,$comments,$start,$end,$date,$allday,$category,$username);
	}else{
		// Insert the records
		$sql = "INSERT INTO calendar_events (relocation_id, title, location, comments, start, end, date, allDay, category, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($sql);
		$statement->bind_param('isssssssss',$relocation_id,$title,$location,$event_comments,$start,$end,$date,$allday,$category,$username);
	}
	if($statement->execute()){
		$results = true;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}
	return $results;
}

function delete_calendar_event($mysqli,$id){
	// Test connection to the database
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	
	// Delete the record
	$sql = "DELETE from calendar_events WHERE id=" .$id;
	$statement = $mysqli->prepare($sql);
	if($statement->execute()){
		$results = true;
	}else{
		die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		$results = false;
	}	
}

?>