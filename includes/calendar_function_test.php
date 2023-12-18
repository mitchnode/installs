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
		$schedule .= '<table class="schedule">';
		$schedule .= '<tr><th>Title</th><th>Location</th><th>Date</th><th>Time</th><th>Tech</th></tr>';
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$result_layout = do_schedule($row['id'],$row["title"],$row["location"],$row["date"],$row["start"],$row["category"]);
			$schedule .= '<tr class="'. $row['category'] .'_s">' . $result_layout . '</tr>';
		}
		$schedule .= '</table>';
	} else {
		$schedule .= 'No Current Events';
	}
	
	return $schedule;
}

function showHours() {
	global $day_week_start_hour, $day_week_end_hour;
	// build day
	$hours = "<td class=\"timex\"><table class=\"day\"><tr><td width=\"100%\"><div class=\"time_frame\">\n";
	$i = $day_week_start_hour ? $day_week_start_hour : 7;
	$j = $day_week_start_hour ? 0 : 30;
	$max = $day_week_end_hour ? $day_week_end_hour : 18;
	$hours .= "<div class=\"cell\">All day</div>\n";
	while ($i < $max) {
		if ($j < 10) {
			$j = "0".$j;
			
		}
		if ($i == 0) {
			$h = 12;
			$ap = "am";
		} elseif ($i == 12) {
			$h = $i;
			$ap = "pm";
		} elseif ($i > 12) {
			$h = $i - 12;
			$ap = "pm";
		} else {
			$h = $i;
			$ap = "am";
		}
		$hours .= "<div class=\"cell\">".$h.":".$j." ".$ap."</div>\n";
		$j = $j+30;
		if ($j >= 60) {
			$j = "0";
			$i++;
		}
	}
	$hours .= "</div></td></tr></table></td>";
	return $hours;
}

function showDay($dy,$dm,$da,$mysqli) {
	global $la, $w, $c, $day_week_start_hour, $day_week_end_hour;
	$date = date('Y-m-d', mktime(0,0,0,$dm,$da,$dy));
	// build day
	$day_table = "<td>";
	$i = $day_week_start_hour ? $day_week_start_hour : 7;
	$j = $day_week_start_hour ? 0 : 30;
	$max = $day_week_end_hour ? $day_week_end_hour : 18;
	$notime = date('H:i:s', mktime(0,0,0,$dm,$da,$dy));
	$day_table .= '<table class="day_table" rows="21" cols="100">';
	$day_table .= '<tr class="cell">'.get_event_data($mysqli,$date,$notime).'</tr>';
	while ($i < $max) {
		if ($j < 10) {
			$j = "0".$j;
			if ($i < 10) $i = $i;
		}
		if ($i == 0) {
			$h = 12;
			$ap = "am";
		} elseif ($i == 12) {
			$h = $i;
			$ap = "pm";
		} elseif ($i > 12) {
			$h = $i - 12;
			$ap = "pm";
		} else {
			$h = $i;
			$ap = "am";
		}
		if ($i < 10) $i = $i;
		$day_table .= "<tr class='cell'>";
		
		
		//GET EVENT DATA
				
		$time = date('H:i:s', mktime($i,$j,0,$dm,$da,$dy));
		$day_table .= get_event_data($mysqli,$date,$time);
		
		$day_table .= "</tr>";
		$j = $j+30;
		if ($j >= 60) {
			$j = "0";
			$i++;
		}
	}
	
	
	
	
	$sdate = $dy.$dm.$da;
	$day_table .= "</table></td>";

	return $day_table;
}

function showDayWeek($dy,$dm,$da,$mysqli) {
	global $la, $w, $c, $day_week_start_hour, $day_week_end_hour;
	$date = date('Y-m-d', mktime(0,0,0,$dm,$da,$dy));
	// build day
	$day_table = "<td style='width:19%'>";
	$i = $day_week_start_hour ? $day_week_start_hour : 7;
	$j = $day_week_start_hour ? 0 : 30;
	$max = $day_week_end_hour ? $day_week_end_hour : 18;
	
	$day_table .= '<table class="day_week_table" rows="21" cols="100">';
	$notime = date('H:i:s', mktime(0,0,0,$dm,$da,$dy));
	$day_table .= '<tr class="cell">'.get_event_data($mysqli,$date,$notime).'</tr>';
	while ($i < $max) {
		if ($j < 10) {
			$j = "0".$j;
			if ($i < 10) $i = $i;
		}
		if ($i == 0) {
			$h = 12;
			$ap = "am";
		} elseif ($i == 12) {
			$h = $i;
			$ap = "pm";
		} elseif ($i > 12) {
			$h = $i - 12;
			$ap = "pm";
		} else {
			$h = $i;
			$ap = "am";
		}
		if ($i < 10) $i = $i;
		$day_table .= "<tr class='cell'>";
		
		
		//GET EVENT DATA
				
		$time = date('H:i:s', mktime($i,$j,0,$dm,$da,$dy));
		$day_table .= get_event_data($mysqli,$date,$time);
		
		$day_table .= "</tr>";
		$j = $j+30;
		if ($j >= 60) {
			$j = "0";
			$i++;
		}
	}
	
	
	
	
	$sdate = $dy.$dm.$da;
	$day_table .= "</table></td>";

	return $day_table;
}


