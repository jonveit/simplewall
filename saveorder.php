<?php

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

require_once "FirePHP.class.php";
$firephp = FirePHP::getInstance(true);

$postid = $_POST['id'];
$order = $_POST['order']; 

try {
	
	require_once "config.php";
	require_once "dbaccess.php";
	
	$statement = $db->prepare("UPDATE post SET _z_order = ? WHERE id = ?");
	$statement->execute(array($order, $postid));
	$affected_rows = $statement->rowCount();
	return $affected_rows;
	
} catch(PDOException $e) {
	$errorMessage = $e->getMessage();
}