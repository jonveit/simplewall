<?php

require_once "FirePHP.class.php";

$firephp = FirePHP::getInstance(true); 

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

$id = $_POST['postid'];

try {
	
	require_once "config.php";
	require_once "dbaccess.php";
	
	$SQL = "DELETE FROM post WHERE id = :id";
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