<!--
    php notes
    John Park
    12/01/2014
    Dr. Gabor's Web Development Class
-->
<?php
    $year = date("Y");
?>
<html>
<head>
    <title>PHP Script 1</title>
</head>
<body>
    <?php
        //phpinfo();
        $foo = 7;
        $str1 = "Hi";
        $str2 = "mom";
        print "\r\n" . $str1 . " " . $str2;
        echo "It is $year.";
        print "\r\n$str1 $str2";


        $arrayVar = array();
        $arrayVar[] = 'foo';
        $arrayVar[sizeOf($arrayVar)] = 'foo';
        $arrayVar[1] = 'string';
        $arrayVar['stringIndex'] = 'foo';
        //array_keys
    ?>
    
    <form name="myform" method="get" action="index.php">
    Enter string to permute: <input name="strPerm"><br>
        <button name="btnSubmit" type="submit" accessKey="s"><u>S</u>ubmit</button>
    </form>
</body>
</html>
<!--
for Friday, write a form for permutations
for Wednesday, php local server, upload php file on tjsite


on server side there is
$_REQUEST['strPerm']

google.com?var=value&var=value

WAMP | LAMP
Windows|Linux Apache MySQL PHP


in command line:
php myscript.php argsGoHere
-->