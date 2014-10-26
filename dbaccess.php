<?php

    //create the FileMaker Object
    try {
		
		$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, 
		array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
    } catch( Exception $e) {
    
		$errorMessage = "Error within the database:" . $e;
   	   
    }

?>