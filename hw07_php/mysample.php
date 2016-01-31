<?php
error_reporting(E_ALL);  // Turn on all errors, warnings and notices for easier debugging

// API request variables
$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$version = '1.0.0';  // API version supported by your application
$appid = 'JohnPark-23a8-4d89-aa3e-ccd391087ff6';  // Replace with your own AppID
$globalid = 'EBAY-US';  // Global ID of the eBay site you want to search (e.g., EBAY-DE)
$query = $_REQUEST["query"]; // You may want to supply your own query
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



// Load the call and capture the document returned by eBay API
$resp = simplexml_load_file($apicall);

// Check to see if the request was successful, else print an error
if ($resp->ack == "Success") {
	$results = '';
  // If the response was loaded, parse it and build links
	foreach($resp->searchResult->item as $item) {
		$pic   = $item->galleryURL;
		$link  = $item->viewItemURL;
		$title = $item->title;

		///my own
		$unformattedmoney = ((float)$item->sellingStatus->currentPrice);
		$price = money_format('$%i', $unformattedmoney);

    // For each SearchResultItem node, build a link and append it to $results
		$results .= "<tr><td><img src=\"$pic\"></td><td><a href=\"$link\">$title</a></td><td style=\"text-align: right; margin-right: 10px;\">$price</td></tr>";
	}
}
elseif ($query == null || $query == "") {
	$results = "Please enter a valid query.";
}
// If the response does not indicate 'Success,' print an error
else {
	$results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
	$results .= "AppID for the Production environment.</h3>";
}



// Create a PHP array of the item filters you want to use in your request
$filterarray =
array(
	array(
		'name' => 'MaxPrice',
		'value' => '25',
		'paramName' => 'Currency',
		'paramValue' => 'USD'),
	array(
		'name' => 'FreeShippingOnly',
		'value' => 'true',
		'paramName' => '',
		'paramValue' => ''),
	array(
		'name' => 'ListingType',
		'value' => array('AuctionWithBIN','FixedPrice'),
		'paramName' => '',
		'paramValue' => ''),
	);

////////////////////////////////////////////////////////////////////////////////////////////
$urlfilter = buildURLArray($filterarray);
$apicall .= "$urlfilter";
////////////////////////////////////////////////////////////////////////////////////////////

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
			padding-left: calc((100% - 800px) / 2);
			padding-right: calc((100% - 800px) / 2);;
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