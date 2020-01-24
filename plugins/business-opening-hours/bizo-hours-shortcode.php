<?php 
function bizohours_shortcode( $args, $instance ) {

		$args = shortcode_atts( array(
			'title' => 'Business Opening Hours',
			'mondayfrom' => '10:00am',
			'mondayto' => '10:00pm',
			'tuesdayfrom' => '10:00am',
			'tuesdayto' => '10:00pm',
			'wednesdayfrom' => '10:00am',
			'wednesdayto' => '10:00pm',
			'thursdayfrom' => '10:00am',
			'thursdayto' => '10:00pm',
			'fridayfrom' => '10:00am',
			'fridayto' => '10:00pm',
			'saturdayfrom' => '10:00am',
			'saturdayto' => '10:00pm',
			'sundayfrom' => '10:00am',
			'sundayto' => '10:00pm',
			'bizohbgcolor' => '#000000',
			'bizohfontcolor' => '#ffffff'

		), $args );

		$bizoh_currentday_style = 'style="background-color:'.$args["bizohbgcolor"].';color:'.$args["bizohfontcolor"].';"';
		$bizohours_options = get_option( "bizohours_options" );
		$timezone = $bizohours_options["timezone"];
		if(empty($timezone) || stristr($timezone, 'UTC+') || stristr($timezone, 'UTC-') ) {
			$timezone = 'UTC';
		}
		
		$date = new DateTime('now', new DateTimeZone($timezone));
		$currentday = $date->format('w');

		$_monday_from = ($args["mondayfrom"] == 'Close') ? __("Close", "bizo-hours") : $args["mondayfrom"];
		$_monday_to = ($args["mondayto"] == 'Close') ? __("Close", "bizo-hours") : $args["mondayto"];
		$_tuesday_from = ($args["tuesdayfrom"] == 'Close') ? __("Close", "bizo-hours") : $args["tuesdayfrom"];
		$_tuesday_to = ($args["tuesdayto"] == 'Close') ? __("Close", "bizo-hours") : $args["tuesdayto"];
		$_wednesday_from = ($args["wednesdayfrom"] == 'Close') ? __("Close", "bizo-hours") : $args["wednesdayfrom"];
		$_wednesday_to = ($args["wednesdayto"] == 'Close') ? __("Close", "bizo-hours") : $args["wednesdayto"];
		$_thursday_from = ($args["thursdayfrom"] == 'Close') ? __("Close", "bizo-hours") : $args["thursdayfrom"];
		$_thursday_to = ($args["thursdayto"] == 'Close') ? __("Close", "bizo-hours") : $args["thursdayto"];
		$_friday_from = ($args["fridayfrom"] == 'Close') ? __("Close", "bizo-hours") : $args["fridayfrom"];
		$_friday_to = ($args["fridayto"] == 'Close') ? __("Close", "bizo-hours") : $args["fridayto"];
		$_saturday_from = ($args["saturdayfrom"] == 'Close') ? __("Close", "bizo-hours") : $args["saturdayfrom"];
		$_saturday_to = ($args["saturdayto"] == 'Close') ? __("Close", "bizo-hours") : $args["saturdayto"];
		$_sunday_from = ($args["sundayfrom"] == 'Close') ? __("Close", "bizo-hours") : $args["sundayfrom"];
		$_sunday_to = ($args["sundayto"] == 'Close') ? __("Close", "bizo-hours") : $args["sundayto"];
		
		$output = '';
		$output .=
		'<h2>'. $args["title"] .'</h2>
		<table class="bizoh-table">
			<thead>
				<tr><th>'. __("Day", "bizo-hours") .'</th><th>'. __("From", "bizo-hours") .'</th><th>'. __("To", "bizo-hours") .'</th></tr>
			</thead>
			<tbody>
				<tr '; 
				if ($currentday == 1)
					$output .= $bizoh_currentday_style;
				$output .= ' ><td>'. __("Monday", "bizo-hours") .'</td><td>'. $_monday_from .'</td><td>'. $_monday_to .'</td></tr>
				<tr '; 
				if ($currentday == 2)
					$output .= $bizoh_currentday_style;
				$output .= ' ><td>'. __("Tuesday", "bizo-hours") .'</td><td>'. $_tuesday_from .'</td><td>'. $_tuesday_to .'</td></tr>
				<tr '; 
				if ($currentday == 3)
					$output .= $bizoh_currentday_style;
				$output .= ' ><td>'. __("Wednesday", "bizo-hours") .'</td><td>'. $_wednesday_from .'</td><td>'. $_wednesday_to .'</td></tr>
				<tr '; 
				if ($currentday == 4)
					$output .= $bizoh_currentday_style;
				$output .= ' ><td>'. __("Thursday", "bizo-hours") .'</td><td>'. $_thursday_from .'</td><td>'. $_thursday_to .'</td></tr>
				<tr '; 
				if ($currentday == 5)
					$output .= $bizoh_currentday_style;
				$output .= ' ><td>'. __("Friday", "bizo-hours") .'</td><td>'. $_friday_from .'</td><td>'. $_friday_to .'</td></tr>
				<tr '; 
				if ($currentday == 6)
					$output .= $bizoh_currentday_style;
				$output .= ' ><td>'. __("Saturday", "bizo-hours") .'</td><td>'. $_saturday_from .'</td><td>'. $_saturday_to .'</td></tr>
				<tr '; 
				if ($currentday == 0)
					$output .= $bizoh_currentday_style;
				$output .= ' ><td>'. __("Sunday", "bizo-hours") .'</td><td>'. $_sunday_from .'</td><td>'. $_sunday_to .'</td></tr>
		    </tbody>
		</table>';
	return $output;	
		
}

// Generate Shortcode
add_shortcode( 'bizohours', 'bizohours_shortcode' );
