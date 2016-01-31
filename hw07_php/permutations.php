<?php
	//code here will permute the string...
// if($_REQUEST)
$string = $_REQUEST["string"];
$permutations = findPermutations($string);

function findPermutations($str)  {
	$permutations = array();
			//should store all permutations into the $permutations array variable
	permute($str, 0, strlen($str), $permutations);

 $cleaned = array_unique($permutations, SORT_STRING);
 $cleaned = array_values($cleaned);

   // return $permutations;
 return $cleaned;
			/*
			for($i = 0; $i < sizeOf($permutations); $i++)	{
				print $permutations[$i] . "<br>";
			}
			print sizeOf($permutations);
			*/
		}

function permute($str, $i, $n, &$arr)  {//, &$arr)  {
	if(!is_array($arr))  {
		$arr = array();
	}
	if($i == $n)    {
		$arr[] = $str;
				// print "$str\n";
	}   else    {
		for($j = $i; $j < $n; $j++) {
     swap($str, $i, $j);
     permute($str, $i + 1, $n, $arr);
     swap($str, $i, $j);
   }
 }
}  

function swap(&$str, $a, $b)    {
	$temp = $str[$b];
	$str[$b] = $str[$a];
	$str[$a] = $temp;
}

function test_length($str) {
 return (strlen($str) > 0);
}

// function clean($arr) {
//    sort($arr);
//    $arrCopy = 
// }

?>


<html>
<head>
  <title>Permutations of String Using PHP</title>
  <script type="text/javascript">
   function onload() {
    var textbox = document.getElementById("textbox_string");
    var input_text = "<?php echo $string; ?>";
    textbox.value = input_text;
    textbox.focus();
    textbox.select();
  }
</script>
<style type="text/css">
 tab   {
   padding-left: 20px;
 }
 #background-image {
   position: fixed;
   top: -15px;
   left: -15px;
   z-index: -1;

   background-color: #000000;
   /*background-image: url('https://dl.dropboxusercontent.com/u/51849338/Desktop/Backgrounds/mountain_at_night-wallpaper-1600x1200.jpg');*/
   background-image: url('https://dl.dropboxusercontent.com/u/51849338/Desktop/Backgrounds/space_sunset.jpg');
   background-size: cover;
   background-repeat: no-repeat;
   /*			width: calc(100% + 500px);*/
   /*			height: calc(100% + 500px);*/
   width: calc(100% + 30px);
   height: calc(100% + 30px);

   -webkit-filter: blur(10px);
   -moz-filter: blur(10px);
   -o-filter: blur(10px);
   -ms-filter: blur(10px);
   filter: blur(10px);
 }
 #body_wrapper	{
   padding-top: 50px;
   padding-left: calc((100% - 400px) / 2);
   padding-right: calc((100% - 400px) / 2);
 }
 #input	{
   font-family: "Trebuchet MS", Helvetica, sans-serif;
   font-size: 14px;
   font-weight: bold;
   /*border-style: dashed;*/
   border-width: thick;
   /*border-color: #1758E4;*/
   border-top-left-radius: 10px;
   border-top-right-radius: 10px;
   background-color: #3B95DA;

   opacity: 0.85;

   color: #EEEEEE;

   padding-top: 20px;
   padding-left: 50px;
   padding-right: 20px;
   padding-bottom: 5px;
 }
 #output	{
   font-family: "Courier New", Courier, monospace;
   font-size: 14px;
   /*border-style: dashed;*/
   border-width: thick;
   border-bottom-left-radius: 10px;
   border-bottom-right-radius: 10px;
   /*border-color: #FF0026;*/
   background-color: #111111;

   opacity: 0.85;

   color: #FFFFFF;

   padding-top: 10px;
   padding-left: 20px;
   padding-right: 20px;
   padding-bottom: 15px;
 }
 #textbox_string	{
   border-color: #FFFFFF;
   border-radius: 5px;
   background-color: #EEEEEE;
   position: relative;
   width: 125px;
   margin-left: 5px;
   margin-right: 5px;
   padding-left: 5px;
 }
 #button_submit	{
   border-style: none;
   border-radius: 1px;
   background-color: #F9AEAE;

   font-family: "Trebuchet MS", Helvetica, sans-serif;
   font-size: 13px;
   font-weight: bold;
 }
</style>
</head>
<body onload="onload();">
  <div id="background-image"></div>
  <div id="body_wrapper">
    <div id="input">
      <form name="form_string" method="GET" action="">
        Enter string:
        <input name="string" id="textbox_string" accessKey="s"/>
        <button type="submit" accessKey="p" id="button_submit"><u>P</u>ermute</button>
      </form>
    </div>
    <div id="output">
     <b>Output: </b><br><br>
     <?php
     if($permutations != null)   {
      $size = count(array_filter($permutations, "test_length"));
    // echo "Size: " . $size . "<br>";
    // echo "Array: " . print_r($permutations) . "<br>";
      print "<br><tab><b>Count: </b>" . ($string == "" ? "0" : $size) . "<br><br>";
      for($i = 0; $i < $size; $i++)	{
      // echo $i;
       print "<tab>" . $permutations[$i] . "<br>";
     }
     // print "<br><br><b>Count: </b>" . ($string == "" ? "0" : count($permutations));
   }
   ?>
 </div>
</div>


</body>
</html>
