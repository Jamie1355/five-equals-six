<?php
/* ==================================== 
Functions to help with displaying 
elements

VIEW

======================================*/



function MakeQuestionsLink($topicData)
{
	$text = "<P CLASS=\"questionLink\"><A HREF=question.php?SubTopicID=" . $topicData["SubTopicID"] . ">Questions</A><P>";
	return $text;
}
function DisplayNotesText($text)
{
	return "<DIV class=\"notes\">".nl2br($text)."</DIV>\n";
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

function DisplayInlineQuestion($id,$question,$answer)
{
	$text = "<P CLASS=\"question\">" . nl2br($question) ."</P>";
	$text .= "<INPUT TYPE=\"TEXT\" NAME=\"A-$id\" onkeypress=\"return event.keyCode != 13;\"><P>";
	$text .= "<INPUT TYPE=\"HIDDEN\" NAME=\"Q-$id\" VALUE=\"$question\">";
	$text .= "<INPUT TYPE=\"HIDDEN\" NAME=\"CA-$id\" VALUE=\"$answer\">";
	
	return $text;
}

function DisplayAnswers($no,$question,$answerGiven,$correctAnswer )
{
	$text = "<DIV CLASS=\"questionAnswered\"><h2>$no</h2>";
	$text .= "<P>Question: " .nl2br($question) . "</P>";
	$text .= "<P>Your Answer: " .nl2br($answerGiven) . "</P>";
	$text .= "<P>Correct Answer: " .nl2br($correctAnswer) . "</P>";

	
	return $text;
	
}

function MakeBreadcrumbs($topicID,$topicName, $subTopicName)
{
	return  "<DIV CLASS=\"breadcrumbs\"><A HREF=\"topic.php?MODE=Subsection&TopicID=$topicID\">$topicName</A> -> $subTopicName</DIV>";
	
}

?>