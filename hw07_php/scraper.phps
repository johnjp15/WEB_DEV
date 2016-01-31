	<?php
	error_reporting(E_ALL);  // Turn on all errors, warnings and notices for easier debugging

	// API request variables
	$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
	$version = '1.0.0';  // API version supported by your application
	$appid = 'JohnPark-23a8-4d89-aa3e-ccd391087ff6';  // Replace with your own AppID
	$globalid = 'EBAY-US';  // Global ID of the eBay site you want to search (e.g., EBAY-DE)
	$query = trim($_REQUEST["query"]); // You may want to supply your own query
	$safequery = urlencode($query);  // Make the query URL-friendly
	$i = '0';  // Initialize the item filter index to 0

	// Construct the findItemsByKeywords HTTP GET call
	$apicall = "$endpoint?";
	$apicall .= "OPERATION-NAME=findItemsByKeywords";
	$apicall .= "&SERVICE-VERSION=$version";
	$apicall .= "&SECURITY-APPNAME=$appid";
	$apicall .= "&GLOBAL-ID=$globalid";
	$apicall .= "&keywords=$safequery";
	$apicall .= "&paginationInput.entriesPerPage=10";
	// $apicall .= "$urlfilter";
	/*
	expiration date  time
	shipping price
	item condition
	save entries to text file
	version with information dumped to database

	Front:
	A: 7
	B: 22
	C: 13

	Back:
	A: 23
	B: 1
	C: 18

	my project
	problem is different data stored
	some info is the same
	another problem, the data is hard to match
	program would be confused
	more work for humans
	*/

	// Load the call and capture the document returned by eBay API
	$resp = simplexml_load_file($apicall);

	// Check to see if the request was successful, else print an error
	if ($resp->ack == "Success") {	
		$results = '<tr>
		<td><b>Image</b></td>
		<td><b>Item</b></td>
		<td><b>Condition</b></td>
		<td><b>Price</b></td>
		<td><b>Shipping</b></td>
		<td><b>Start Time</b></td>
		<td><b>End Time</b></td>
		<td><b>Location</b></td>
		<td><b>Payment Method</b></td>
		<td style=\"text-align: right; margin-right: 10px;\"><b>ID</b></td>
	</tr>';	

	//DATABASE
	class MyDB extends SQLite3 
	{ 
		function __construct() 
		{
			$this->open('ebay.db'); 
		}
	}
	$db = new MyDB();

	// $limit = 10;
	$create_cmd = "CREATE TABLE IF NOT EXISTS ebay (TimeAdded TEXT, Id INT, Condition TEXT, Price INT, Shipping INT, StartTime TEXT, EndTime TEXT, Location TEXT, PaymentMethod TEXT, URL TEXT)";
	$create = $db->query($create_cmd);



	  // If the response was loaded, parse it and build links
	foreach($resp->searchResult->item as $item) {
	//http://stackoverflow.com/questions/20048033/ebay-api-grabbing-user-products-grabbing-individual-product-details
	//http://zetcode.com/db/sqlitephp/
		$pic   = $item->galleryURL;
		$link  = $item->viewItemURL;
		$title = $item->title;

			///my own
		$unformattedmoney = ((float)$item->sellingStatus->currentPrice)
	;	$price = money_format('$%i', $unformattedmoney);

			///////////
		$itemsID = $item->itemId;
		$shippingprice = sprintf("%01.2f", $item->shippingInfo->shippingServiceCost);
		$ship  = ($shippingprice == 0) ? "Free" : money_format('$%i', $shippingprice);
		$price = money_format('$%i', sprintf("%01.2f", $item->sellingStatus->convertedCurrentPrice));
		//$total = money_format('$%i', sprintf("%01.2f", ((float)$item->sellingStatus->convertedCurrentPrice + (float)$item->shippingInfo->shippingServiceCost)));
		$timeLeft = $item->sellingStatus->timeLeft;
	    $startTime = date('m/d/y  h:i a', strtotime($item->listingInfo->startTime));
	    $endTime = date('m/d/y  h:i a', strtotime($item->listingInfo->endTime));
			///////////
	    $location = $item->location;
	    $paymentMethod = $item->paymentMethod;
	    $condition = $item->condition->conditionDisplayName;

	    // For each SearchResultItem node, build a link and append it to $results
	    $results .= "<tr>
	    <td><img src=\"$pic\"></td>
	    <td><a href=\"$link\">$title</a></td>
	    <td>$condition</td>
	    <td style=\"text-align: right; margin-right: 10px;\">$price</td>
	    <td style=\"text-align: right; margin-right: 10px;\">$ship</td>
	    <td style=\"text-align: right; margin-right: 10px;\">$startTime</td>
	    <td style=\"text-align: right; margin-right: 10px;\">$endTime</td>
	    <td style=\"text-align: right; margin-right: 10px;\">$location</td>
	    <td style=\"text-align: right; margin-right: 10px;\">$paymentMethod</td>
	    <td style=\"text-align: right; margin-right: 10px;\">$itemsID</td>

		</tr>";

		$date = date('m/d/Y h:i:s a', time());


	//DATABASE

	$insert_cmd = "INSERT INTO ebay(TimeAdded, Id, Condition, Price, Shipping, StartTime, EndTime, Location, PaymentMethod, URL) values('$date', '$itemsID', '$condition', '$price', '$ship', '$startTime', '$endTime', '$location', '$paymentMethod', '$link')";
	$insert = $db->query($insert_cmd);

	}
	$results .= "</table>";
	}
	elseif ($query == null || $query == "") {
		$results = "Please enter a valid query.";
	}
	// If the response does not indicate 'Success,' print an error
	else {
		$results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
		$results .= "AppID for the Production environment.</h3>";
	}

