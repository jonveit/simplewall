<?php

require_once "FirePHP.class.php";
$firephp = FirePHP::getInstance(true);

try {
	
	require_once "config.php";
	require_once "dbaccess.php";
	
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

	$SQL = "SELECT * from post WHERE _f_user = '$id' ORDER BY _z_order ASC";
    $statement = $db->query($SQL);
	$num_rows = $statement->rowCount();

	if($num_rows > 0) {

		while($row = $statement->fetch(PDO::FETCH_ASSOC)) {

			$id = $row['id'];
			$title = $row['title'];
			$description = $row['description'];
			$url = $row['url'];
			$postdate = $row['postdate'];
			
			$SQL = "SELECT * FROM image WHERE _f_post = $id";
			$imagestatement = $db->query($SQL);
			$image = $imagestatement->fetch();
			$imageurl = $image['url'];

			echo <<< EOT
				<li class='post' value='$id'>
					<div class='postcontent'>
						<h3><a href='$url' target="_blank">$title</a></h3>
						<div class=“postdate”>$postdate</div>
						<div>
							<img src='$imageurl' />
							<p>$description</p>
						</div>
					</div>
				</li>

EOT;
		}

	} else {
		echo "<li> Did not find any news for this user </li>";
	} 

} catch(PDOException $e) { 
	$errorMessage = $e->getMessage(); 
	echo $errorMessage;
}

