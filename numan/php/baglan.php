<?php 
	
	try 
	{
     $db = new PDO("mysql:host=localhost;dbname=numan", "root", "");
	} 
	catch ( PDOException $e )
	{
     print $e->getMessage();
	}



 ?>