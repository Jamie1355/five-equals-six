<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="styles.css">
		
		<script type="text/javascript" src="5e6.js"></script>
</HEAD>
<BODY>

<?php
	require("functions.php");
	require ("view.php");
	
	$db=new MyDB();
	if(!$db){
		echo $db->lastErrorMsg();
		die;
	}
	
	$breadcrumbs = "";
	$text = "Error";
	
	if (!array_key_exists("MODE",$params))
	{
		// print intro message
		$text= file_get_contents("home.html");
	}
	
	else if($params["MODE"]=="Subsection")
	{
		
			
			$results =$db->GetSubTopicTopicList($params["TopicID"]);
			$text = "";
			foreach($results as $row)
			{
				  $name = $row['SubTopicName'];
				  $topic = $params['TopicID'];
				  $id = $row['SubTopicID'];
				  $path = $row["NotesPath"];
				  if(file_exists($path) == 1){
					$text .= "<DIV class=\"live_subsection\"><A style=\"vertical-align: middle;\" HREF=\"topic.php?MODE=Notes&SubTopicID=$id&PATH=$path\" TARGET=\"content\">$name</A></DIV>\n";
				  }else{
					$text .= "<DIV class=\"dormant_subsection\">$name</DIV>\n";
				  }
			}
	}else if($params["MODE"]=="Notes"){
	
		$results = $db->GetSubTopicData($params["SubTopicID"]);
				
		
		if (count($results) > 0)
		{
			$row = $results[0];
			
			$breadcrumbs = MakeBreadcrumbs($row["TopicID"],$row["TopicName"], $row["SubTopicName"]);
			$text = DisplayNotesText(GetNotesFileContents($row), $row["ImagesPath"]);
			$text.= MakeQuestionsLink($row);
			

		}
	}
	
	
	echo($breadcrumbs);
	echo($text);

?>

</BODY>
</HEAD>