<?php

require_once "config.php";
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
$date = $_POST['date'];


try {
	$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, 
	array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	$SQL = "UPDATE news SET title = :title, url = :url, description = :description, date = :date WHERE id = :id";
	$stmt = $db->prepare($SQL);
	$stmt->bindParam(':id', $postid, PDO::PARAM_INT);  
	$stmt->bindParam(':title', $title, PDO::PARAM_STR);
	$stmt->bindParam(':url', $url, PDO::PARAM_STR);
	$stmt->bindParam(':description', $description, PDO::PARAM_STR);
	$stmt->bindParam(':date', $date, PDO::PARAM_STR);
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

