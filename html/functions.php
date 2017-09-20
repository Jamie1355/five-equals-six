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
		   $questions = array();
		   $answers = array();
		   $contents = file_get_contents($path."/questions.txt");
		   $questions[] = $this->GetQs($contents);
		   $x = 0;
		   $end = "";
		   foreach($questions as $q){
			   $end .= $q[$x];
			   $x++;
		   }
		   return $end;
	   }
	   
	   function GetQs($text){
		   $subText = "";
		   $SEARCH = "###QUESTION";
		   $SEARCH2 = "###ANSWER";
		   $qs = array();
		   $counter = 0;
		   $offset = 0;
		   $previousPos = 0;
		   
		   preg_match_all('/[~]{3}(QUESTION|ANSWER)(.[^~]*)/', $text, $qs);
		   echo "<pre>";
		   var_dump ($qs);
		   echo "</pre>";
		   
		   /*while(true){
			   $pos = strpos($text, $SEARCH, $offset);
			   $pos2 = strpos($text, $SEARCH2, $offset);
			   if($pos !== false){
				   $subText = substr($text, $pos + strlen($SEARCH), $pos2 - $pos);
				   $qs[$counter] = $subText;//substr($text, $previousPos + strlen($SEARCH), $pos - strlen($text));
				   $counter++;
				   $offset = $pos2 + 1;
				   $previousPos = $pos;
			   }
			   else{
				   break;
			   }
		   }*/
		   
		   return $qs[2];
	   }
   }
  
?>