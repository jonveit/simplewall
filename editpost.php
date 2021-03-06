<?php

require_once "FirePHP.class.php";
$firephp = FirePHP::getInstance(true); 

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

$id = trim($_GET['postid']);
$user = $_SESSION['user'];

try {
	
		
	require_once "config.php";
	require_once "dbaccess.php";
	
	$SQL = "SELECT * FROM post WHERE id = '$id'";
	$statement = $db->query($SQL);
	$row = $statement->fetch();
	
	$title = $row['title'];
	$url = $row['url'];
	$description = $row['description'];
	$postdate = $row['postdate'];
	
	$SQL = "SELECT * FROM image WHERE _f_post = '$id'";
	$statement = $db->query($SQL);
	$row = $statement->fetch();
	
	$imageurl = $row['url'];
	
} catch(PDOException $e) {
    	echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Blog </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	
	<div id="header-wrap">
		<div id="header">
			<h2>SimpleWall for <?php echo ucwords($user); ?></h2>
			<button id="logout" onclick="location.href='logout.php'">Logout</button>
			<button id="display" onclick="location.href='display.php?user=<?php echo $user ?>'">Display</button>
		</div>
	</div>
	
	<div id="wrap">
		
		<form id="editpost" action="savepost.php" method="POST">
			<h2>Edit Post</h2>
			<label> Image </label>
			<img src=<?php echo $imageurl ?> />
			<label> Image URL </label>
			<input type="text" name="imageurl" value="<?php echo $imageurl ?>" />
			<input type="hidden" name="postid" value="<?php echo $id ?>" />
			<label> Title </label>
			<input type="text" name="title" value="<?php echo $title; ?>" />
			<label> URL </label>
			<input type="text" name="url" value="<?php echo $url; ?>" />
			<label> Description </label>
			<textarea name="description"> <?php echo $description; ?> </textarea>
			<label> Date </label>
			<input type="text" name="postdate" value="<?php echo $postdate; ?>" />
			<input type="submit" value="Save" />
			<button onclick="location.href='index.php'">Cancel</button>
		</form>
	</div>
	<script>
	$('#logout').click( function() {
		window.location.href = "logout.php";
	});
	
	$('#display').click( function() {
		window.location.href = "display.php?user=<?php echo $user; ?>";
	});
	</script>
</body>
</html>
