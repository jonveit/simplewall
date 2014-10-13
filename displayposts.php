<?php

require_once "config.php";
require_once "FirePHP.class.php";

$firephp = FirePHP::getInstance(true);

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

	$SQL = "SELECT * from news WHERE _f_user = '$id'";
    $statement = $db->query($SQL);
	$num_rows = $statement->rowCount();

	if($num_rows > 0) {

		while($row = $statement->fetch(PDO::FETCH_ASSOC)) {

			$id = $row['id'];
			$title = $row['title'];
			$description = $row['description'];
			$url = $row['url'];
			$date = $row['date'];
			
			$SQL = "SELECT * FROM image WHERE _f_post = $id";
			$imagestatement = $db->query($SQL);
			$image = $imagestatement->fetch();
			$imageurl = $image['url'];

			echo <<< EOT
				<li class='post' value='$id'>
					<div class='postcontent'>
						<h3><a href='$url' target="_blank">$title</a></h3>
						<div>$date</div>
						<div>
							<img src='$imageurl' />
							<p>$description</p>
							<span><a href='$url' target="_blank">Read More...</a></span>
						</div>
					</div>
				</li>

EOT;
		}

	} else {
		echo "<p> Did not find any news for this user </p>";
	} 

} catch(PDOException $e) { 
	$errorMessage = $e->getMessage(); 
	echo $errorMessage;
}

