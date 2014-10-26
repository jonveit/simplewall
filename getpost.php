<?php

require_once "config.php";
require_once "FirePHP.class.php";

$firephp = FirePHP::getInstance(true);

session_start();

///
// Won't access the database without being logged on.
///
if (isset($_SESSION['login']) && $_SESSION['login'] != '' && isset($_SESSION['user'])) {
	
	try {
		
	$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, 
	array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
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

	$SQL = "SELECT * from post WHERE _f_user = '$id'";
	$statement = $db->query($SQL);
	$num_rows = $statement->rowCount();

	if($num_rows > 0) {

		while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
	
			$id = $row['id'];
			$title = $row['title'];
			$description = $row['description'];
			$url = $row['url'];
			$imageid = $row['_f_image'];
			$SQL = "SELECT * FROM image WHERE id = '$imageid'";
			$imagestatement = $db->query($SQL);
			$image = $imagestatement->fetch();
	
			echo "<li><button class='deletepost' value='$id'>Delete</button><img src=".$image['url']." /><h3>".$row['title']."</h3><p>".$row['description']."</p></li>";
		}

	} else {
		echo "<p> Did not find any post for this user </p>";
	}


?>