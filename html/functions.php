<?php
	/*=========================================
	Functions to do with getting data 
	
	MODEL
	
	=========================================*/

	$params = $_GET + $_POST;

   class MyDB extends SQLite3
   {
	  
	   
      function __construct()
      {
         $this->open('../data/alevel.db');
		 $this->debug = false;
      }
	  
	  function RunQuery($sql)
	  {
		if ($this->debug) $this->Debug($sql);
		$results = $this->query($sql);
		$retval = array();
		while ($row = $results->fetchArray()) 
		{
			$retval[] = $row;
		}
		return $retval;
	  }
	  function GetSubTopicTopicList($id)
	  {
		  
		  $sql="SELECT * FROM SubTopics JOIN Topics ON SubTopics.TopicID = Topics.TopicID WHERE SubTopics.TopicID='".$id."' ORDER BY SubTopics.SubTopicID;";
		  $results = $this->RunQuery($sql);
		  $this->AddPathsToResults($results);
		  return $results;
		  
	  }
	  function AddPathsToResults(&$results)
	  {
		for($i=0;$i<count($results);$i++)
		{
			$path = $results[$i]["TopicFolderPath"]."/".$results[$i]["SubTopicFolderPath"]."/";
			$results[$i]["NotesPath"] = $path . "notes.html";
			$results[$i]["QuestionsPath"] = $path . "questions.xml";
		} 
	  }
	  
	  function GetSubTopicData($id)
	  {
		  $sql="SELECT * FROM SubTopics JOIN Topics ON SubTopics.TopicID = Topics.TopicID WHERE
		  SubTopics.SubTopicID='".$id."' ORDER BY SubTopics.SubTopicID;";
		$results = $this->RunQuery($sql);
		$this->AddPathsToResults($results);
		return $results;
	  }
	  
	  function Debug($text)
	  {
		echo "<PRE>";
		echo $text;
		echo "</PRE>";
		  
	  }
   }
   
   function GetNotesFileContents($subtopic_data)
   {
	   $text = file_get_contents($subtopic_data["NotesPath"]) or "File $path could not be found";
	   return $text;
	   
	   
   }
   
   class QuestionGetter{
	   function QAndA($num, $path){
		   $xml=simplexml_load_file($path);
		   
		   // put these into an array of ayrrays
		   $questions = array();
		   $count = 0;
		   foreach($xml->question as $question)
		   {
			   $thisQuestion = array();
			   $thisQuestion["text"] = $question->text;
			   $thisQuestion["answer"] = $question->answer;
			   $thisQuestion["number"] = $count;
			   $count++;
			   $questions[] = $thisQuestion;
		   }
		   
		   // choose the number of questions asked for
		   if (($count <= $num) || ($num == 0))
		   {
			   // return them all
			   return $questions;
		   }else{
			   shuffle($questions);
			   $result = array();
			   for($i=0;$i<$num;$i++)
			   {
				   $q= array_pop($questions);
				   $q["number"] = $i;
				   $result[] = $q;
				   
			   }
			   return $result;
			   
		   }
		   
	  
	   }
   }
  
?>