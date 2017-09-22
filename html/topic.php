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
			$text = DisplaySubtopicList($results);
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