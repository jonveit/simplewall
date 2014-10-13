<?php

require_once "config.php";
require_once "FirePHP.class.php";

$firephp = FirePHP::getInstance(true); 

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

$user = $_SESSION['user'];
$id = trim($_GET['postid']);

try {
	$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, 
	array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	$SQL = "DELETE FROM news WHERE id = :id";
	$stmt = $db->prepare($SQL);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);  
	$num_rows = $stmt->execute();

	if($num_rows == 1) {
		echo "Deleted successfully";
		echo "$num_rows";
	} else if($num_rows > 1) {
		echo "Deleted multiple posts";
	} else {
		echo "Could not find post to delete.";
	}
	
	$SQL = "DELETE FROM image WHERE _f_news = :id";
	$stmt = $db->prepare($SQL);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);  
	$num_rows = $stmt->execute();
	
	if($num_rows == 1) {
		echo "Image successfully";
	} else if($num_rows > 1) {
		echo "Deleted multiple images";
	} else {
		echo "Could not find image to delete.";
	}
		
} catch(PDOException $e) {
    	echo $e->getMessage();
}
	
?>