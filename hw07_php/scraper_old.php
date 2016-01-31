<?php
$url = "http://www.ebay.com/sch/i.html?_odkw=test&_from=R40&_osacat=0&_from=R40&_trksid=p2045573.m570.l1313.TR11.TRC1.A0.H0.Xlaptop&_nkw=laptop&_sacat=0";

$data = file_get_contents($url);

$regex = "/<\s*h3\s*class\s*=\s*\"lvtitle\"\s*>\s*<\s*a\s*href\s*=\s*\".*?\"/";

// print($data);
$matches = array();

preg_match_all($regex, $data, $matches);
// print_r($matches);
$size_matches = sizeof($matches);
$urls = array_values($matches);

//try preg_match or strstr() or stristr() or strpos() or strip_tags
?>

<html>
<head>
	<title>Page Scraper Lab</title>  
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

			print_r($matches);
			?>
		</div>
	</div>


</body>
</html>