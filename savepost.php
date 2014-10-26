<?php

require_once "FirePHP.class.php";
$firephp = FirePHP::getInstance(true); 

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

$postid = $_POST['postid'];
$title = $_POST['title'];
$url = $_POST['url'];
$description = $_POST['description'];
$imageurl = $_POST['imageurl'];
$postdate = $_POST['postdate'];

try {
	require_once "localconfig.php";
	require_once "dbaccess.php";
	
	$SQL = "UPDATE post SET title = :title, url = :url, description = :description, postdate = :postdate WHERE id = :id";
	$stmt = $db->prepare($SQL);
	$stmt->bindParam(':id', $postid, PDO::PARAM_INT);  
	$stmt->bindParam(':title', $title, PDO::PARAM_STR);
	$stmt->bindParam(':url', $url, PDO::PARAM_STR);
	$stmt->bindParam(':description', $description, PDO::PARAM_STR);
	$stmt->bindParam(':postdate', $postdate, PDO::PARAM_STR);
	$num_rows = $stmt->execute();
	
	$SQL = "UPDATE image SET url = :imageurl WHERE _f_post = :id";
	$stmt = $db->prepare($SQL);
	$stmt->bindParam(':id', $postid, PDO::PARAM_INT);  
	$stmt->bindParam(':imageurl', $imageurl, PDO::PARAM_STR);  
	$num_rows = $stmt->execute();
	
	if($num_rows > 0){
		header( 'Location: index.php' );
	} else  {
		$errorMessage = "Nothing was updated";
		echo $errorMessage;
	}
	
} catch(PDOException $e) { 
		$errorMessage = $e->getMessage(); 
		include 'login.php';
}

