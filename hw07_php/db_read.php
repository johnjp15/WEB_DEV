<?php
$file = trim($_REQUEST["file"]);

//DATABASE
class MyDB extends SQLite3 
{ 
	function __construct() 
	{
		$this->open('ebay.db'); 
	}
}
$db = new MyDB();
$query = "SELECT * FROM ebay";

$result = $db->query($query);


$table = "<table>
		<td><b>Time Updated</b></td>
		<td><b>Item ID</b></td>
		<td><b>Condition</b></td>
		<td><b>Price</b></td>
		<td><b>Shipping</b></td>
		<td><b>Start Time</b></td>
		<td><b>End Time</b></td>
		<td><b>Location</b></td>
		<td><b>Payment Method</b></td>
		<td><b>URL</b></td>
	</tr>";

while($array = $result->fetchArray())	{
	$table .= "<tr>";
for($i = 0; $i < sizeof($array); $i++)	{
	// for($j = 0; $j < sizeof($array[$i]); $j++)	{
	if($i == 9)	{
		$table .= "<td><a href=\"" . $array[$i] . "\">Link</a></td>";
	}	else	{
		$table .= "<td>" . $array[$i] . "</td>";
	}
	// }
}
	$table .= "</tr>";
}
$table .= "</table>";
?>
	<html>
	<head>
		<title>Database File Reader</title>  
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
				border-color: #FFFFFF;
				border-style: solid;
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
				// var textbox = document.getElementById("textbox_string");
				// var input_text = "<?php echo $query; ?>";
				// textbox.value = input_text;
				// textbox.focus();
				// textbox.select();
			}
		</script>
	</head>
	<body onload="onload();">
		<div id="background-image"></div>
		<div id="body_wrapper">
			<div id="input">
			<h1>Database Contents of "<?php echo $file; ?>"</h1>
				<!-- <form name="form_string" method="GET" action="">
					eBay:
					<input name="query" id="textbox_string" accessKey="s"/>
					<button type="submit" accessKey="s" id="button_submit"><u>S</u>earch</button>
				</form> -->
			</div>
			<div id="output">
				<!-- <h1>Database Contents of "<?php echo $file; ?>"</h1> -->
				<table>
					<tr>
						<td>
							<?php echo $table;?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
	</html>