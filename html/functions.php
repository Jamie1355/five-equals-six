<?php
	$params = $_GET + $_POST;

   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('../data/alevel.db');
      }
	  
	  function RunQuery($sql)
	  {
	
		$results = $this->query($sql);
		$retval = array();
		while ($row = $results->fetchArray()) 
		{
			$retval[] = $row;
		}
		return $retval;
	  }
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
		   if ($count <= $num)
		   {
			   // return them all
			   return $questions;
		   }else{
			   shuffle($questions);
			   $result = array();
			   for($i=0;$i<$num;$i++)
			   {
				   $result[] = array_pop($questions);
			   }
			   return $result;
			   
		   }
		   
	  
	   }
   }
  
?>