<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="styles.css">
		
		<script type="text/javascript" src="5e6.js"></script>
</HEAD>
<BODY>

<?php
	include("functions.php");
	
	$db=new MyDB();
	if(!$db){
		echo $db->lastErrorMsg();
		die;
	}
	
	$breadcrumbs = "";
	$text = "Error";
	
	if($params["MODE"]=="Subsection")
	{
			$sql="SELECT * FROM SubTopics JOIN Topics ON SubTopics.TopicID = Topics.TopicID WHERE SubTopics.TopicID='".$params["TopicID"]."' ORDER BY SubTopics.SubTopicID;";
			$results = $db->RunQuery($sql);
			$text = "";
			foreach($results as $row)
			{
				  $name = $row['SubTopicName'];
				  $topic = $params['TopicID'];
				  $id = $row['SubTopicID'];
				  $path = $row["TopicFolderPath"]."/".$row["SubTopicFolderPath"];
				  if(file_exists($path) == 1){
					$text .= "<DIV class=\"live_subsection\"><A style=\"vertical-align: middle;\" HREF=\"topic.php?MODE=Notes&SubTopicID=$id&PATH=$path\" TARGET=\"content\">$name</A></DIV>\n";
				  }else{
					$text .= "<DIV class=\"dormant_subsection\">$name</DIV>\n";
				  }
			}
	}else if($params["MODE"]=="Notes"){
	
		$sql="SELECT * FROM SubTopics JOIN Topics ON SubTopics.TopicID = Topics.TopicID WHERE SubTopics.SubTopicID='".$params["SubTopicID"]."' ORDER BY SubTopics.SubTopicID;";
		$results = $db->RunQuery($sql);
		if (count($results) > 0)
		{
			$row = $results[0];
			
			$breadcrumbs .=  "<DIV CLASS=\"breadcrumbs\"><A HREF=\"topic.php?MODE=Subsection&TopicID=". $row["TopicID"] . "\">" .  $row["TopicName"] . "</A> -> ".  $row["SubTopicName"] . "</DIV>";

		}
		
		$qs = new QuestionGetter();
		
		$path = $params["PATH"];
		$text = "<DIV class=\"notes\">".file_get_contents($path."/notes.html")."</DIV>\n";
		foreach(nl2br($qs->QAndA(4, $path)) as $question){
			$text .= "<DIV class=\"questions\">".$question."</DIV>\n";
		}
	}
	
	
	echo($breadcrumbs);
	echo($text);

?>

</BODY>
</HEAD>