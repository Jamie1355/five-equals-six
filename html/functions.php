<?php
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
  
?>