function get_event_data($mysqli,$date,$time){
	// List of events
	$event = '';

	// Test connection to the database
	if ($mysqli->connect_errno){
		die("Failed to connect to MySQL: " . $mysqli->connect_error);
	}
	 
	// Query that retrieves events
	$sql = "SELECT * FROM calendar_events WHERE date = '". $date . "' AND start = '" . $time . "'";
	
	// Execute the query
	$result = $mysqli->query($sql);
	$num_rows = $result->num_rows;
	if ($num_rows == 0){
		$event.= '<td colspan="100" class="cell"></td>';
	} else {
		$event_width = 100 / $num_rows;
		// sending the result to success page
		while($row = $result->fetch_assoc()) {
				$event_height = (((idate('H',strtotime($row['end']))+(idate('i',strtotime($row['end']))/60))-(idate('H',strtotime($row['start']))+(idate('i',strtotime($row['start'])))/60))*2);
				if ($event_height < 1){
					$event_height = 1;
				}
				$event .= '<td style="width:33.3%;" rowspan="'. $event_height .'" class="cell"><div style="height:'.($event_height*26).'px;"><a href="calendar.php?d=true&id='.$row['id'].'" id="day_event" class="'.$row['category'].'_dayview" title="'. date('h:ia', strtotime($row['start'])).'-'. date('h:ia', strtotime($row['end'])).': '.$row['title'].' - '. $row['location'] .'">'.$row['title'].'</a></div></td>';
		}
		$event .= '<td colspan="100" class="cell"></td>';
	}
	return $event;
}

function get_day_layout($mysqli,$month, $day, $year){
	//This gets today's date
	$date =time () ;

	//Here we generate the first day of the month
	$first_day = mktime(0,0,0,$month, 1, $year) ;

	//This gets us the month name
	$title = date('l, F j, Y', mktime(0,0,0,$month,$day,$year)) ;

	//We then determine how many days are in the current month 
	$prev_day = ($day-1);
	$next_day = ($day+1);
	//Here we start building the table heads
	$day_layout = '<table width="100%"><tr><td><div id="cal_button"><a href="calendar.php?w=true">Week View</a></div></td><td><div id="cal_button"><a href="calendar.php">Month View</a></div></td></tr></table>';
	
	$day_layout .= "<table id='day_view'>";
	$day_layout .= "<tr><th colspan='5'><div id='day_title'><a class='day_nav' href='calendar.php?month=$month&day=$prev_day&year=$year&d=true'>< Previous Day</a> $title <a class='day_nav' href='calendar.php?month=$month&day=$next_day&year=$year&d=true'>Next Day ></a></div></th></tr>"; 
	$day_layout .= "<tr>"; 
	$day_layout .= showHours();
	
	$day_layout .= showDay($year,$month,$day,$mysqli);
	    
	$day_layout .= "</tr></table>";
	
	return $day_layout;
}

function get_week_layout($mysqli,$month, $day, $year){
	//This gets today's date
	$date =time () ;

	//Here we generate the first day of the month
	$first_day = strtotime('last monday', mktime(0,0,0,$month, ($day+1), $year));
	$wday = date('d',$first_day);
	$wmonth = date('m',$first_day);
	$wyear = date('Y',$first_day);
	
	//This gets us the month name
	$title = date('l, F j, Y', mktime(0,0,0,$month,$day,$year)) ;
	$day_count = 1;
	
	//Here we start building the table heads
	
	$week_layout = '<table width="100%"><tr><td><div id="cal_button"><a href="calendar.php?d=true">Day View</a></div></td><td><div id="cal_button"><a href="calendar.php">Month View</a></div></td></tr></table>';
	
	$week_layout .= "<table id='week_view'>";
	$week_layout .= "<tr><th></th><th>Monday ".$wday."/".$wmonth."/".$wyear."</th><th>Tuesday ".($wday+1)."/".$wmonth."/".$wyear."</th><th>Wednesday ".($wday+2)."/".$wmonth."/".$wyear."</th><th>Thursday ".($wday+3)."/".$wmonth."/".$wyear."</th><th>Friday ".($wday+4)."/".$wmonth."/".$wyear."</th></tr>";
	$week_layout .= "<tr>"; 
	$week_layout .= showHours();
	
	while ($day_count <= 5){
		$week_layout .= showDayWeek($wyear,$wmonth,$wday,$mysqli);
		$day_count++;
		$wday++;
	}
	$week_layout .= "</tr></table>";
	
	return $week_layout;
}



