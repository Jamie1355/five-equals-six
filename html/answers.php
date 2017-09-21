<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="styles.css">
		
		<script type="text/javascript" src="5e6.js"></script>
</HEAD>
<BODY>

<?php
	include("functions.php");
	include ("view.php");
	
	$db=new MyDB();
	if(!$db){
		echo $db->lastErrorMsg();
		die;
	}
	
	$text = "<h1>Answers to the questions</h1>";
	// go through the post data while there are questions
	$i = 0;
	while (array_key_exists("Q-" . $i,$params))
	{
		$text .= DisplayAnswers($i, $params["Q-" . $i],$params["A-" . $i],$params["CA-" . $i] );
		$i++;
	}
	$text .= "<h1>How did you do?</h1><FORM ACTION=\"status.php\" METHOD=\"POST\">";	
	$text .= "<INPUT TYPE=\"radio\" NAME=\"Score\" VALUE=\"5\">All correct</INPUT><BR>";
	$text .= "<INPUT TYPE=\"radio\" NAME=\"Score\" VALUE=\"4\">Mostly correct</INPUT><BR>";
	$text .= "<INPUT TYPE=\"radio\" NAME=\"Score\" VALUE=\"3\">Some wrong</INPUT><BR>";
	$text .= "<INPUT TYPE=\"radio\" NAME=\"Score\" VALUE=\"2\">Most wrong</INPUT><BR>";
	$text .= "<INPUT TYPE=\"radio\" NAME=\"Score\" VALUE=\"2\">All wrong</INPUT><BR>";
	$text .= "<INPUT TYPE=\"Submit\" VALUE=\"Save\"></FORM>";
	echo $text;

?>

</BODY>
</HEAD>