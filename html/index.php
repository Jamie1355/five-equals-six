<html>
    <head>
	    <title>Five Equals Six</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		
		<script type="text/javascript" src="5e6.js"></script>
		
	</head>
	
	<body>
		<div id="wholpepage">
			<div id=header>
				This is a header
				<BR>
				<button onclick="toggle_sidebar()">-</button>
			</div>
			<table CELLPADDING=0 CELLSPACING=0>
			<tr>
			<td id="sidebar" valign="top">
		
				<?php
require("functions.php");

 $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
	  $sql = "SELECT * from Topics order by TopicID;";
	  $results = $db->RunQuery($sql);
	  $text = "";
	  foreach($results as $row)
	  {
		  $name = $row['TopicName'];
		  $id = $row['TopicID'];
		  if (strlen($row['TopicFolderPath']) > 0)
		  {
			  $text .= "<DIV class=\"live_section\"><A style=\"vertical-align: middle;\" HREF=\"topic.php?MODE=Subsection&TopicID=$id\" TARGET=\"content\">$name</A></DIV>\n";
		  }else{
			  $text .= "<DIV class=\"dormant_section\">$name</DIV>\n";
		  }  
	  }
	  echo ($text);
   }

?>
				
			</td>
			<td valign="top">
			
			<div id="content">
				<iframe id="iframe" scrolling=auto width="100%" height="100%" name="content" src="topic.php"></iframe>
			</div>
			</td>
			</table>
			
		</div>
	</body