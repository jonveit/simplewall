<?php

require_once "config.php";
require_once "FirePHP.class.php";

$firephp = FirePHP::getInstance(true); 

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

$id = trim($_GET['postid']);

try {
	$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, 
	array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	$SQL = "SELECT * FROM news WHERE id = '$id'";
	$statement = $db->query($SQL);
	$row = $statement->fetch();
	
	$title = $row['title'];
	$url = $row['url'];
	$description = $row['description'];
	
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
	<div id="wrap">
		<a href="index.php"> Return </a>
		<form id="editpost" action="savepost.php" method="POST">
			<input type="hidden" name="postid" value="<?php echo $id ?>" />
			<label> Title </label>
			<input type="text" name="title" value="<?php echo $title; ?>" />
			<label> URL </label>
			<input type="text" name="url" value="<?php echo $url; ?>" />
			<label> Description </label>
			<textarea name="description"> <?php echo $description; ?> </textarea>
			<input type="submit" value="Save" />
		</form>
	</div>
</body>
</html>
