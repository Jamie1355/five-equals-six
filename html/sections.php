<?php
include("functions.php");

 $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
	  $sql = "SELECT * from Sections order by TopicID;";
	  $results = $db->RunQuery($sql);
	  $html = "";
	  foreach($results as $row)
	  {
		  $name = $row['TopicName'];
		  if (strlen($row['TopicFolderPath']) > 0)
		  {
			  $html += "<DIV class=\"live_section\">$name</DIV>\n";
		  }else{
			  $html += "<DIV class=\"dormant_section\">$name</DIV>\n";
		  }  
	  }
	  echo $html;
   }

?>