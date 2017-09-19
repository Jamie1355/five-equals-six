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
	   function QAndA(){
		   $num = $params["numOfQuestions"];
		   $questions = array();
		   $answers = array();
		   $contents = file_get_contents($params["questionsPath"]."/questions.txt");
		   $questions[] = GetQs($contents);
		   foreach($questions as $q){
			   echo $q;
		   }
	   }
	   
	   function GetQs($text){
		   $SEARCH = "###QUESTION";
		   $qs = array();
		   $counter = 0;
		   $offset = 1;
		   $previousPos = 0;
		   
		   while(true){
			   $pos = strpos($text, $SEARCH, $offset);
			   if($pos !== false){
				   $qs[$counter] = substr($text, $previousPos + strlen($SEARCH), $pos - strlen($text));
				   $counter++;
				   $offset = $pos + 1;
				   $previousPos = $pos;
			   }
			   else{
				   break;
			   }
		   }
		   
		   return qs;
	   }
   }
  
?>