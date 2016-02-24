<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

  function first($int, $string){ //function parameters, two variables.
    return $string;  //returns the second argument passed into the function
  }
  
  
  function select_All_Items(){
	$query = 'SELECT * FROM book;';
	$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
	return $result;
	}
	
//pg_close($dbconn);
?>