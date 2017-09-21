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
	
	$breadcrumbs = "";
	$questions = "Error, questions could not be loaded";
	$results = $db->GetSubTopicData($params["SubTopicID"]);
				
		
		if (count($results) > 0)
		{
			$row = $results[0];
			
			$breadcrumbs = MakeBreadcrumbs($row["TopicID"],$row["TopicName"], $row["SubTopicName"]);
			$qs = new QuestionGetter();
			$questions = DisplayQuestionsText($qs->QAndA(0,$row["QuestionsPath"]));

		}
	
	echo($breadcrumbs);
	echo($questions);

?>

</BODY>
</HEAD>