

<?php
include("functions.php");

echo "This is topic.php";

 $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
	  $sql = "SELECT * from Users;";
	  $results = $db->RunQuery($sql);
	  foreach($results as $row)
	  {
		  echo "<PRE>";
		 var_dump($row);
		 echo "</PRE>";
		  
	  }
   }

?>