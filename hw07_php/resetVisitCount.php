<?php
	$file = fopen("./count_visits.txt", "w");
	fwrite($file, "0");
	fclose($file);
?>