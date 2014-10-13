<?php

require_once "config.php";
require_once "FirePHP.class.php";

$firephp = FirePHP::getInstance(true);

///
// Won't access the database without being logged on.
///	

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '' && isset($_SESSION['user']))) {
	header ("Location: index.php");
}

try {
	
	$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, 
	array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	$user = $_SESSION['user'];

	$SQL = "SELECT id FROM user WHERE name = '$user'";
	$statement = $db->query($SQL);
	$num_rows = $statement->rowCount();

	if($num_rows == 1) {
		$row = $statement->fetch();
		$id = $row['id'];
	} else if($num_rows > 1) {
		echo "Error: Multiple users with the same name.  Check database.";
	} 
	else {
		echo "Error: No user found with that name.";
	}

	$SQL = "SELECT * from news WHERE _f_user = '$id'";
    $statement = $db->query($SQL);
	$num_rows = $statement->rowCount();

	if($num_rows > 0) {

		while($row = $statement->fetch(PDO::FETCH_ASSOC)) {

			$id = $row['id'];
			$title = $row['title'];
			$description = $row['description'];
			$url = $row['url'];
			
			$SQL = "SELECT * FROM image WHERE _f_post = $id";
			$imagestatement = $db->query($SQL);
			$image = $imagestatement->fetch();
			$imageurl = $image['url'];

			echo "<li><div class='postcontrols'><button class='deletepost' value='$id'>Delete</button><button class='editpost' value='$id'>Edit</button></div><div><img src='$imageurl' /><h3><a href='$url'>$title</a></h3><p>$description</p></div></li>";
		}

	} else {
		echo "<p> Did not find any news for this user </p>";
	} 

} catch(PDOException $e) { 
	$errorMessage = $e->getMessage(); 
	echo $errorMessage;
}

