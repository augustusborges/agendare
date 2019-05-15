<?php
  	error_reporting(E_ALL|E_STRICT);
	
	// Require our Event class and datetime utilities
	require_once '../config.php';
	require_once BASE_DIR.'lib'.DS.'utils.php';
	
	if (!isset($_GET['start']) || !isset($_GET['end'])) {
	  //die("Please provide a date range.");
	}

	// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
	// Since no timezone will be present, they will parsed as UTC.
	$range_start = parseDateTime($_GET['start']);
	$range_end = parseDateTime($_GET['end']);

	// Parse the timezone parameter if it is present.
	$timezone = null;
	if (isset($_GET['timezone'])) {
	  $timezone = new DateTimeZone($_GET['timezone']);
	}

	// Read and parse our events JSON file into an array of event data arrays.
	$json = file_get_contents(BASE_DIR.'json'.DS.'arquivo.json');
	$input_arrays = json_decode($json, true);

	$output_arrays = array();
	foreach ($input_arrays as $array) {

	  // Convert the input array into a useful Event object
	  $event = new Event($array, $timezone);

	  // If the event is in-bounds, add it to the output
	  if ($event->isWithinDayRange($range_start, $range_end)) {
	    $output_arrays[] = $event->toArray();
	  }
	}
	// Send JSON to the client.
	echo json_encode($output_arrays);
?>