function get_calendar_layout($mysqli,$month){
	//This gets today's date
	$date =time () ;

	//This puts the day, month, and year in seperate variables
	$day = date('d', $date) ;
	$year = date('Y', $date) ;

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
	$prev_month = ($month-1);
	$next_month = ($month+1);
	//Here we start building the table heads 
	$calendar_layout = '<table width="100%"><tr><td><div id="cal_button"><a href="calendar.php?d=true">Day View</a></div></td><td><div id="cal_button"><a href="calendar.php?w=true">Week View</a></div></td></tr></table>';
	
	$calendar_layout .= "<table id='calendar'>";
	$calendar_layout .= "<tr><th><a class='month_nav' href='calendar.php?month=$prev_month'>< Previous Month</a></th><th colspan=5> $title $year </th><th><a class='month_nav' href='calendar.php?month=$next_month'>Next Month ></a></th></tr>"; 
	$calendar_layout .= "<tr><th id='days'>Sunday</th><th id='days'>Monday</th><th id='days'>Tuesday</th><th id='days'>Wednesday</th><th id='days'>Thursday</th><th id='days'>Friday</th><th id='days'>Saturday</th></tr>"; 
	
	//This counts the days in the week, up to 7 
	$day_count = 1; 
	$calendar_layout .= "<tr>"; 

	//first we take care of those blank days 
	while ( $blank > 0 ) { 
		$calendar_layout .= "<td></td>"; 
		$blank = $blank-1; 
		$day_count++; 
	}

	//sets the first day of the month to 1 
	$day_num = 1; 

	//count up the days, until we've done all of them in the month 
	while ( $day_num <= $days_in_month ) {
		$date_of = date('Y-m-d',mktime(0, 0, 0, $month, $day_num, $year));
		$calendar_layout .= "<td>" . $day_num . get_calendar_events($mysqli,$date_of) ."<a class='new_event' href='calendar.php?id=0&date=".$date_of."'>+</a></td>"; 
		$day_num++;
		$day_count++; 
		//Make sure we start a new row every week 
		if ($day_count > 7) { 
			$calendar_layout .= "</tr><tr>"; 
			$day_count = 1; 
		} 
	}

	//Finaly we finish out the table with some blank details if needed  
	while ( $day_count >1 && $day_count <=7 )   {   
		$calendar_layout .= "<td> </td>";   
		$day_count++;   
	}    
	$calendar_layout .= "</tr></table>";
	
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
			$events .= '<div id="events"><a href="calendar.php?id='.$row['id'].'" class="'.$row['category'].'" title="'. date('h:ia', strtotime($row['start'])).'-'. date('h:ia', strtotime($row['end'])).': '.$row['title'].' - '. $row['location'] .'">'.$row['title'].'</a></div>';
	}
	
	return $events;
}

function get_event($mysqli,$id,$date,$username){
	global $event;
	
	$script = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';";
	$script_close = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';";
	
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
	
	$event .= '<div id="light" class="white_content"><form name="event" action="event.php" method="POST"><table id="event">';
	
	if ($id == "0"){
		$event .= '<tr><td colspan="8"><h2>New Event Details</h2></td></tr>';
	} else {
		$event .= '<tr><td colspan="8"><h2>Event Details</h2></td></tr>';
	}
	$event .= '<tr><td colspan="2">Event Title</td><td colspan="6"><input id="input_text" type="text" name="title" placeholder="Event Title" required Value="' . $row["title"] . '"></td></tr>';
	$event .= '<tr><td colspan="2">Location</td><td colspan="6"><input id="input_text" type="text" name="location" placeholder="Location" required Value="' . $row["location"] . '"></td></tr>';
	$event .= '<tr><td colspan="2">Date</td><td colspan="2"><input type="date" name="date" required Value="' . $row["date"] . '"></td><td colspan="2">Start Time</td><td colspan="2"><input id="input_text" type="time" name="start" Value="' . $row["start"] . '"></td></tr>';
	$event .= '<tr><td colspan="4">All Day?<input type="checkbox" name="allday" value="Yes"';
	if($row["allDay"]=="Yes"){
		$event .= ' checked';
	}
	$event .= '></td><td colspan="2">End Time</td><td colspan="2"><input type="time" name="end" Value="' . $row["end"] . '"></td></tr>';
	$event .= '<tr><td colspan="8"><br></td></tr>';
	$event .= '<tr><td colspan="8"><h3>Comments</h3></td></tr>';
	$event .= '<tr><td colspan="8"><textarea id="comments" rows="7" cols="50" name="comments" placeholder="Comments">'.$row['comments'].'</textarea></td></tr>';
	$event .= '<tr><td colspan="2">Tech to Attend</td><td colspan="2"><input id="input_text" type="text" name="category" list="category" placeholder="Tech To Attend" Value="'.$row['category'].'"><datalist id="category"><option value="No_Tech"><option value="Ash"><option value="Mitch"><option value="Mitch_and_Ash"><option value="Other"></datalist></td><td colspan="4">  Updated by: '. $row["username"] .'</td></tr>';
	$event .= '<tr><td colspan="2"><br></td></tr>';

	$event .= '<tr><td colspan="8"><input type="hidden" name="id" value="'. $id .'">';
	$event .= '<input type="hidden" name="username" value="' . $username . '">';
	$event .= '</td></tr></table><br>';
	$event .= '<input id="button" name="save_button" type="submit" Value="Save"> <input id="button" name="delete" type="submit" Value="Delete"> ';
	
	$event .= '<input type="button" value="Close" onclick="'. $script_close .'"></form></div><script>'. $script .'</script>';
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