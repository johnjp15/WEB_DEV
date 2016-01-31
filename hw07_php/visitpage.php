<?php

updateVisitTime();
incrementVisitCount();

////////////////////////////////////
function updateTime()	{
	// date_default_timezone_set('America/New_York');
	echo date_default_timezone_get() . "<br>";

	$date = date('m/d/Y h:i:s a', time());
	echo getTime();
}

function getTime()	{
	return date("m/d/Y h:i:s A");
}

function getNumberOfVisits()	{
	$file = fopen("./count_visits.txt", "r");
	$count = fgets($file);
	if($count == "")	{
		$count = "0";
	}
	fclose($file);

	return $count;
}

function incrementVisitCount()	{
	$current_count = getNumberOfVisits();
	$file = fopen("./count_visits.txt", "w");
	fwrite($file, $current_count + 1);
	fclose($file);
}

function updateVisitTime()	{
	$file = fopen("./time_visit.txt", "a");
	fwrite($file, getTime() . "\n");
	fclose($file);
}

function getTimeOfLastVisit()	{
	$filepath = "./time_visit.txt";
	$file = fopen($filepath, "r");
	$lines = file($filepath);
	$last_visit_time = $lines[sizeof($lines) - 2];

	if($last_visit_time == null || $last_visit_time == "")	{
		$last_visit_time = "n/a";
	}

	return $last_visit_time;
}

?>


<html>
<head>
	<title>Visit Page Lab</title>  
	<link rel="stylesheet" type="text/css" href="css/main.css"/>
	<style type="text/css">
		#output   {
			border-top-left-radius: 10px;
			border-top-right-radius: 10px;
		}
	</style>
	<script type="text/javascript">
		function onload() {
			
		}
	</script>
</head>
<body onload="onload();">
	<div id="background-image"></div>
	<div id="body_wrapper">
		<div id="output">
			<b><h3>Output: </h3></b>
			<?php

			// updateTime();
			echo "<b>Current time: </b>" . getTime();
			echo "<br><b>Time of last visit: </b>" . getTimeOfLastVisit();
			echo "<br><b>Visits: </b>" . @getNumberOfVisits();
			?>
		</div>
	</div>


</body>
</html>
