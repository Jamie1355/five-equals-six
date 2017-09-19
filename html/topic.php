

<?php
	include("functions.php");
	
	if($params["MODE"]=="Subsection"){
		$db=new MyDB();
		if(!$db){
			echo $db->lastErrorMsg();
		} else {
			$sql="SELECT * FROM SubTopics JOIN Topics ON SubTopics.TopicID = Topics.TopicID WHERE SubTopics.TopicID='".$params["TopicID"]."' ORDER BY SubTopics.SubTopicID;";
			$results = $db->RunQuery($sql);
			$text = "";
			  foreach($results as $row)
			  {
				  $name = $row['SubTopicName'];
				  $topic = $params['TopicID'];
				  $id = $row['SubTopicID'];
				  $path = $row["TopicFolderPath"]."/".$row["SubTopicFolderPath"]."/notes.html";
				  if(file_exists($path) == 1){
					$text .= "<DIV class=\"live_section\"><A style=\"vertical-align: middle;\" HREF=\"topic.php?MODE=Notes&PATH=$path\" TARGET=\"content\">$name</A></DIV>\n";
				  }else{
					$text .= "<DIV class=\"dormant_section\">$name</DIV>\n";
				  }
			  }
			echo ($text);
		}
	}
	
	else if($params["MODE"]=="Notes"){
		$path = $params["PATH"];
		$text = "<DIV class=\"notes\">".file_get_contents($path)."</DIV>\n";
		echo ($text);
	}

?>