/*

	// Generates an indexed URL snippet from the array of item filters
	function buildURLArray ($filterarray) {
		global $urlfilter;
		global $i;
	  // Iterate through each filter in the array
		foreach($filterarray as $itemfilter) {
	    // Iterate through each key in the filter
			foreach ($itemfilter as $key =>$value) {
				if(is_array($value)) {
	        foreach($value as $j => $content) { // Index the key for each value
	        	$urlfilter .= "&itemFilter($i).$key($j)=$content";
	        }
	    }
	    else {
	    	if($value != "") {
	    		$urlfilter .= "&itemFilter($i).$key=$value";
	    	}
	    }
	}
	$i++;
	}
	return "$urlfilter";
	} // End of buildURLArray function

	// Build the indexed item filter URL snippet
*/
	?>
	<!-- Build the HTML page with values from the call response -->
	<html>
	<head>
		<title>Page Scraper Lab</title>  
		<link rel="stylesheet" type="text/css" href="css/main.css"/>
		<style type="text/css">
	/*		#output   {
				border-top-left-radius: 10px;
				border-top-right-radius: 10px;
			}*/
			#body_wrapper	{
				padding-left: calc((100% - 1100px) / 2);
				padding-right: calc((100% - 1100px) / 2);;
			}
			#input	{
				padding-left: 200px;
			}
			#output	{
				font-family: "Trebuchet MS", Helvetica, sans-serif;
			}
			#output a	{
				color: #62C8FF;
			}
			#textbox_string	{
				width: 200px;
			}
			table	{
				border-color: #FFFFFF;
			}
			tr	{
				margin-right: 10px;
			}
			td	{
				color: #F0F0F0;
				padding-top: 10px;
				padding-left: 10px;
			}
			img	{
				border-radius: 5px;
			}
			#background-image	{
				background-image: url("http://cache.desktopnexus.com/thumbnails/299183-bigthumbnail.jpg");
			}
		</style>
		<script type="text/javascript">
			function onload() {
				var textbox = document.getElementById("textbox_string");
				var input_text = "<?php echo $query; ?>";
				textbox.value = input_text;
				textbox.focus();
				textbox.select();
			}
		</script>
	</head>
	<body onload="onload();">
		<div id="background-image"></div>
		<div id="body_wrapper">
			<div id="input">
				<form name="form_string" method="GET" action="">
					eBay:
					<input name="query" id="textbox_string" accessKey="s"/>
					<button type="submit" accessKey="s" id="button_submit"><u>S</u>earch</button>
				</form>
			</div>
			<div id="output">
				<h1>eBay Search Results for "<?php echo $query; ?>"</h1>
				<table>
					<tr>
						<td>
							<?php echo $results;?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
	</html>