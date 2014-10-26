<?php

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	return "<li> Error Not Logged In </li>";
}

try {
	
	include "config.php";
	include "dbaccess.php";
		
	$userid = $_SESSION['userid'];
	
	$SQL = "SELECT * from post WHERE _f_user = '$userid' ORDER BY _z_order ASC";
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
				<div class='postcontrols'>
					<button class='deletepost' value='$id'>Delete</button>
					<button class='editpost' value='$id'>Edit</button>
				</div>
				<div class='postcontent'>
					<h3><a href='$url' target="_blank">$title</a></h3>
					<div> $postdate </div>
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
		echo "<li> Did not find any news for this user </li>";
	} 

} catch(PDOException $e) { 
	$errorMessage = $e->getMessage();
	return "<li> $errorMessage </li>";
}

