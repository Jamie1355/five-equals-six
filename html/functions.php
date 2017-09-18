<?php
   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('../data/alevel.db');
      }
	  
	  function Query($sql)
	  {
		  $this->query('SELECT bar FROM foo');
while ($row = $results->fetchArray()) {
    var_dump($row);
}
		  
	  }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }
?>