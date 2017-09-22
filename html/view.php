<?php
/* ==================================== 
Functions to help with displaying 
elements

VIEW

======================================*/



function MakeQuestionsLink($topicData)
{
	if (file_exists($topicData["QuestionsPath"]))
	{
		
	$text = "<SPAN CLASS=\"questionLink\"><A HREF=question.php?SubTopicID=" . $topicData["SubTopicID"] . ">Questions</A></SPAN>";
	}else{
		$text = "There are no questions for this section";
	}
	return $text;
}
function DisplayNotesText($text,$path)
{
	//$text = nl2br($text);
	$text = str_replace("SRC=\"","SRC=\"" . $path ,$text);
	$text = str_replace("src=\"","src=\"" . $path,$text );
	return "<DIV class=\"notes\">".$text."</DIV>\n";
}

function DisplayQuestionsText($listOfQuestions)
{
		$text = "<DIV Class=\"questionsText\"><FORM ACTION=\"answers.php\" METHOD=\"POST\">\n";
		foreach ($listOfQuestions as $q)
		{
			$text .= DisplayInlineQuestion($q["number"],$q["text"],$q["answer"]);
		}
		$text .= "<INPUT TYPE=\"submit\" VALUE=\"Check Answers\"></FORM></DIV>";
		return $text;

}

function DisplaySubtopicList($listOfTopics){
	$text = "";
	foreach($listOfTopics as $row)
		{
			  $name = $row['SubTopicName'];
			  $id = $row['SubTopicID'];
			  $notesPath = $row["NotesPath"];
			  $questionsPath = $row["QuestionsPath"];
			  
			  $style = "dormant_subsection";
			  $notesLink = "";
			  $questionsLink = "";
			  if (file_exists($notesPath))
			  {
				  $style = "live_subsection";
				  $notesLink = "<A style=\"notesLink\" HREF=\"topic.php?MODE=Notes&SubTopicID=$id\" TARGET=\"content\">Explanation</A>";
			  }
			  if ( file_exists($questionsPath)){
				  $style = "live_subsection";
				  $questionsLink = MakeQuestionsLink($row);
			  }
			  $text .="<DIV class=\"$style\">$name | $notesLink | $questionsLink</DIV>\n";

		}
		return $text;

}
function NewLinesToHTML($text)
{
	$rval = nl2br($text);
	return preg_replace('/\<br[>]/i','xxx',$rval);
}


function DisplayInlineQuestion($id,$question,$answer)
{
	$text = "<P CLASS=\"question\">" . NewLinesToHTML($question) ;
	$text .= "<INPUT TYPE=\"TEXT\" NAME=\"A-$id\" onkeypress=\"return event.keyCode != 13;\">";
	$text .= "<INPUT TYPE=\"HIDDEN\" NAME=\"Q-$id\" VALUE=\"$question\">";
	$text .= "<INPUT TYPE=\"HIDDEN\" NAME=\"CA-$id\" VALUE=\"$answer\">"."</P>";
	
	return $text;
}

function DisplayAnswers($no,$question,$answerGiven,$correctAnswer )
{
	$text = "<DIV CLASS=\"questionAnswered\"><h2>$no</h2>";
	$text .= "<P>Question: " .NewLinesToHTML($question) . "</P>";
	$text .= "<P>Your Answer: " .NewLinesToHTML($answerGiven) . "</P>";
	$text .= "<P>Correct Answer: " .NewLinesToHTML($correctAnswer) . "</P>";

	
	return $text;
	
}

function MakeBreadcrumbs($topicID,$topicName, $subTopicName)
{
	return  "<DIV CLASS=\"breadcrumbs\"><A HREF=\"topic.php?MODE=Subsection&TopicID=$topicID\">$topicName</A> -> $subTopicName</DIV>";
	
}

?>